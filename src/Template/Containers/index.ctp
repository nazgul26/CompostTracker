<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('New Container'), ['action' => 'edit']) ?></li>
    </ul>
</nav>
<div class="clients index large-9 medium-8 columns content">
    <h3><?= __('Containers') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('gallons') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($containers as $container): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $container->id]) ?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $container->id], ['confirm' => __('Are you sure you want to container {0}?', $container->name)]) ?>
                </td>
                <td><?= h($container->name) ?></td>
                <td><?= h($container->gallons) ?></td>
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