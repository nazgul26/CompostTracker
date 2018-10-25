<?php use Cake\Core\Configure; ?>
<script>
$( function() {
    $('#navReports').addClass('active');
});
</script>
<h2>Residential Daily Schedule Report</h2>
<div class="reports form large-9 medium-8 columns content">
    <?= $this->Form->create(null, ['url' => ['action' => 'residential']]) ?>
    <fieldset>
        <legend>Reporting</legend>
        <?= $this->Form->control('collection_day',  array('options' => Configure::read('DaysOfWeek'))); ?>
    </fieldset>
    <?= $this->Form->button(__('Run Report')) ?>
    <?= $this->Form->end() ?>
</div>