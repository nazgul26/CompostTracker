<script>
$( function() {
    $('#navActivePiles').addClass('active');
});
</script>

<div class="activePiles index large-9 medium-8 columns content">
    <h3><?= __('Active Piles') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pile_location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($piles as $activePile): ?>
            <tr>
                <td><?= $this->Number->format($activePile->id) ?></td>
                <td><?= $activePile->has('pile_location') ? $this->Html->link($activePile->pile_location->name, ['controller' => 'Piles', 'action' => 'view', $activePile->pile_location->id]) : '' ?></td>
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
    </div>
    <?= $this->Html->link(__('Add New Pile'), ['action' => 'edit'], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
</div>
