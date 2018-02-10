<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Form\ReportsForm;
use Cake\I18n\Time;
use Cake\Core\Configure;

class ReportsController extends AppController
{
    public function isAuthorized($user = null) {
        if ($user['access_level'] >= Configure::read('AuthRoles.client')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }


    public function index()
    {
        $isClient = false;
        $authLevel = $this->Auth->user('access_level');
        if ($authLevel == Configure::read('AuthRoles.client')) {
            $isClient = true;
        } 

        $report = new ReportsForm();

        $client = TableRegistry::get('Clients');
        $clients = $client->find('list', ['limit' => 200, 'order' => 'Clients.name']);
        $this->set(compact('report', 'clients', 'isClient'));
        $this->set('_serialize', ['report']);
    }

    public function report() {
        $pickups = TableRegistry::get('Pickups');
        $containers = TableRegistry::get('Containers');

        $requestData = $this->request->getData();
        $authLevel = $this->Auth->user('access_level');
        if ($authLevel == Configure::read('AuthRoles.client')) {
            $clientId = $this->Auth->user('client_id');
        } else {
            $clientId = $requestData['client_id'];
        }

        $startDate = new Time($requestData['start_date']['year'] . '/' . $requestData['start_date']['month'] . '/' . $requestData['start_date']['day'] . " 00:00");
        $endDate = new Time($requestData['end_date']['year'] . '/' . $requestData['end_date']['month'] . '/' . $requestData['end_date']['day'] . " 24:00");
        $export = $requestData['export'] == 1;

        $conditions = [
            'Pickups.pickup_date >=' => $startDate,
            'Pickups.pickup_date <=' => $endDate];

        if ($clientId) {
            $conditions['Clients.id'] = $clientId;
        }
        
		$pickups = $pickups->find('all',
            [
                'conditions' => $conditions,
                'contain' => [
                    'Users', 
                    'Locations' => 
                        ['Sites' => ['Clients']],
                    'Containers'
                    ],
                'order' => ['Pickups.pickup_date' => 'DESC']
            ]);
            
        
        if ($export) {
            $containers = $containers->find('list', ['limit' => 200])->toArray();
            $this->set(compact('pickups', 'containers'));
            $this->response->download("report.csv");
            $this->render('export');
        } else {
            $sortedPickups = [];
            foreach ($pickups as $pickup) {
                $sortedPickups[$pickup->location->site->name][] = $pickup;
            }    
            $this->set(compact('sortedPickups'));
            $this->render('graph');
        }

		return;
	}
}
