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
                <?= $this->Html->link(__('Edit'), ['controller'=>'sites', 'action' => 'edit', $id, $site->id]) ?> | 
                <?= $this->Form->postLink(__('Delete'), ['controller' => 'sites', 'action' => 'delete', $id, $site->id], 
                    ['confirm' => __('Are you sure you want to delete # {0}?', $site->id)]) ?>
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
<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('New Site'), ['controller'=>'sites', 'action' => 'edit', $id]) ?></li>
    </ul>
</nav>
<?php } ?>
