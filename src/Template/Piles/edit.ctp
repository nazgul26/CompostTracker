<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Piles'), ['action' => 'index'])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="activePiles form large-9 medium-8 columns content">
    <?= $this->Form->create($pile) ?>
    <fieldset>
        <?php
            echo $this->Form->control('pile_location_id', ['options' => $pileLocations, 'empty' => true]);
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
