<div class="collections index large-9 medium-8 columns content">
    <h3><?= __('Residential Subscribers') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('Subscriber') ?></th>
                <th><?= $this->Paginator->sort('ChargeBee ID') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subscribers as $subscriber): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Details'), ['action' => 'details', $subscriber->external_id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscriber->id], ['confirm' => __('Are you sure you want to delete this subscriber?', $subscriber->id)]) ?>    
                </td>
                <td><?= h($subscriber->first_name) . ' ' . h($subscriber->last_name) ?></td>
                <td><?= h($subscriber->external_id) ?></td>
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