<?php use Cake\Core\Configure; ?>
<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Drop offs'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($drop) ?>
    <fieldset>
        <legend><?= __('Edit Drop Off Location') ?></legend>
        <?= $this->Form->control('name'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>