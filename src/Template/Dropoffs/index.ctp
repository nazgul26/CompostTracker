<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<div class="dropoffs index large-9 medium-8 columns content">
    <h3><?= __('Drop Off Locations') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dropoffs as $drop): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $drop->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $drop->id], ['confirm' => __('Are you sure you want to drop off {0}?', $drop->name)]) ?>
                </td>
                <td><?= h($drop->name) ?></td>
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

    <?= $this->Html->link(__('Add New Drop Off Location'), ['action' => 'edit'], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
</div>