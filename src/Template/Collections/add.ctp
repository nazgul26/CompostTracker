<?php
    $addUrl =  $this->Url->build([
    "controller" => "Collections",
    "action" => "add", ""]);
?>

<script>
$( function() {
    $('#navAddResidentialPickup').addClass('active');

    $('#customer-user-id').change(function() {
        window.location = "<?=$addUrl?>/" +  $(this).val();
    });
});
</script>
<h3>Residential Waste Tracking</h3>
<?= $this->Form->create($collection, ['id' => 'addForm'])?>
    <?= $this->Form->control('customer_user_id', ['type'=>'number', 'default' => $customerId, 'label' => 'Customer #'] )?>
    <hr/>
    <?php if (isset($customer)) : ?>
    <div class="customerAddress">
    <?= $customer->first_name ?> <?= $customer->last_name ?><br/>
    <?= $customer->address->street1 ?><br/>
    <?= $customer->address->city ?>
    </div>
    <?php endif;?>
    <?= $this->Form->control('pounds'); ?> 
    <?= $this->Form->control('note', ['autocomplete' => 'off'])?>
    <p>
        <button type="submit" class="btn btn-primary" id="savePickup">Submit</button>
    </p>
<?= $this->Form->end() ?>
