<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('New Service Zone'), ['action' => 'edit']) ?></li>
    </ul>
</nav>
<div class="zones index large-9 medium-8 columns content">
    <h3><?= __('Zones') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('active') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($zones as $zone): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $zone->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $zone->id], ['confirm' => __('Are you sure you want to zone {0}?', $zone->name)]) ?>
                </td>
                <td><?= h($zone->name) ?></td>
                <td><?= $zone->active == 1 ? __('Yes') : __('No') ?></td>
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