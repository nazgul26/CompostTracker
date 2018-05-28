<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class ZonesController extends AppController
{
    public function index()
    {
        $zones = $this->paginate($this->Zones);

        $this->set(compact('zones'));
        $this->set('_serialize', ['zones']);
    }

    public function edit($id = null)
    {
        // Edit
        if ($id) {
            $zone = $this->Zones->get($id);
        } else {  
        // Add - first load
            $zone = $this->Zones->newEntity();
        }

        // Save
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $requestData['coordinates'] = $this->trimCoordinates($requestData['coordinates']);
            $zone = $this->Zones->patchEntity($zone, $requestData);
            if ($this->Zones->save($zone)) {
                $this->Flash->success(__('The zone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zone could not be saved. Please, try again.'));
        }

        $this->set(compact('zone', 'id'));
        $this->set('_serialize', ['zone']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Zones->get($id);
        if ($this->Zones->delete($client)) {
            $this->Flash->success(__('The zone has been deleted.'));
        } else {
            $this->Flash->error(__('The zone could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    function trimCoordinates($txt)
    {
        // Cleanup the KML extra stuff
        $txt = preg_replace('/^\s+|\s+$/m', '', $txt);
        return preg_replace('/^(.*),0$/m', '$1', $txt);
    }   
}