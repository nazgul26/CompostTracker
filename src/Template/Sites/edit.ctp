<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Clients'), ['controller'=>'clients', 'action' => 'index'])?></li>
  <li><?= $this->Html->link(__('Edit Client'), ['controller'=>'clients', 'action' => 'edit', $clientId])?></li>
  <li class="active"><?= ($siteId) ? "Edit Site" : "Add Site"?></li>
</ol>

<div class="sites form large-9 medium-8 columns content">
    <?= $this->Form->create($site) ?>
    <fieldset>
        <legend><?= (isset($site->client)) ? $site->client->name : ""?></legend>
        <?php
            echo $this->Form->control('client_id', ['type' => 'hidden', 'value' => $clientId]);
            echo $this->Form->control('name', ['autocomplete'=>'off']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?php if ($siteId) { ?>
    <h3><?= __('Locations') ?></h3>
    <?php if ($site->locations) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>              
            </tr>
        </thead>
        <tbody>
            <?php foreach ($site->locations as $location): ?>
            <tr>
                <td>
                    <?= $this->Html->link(__('Edit'), ['controller'=>'locations', 'action' => 'edit', $clientId, $siteId, $location->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'locations', 'action' => 'delete', $clientId, $siteId, $location->id], 
                        ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?>
                </td>
                <td><?= h($location->name) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php } else { ?>
            <div class="alert alert-warning">No Locations Setup</div>
    <?php } ?>
    <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
            <li><?= $this->Html->link(__('New Location'), ['controller'=>'locations', 'action' => 'edit', $clientId, $siteId]) ?></li>
        </ul>
    </nav>
<?php } ?>