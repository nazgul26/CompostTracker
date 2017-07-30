<div class="reports form large-9 medium-8 columns content">
    <?= $this->Form->create($report, ['url' => ['action' => 'export']]) ?>
    <fieldset>
        <legend>Reporting</legend>
        <?= $this->Form->control('client_id'); ?>
        <?= $this->Form->control('start_date'); ?>
        <?= $this->Form->control('end_date'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>