<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PileTurn $pileTurn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pileTurn->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pileTurn->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Pile Turns'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Piles'), ['controller' => 'Piles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pile'), ['controller' => 'Piles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pileTurns form large-9 medium-8 columns content">
    <?= $this->Form->create($pileTurn) ?>
    <fieldset>
        <legend><?= __('Edit Pile Turn') ?></legend>
        <?php
            echo $this->Form->control('pile_id', ['options' => $piles, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
