<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class DropoffsController extends AppController
{
    public function index()
    {
        $dropoffs = $this->paginate($this->Dropoffs);

        $this->set(compact('dropoffs'));
        $this->set('_serialize', ['dropoffs']);
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $drop = $this->Dropoffs->get($id);
        } else {  
        // Add - first load
            $drop = $this->Dropoffs->newEntity();
        }

        // Save
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $drop = $this->Dropoffs->patchEntity($drop, $requestData);
            if ($this->Dropoffs->save($drop)) {
                $this->Flash->success(__('The drop off location has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The drop off could not be saved. Please, try again.'));
        }

        $this->set(compact('drop', 'id'));
        $this->set('_serialize', ['drop']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Dropoffs->get($id);
        if ($this->Dropoffs->delete($client)) {
            $this->Flash->success(__('The drop off has been deleted.'));
        } else {
            $this->Flash->error(__('The drop off could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}