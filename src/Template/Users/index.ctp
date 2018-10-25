<script>
$( function() {
    $('#navAdmin').addClass('active');
});
</script>

<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('New User'), ['action' => 'edit']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('ID') ?></th>
                <th><?= $this->Paginator->sort('Status') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('access') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id])?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete permamently {0}?', $user->username)]) ?>
                </td>
                <td><?= h($user->id) ?></td>
                <td><?= ($user->active) ? "Active" : "Disabled" ?></td>
                <td><?= h($user->first_name) . ' ' . h($user->last_name)?></td>
                <td><?= h($user->email) ?></td>
                <td><?php switch ($user->access_level) {
                    case 90: 
                        echo "Admin"; 
                        break;
                    case 60:
                        echo "User"; 
                        break;
                    case 30:
                        echo "Client"; 
                        break;
                    case 20:
                        echo "Residential"; 
                        break;
                    default: 
                        echo "Unknown"; 
                        break;
                } ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>