<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Core\Configure;

class UsersController extends AppController
{
    public function isAuthorized($user = null) {

        // The owner of an user can edit and delete it
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $userId = (int)$this->request->getParam('pass.0');
            if ($userId == $user['id']) {
                return true;
            }
        }
        
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
    }

    public function edit($userId = null)
    {
        $authLevel = $this->Auth->user('access_level');
        $isAdmin = false;
        if ($authLevel >= Configure::read('AuthRoles.admin')) {
            $isAdmin = true;
        }

        // Edit
        if ($userId) {
            $user = $this->Users->get($userId);
        } else {  
            // Add - first load
            $user = $this->Users->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            if ($request['password1'] === $request['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($request['password2'])) {  
                    $request['password'] = $request['password2'];
                }

                $user = $this->Users->patchEntity($user, $request);
                
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Unable to add the user.'));
            } else {
                $this->Flash->error(__('Passwords do not match.'));
            }
        }
        $clients = $this->Users->Clients->find('list', ['limit' => 200]);
        $this->set(compact('user', 'userId', 'clients', 'isAdmin'));
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        $this->Flash->success(__('Logged out.'));
        return $this->redirect($this->Auth->logout());
    }

    public function signup() { 

        // Add - first load
        $user = $this->Users->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $request['email'] = $request['username']; // Until email is removed...

            if ($request['password1'] === $request['password2']) {
                // only pass on the password when there is a value (and it matches the confirm)
                if (!empty($request['password2'])) {  
                    $request['password'] = $request['password2'];
                }

                $address = $this->Users->Addresses->newEntity($request['Address']);
                if ($this->Users->Addresses->save($address)) {
                    $request["address_id"] = $address->id;
                    $request["access_level"] = Configure::read('AuthRoles.residential');
                    $user = $this->Users->patchEntity($user, $request);

                    // Create the Stripe user as well
                    $customer = \Stripe\Customer::create(array(
                        'email' => $user->email,
                        'description' => $user->first_name . " " . $user->last_name
                    ));

                    $user->stripe_id = $customer->id;

                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Account created.  Setup Payment to complete registration.'));
                        $this->Auth->setUser($user);
                        return $this->redirect(['controller' => 'payments', 'action' => 'index']);
                    }
                }
                $this->Flash->error(__('Unable to add the user.'));
            } else {
                $this->Flash->error(__('Passwords do not match.'));
            }
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reset() {     
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            $user = $this->Users->find('all')->where(['Users.email' => $requestData['email']])->first();
            if (isset($user->email)) {
                $hashedKey = Security::hash(Text::uuid(),'sha256',true);
                $user->reset_token = $hashedKey;
                $user->reset_time = date("Y-m-d H:i:s");
                
                if ($this->Users->save($user))
                {
                    $email = new Email('default');
                    $email->from(array('app@rustbeltriders.com' => 'Rust Belt Riders'))
                        ->template('reset', 'default')
                        ->emailFormat('both')
                        ->viewVars(array('resetLink' => Router::url( ['controller'=>'users','action'=>'resetLink', '_ssl' => true], true ).'/'.$hashedKey))
                        ->to($user->email)
                        ->subject('Password Reset')
                        ->replyTo('support@rustbeltriders.com')
                        ->send();

                    $this->Flash->success(__('Your reset email is on the way!'));
                    return;
                }
                $this->Flash->error(__('Could not send a reset email. Please contact support.'));
            }
            $this->Flash->error(__('Could not find your email address, try again.'));
        }
    }
    
    public function resetLink($token) {
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            $token = $requestData['token'];
            // Load the User from the Token. Don't trust the input.
            $user = $this->Users->find('all')->where(['Users.reset_token' => $token])->first();
            
            // Set in case in case of failure and end of returning to user.
            $this->set(compact('user', 'token'));
            
            //$item['User']['reset_time']) -- TODO: need to compare time within 1 hour
            if ($requestData['password1'] != $requestData['password2']) {
                $this->Flash->error(__('Passwords are not set to same value. Please, try again.'));
                return;
            }
            
            // only pass on the password when there is a value (and it matches the confirm)
            if (empty($requestData['password2'])) {  
                $this->Flash->error(__('A new password is required. Please, try again.'));
                return;
            }
            
            // Everything looks good, lets reset :-)
            $user->password = $requestData['password2'];
            $user->locked = false;
            $user->reset_token = null;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Password successfully reset. Login with your new password to continue.'), 'success');
                return $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Flash->error(__('The password could not be saved. Please, try again.'));
                return;
            }
        } else {
            $user = $this->Users->find('all')->where(['Users.reset_token' => $token])->first();
            if (isset($user->email)) {   
                $this->set(compact('user', 'token'));
                return;
            }
        }
        $this->Flash->error(__('Could not find reset information. Please try again.'));
    }

}