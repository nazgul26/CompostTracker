<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Piles'), ['action' => 'index'])?></li>
  <li class="active">Take Temperature</li>
</ol>

<div class="activePiles form large-9 medium-8 columns content">
    <?= $this->Form->create($temp) ?>
    <fieldset>
        <?php
            echo $this->Form->control('temp1', ['label' => 'Reading 1', 'placeholder' => 'Set Temperature']);
            echo $this->Form->control('temp2', ['label' => 'Reading 2', 'placeholder' => 'Set Temperature']);
            echo $this->Form->control('temp3', ['label' => 'Reading 2', 'placeholder' => 'Set Temperature']);
            echo $this->Form->control('turn', ['type' => 'radio', 'label' => 'Set Turn Flag']);
            echo $this->Form->control('comment', ['placeholder' => 'Add comments if needed']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>