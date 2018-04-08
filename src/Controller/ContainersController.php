<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class ContainersController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'order' => ['Containers.gallons' => 'ASC']
        ];
        $containers = $this->paginate($this->Containers);

        $this->set(compact('containers'));
        $this->set('_serialize', ['containers']);
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $container = $this->Containers->get($id, [
                'contain' => ['Sites']
            ]);
        } else {  
        // Add - first load
            $container = $this->Containers->newEntity();
        }

        // Save
        if ($this->request->is(['patch', 'post', 'put'])) {
            $container = $this->Containers->patchEntity($container, $this->request->getData());
            if ($this->Containers->save($container)) {
                $this->Flash->success(__('The container has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The container could not be saved. Please, try again.'));
        }

        $this->set(compact('container', 'id'));
        $this->set('_serialize', ['container']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $container = $this->Containers->get($id);
        if ($this->Containers->delete($container)) {
            $this->Flash->success(__('The container has been deleted.'));
        } else {
            $this->Flash->error(__('The container could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}