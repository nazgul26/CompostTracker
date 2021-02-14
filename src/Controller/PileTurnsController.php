<?php
namespace App\Controller;

use App\Controller\AppController;

class PileTurnsController extends AppController
{
    public function delete($pileId = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pileTurn = $this->PileTurns->get($id);
        if ($this->PileTurns->delete($pileTurn)) {
            $this->Flash->success(__('The pile turn has been deleted.'));
        } else {
            $this->Flash->error(__('The pile turn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=> 'piles', 'action' => 'details', $pileId]);
    }
}
