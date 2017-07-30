<?php
namespace App\Controller;

use App\Controller\AppController;

class LocationsController extends AppController
{
    public function edit($clientId, $siteId, $locationId = null)
    {
        // Edit
        if ($locationId) {
            $location = $this->Locations->get($locationId, [
                'contain' => ['Containers', 'Sites']
            ]);
        } else {  
        // Add - first load
            $location = $this->Locations->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['controller'=>'sites', 'action' => 'edit', $clientId, $siteId]);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $sites = $this->Locations->Sites->find('list', ['limit' => 200]);
        $containers = $this->Locations->Containers->find('list', ['limit' => 200]);
        $this->set(compact('location', 'sites', 'containers', 'clientId', 'siteId', 'locationId'));
        $this->set('_serialize', ['location']);
    }

    public function delete($clientId, $siteId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'sites', 'action' => 'edit', $clientId, $siteId]);
    }
}
