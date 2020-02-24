<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;
use ChargeBee;
use ChargeBee_Customer;
use Cake\Event\Event;

/*
    Residential Subscribers 
*/
class SubscribersController extends AppController
{
    public function isAuthorized($user = null) {
        if ($user['access_level'] >= Configure::read('AuthRoles.user')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Disable for this page
        $this->getEventManager()->off($this->Security);
        $this->getEventManager()->off($this->Csrf);
    }

    public function index()
    {
        $this->paginate = [
            'order' => ['Subscriber.last_name' => 'DESC']
        ];
        $subscribers = $this->paginate($this->Subscribers);

        $this->set(compact('subscribers'));
        $this->set('_serialize', ['subscribers']);
    }

    public function details($id = null) {
        $subscriber = $this->Subscribers->get($id); 
        $this->set(compact('subscriber'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriber = $this->Subscribers->get($id);
        if ($this->Subscribers->delete($subscriber)) {
            $this->Flash->success(__('The subscriber has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriber could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
        WebHook API for Recurly
        Expected:
            XML data of invoice
    */
    public function webhook() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Local Debuggin
            //$request = $this->request->getData();
            //$content = $request["content"]; 
            
            // Live Get
            $content = file_get_contents ("php://input");
            
            if (strpos($content, "paid_charge_invoice_notification") == false) return;

            $xml = simplexml_load_string($content);
            $json = json_encode($xml);
            $event = json_decode($json,TRUE);

            //print_r($event);

            if (isset($event)) {
                
                $customer = $event["account"];
                $invoice = $event["invoice"];
                
                $response = false;
                $lastStep = "Start";
                $customerId = $customer["account_code"];
    
                if (isset($customerId)) {
                    $subscriber = null;
                    $query = $this->Subscribers->findByExternalId($customerId)->contain(['Addresses']);
                    if ($query->count() == 0) {
                        // Need to create it
                        $subscriber = $this->Subscribers->newEntity();
                    } else {
                        $subscriber = $query->first();
                    }

                    // Update fields
                    $subscriber->first_name = $customer["first_name"];
                    $subscriber->last_name = $customer["last_name"];
                    $subscriber->email = $customer["email"];
                    $subscriber->phone = $customer["phone"];
                    $subscriber->active = true;
                    $subscriber->external_id = $customerId;
    
                    $address = $invoice["address"];
                    if (isset($address)) {
                        
                        if (!isset($subscriber->address)) {
                            $subscriber->address = $this->Subscribers->Addresses->newEntity();
                        }
                        $subscriber->address->street1 = $address["address1"];
                        $subscriber->address->street2 = $address["address1"];
                        $subscriber->address->city = $address["city"];
                        $subscriber->address->state = $address["state"];
                        $subscriber->address->zip = $address["zip"];
                        $lastStep = "Address";
                    }

                    if ($this->Subscribers->save($subscriber)) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                    $lastStep = "Saved";
                }
            }
            // De-activate when subscription ends
            // $subscriber->active = false;

            $this->set(compact('response', 'customerId', 'lastStep'));
            $this->RequestHandler->renderAs($this, 'json');
        }
    }
}?>
