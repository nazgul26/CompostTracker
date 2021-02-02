<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivePile $activePile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Active Pile'), ['action' => 'edit', $activePile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Active Pile'), ['action' => 'delete', $activePile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activePile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Active Piles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Active Pile'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Piles'), ['controller' => 'Piles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pile'), ['controller' => 'Piles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="activePiles view large-9 medium-8 columns content">
    <h3><?= h($activePile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Pile') ?></th>
            <td><?= $activePile->has('pile') ? $this->Html->link($activePile->pile->name, ['controller' => 'Piles', 'action' => 'view', $activePile->pile->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($activePile->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($activePile->id) ?></td>
        </tr>
    </table>
</div>
