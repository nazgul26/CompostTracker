<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Clients'), ['controller'=>'clients', 'action' => 'index'])?></li>
  <li><?= $this->Html->link(__('Edit Client'), ['controller'=>'clients', 'action' => 'edit', $clientId])?></li>
  <li><?= $this->Html->link(__('Edit Client'), ['controller'=>'sites', 'action' => 'edit', $clientId, $siteId])?></li>
  <li class="active"><?= ($locationId) ? "Edit Location" : "Add Location"?></li>
</ol>

<div class="locations form large-9 medium-8 columns content">
    <?= $this->Form->create($location) ?>
    <fieldset>
        <legend><?= (isset($location->site)) ? $location->site->name : ""?></legend>
        <?php
            echo $this->Form->control('name', ['autocomplete'=>'off']);
            echo $this->Form->control('site_id', ['type' => 'hidden', 'value' => $siteId]);
            echo $this->Form->control('containers._ids', ['options' => $containers]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
