<?php
namespace App\Controller;

use App\Controller\AppController;

class PilesController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'contain' => ['PileLocations'],
        ];
        $piles = $this->paginate($this->Piles);

        $this->set(compact('piles'));
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $pile = $this->Piles->get($id);
        } else {  
        // Add - first load
            $pile = $this->Piles->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pile = $this->Piles->patchEntity($pile, $this->request->getData());
            if ($this->Piles->save($pile)) {
                $this->Flash->success(__('The active pile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The active pile could not be saved. Please, try again.'));
        }
        $pileLocations = $this->Piles->PileLocations->find('list', ['limit' => 200]);
        $this->set(compact('pile', 'pileLocations', 'id'));
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
}
