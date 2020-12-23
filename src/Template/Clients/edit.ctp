<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Clients'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="clients form large-9 medium-8 columns content">
    <?= $this->Form->create($client) ?>
    <fieldset>
        <legend><?= __('Edit Client') ?></legend>
        <?= $this->Form->control('name'); ?>
        <?= $this->Form->control('contact_name'); ?>
        <?= $this->Form->control('contact_phone', ['type' => 'phone']); ?>
        <?= $this->Form->control('contact_email', ['type' => 'email']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<h3><?= __('Sites') ?></h3>
<?php if ($client->sites) { ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th><?= __('Actions') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($client->sites as $site): ?>
        <tr>
            <td>
            <?php 
                    if ($site->active) {
                        echo $this->Html->link(__('Edit'), ['controller'=>'sites', 'action' => 'edit', $id, $site->id]) . " | ";
                        echo $this->Form->postLink(__('Remove'), ['controller' => 'sites', 'action' => 'activate', $id, $site->id, 0], 
                            ['confirm' => __('Are you sure you want to remove {0}?', $site->name)]);
                    } else {
                        echo $this->Form->postLink(__('Restore'), ['controller' => 'sites', 'action' => 'activate', $id, $site->id, 1], 
                            ['confirm' => __('Are you sure you want to restore {0}?', $site->name)]);
                    } 
                    ?>
            </td>
            <td><?= h($site->name) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php } else { ?>
    <div class="alert alert-warning">No Sites Setup</div>
<?php } ?>

<?php if ($id) { ?>
<?= $this->Html->link(__('Add New Site'), ['controller'=>'sites', 'action' => 'edit', $id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
<?php } ?>
