<?php
use Cake\Core\Configure;
?>
<ol class="breadcrumb">
  <?php if ($isAdmin) { ?>
  <li><?= $this->Html->link(__('Users'), ['controller'=>'users', 'action' => 'index'])?></li>
  <?php } else { ?>
    <li><?= $this->Html->link(__('Home'), ['controller'=>'pages', 'action' => 'home'])?></li>
  <?php } ?>
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