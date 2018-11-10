<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Email;

class PaymentsController extends AppController
{

    public function beforeFilter(Event $event) {
      if (in_array($this->request->action, ['update', 'card'])) {
          $this->eventManager()->off($this->Csrf);
          $this->eventManager()->off($this->Security);
      }
    }

    public function isAuthorized($user = null) {
        if ($user['access_level'] >= Configure::read('AuthRoles.residential')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }

    public function index() {
      $stripeId =  $this->Auth->user('stripe_id');
      $customer = \Stripe\Customer::retrieve($stripeId);
      $cards = $customer->sources->all(array(
        'limit'=>5,
        'object' => 'card'
      ));
      $subscriptions = $customer->subscriptions->all();
      //var_dump($card_on_file->data[0]->id);
      //echo "<pre>";
      //print_r($cards);
      //print_r($subscriptions);
      //echo "</pre>";
      $email = $this->Auth->user('email');

      $this->set(compact('cards','subscriptions', 'email'));
    }

    public function card() {
      $request = $this->request->getData();
      $stripeId =  $this->Auth->user('stripe_id');
      $customer = \Stripe\Customer::retrieve($stripeId);
      $customer->source = $request['stripeToken']; // obtained with Checkout
      $customer->save();

      $this->Flash->success(__('Card successfully updated.'));
      return $this->redirect(['controller' => 'payments', 'action' => 'index']);

    }
    
    public function subscribe() {
      $email = $this->Auth->user('email');
      $this->set('email', $email);     
    }

    public function update() {
      if ($this->request->is(['patch', 'post', 'put'])) {
        $request = $this->request->getData();
        
        $firstDayNextMonth = strtotime('first day of next month');
        $daysTilNextMonth = ($firstDayNextMonth - time()) / (24 * 3600);

        try {
          $stripeId =  $this->Auth->user('stripe_id');
          $customer = \Stripe\Customer::retrieve($stripeId);
          $customer->source = $request['stripeToken']; // obtained with Checkout
          $customer->save();

          $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => 'RESIDENTIAL']],
            'trial_period_days' => $daysTilNextMonth,
          ]);
          
          // Let RBR know
          /*$email = new Email('default');
          $email->from(array('app@rustbeltriders.com' => 'Rust Belt Riders'))
              ->template('new', 'default')
              ->emailFormat('both')
              ->viewVars(array('email' => $this->Auth->user('email'), 'phone' => $this->Auth->user('phone')))
              ->to('toddrogers3286@gmail.com')
              ->subject('[Test] New Residential Customer - ' . $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name'))
              ->replyTo('app@rustbeltriders.com')
              ->send();

          // let the New User know
          $email = new Email('default');
          $email->from(array('support@rustbeltriders.com' => 'Rust Belt Riders'))
              ->template('welcome')
              ->emailFormat('html')
              ->to('toddrogers3286@gmail.com')
              ->subject('[Test] Welcome From Rust Belt Riders')
              ->replyTo('support@rustbeltriders.com')
              ->send();*/

          $this->Flash->success(__('You are successfully Registered.  You will receive a welcome email.'));
          return $this->redirect(['controller' => 'home', 'action' => 'index']);

        } catch(\Stripe\Error\Card $e) {
          // Since it's a decline, \Stripe\Error\Card will be caught
          $body = $e->getJsonBody();
          $err  = $body['error'];
        
          print('Status is:' . $e->getHttpStatus() . "\n");
          print('Type is:' . $err['type'] . "\n");
          print('Code is:' . $err['code'] . "\n");
          // param is '' in this case
          print('Param is:' . $err['param'] . "\n");
          print('Message is:' . $err['message'] . "\n");
        } catch (Exception $e) {
          echo "Something bad happened" . $e;
          // Something else happened, completely unrelated to Stripe
        }
    }
  }

  public function welcome() {

  }
  
}