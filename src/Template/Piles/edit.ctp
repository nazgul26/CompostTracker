
<div class="activePiles form large-9 medium-8 columns content">
    <?= $this->Form->create($pile) ?>
    <fieldset>
        <legend><?= __('Edit Active Pile') ?></legend>
        <?php
            echo $this->Form->control('pile_location_id', ['options' => $pileLocations, 'empty' => true]);
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
