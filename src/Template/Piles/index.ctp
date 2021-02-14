<script>
<?php
    $indexUrl =  $this->Url->build([
    "controller" => "Piles",
    "action" => "index", "", "", ""]);
?>

$(function() {
    $('#navActivePiles').addClass('active');

    $('#filter-id').on('change', function() {
        var filterType =  $(this).val();
        window.location = "<?=$indexUrl?>/" +  filterType;
    });
});
</script>

<div class="activePiles index large-9 medium-8 columns content">
    <?= $this->Html->link(__('Build Pile'), ['action' => 'edit'], ['class' => 'btn btn-primary', 'role' => 'button', 'style' => 'width: 100%; font-size: 2em;']) ?>
    <br/><br/>
    <?= $this->Form->control('filter_id', ['options' => $filters, 'value' => $filter]) ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
        <?php
        $i = 0; 
        foreach ($piles as $activePile): 
            $pileCreated = new DateTime($activePile->created);
            $now = new DateTime();
            $pileAge = $pileCreated->diff($now); 
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?= $i ?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>">
                <span style="font-size: 2em; padding-right: 1em;"><?= $activePile->pile_location->name ?></span>
                <span><?= $activePile->total_turns ?> Turns</span>
                <span style="padding-left: 1em; padding-right: 2em;"><?= $pileAge->format('%a') ?> Days Old</span>
                </a>
            </h4>
            </div>
            <div id="collapse<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $i ?>">
                <div class="panel-body">
                <?= $this->Html->link(__('[Open Details]'), ['action' => 'details', $activePile->id], ['style' => 'float: right;']); ?>
                <?php if ($activePile->turn_status == 1) : ?>
                    <br><div class="alert alert-danger" role="alert">Turn Needed</div>
                <?php endif;?>

                <?php if (count($activePile->pile_temperatures) > 0) : ?>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Temp 1</th>
                        <th scope="col">Temp 2</th>
                        <th scope="col">Temp 3</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($activePile->pile_temperatures as $temp) : ?>
                    <tr>
                        <td><?= ($temp->created->isToday()) ? '<b>Today</b>' : $temp->created->format('M d') ?></td>
                        <td><?= $temp->temp1 ?></td>
                        <td><?= $temp->temp2 ?></td>
                        <td><?= $temp->temp3 ?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                </table>
                <?php else : ?>
                <br/><br/>
                <?php endif; ?>

                <?php 
                    if ($activePile->turn_status == 1) {
                        echo $this->Html->link(__('Mark As Turned'), ['action' => 'turn', $activePile->id], ['class' => 'btn btn-success', 'role' => 'button', 'style' => 'width: 100%; font-size: 2em;']);
                    } else if ($activePile->turn_status == 3) {
                        echo $this->Html->link(__('Need Turn'), ['action' => 'decide', $activePile->id, 1], ['class' => 'btn btn-success', 'role' => 'button', 'style' => 'width: 49%; font-size: 2em;margin-right: 2px;']);
                        echo $this->Html->link(__('Skip Turn'), ['action' => 'decide', $activePile->id, 2], ['class' => 'btn btn-danger', 'role' => 'button', 'style' => 'width: 50%; font-size: 2em;']);
                    } else if ($activePile->temp_last == null || !$activePile->temp_last->isToday()) {
                        echo $this->Html->link(__('Take Temps'), ['action' => 'temp', $activePile->id], ['class' => 'btn btn-warning', 'role' => 'button', 'style' => 'width: 100%; font-size: 2em;']);
                    } else if ($activePile->turned_last != null && $activePile->turned_last->isToday()) {
                        echo $this->Html->link(__('Pile Is Done'), ['action' => 'done', $activePile->id], ['class' => 'btn btn-info', 'role' => 'button', 'style' => 'width: 100%; font-size: 2em;']);
                    }
                ?>
                </div>
            </div>
        </div>
        <?php 
            $i++;
        endforeach; ?>
    </div>
 
</div>
