<div class="pickups index large-9 medium-8 columns content">
    <h3><?= __('Pickups') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('Client') ?></th>
                <th><?= $this->Paginator->sort('Site') ?></th>
                <th><?= $this->Paginator->sort('Location') ?></th>
                <th><?= $this->Paginator->sort('User') ?></th>
                <th><?= $this->Paginator->sort('Date') ?></th>
                <th><?= $this->Paginator->sort('Pounds') ?></th>
                <th><?= __('Note')?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pickups as $pickup): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pickup->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pickup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pickup->id)]) ?>    
                </td>
                <td><?= h($pickup->location->site->client->name) ?></td>
                <td><?= h($pickup->location->site->name) ?></td>
                <td><?= h($pickup->location->name) ?></td>
                <td><?= h($pickup->user->name) ?></td>
                <td><?= h($pickup->pickup_date) ?></td>
                <td><?= h($pickup->pounds) ?></td>
                <td><?= h($pickup->note) ?></td>
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