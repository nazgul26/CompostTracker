<script>
    $( function() {
        $('#navAdmin').addClass('active');

        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
    });

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: ['short_name', 'address-street1'],
        route: ['long_name', 'address-street1'],
        locality: ['long_name', 'address-city'],
        administrative_area_level_1: ['short_name', 'address-state'],
        country: ['long_name', 'AddressCountry'],
        postal_code: ['short_name', 'address-zip']
    };
    
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
    }
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

            $this->Form->unlockField('siteAddress');
        ?>
        <div class="location-field">
            <label for="siteAddress">Address Search</label>
            <input id="autocomplete" 
                name="siteAddress" 
                placeholder="<Address Search>" 
                type="text" 
                class="form-control"/>
        </div>
        <br/>
        <?php
            echo $this->Form->control('address.street1', ['autocomplete'=>'off']);
            echo $this->Form->control('address.city', ['autocomplete'=>'off']);
            echo $this->Form->control('address.state', ['autocomplete'=>'off']);
            echo $this->Form->control('address.zip', ['autocomplete'=>'off']);
        ?>
    </fieldset>
    <br/>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?php if ($siteId) { ?>
    <h3><?= __('Locations') ?></h3>
    <?php if (isset($site->locations)) { ?>
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
                <?php 
                    if ($location->active) {
                        echo $this->Html->link(__('Edit'), ['controller'=>'locations', 'action' => 'edit', $clientId, $siteId, $location->id]) . " | ";
                        echo $this->Form->postLink(__('Remove'), ['controller' => 'locations', 'action' => 'activate', $clientId, $siteId, $location->id, 0], 
                            ['confirm' => __('Are you sure you want to remove ?', $location->name)]);
                    } else {
                        echo $this->Form->postLink(__('Restore'), ['controller' => 'locations', 'action' => 'activate', $clientId, $siteId, $location->id, 1], 
                            ['confirm' => __('Are you sure you want to restore ?', $location->name)]);
                    } 
                    ?>
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