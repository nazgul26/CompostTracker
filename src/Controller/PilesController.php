<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class PilesController extends AppController
{

    private $turns = [ 
        1 => 'Needs Turn', 
        2 => 'Skip Turn', 
        3 => 'Set Later - Need More Info'];

    public function index($filter = 0)
    {
        $today = Time::now();
        $filters = [
            0 => 'All', 
            1 => 'Need Temps', 
            2 => 'Need Flagged for Turn', 
            3 => 'Need Turned', 
            4 => 'Ready to be Done'];

        $piles = $this->Piles->find("all")
            ->where(['active =' => true])
            ->contain(['PileLocations', 'PileTemperatures'])
            ->order(['PileLocations.name' => 'asc']);
        
        if ($filter == 1) {
            // Need Temps
            $piles->where(['OR' => ['temp_last IS NULL', 'temp_last < ' => $today]]);
        } else if ($filter == 2) {
            // Need Flagged For Turn
            $piles->where(['turn_status =' => 3]);
        } else if ($filter == 3) {
            // Need Turned
            $piles->where(['turn_status =' => 1]);
        } else if ($filter == 4) {
            // Ready to be Done (Turned and Temped for Today)
            $piles->where(['turned_last IS NOT NULL', 'temp_last = ' => $today]);
        }


        $this->set(compact('piles', 'filters', 'filter'));
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $pile = $this->Piles->get($id);
        } else {  
            // Add - first load
            $pile = $this->Piles->newEntity();
            $pile->user_id = $this->Auth->user('id');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pile = $this->Piles->patchEntity($pile, $this->request->getData());
            if ($this->Piles->save($pile)) {
                $this->Flash->success(__('The active pile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The active pile could not be saved. Please, try again.'));
        }
        
        // Only allow a new pile to be selected if it is not already Active
        $activePiles = $this->Piles->find()->select(['Piles.pile_location_id'])->where(['Piles.active = ' => 1]);
        $pileLocations = $this->Piles->PileLocations->find('list', ['limit' => 200])->where(['id NOT IN' => $activePiles]);;

        $this->set(compact('pile', 'pileLocations', 'id'));
    }

    public function temp($id = null)
    {
        // Take Temperature
        $temp = $this->Piles->PileTemperatures->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $temp = $this->Piles->PileTemperatures->patchEntity($temp, $requestData);
            $temp->pile_id = $id;
            $temp->user_id = $this->Auth->user('id');
            
            $turnStatus = $requestData["turn"];
            $pile = $this->Piles->get($id);
            $pile->turn_status = $turnStatus;
            $pile->temp_last = Time::now();

            if ($this->Piles->save($pile) && $this->Piles->PileTemperatures->save($temp)) {
                $this->Flash->success(__('The temperatures have been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temps could not be saved. Please, try again.'));
        }

        $turns = $this->turns;
        $this->set(compact('temp', 'turns'));
    }

    public function turn($id = null) {

        $turn = $this->Piles->PileTurns->newEntity();
        $turn->user_id = $this->Auth->user('id');
        $turn->pile_id = $id;

        $pile = $this->Piles->get($id);
        $pile->turn_status = null;
        $pile->total_turns++;
        $pile->turned_last = Time::now();

        if ($this->Piles->save($pile) && $this->Piles->PileTurns->save($turn)) {
            $this->Flash->success(__('Pile Marked as Turned.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The pile could not be saved. Please, try again.'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activePile = $this->Piles->get($id);
        if ($this->Piles->delete($activePile)) {
            $this->Flash->success(__('The active pile has been deleted.'));
        } else {
            $this->Flash->error(__('The active pile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function done($id = null) {
        $pile = $this->Piles->get($id);
        $pile->active = false;
        $pile->done_date = Time::now();

        if ($this->Piles->save($pile)) {
            $this->Flash->success(__('Pile Marked as Done.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The pile could not be saved. Please, try again.'));
    }

    public function decide($id = null, $shouldTurn = null) {
        $pile = $this->Piles->get($id);
        $pile->turn_status = $shouldTurn;

        if ($this->Piles->save($pile)) {
            $this->Flash->success(__('Pile Turn Status Set.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The pile could not be saved. Please, try again.'));
    }

    public function details($id = null) {
        $pile = $this->Piles->get($id, ['contain' => ['PileLocations', 'PileTemperatures', 'PileTurns']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pile = $this->Piles->patchEntity($pile, $this->request->getData());
            if ($this->Piles->save($pile)) {
                $this->Flash->success(__('The pile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pile could not be saved. Please, try again.'));
        }

        $turns = $this->turns;
        $this->set(compact('pile', 'turns'));
    }
}
