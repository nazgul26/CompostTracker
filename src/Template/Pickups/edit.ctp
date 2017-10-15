<script>
$( function() {
    /*$('.add-spinner').click(function() {
        var $input = $(this).parent().parent().find('.form-control');
        $input.val(parseInt($input.val(), 10) + 1);
    });
    $('.subtract-spinner').click(function() {
        var $input = $(this).parent().parent().find('.form-control');
        var newValue = parseInt($input.val(), 10) - 1;
        if (newValue) {
            $input.val(newValue);
        }
    });*/
});
</script>

<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Pickups'), ['contoller'=>'pickups', 'action' => 'index'])?></li>
  <li class="active">Edit Pickup</li>
</ol>

<?= $this->Form->create($pickup, ['id' => 'editForm'])?>

<div class="form-group">
    <label class="control-label">Client</label>
    <input type="text" id="client-id" class="form-control" value="<?= $pickup->location->site->client->name?>" disabled />
    <?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$pickup->location->site->client->id])?>
</div>

<div class="form-group">
    <label class="control-label">Site</label>
    <input type="text" id="site-id" class="form-control" value="<?= $pickup->location->site->name?>" disabled />
    <?= $this->Form->control('site_id', ['type'=>'hidden', 'value'=>$pickup->location->site->id])?>
</div>

<div class="form-group">
    <label class="control-label">Location</label>
    <input type="text" id="location-id" class="form-control" value="<?= $pickup->location->name?>" disabled />
    <?= $this->Form->control('location_id', ['type'=>'hidden', 'value'=>$pickup->location->id])?>
</div>
    <?php 
    echo "<hr/>";
    $i = 0;
    foreach ($pickup->containers as $container) { ?>
        <div class="row">
            <div class="col-md-10">
                <!--
                <?//= $this->Form->control("containers." . $i . ".id", ['type' => 'hidden', 'value' => $container->id])?>
                <?//= $this->Form->control("containers." . $i . "._joinData.id", ['type' => 'hidden', 'value' => $container["_joinData"]->id])?>
                <?//= $this->Form->control("containers." . $i . "._joinData.pickup_id", ['type' => 'hidden', 'value' => $pickup->id])?>
                -->
                <div class="form-group">
                    <label>Container</label>
                    <div class="containerName"><?=$container->name?></div>
                    <!--
                    <?//=$this->Form->control("containers." . $i . "._joinData.container_id", ['type' => 'hidden', 'value' => $container->id])?>
                    -->
                </div>
            </div>
            <div class="col-md-2 add-quantity">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-number subtract-spinner">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </span>
                    <input type="text" id="quantity" class="form-control" value="<?= $container["_joinData"]->quantity ?>" disabled />
                    <!--<?//= $this->Form->control("containers." . $i . "._joinData.quantity") ?>-->
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
  
    <hr/>
    <?= $this->Form->control('pounds'); ?> 
    <?= $this->Form->control('note', ['autocomplete' => 'off'])?>
    <?= $this->Form->control('user_id'); ?> 
    <?= $this->Form->control('pickup_date'); ?> 
    <p>
        <button type="submit" class="btn btn-primary" id="savePickup">Save</button>
    </p>
<?= $this->Form->end() ?>