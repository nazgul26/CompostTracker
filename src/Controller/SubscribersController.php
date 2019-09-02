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
            'contain' => [
                'Addresses'
            ],
            'order' => ['Subscriber.last_name' => 'DESC']
        ];
        $subscribers = $this->paginate($this->Subscribers);

        $this->set(compact('subscribers'));
        $this->set('_serialize', ['subscribers']);
    }

    public function details($subscriberId = null) {
        $result = ChargeBee_Customer::retrieve($subscriberId);
        $subscriber = $result->customer();
        $this->set(compact('subscriber'));
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

            if ($chargeBeeEvent == "subscription_started") {
                $subscriber = $this->Subscribers->findByExternalId($customerId);
                if ($subscriber->count() == 0) {
                    $subscriber = $this->Subscribers->newEntity();
                    $subscriber->first_name = $customer["first_name"];
                    $subscriber->last_name = $customer["last_name"];
                    $subscriber->email = $customer["email"];
                    $subscriber->external_id = $customer["id"];
                    if ($this->Subscribers->save($subscriber)) {
                        $response = true;
                    } else {
                        $response = false;
                    }
                }
            }

            $this->set(compact('response', 'customerId'));
            $this->RequestHandler->renderAs($this, 'json');
        }
    }
}?>
