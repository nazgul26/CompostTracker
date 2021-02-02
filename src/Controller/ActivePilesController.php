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
        $activePile = $this->Piles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activePile = $this->Piles->patchEntity($activePile, $this->request->getData());
            if ($this->Piles->save($activePile)) {
                $this->Flash->success(__('The active pile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The active pile could not be saved. Please, try again.'));
        }
        $pileLocations = $this->Piles->PileLocations->find('list', ['limit' => 200]);
        $this->set(compact('pile', 'pileLocations'));
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
