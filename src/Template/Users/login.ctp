<div class="logo">
    <?= $this->Html->image("logo_circle.png", ["alt" => "Rust Belt Riders", "class" => "center-block"])?>
</div>
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