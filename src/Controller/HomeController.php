<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Form\ReportsForm;
use Cake\I18n\Time;
use Cake\Core\Configure;

class HomeController extends AppController
{
    public function isAuthorized($user = null) {
        if ($user['access_level'] >= Configure::read('AuthRoles.residential')) {
            return true;
        }
        
        return parent::isAuthorized($user);
    }


    public function index()
    {
        if ($this->Auth->user('access_level') == Configure::read('AuthRoles.residential')) {
            $accountCreatedDate = $this->Auth->user('created');
            $userId = $this->Auth->user('id');
            
            // Collection Day
            $zonesTable = TableRegistry::get('Zones');
            $days = Configure::read('DaysOfWeek');
            $zone = $zonesTable->get($this->Auth->user('zone_id'));
            $collectionDay = $days[$zone->collection_day];

            // Collection history
            $collectionsTable = TableRegistry::get('Collections');
            $collections = $collectionsTable->find('all',
            [
                'conditions' => ['Collections.customer_user_id' => $userId],
                'order' => ['Collections.pickup_date' => 'DESC']
            ]);
            $collections->execute();
            
            $this->set(compact('accountCreatedDate', 'collectionDay', 'collections'));

            $this->render("residential");
        } else if ($this->Auth->user('access_level') == Configure::read('AuthRoles.client')) {
            $this->render("client");
        } else if ($this->Auth->user('access_level') >= Configure::read('AuthRoles.user')) {
            $this->render("employee");
        }
        
    }

}
