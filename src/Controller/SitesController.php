<?php
namespace App\Controller;

use App\Controller\AppController;

class SitesController extends AppController
{
    public function edit($clientId, $siteId = null)
    {
        // Edit
        if ($siteId) {
            $site = $this->Sites->get($siteId, [
                'contain' => ['Clients', 'Locations']
            ]);
        } else {  
        // Add - first load
            $site = $this->Sites->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->getData());
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));
                return $this->redirect(['controller'=>'clients', 'action' => 'edit', $clientId]);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site', 'clients', 'siteId', 'clientId'));
        $this->set('_serialize', ['site']);
    }

    public function delete($clientId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($id);
        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'clients', 'action' => 'edit', $clientId]);
    }
}
