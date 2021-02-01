<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>
<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Piles'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="piles form large-9 medium-8 columns content">
    <?= $this->Form->create($pile) ?>
    <fieldset>
        <legend><?= __('Edit Pile') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div> 
