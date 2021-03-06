<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;

/*
    Commercial Account Pickups
*/
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
                'Dropoffs',
                'Locations' => 
                    ['Sites' => ['Clients']]
            ],
            'order' => ['Pickups.pickup_date' => 'DESC']
        ];
        $pickups = $this->paginate($this->Pickups);

        $this->set(compact('pickups'));
        $this->set('_serialize', ['pickups']);
    }

    public function pounds() {
        $query = $this->Pickups->find();
        $totalQuery = $query->select(['total' => $query->func()->sum('pounds')]);
        // Pounds CO2 = Pounds collected in this App + Total Collected Prior * .72
        $total = round(($totalQuery->first()->total + 2500000) * .72);
        $this->set('total', $total);
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
            $requestData['pickup_date'] = date("Y-m-d H:i:s");
            $requestData['user_id'] = $this->Auth->user('id');

            // Auto Zero the pickup weight using the container weights
            $zeroTotal = 0;
            foreach ($requestData['containers'] as $container) {
                $weight = $container['weight'];
                $quantity = $container['_joinData']['quantity'];
                $zeroTotal += $weight * $quantity;
            }
            $requestData['pounds'] = $requestData['pounds'] - $zeroTotal;

            $pickup = $this->Pickups->patchEntity($pickup, $requestData ,
                ['associated' => ['Containers', 'Containers._joinData']]
            );

            if ($this->Pickups->save($pickup, ['associated' => ['Containers._joinData']])) {
                $this->Flash->success(__('The pickup has been saved.'));
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('The pickup could not be saved. Please, try again.'));
            }
        }
        $clients = $this->Pickups->Locations->Sites->Clients->find('list', ['conditions' => ['Clients.active' => true],
            'limit' => 200, 'order' => 'Clients.name']);
        $sites = $this->Pickups->Locations->Sites->find('list', ['conditions' => ['Sites.client_id' => $clientId], 'limit' => 200, 'order' => 'Sites.name']);
        $locations = $this->Pickups->Locations->find('list')->where(['Locations.site_id' => $siteId])->limit(200);
        $dropoffs = $this->Pickups->Dropoffs->find('list', ['order' => 'Dropoffs.name'])->limit(200);

        if (!isset($locationId) && $siteId && $locations->count() > 0) {
            $locationId = array_keys($locations->toArray())[0];
        }
        $containers = $this->Pickups->Locations->find('all')->where(['Locations.id' => $locationId])->contain(['Containers'])->limit(200);

        $this->set(compact('clientId', 'siteId', 'locationId', 'pickup', 'clients', 'sites', 'locations', 'containers', 'dropoffs'));
        $this->set('_serialize', ['pickup']);
    }

    public function edit($id = null)
    {
        $pickup = $this->Pickups->get($id, [
            'contain' => [
                'Users', 
                'Locations' => 
                    ['Sites' => ['Clients']],
                'Containers',
                'Dropoffs'
            ]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //$this->Pickups->association('PickupsContainers')->saveStrategy();
            $pickup = $this->Pickups->patchEntity($pickup, $this->request->getData()
                ,['associated' => ['Containers._joinData']]
            );

            if ($this->Pickups->save($pickup)) {

                $this->Flash->success(__('The pickup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The pickup could not be saved. Please, try again.'));
        }
        $users = $this->Pickups->Users->find('list', ['limit' => 200]);
        $this->set(compact('pickup', 'users', 'containers'));
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
