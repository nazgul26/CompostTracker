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

    public function add($subscriberName = null) {
        $collection = $this->Collections->newEntity();
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            $requestData['pickup_date'] = date("Y-m-d H:i:s");
            $requestData['worker_user_id'] = $this->Auth->user('id');
            $collection = $this->Collections->patchEntity($collection, $requestData );
            if ($this->Collections->save($collection)) {
                $this->Flash->success(__('Collection added successfully.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The collection could not be saved. Please, try again.'));
        }

        if ($subscriberName) {
            $name = explode('.', $subscriberName);
            $subscriberQuery = $this->Collections->Subscriber->find('all', [
                'conditions' => ['Subscriber.first_name' => $name[0], 'Subscriber.last_name' => $name[1]]]);

            if ($subscriberQuery->count() > 0) {
                $subscriber = $subscriberQuery->first();
            } else {
                $this->Flash->error(__('Subscriber could not be found. Please try again.'));
            }
        }

        $this->set(compact('collection', 'subscriber', 'subscriberName'));
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