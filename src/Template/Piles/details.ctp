<ol class="breadcrumb">
  <li><?= $this->Html->link(__('Piles'), ['action' => 'index'])?></li>
  <li class="active">Details</li>
</ol>
<div class="panel panel-primary">
  <div class="panel-heading"><?= $pile->pile_location->name?></div>
  <div class="panel-body">
    <?= $this->Form->create($pile) ?>
    <?= $this->Form->control('comment') ?>
    <?= $this->Form->control('turn_status', ['options' => $turns, 'empty' => true]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Temperature History</div>
  <div class="panel-body">
  <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Date</th>
            <th scope="col">Temp 1</th>
            <th scope="col">Temp 2</th>
            <th scope="col">Temp 3</th>
            <th scope="col">Comment</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pile->pile_temperatures as $temp) : ?>
        <tr>
            <td>
              <?= $this->Html->link(__('Edit'), ['controller' => 'PileTemperatures', 'action' => 'edit', $pile->id, $temp->id]) ?> | 
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'PileTemperatures', 'action' => 'delete', $pile->id, $temp->id], ['confirm' => __('Are you sure you want to delete this temperature?', $temp->id)]) ?>    
            </td>
            <td><?= ($temp->created->isToday()) ? '<b>Today</b>' : $temp->created->format('M d') ?></td>
            <td><?= $temp->temp1 ?></td>
            <td><?= $temp->temp2 ?></td>
            <td><?= $temp->temp3 ?></td>
            <td><?= $temp->comment ?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
    </table>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Turn History</div>
  <div class="panel-body">
  <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pile->pile_turns as $turn) : ?>
        <tr>
            <td>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'PileTurns', 'action' => 'delete', $pile->id, $turn->id], ['confirm' => __('Are you sure you want to delete this turn?', $turn->id)]) ?>    
            </td>
            <td><?= ($turn->created->isToday()) ? '<b>Today</b>' : $turn->created->format('M d') ?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
    </table>
  </div>
</div>