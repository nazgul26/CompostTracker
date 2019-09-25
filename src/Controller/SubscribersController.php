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
            //$content = json_decode($content,true); // LOCAL Debugging only.
            $chargeBeeEvent = $request["event_type"];
            $customer = $content["customer"];
            $subscription = isset($content["subscription"]) ? $content["subscription"] : null;
            
            $response = false;
            $lastStep = "start";
            $customerId = $customer["id"];
 
            if (isset($customerId)) {
                $subscriber = null;
                $query = $this->Subscribers->findByExternalId($customerId);
                if ($query->count() == 0) {
                    // Need to create it
                    $subscriber = $this->Subscribers->newEntity();
                } else {
                    $subscriber = $query->first();
                }

                if ($chargeBeeEvent == "customer_created" ||
                    $chargeBeeEvent == "customer_updated" ||
                    $chargeBeeEvent == "subscription_created" ||
                    $chargeBeeEvent == "subscription_updated" ||
                    $chargeBeeEvent == "subscription_shipping_address_updated") {

                    // Update fields
                    $subscriber->first_name = $customer["first_name"];
                    $subscriber->last_name = $customer["last_name"];
                    $subscriber->email = $customer["email"];
                    $subscriber->external_id = $customer["id"];
                    $subscriber->bucket_location = $customer["cf_bucket_location"];
                    
                    $billing = isset($customer["billing_address"]) ?  $customer["billing_address"] : null;
                    if (isset($billing)) {
                        $subscriber->phone = $billing["phone"];
                        $subscriber->street1 = $billing["line1"];
                        $subscriber->street2 = $billing["line2"];
                        $subscriber->city = $billing["city"];
                        $subscriber->state_code = $billing["state_code"];
                    }

                    // Get shipping address / phone will override billing values if set
                    if (isset($subscription)) {
                        $shipping = $subscription["shipping_address"];
                        if (isset($shipping)) {
                            $subscriber->phone = $shipping["phone"];
                            $subscriber->street1 = $shipping["line1"];
                            $subscriber->street2 = $shipping["line2"];
                            $subscriber->city = $shipping["city"];
                            $subscriber->state_code = $shipping["state_code"];
                        }
                    }
                }

                if ($chargeBeeEvent == "subscription_started" || 
                    $chargeBeeEvent == "subscription_created") {

                    $subscriber->active = true;
                } else if ($chargeBeeEvent == "subscription_cancelled" || 
                           $chargeBeeEvent == "subscription_deleted") {
                    $subscriber->active = false;
                }

                if ($this->Subscribers->save($subscriber)) {
                    $response = true;
                } else {
                    $response = false;
                }
            }

            $this->set(compact('response', 'customerId', 'lastStep'));
            $this->RequestHandler->renderAs($this, 'json');
        }
    }
}?>
