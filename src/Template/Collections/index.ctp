<div class="collections index large-9 medium-8 columns content">
    <h3><?= __('Residential Collections') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('Customer') ?></th>
                <th><?= $this->Paginator->sort('Date') ?></th>
                <th><?= $this->Paginator->sort('Pounds') ?></th>
                <th><?= __('Note')?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collections as $collection): ?>
            <tr>
               <td>
                    Edit | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $collection->id], ['confirm' => __('Are you sure you want to delete this collection?', $collection->id)]) ?>    
                </td>
                <td><?= h($collection->customer->first_name) ?></td>
                <td><?= h($collection->pickup_date) ?></td>
                <td><?= h($collection->pounds) ?></td>
                <td><?= h($collection->note) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <?= $this->Paginator->numbers() ?>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>