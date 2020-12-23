<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<div class="clients index large-9 medium-8 columns content">
    <h3><?= __('Clients') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
               <td>
                    <?php 
                    if ($client->active) {
                        echo $this->Html->link(__('Edit'), ['action' => 'edit', $client->id]) . " | ";
                        echo $this->Form->postLink(__('Remove'), ['action' => 'activate', $client->id, 0], ['confirm' => __('Are you sure you want to remove {0}?', $client->name)]); 
                    } else {
                        echo $this->Form->postLink(__('Restore'), ['action' => 'activate', $client->id, 1], ['confirm' => __('Are you sure you want to restore {0}?', $client->name)]); 
                    } 
                    ?>
                </td>
                <td><?= h($client->name) ?></td>
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

    <?= $this->Html->link(__('Add New Client'), ['action' => 'edit'], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
</div>
