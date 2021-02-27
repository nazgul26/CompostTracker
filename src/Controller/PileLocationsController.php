<?php
namespace App\Controller;

use App\Controller\AppController;

class PileLocationsController extends AppController
{
    public function index()
    {
        $piles = $this->paginate($this->PileLocations, ['order' => ['PileLocations.name']]);
        $this->set(compact('piles'));
    }


    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $pile = $this->PileLocations->get($id);
        } else {  
        // Add - first load
            $pile = $this->PileLocations->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pile = $this->PileLocations->patchEntity($pile, $this->request->getData());
            if ($this->PileLocations->save($pile)) {
                $this->Flash->success(__('The pile location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pile location could not be saved. Please, try again.'));
        }
        $this->set(compact('pile', 'id'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pile = $this->PileLocations->get($id);
        if ($this->PileLocations->delete($pile)) {
            $this->Flash->success(__('The pile location has been deleted.'));
        } else {
            $this->Flash->error(__('The pile location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
