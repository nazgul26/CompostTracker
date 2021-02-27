<?php
namespace App\Controller;

use App\Controller\AppController;

class PileTurnsController extends AppController
{
    public function edit($pileId = null, $id = null)
    {
        if ($id) {
            $pileTurn = $this->PileTurns->get($id);
        } else {  
            // Add - first load
            $pileTurn = $this->PileTurns->newEntity();
            $pileTurn->user_id = $this->Auth->user('id');
            $pileTurn->pile_id = $pileId;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pileTurn = $this->PileTurns->patchEntity($pileTurn, $this->request->getData());
            if ($this->PileTurns->save($pileTurn)) {
                $this->Flash->success(__('The pile turn has been saved.'));

                return $this->redirect(['controller'=> 'piles', 'action' => 'details', $pileId]);
            }
            $this->Flash->error(__('The pile turn could not be saved. Please, try again.'));
        }
        $users = $this->PileTurns->Users->find('list', ['limit' => 200]);
        $this->set(compact('pileTurn', 'users', 'pileId', 'id'));
    }


    public function delete($pileId = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pileTurn = $this->PileTurns->get($id);
        if ($this->PileTurns->delete($pileTurn)) {
            $this->Flash->success(__('The pile turn has been deleted.'));
        } else {
            $this->Flash->error(__('The pile turn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=> 'piles', 'action' => 'details', $pileId]);
    }
}
