<script type="text/javascript">

    var placeSearch, autocomplete, map;
    var serviceArea = []

    var componentForm = {
        street_number: ['short_name', 'AddressStreet1'],
        route: ['long_name', 'AddressStreet1'],
        locality: ['long_name', 'AddressCity'],
        administrative_area_level_1: ['short_name', 'AddressState'],
        country: ['long_name', 'AddressCountry'],
        postal_code: ['short_name', 'AddressZip']
    };

    $(function() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);

        $("#phone").inputmask({"mask": "(999) 999-9999"});
        $("#addressOK").hide();
        $("#addressFail").hide();
        initMap();
    });

    function initMap() {

        var serviceAreaCords = [
            <?= $coordinateData?>
        ];

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lng: -81.56, lat: 41.50},
          zoom: 11,
        });

        // Construct the polygons.
        for (i = 0; i < serviceAreaCords.length; i++) {
            console.log("Area" + i);
            serviceArea[i] = new google.maps.Polygon({
                paths: serviceAreaCords[i],
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            serviceArea[i].setMap(map);
        }
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();
        
        for (var key in componentForm) {
            $('#' + componentForm[key][1]).val('');
        }

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType][0]];
                var itemId = "#" + componentForm[addressType][1];
                if (addressType === "route") {
                    $(itemId).val($(itemId).val() + " " + val);
                } else {
                    $(itemId).val(val);
                }
            }
        }
        
        var inArea = false;
        for (var i=0; i < serviceArea.length && !inArea; i++) {
            inArea = google.maps.geometry.poly.containsLocation(place.geometry.location, serviceArea[i]);
        }

        if (inArea) {
            $("#addressOK").show();
            $("#formInputs").show();
            $("#addressFail").hide();
        } else {
            $("#addressOK").hide();
            $("#formInputs").hide();
            $("#addressFail").show();
        }

        // Create a marker and set its position.
        marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            title: 'Your Address',
            draggable: false,
            animation: google.maps.Animation.DROP,
        });
    }
</script>

<div class="logo">
    <?= $this->Html->image("logo_circle.png", ["alt" => "Rust Belt Riders", "class" => "center-block"])?>
</div>


<h2 class="text-center">Residential Curbside Composting Signup</h2>
Our collection service takes all your food scraps and makes them into compost.
<hr/>

<div id="map"></div>

<div class="users form">
<?= $this->Form->create('User') ?>
    <div class="form-group text">
        <label for="residentAddress">Address</label>
        <input id="autocomplete" 
            placeholder="Street Address" 
            type="text" 
            class="form-control"/>
    </div>

    <div id="addressBlock">
    <?= $this->Form->input('Address.street1', ['id'=>'AddressStreet1']); ?>
    <?= $this->Form->input('Address.city', ['id'=>'AddressCity']); ?>
    <?= $this->Form->input('Address.state', ['id'=>'AddressState']); ?>
    <?= $this->Form->input('Address.zip', ['id'=>'AddressZip']); ?>
    </div>
    <div id="addressOK" class="alert alert-success" role="alert"><b>Great!</b> Service is available for your address.</div>
    <div id="addressFail" class="alert alert-danger" role="alert">
        <b>Sorry.</b> We are not currently serving your address. Please <a href="https://form.jotform.com/80254420403140">fill out this survey</a> to help us target what areas we offer services in next.
    </div>

    <div id="formInputs">
    <?= $this->Form->control('first_name', ['required'=>'required']) ?>
    <?= $this->Form->control('last_name', ['required'=>'required']) ?>
    <?= $this->Form->control('username', ['autocomplete'=>'off', 'label'=>'Email', 'type'=>'email', 'required'=>'required', 'placeholder'=>'your@email.com']) ?>
    <?= $this->Form->control('phone', ['required'=>'required', 'type'=>'tel', 'placeholder'=>'(555) 555-5555']) ?>
    <?= $this->Form->control('password1', ['label' => 'Password', 'type' => 'password', 'required'=>'required']) ?>
    <?= $this->Form->control('password2', ['label' => 'Confirm Password', 'type' => 'password','required'=>'required']) ?>
    <?= $this->Form->button(__('Sign Up')); ?>
    </div>
<?= $this->Form->end() ?>
</div>
<br/>
<?= $this->Flash->render() ?>