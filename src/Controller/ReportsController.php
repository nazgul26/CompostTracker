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
        if ($user['access_level'] >= Configure::read('AuthRoles.user')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }


    public function index()
    {
        $report = new ReportsForm();

        $client = TableRegistry::get('Clients');
        $clients = $client->find('list', ['limit' => 200]);
        $this->set(compact('report', 'clients'));
        $this->set('_serialize', ['report']);
    }

    public function export() {
        $pickups = TableRegistry::get('Pickups');
        $requestData = $this->request->getData();
        $clientId = $requestData['client_id'];
        $startDate = new Time($requestData['start_date']['year'] . '/' . $requestData['start_date']['month'] . '/' . $requestData['start_date']['day'] . " 00:00");
        $endDate = new Time($requestData['end_date']['year'] . '/' . $requestData['end_date']['month'] . '/' . $requestData['end_date']['day'] . " 24:00");

		$this->response->download("report.csv");

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
		$this->set(compact('pickups'));
		return;
	}

    public function summary() {
        $pickups = TableRegistry::get('Pickups');
        $requestData = $this->request->getData();
        $clientId = $requestData['client_id'];
        $startDate = new Time($requestData['start_date']['year'] . '/' . $requestData['start_date']['month'] . '/' . $requestData['start_date']['day'] . " 00:00");
        $endDate = new Time($requestData['end_date']['year'] . '/' . $requestData['end_date']['month'] . '/' . $requestData['end_date']['day'] . " 24:00");
        
		$pickups = $pickups->find('all',
            [
                'conditions' => [
                    'Clients.id' => $clientId, 
                    'Pickups.pickup_date >=' => $startDate,
                    'Pickups.pickup_date <=' => $endDate
                    ],
                'contain' => [
                    'Users', 
                    'Locations' => 
                        ['Sites' => ['Clients']],
                    'Containers'
                    ],
                'order' => ['Pickups.pickup_date' => 'DESC']
            ]);
		$this->set(compact('pickups'));
		return;
    }

}
