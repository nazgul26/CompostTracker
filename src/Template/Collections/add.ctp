<?php
    $addUrl =  $this->Url->build([
    "controller" => "Collections",
    "action" => "add", ""]);
?>

<script>
$( function() {
    $('#navAddResidentialPickup').addClass('active');

    $('#subscriber-id').change(function() {
        window.location = "<?=$addUrl?>/" +  $(this).val();
    });
});
</script>
 <?= $this->Html->link('Pickup History', ['controller' => 'Collections', 'action' => 'index']); ?>
<h3>Residential Tracking</h3>
<?= $this->Form->create($collection, ['id' => 'addForm'])?>
    <?= $this->Form->control('subscriber_id', ['type'=>'number', 'default' => $subscriberId, 'label' => 'Subscriber #'] )?>
    <hr/>
    <?php if (isset($subscriber)) : ?>
    <div class="customerAddress">
    <?= $subscriber->first_name ?> <?= $subscriber->last_name ?><br/>
    <?= $subscriber->address->street1 ?><br/>
    <?= $subscriber->address->city ?>
    </div>
    <?php endif;?>
    <?= $this->Form->control('pounds'); ?> 
    <?= $this->Form->control('note', ['autocomplete' => 'off'])?>
    <p>
        <button type="submit" class="btn btn-primary" id="savePickup">Submit</button>
    </p>
<?= $this->Form->end() ?>
