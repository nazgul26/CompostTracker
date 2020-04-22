<?php
namespace App\Controller;

use App\Controller\AppController;

class SitesController extends AppController
{
    public function edit($clientId, $siteId = null)
    {
        // Edit
        if ($siteId) {
            $site = $this->Sites->find()->where(['Sites.Id' => $siteId])->contain([
                'Clients',
                'Addresses',
                'Locations' => [
                    'sort' => ['Locations.active' => 'DESC', 'Locations.name' => 'ASC']
                ]
            ])->first();
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
        $this->set(compact('site', 'siteId', 'clientId'));
        $this->set('_serialize', ['site']);
    }

    public function activate($clientId, $siteId, $enableDisable)
    {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($siteId);
        $site->active = $enableDisable;
        if ($this->Sites->save($site)) {
            if ($enableDisable) {
                $this->Flash->success(__('The site has been restored.'));
            } else {
                $this->Flash->success(__('The site has been removed.'));
            }
        } else {
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }

        return $this->redirect(['controller' => 'clients', 'action' => 'edit', $clientId]);
    }
}
