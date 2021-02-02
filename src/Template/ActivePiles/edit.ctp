<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivePile $activePile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activePile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activePile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Active Piles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Piles'), ['controller' => 'Piles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pile'), ['controller' => 'Piles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="activePiles form large-9 medium-8 columns content">
    <?= $this->Form->create($activePile) ?>
    <fieldset>
        <legend><?= __('Edit Active Pile') ?></legend>
        <?php
            echo $this->Form->control('pile_id', ['options' => $piles, 'empty' => true]);
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
