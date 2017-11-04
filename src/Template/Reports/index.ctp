<div class="reports form large-9 medium-8 columns content">
    <?= $this->Form->create($report, ['url' => ['action' => 'report']]) ?>
    <fieldset>
        <legend>Reporting</legend>
        <?php if (!$isClient) { ?>
        <?= $this->Form->control('client_id', ['empty' => '(All)']); ?>
        <?php } ?>
        <?= $this->Form->control('start_date'); ?>
        <?= $this->Form->control('end_date'); ?>
        <?= $this->Form->radio('export', [ "Graph", "Export To CSV"], ['value' => "0"]); ?>
    </fieldset>
    <?= $this->Form->button(__('Run Report')) ?>
    <?= $this->Form->end() ?>
</div>