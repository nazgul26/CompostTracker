<script>
$( function() {
    $('#navActivePiles').addClass('active');
});
</script>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Active Pile'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Piles'), ['controller' => 'Piles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pile'), ['controller' => 'Piles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="activePiles index large-9 medium-8 columns content">
    <h3><?= __('Active Piles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pile_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activePiles as $activePile): ?>
            <tr>
                <td><?= $this->Number->format($activePile->id) ?></td>
                <td><?= $activePile->has('pile') ? $this->Html->link($activePile->pile->name, ['controller' => 'Piles', 'action' => 'view', $activePile->pile->id]) : '' ?></td>
                <td><?= h($activePile->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $activePile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activePile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activePile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activePile->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
