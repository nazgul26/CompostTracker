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
        $result = ChargeBee_Customer::retrieve($subscriber->external_id);
        $chargeBee = $result->customer();
        
        $this->set(compact('subscriber', 'chargeBee'));
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
        WebHook API for ChargeBee
        Expected:
            content - json data of charge bee subscription
            id
    */
    public function webhook() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $content = $request["content"];
            print_r($request);
            //$content = json_decode($content,true);
            $chargeBeeEvent = $request["event_type"];
            $customer = $content["customer"];
            $subscription = $content["subscription"];
            
            $response = true;
            $customerId = $customer["id"];
 
            if (isset($customerId)) {
                $subscriber = null;
                $query = $this->Subscribers->findByExternalId($customerId);
                if ($query->count() == 0) {
                    // Need to create it
                    $subscriber = $this->Subscribers->newEntity();
                    $subscriber->first_name = $customer["first_name"];
                    $subscriber->last_name = $customer["last_name"];
                    $subscriber->email = $customer["email"];
                    $subscriber->external_id = $customer["id"];
                } else {
                    $subscriber = $query->first();
                }

                if ($chargeBeeEvent == "subscription_started" || 
                    $chargeBeeEvent == "subscription_created") {
                    $subscriber->active = true;
                } else if ($chargeBeeEvent == "subscription_cancelled" || 
                            $chargeBeeEvent == "subscription_deleted") {
                    $subscriber->active = false;
                } else if ($chargeBeeEvent == "subscription_shipping_address_updated") {
                    // Get shipping address / phone
                    $shipping = $subscription["shipping_address"];
                    $subscriber->phone = $shipping["phone"];
                    $subscriber->street1 = $shipping["street1"];
                    $subscriber->street2 = $shipping["street2"];
                    $subscriber->city = $shipping["city"];
                    $subscriber->state_code = $shipping["state_code"];
                }

                if ($this->Subscribers->save($subscriber)) {
                    $response = true;
                } else {
                    $response = false;
                }
            }

            $this->set(compact('response', 'customerId'));
            $this->RequestHandler->renderAs($this, 'json');
        }
    }
}?>
