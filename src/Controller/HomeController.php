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
        if ($this->Auth->user('access_level') == Configure::read('AuthRoles.client')) {
            $this->render("client");
        } else if ($this->Auth->user('access_level') >= Configure::read('AuthRoles.user')) {
            $this->render("employee");
        }
        
    }

}
