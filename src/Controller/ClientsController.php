<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class ClientsController extends AppController
{
    public function index()
    {
        $clients = $this->paginate($this->Clients, ['order' => [
            'Clients.active' => 'desc',
            'Clients.name' => 'asc'
        ]]);

        $this->set(compact('clients'));
        $this->set('_serialize', ['clients']);
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $client = $this->Clients->get($id, [
                'contain' => ['Sites']
            ]);
        } else {  
        // Add - first load
            $client = $this->Clients->newEntity();
        }

        // Save
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }

        $this->set(compact('client', 'id'));
        $this->set('_serialize', ['client']);
    }

    public function activate($id = null, $enableDisable)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        $client->active = $enableDisable;
        if ($this->Clients->save($client)) {
            if ($enableDisable) {
                $this->Flash->success(__('The client has been activated.'));
            } else {
                $this->Flash->success(__('The client has been de-activated.'));
            }
        } else {
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
