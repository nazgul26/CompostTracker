<?php
    $addUrl =  $this->Url->build([
    "controller" => "Pickups",
    "action" => "add", "", "", ""]);
?>

<script>
$( function() {
    
    $('.add-quantity .form-control').val(0);

    $('.add-spinner').click(function() {
        var $input = $(this).parent().parent().find('.form-control');
        $input.val(parseInt($input.val(), 10) + 1);
    });
    $('.subtract-spinner').click(function() {
        var $input = $(this).parent().parent().find('.form-control');
        var newValue = parseInt($input.val(), 10) - 1;
        if (newValue) {
            $input.val(newValue);
        }
    });

    $('#client-id').change(function() {
        window.location = "<?=$addUrl?>/" + $(this).val();
    });

    $('#site-id').change(function() {
        window.location = "<?=$addUrl?>/<?= $clientId?>/" +  $(this).val();
    });
});
</script>
<h3>Organic Waste Tracking</h3>
<?= $this->Form->create($pickup, ['id' => 'addForm'])?>
<?= $this->Form->control('client_id', ['empty' => true, 'default' => $clientId])?>
<?php if ($clientId) { ?>
    <?= $this->Form->control('site_id', ['empty' => true, 'default' => $siteId])?>
    <?php if ($siteId) { 
        if ($locations->count() > 1) {
            echo $this->Form->control('location_id');
        } else {
            echo $this->Form->control('location_id', ['type'=>'hidden', 'value'=>$locationId]);
        }
    echo "<hr/>";
    if ($containers->count() == 0) {
        echo '<div class="alert alert-danger">No Locations Setup</div>';
    }
    foreach ($containers as $container) {
        $i = 0;
        foreach ($container["containers"] as $item) {?>
            <div class="row">
               <div class="col-md-10">
                    <?= $this->Form->control("containers." . $i . ".id", ['type' => 'hidden', 'value' => ($i+1)])?>
                    <div class="form-group">
                        <label>Container</label>
                        <div class="containerName"><?=$item['name']?></div>
                        <?= $this->Form->control("containers." . $i . "._joinData.container_id", ['type' => 'hidden', 'value' => $item['id']])?>
                    </div>
                </div>
                <div class="col-md-2 add-quantity">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number subtract-spinner">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </span>
                        <?= $this->Form->control("containers." . $i . "._joinData.quantity") ?>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number add-spinner">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <br/>
        <?php $i++; 
            }?>
    <?php 
        }?>
        <hr/>
        <?= $this->Form->control('pounds'); ?> 
        <?= $this->Form->control('note', ['autocomplete' => 'off'])?>
        <p>
            <button type="submit" class="btn btn-primary" id="savePickup">Submit</button>
        </p>
    <?php } ?>
<?php } ?>
<?= $this->Form->end() ?>
