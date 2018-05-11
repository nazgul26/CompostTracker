<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

class PaymentsController extends AppController
{

    public function beforeFilter(Event $event) {
      if (in_array($this->request->action, ['update'])) {
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
    
    public function index()
    {
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
          
          $this->Flash->success(__('You are successfully Registered.'));
          return $this->redirect(['controller' => 'payments', 'action' => 'welcome']);

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