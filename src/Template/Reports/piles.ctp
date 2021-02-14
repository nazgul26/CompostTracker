
<script>
$( function() {
    $('#navReports').addClass('active');
});
</script>
<h2>Compost Pile History Report</h2>
<div class="reports form large-9 medium-8 columns content">
    <?= $this->Form->create($report, ['url' => ['action' => 'piles']]) ?>
    <fieldset>
        <?= $this->Form->control('start_date'); ?>
        <?= $this->Form->control('end_date'); ?>
    </fieldset>
    <?= $this->Form->button(__('Run Report')) ?>
    <?= $this->Form->end() ?>
</div>