<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Piles'), ['controller' => 'piles', 'action' => 'index'])?></li>
  <li><?= $this->Html->link(__('Detail'), ['controller' => 'piles', 'action' => 'details', $pileId])?></li>
  <li class="active"><?= ($id) ? "Edit" : "Add"?></li>
</ol>

<div class="pileTemperatures form large-9 medium-8 columns content">
    <?= $this->Form->create($pileTemperature) ?>
    <fieldset>
        <legend><?= __('Edit Pile Temperature') ?></legend>
        <?php
            echo $this->Form->hidden('pile_id');
            echo $this->Form->control('created');
            echo $this->Form->control('temp1');
            echo $this->Form->control('temp2');
            echo $this->Form->control('temp3');
            echo $this->Form->control('comment');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
