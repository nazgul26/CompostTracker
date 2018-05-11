<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Containers'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($container) ?>
    <fieldset>
        <legend><?= __('Edit Container') ?></legend>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('gallons'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>