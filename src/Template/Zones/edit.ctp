<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Zones'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($zone) ?>
    <fieldset>
        <legend><?= __('Edit Zone') ?></legend>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('coordinates'); ?>
        <?= $this->Form->control('active'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>