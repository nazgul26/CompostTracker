<?php
use Cake\Core\Configure;
?>
<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Users'), ['contoller'=>'users', 'action' => 'index'])?></li>
  <li class="active"><?= ($userId) ? "Edit User" : "Add User"?></li>
</ol>
<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password1', ['label' => 'Password', 'type' => 'password']) ?>
        <?= $this->Form->control('password2', ['label' => 'Confirm Password', 'type' => 'password']) ?>
        <?php if ($isAdmin) {
          echo $this->Form->input('access_level', array('options' => Configure::read('AuthRolesList')));
          echo $this->Form->input('client_id',['empty' => true]);
        } ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
</div>