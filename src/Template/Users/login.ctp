<div class="users form">
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->control('username', ['autocomplete'=>'off']) ?>
        <?= $this->Form->control('password') ?>

        <?= $this->Html->link(__('Forgot password?'), array('action' => 'reset')); ?>   
    </fieldset>
    <br/>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
<br/>
<?= $this->Flash->render() ?>