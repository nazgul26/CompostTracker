<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;

class PickupsController extends AppController
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
                'Users', 
                'Locations' => 
                    ['Sites' => ['Clients']]
            ],
            'order' => ['Pickups.pickup_date' => 'DESC']
        ];
        $pickups = $this->paginate($this->Pickups);

        $this->set(compact('pickups'));
        $this->set('_serialize', ['pickups']);
    }

    public function view($id = null)
    {
        $pickup = $this->Pickups->get($id, [
            'contain' => ['Users', 'Clients']
        ]);

        $this->set('pickup', $pickup);
        $this->set('_serialize', ['pickup']);
    }

   
    public function add($clientId = null, $siteId = null, $locationId = null)
    {
        $pickup = $this->Pickups->newEntity();
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            date_default_timezone_set('US/Eastern');
            $requestData['pickup_date'] = date("Y-m-d H:i:s");
            $requestData['user_id'] = $this->Auth->user('id');
            $pickup = $this->Pickups->patchEntity($pickup, $requestData, 
                ['associated' => ['Containers', 'Containers._joinData']]
            );

            if ($this->Pickups->save($pickup, ['associated' => ['Containers._joinData']])) {
                $this->Flash->success(__('The pickup has been saved.'));
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('The pickup could not be saved. Please, try again.'));
            }
        }
        $clients = $this->Pickups->Locations->Sites->Clients->find('list', ['limit' => 200]);
        $sites = $this->Pickups->Locations->Sites->find('list', ['conditions' => ['Sites.client_id' => $clientId], 'limit' => 200]);
        $locations = $this->Pickups->Locations->find('list')->where(['Locations.site_id' => $siteId])->limit(200);

        if (!isset($locationId) && $siteId) {
            $locationId = array_keys($locations->toArray())[0];
        }
        $containers = $this->Pickups->Locations->find('all')->where(['Locations.id' => $locationId])->contain(['Containers'])->limit(200);
        $this->set(compact('clientId', 'siteId', 'locationId', 'pickup', 'users', 'clients', 'sites', 'locations', 'containers'));
        $this->set('_serialize', ['pickup']);
    }

    public function edit($id = null)
    {
        $pickup = $this->Pickups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pickup = $this->Pickups->patchEntity($pickup, $this->request->getData());
            if ($this->Pickups->save($pickup)) {
                $this->Flash->success(__('The pickup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pickup could not be saved. Please, try again.'));
        }
        $users = $this->Pickups->Users->find('list', ['limit' => 200]);
        $clients = $this->Pickups->Clients->find('list', ['limit' => 200]);
        $this->set(compact('pickup', 'users', 'clients'));
        $this->set('_serialize', ['pickup']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pickup = $this->Pickups->get($id);
        if ($this->Pickups->delete($pickup)) {
            $this->Flash->success(__('The pickup has been deleted.'));
        } else {
            $this->Flash->error(__('The pickup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
