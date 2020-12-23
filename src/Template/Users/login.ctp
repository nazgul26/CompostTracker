<div style="margin: auto; width: 10%;">
    <div class="bigLogo">
        <?= env('LOGO_LETTERS') ?>
    </div>
</div>
<div class="users form">
<?= $this->Form->create() ?>
    <fieldset>
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