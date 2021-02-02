<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<div class="piles index large-9 medium-8 columns content">
    <h3><?= __('Pile Locations') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($piles as $pile): ?>
            <tr>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pile->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pile->id], ['confirm' => __('Are you sure you want to delete {0}?', $pile->name)]) ?>
                </td>
                <td><?= h($pile->name) ?></td>
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
    <?= $this->Html->link(__('Add New Pile Location'), ['action' => 'edit'], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
</div>
