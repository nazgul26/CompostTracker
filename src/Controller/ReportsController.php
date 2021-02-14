<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Form\ReportsForm;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

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
        $allowPickClient = true;
        $authLevel = $this->Auth->user('access_level');
        if ($authLevel == Configure::read('AuthRoles.client')) {
            $allowPickClient = false;
        }

        $report = new ReportsForm();

        $client = TableRegistry::get('Clients');
        $clients = $client->find('list', ['conditions' => ['Clients.active' => true], 'limit' => 200, 'order' => 'Clients.name']);
        $this->set(compact('report', 'clients', 'allowPickClient'));
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
                    'Containers',
                    'Dropoffs'
                    ],
                'order' => ['Pickups.pickup_date' => 'DESC']
            ]);
            
        
        if ($export) {
            $containers = $containers->find('list', ['limit' => 200])->toArray();
            $this->set(compact('pickups', 'containers'));
            $this->response->download("report.csv");
            $this->render('commercial_export');
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
    
    public function residential() {
        // TODO: lock down to employee only
        if ($this->request->is(['patch', 'post', 'put'])) {
            $collectionDay = $this->request->getData()['collection_day'];

            $usersTable = TableRegistry::get('Users');
            $users = $usersTable->find('all',
            [
                'conditions' => ['Zones.collection_day' => $collectionDay, 'Users.active' => 1],
                'contain' => [
                    'Zones',
                    'Addresses'
                ],
                'order' => ['Users.last_name']
            ]);
            $users->execute();
 
            $this->set(compact('users'));
            $this->response->download("report.csv");
            $this->render('residential_export');
        }
    }

    public function monthly() {
        //$authLevel = $this->Auth->user('access_level');
        //if ($authLevel == Configure::read('AuthRoles.client')) {
        //    $clientId = $this->Auth->user('client_id');
        //}

        $startDate = Time::now();
        $startDate->subYears(1);

        /*$conn = ConnectionManager::get('default');
            
        $stmt = $conn->execute('SELECT SUM(pounds) Pounds, MONTH(pickup_date) month, YEAR(pickup_date) Year  
        FROM pickups 
        WHERE pickup_date >= ?
        GROUP BY MONTH(pickup_date), YEAR(pickup_date) ORDER BY YEAR(pickup_date), MONTH(pickup_date);', [$startDate]);
        $row = $stmt->fetch('assoc');

        // Read all rows.
        $rows = $stmt->fetchAll('assoc');
        
        // Read rows through iteration.
        foreach ($rows as $row) {
            // Do work
            echo print_r($row);
        }

        $this->set(compact('pickups'));*/
        $this->render('monthy'); 
    }

    public function piles() {
        $report = new ReportsForm();
        $this->set(compact('report'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $startDate = new Time($requestData['start_date']['year'] . '/' . $requestData['start_date']['month'] . '/' . $requestData['start_date']['day'] . " 00:00");
            $endDate = new Time($requestData['end_date']['year'] . '/' . $requestData['end_date']['month'] . '/' . $requestData['end_date']['day'] . " 24:00");
            
            $pilesTable = TableRegistry::get('Piles');
            $piles = $pilesTable->find('all',
            [
                'conditions' => ['Piles.created >= ' => $startDate, 'Piles.done_date <= ' => $endDate],
                'contain' => ['PileLocations', 'PileTemperatures' => ['Users'], 'PileTurns' => ['Users'], 'Users'],
                'order' => ['Piles.created']
            ]);
            $piles->execute();
 
            $this->set(compact('piles'));
            $this->response->download("report.csv");
            $this->render('piles_export');
        }
    }
}
