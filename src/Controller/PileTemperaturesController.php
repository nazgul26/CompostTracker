<?php
namespace App\Controller;

use App\Controller\AppController;

class PileTemperaturesController extends AppController
{
    public function edit($pileId = null, $id = null)
    {
        $pileTemperature = $this->PileTemperatures->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pileTemperature = $this->PileTemperatures->patchEntity($pileTemperature, $this->request->getData());
            if ($this->PileTemperatures->save($pileTemperature)) {
                $this->Flash->success(__('The pile temperature has been saved.'));

                return $this->redirect(['controller'=> 'piles', 'action' => 'details', $pileId]);
            }
            $this->Flash->error(__('The pile temperature could not be saved. Please, try again.'));
        }
        $piles = $this->PileTemperatures->Piles->find('list', ['limit' => 200]);
        $users = $this->PileTemperatures->Users->find('list', ['limit' => 200]);
        $this->set(compact('pileTemperature', 'piles', 'users', 'pileId', 'id'));
    }

    public function delete($pileId = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pileTemperature = $this->PileTemperatures->get($id);
        if ($this->PileTemperatures->delete($pileTemperature)) {
            $this->Flash->success(__('The pile temperature has been deleted.'));
        } else {
            $this->Flash->error(__('The pile temperature could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=> 'piles', 'action' => 'details', $pileId]);
    }
}
