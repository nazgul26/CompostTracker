<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;

/*
    Residential Pickups 
*/
class CollectionsController extends AppController
{
    public function isAuthorized($user = null) {
        if ($user['access_level'] >= Configure::read('AuthRoles.user')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Worker', 'Subscriber'
            ],
            'order' => ['Collections.pickup_date' => 'DESC']
        ];
        $collections = $this->paginate($this->Collections);

        $this->set(compact('collections'));
        $this->set('_serialize', ['collections']);
    }

    public function add($search = null) {
        $collection = $this->Collections->newEntity();
        $subscriber = null;
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            $requestData['pickup_date'] = date("Y-m-d H:i:s");
            $requestData['worker_user_id'] = $this->Auth->user('id');
            //$requestData['subscriber_id'] = 
            $collection = $this->Collections->patchEntity($collection, $requestData );
            if ($this->Collections->save($collection)) {
                $this->Flash->success(__('Collection added successfully.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The collection could not be saved. Please, try again.'));
        }

        if ($search) {
            if (preg_match('~[0-9]+~', $search)) {
                $houseNumber = substr($search, 0, 2);
                $subscriberQuery = $this->Collections->Subscriber->find('all', [
                    'conditions' => ['Addresses.street1 LIKE' => $houseNumber . '%'],
                    'contain' => ['Addresses']]);
                $search = ""; // Blank out the GPS Address on return
            } else {
                $subscriberQuery = $this->Collections->Subscriber->find('all', [
                    'conditions' => ['Subscriber.last_name LIKE' => $search . '%'],
                    'contain' => ['Addresses']]);
            }
            if ($subscriberQuery->count() == 1) {
                $subscriber = $subscriberQuery->first();
            } else if ($subscriberQuery->count() > 1) {
                $this->Flash->error(__('More than 1 Subscriber found. Try entering a complete last name.'));
            } else {
                $this->Flash->error(__('Subscriber could not be found. Please try again:' . $search));
            }
        }

        $this->set(compact('collection', 'subscriber', 'search'));
        $this->set('_serialize', ['collection']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $collection = $this->Collections->get($id);
        if ($this->Collections->delete($collection)) {
            $this->Flash->success(__('The collection has been deleted.'));
        } else {
            $this->Flash->error(__('The collection could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
?>