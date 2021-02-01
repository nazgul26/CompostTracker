<?php
namespace App\Controller;

use App\Controller\AppController;

class PilesController extends AppController
{
    public function index()
    {
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
                $this->Flash->success(__('The pile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pile could not be saved. Please, try again.'));
        }
        $this->set(compact('pile', 'id'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pile = $this->Piles->get($id);
        if ($this->Piles->delete($pile)) {
            $this->Flash->success(__('The pile has been deleted.'));
        } else {
            $this->Flash->error(__('The pile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
