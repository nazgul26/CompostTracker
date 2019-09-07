<?php
    $addUrl =  $this->Url->build([
    "controller" => "Collections",
    "action" => "add", ""]);
?>

<script>
$( function() {
    $('#navAddResidentialPickup').addClass('active');

    $('#loadSubscriber').click(function(e) {
        e.preventDefault();
        $subscriberId = $('#subscriber-id').val();
        window.location = "<?=$addUrl?>/" +  $subscriberId;
        return false;
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
        <?= $subscriber->street1 ?><br/>
        <?= $subscriber->city ?>
        </div>
        <?php if (!$subscriber->active) : ?>
            <div class="alert alert-warning" role="alert">
            This account is currently not Active!
            </div>
        <?php endif;?>

        <?= $this->Form->control('pounds'); ?> 
        <?= $this->Form->control('note', ['autocomplete' => 'off'])?>
        <p>
            <button type="submit" class="btn btn-primary" id="savePickup">Submit</button>
        </p>
    <?php else:?>
        <button type="button" class="btn btn-info" id="loadSubscriber" style="width: 100%;">Load</button>
    <?php endif;?>

<?= $this->Form->end() ?>
