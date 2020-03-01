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
        $subscriberName = $('#subscriber-name').val();
        if ($subscriberName === "") {
            if (navigator.geolocation) {
                //getReverseGeocodingData(null);
                navigator.geolocation.getCurrentPosition(getReverseGeocodingData, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        } else {
            // Search By Last Name
            window.location = "<?=$addUrl?>/" +  $subscriberName;
        }
        return false;
    });
});


function getReverseGeocodingData(position) {
        var latlng = new google.maps.LatLng(41.4950082,-81.5619442);
        //var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status !== google.maps.GeocoderStatus.OK) {
                alert(status);
            }
            // This is checking to see if the Geoeode Status is OK before proceeding
            if (status == google.maps.GeocoderStatus.OK) {
                console.log(results);
                var address = (results[0].formatted_address);
                //alert(address);
                // Search By Address
                window.location = "<?=$addUrl?>/" +  address;
            }
        });
    }

function showError(error) {
    var error = "";
    switch(error.code) {
        case error.PERMISSION_DENIED:
        error= "User denied the request for Geolocation."
        break;
        case error.POSITION_UNAVAILABLE:
        error = "Location information is unavailable."
        break;
        case error.TIMEOUT:
        error = "The request to get user location timed out."
        break;
        case error.UNKNOWN_ERROR:
        error = "An unknown error occurred."
        break;
    }
    alert (error);
}
</script>
 <?= $this->Html->link('Pickup History', ['controller' => 'Collections', 'action' => 'index']); ?>
<h3>Residential Tracking</h3>
<?= $this->Form->create($collection, ['id' => 'addForm'])?>
    <?= $this->Form->control('subscriber_name', ['type'=>'text', 'default' => $search, 'label' => 'Subscriber Last Name', 'placeholder'=>'<Enter Last Name or Empty to Search by GPS>'] )?>
    <hr/>
    <?php if (isset($subscriber)) : ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $subscriber->first_name ?> <?= $subscriber->last_name ?><br/>
                <?= $subscriber->address->street1 ?><br/>
                <?= $subscriber->address->city ?>
            </div>
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
