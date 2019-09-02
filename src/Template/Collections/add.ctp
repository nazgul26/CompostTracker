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
        <div class="alert alert-danger" role="alert">
        Subscriber could not be found!
        </div>
    <?php endif;?>

<?= $this->Form->end() ?>
