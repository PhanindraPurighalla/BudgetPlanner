<!-- File: /app/View/Frequencies/add.ctp -->
<?php echo $this->Html->link(
'Frequencies',
array('controller' => 'frequencies', 'action' => 'index')
); ?>

<div class="frequencies form">
<legend><?php echo __('Add Frequency'); ?></legend>
<?php
echo $this->Form->create();
?>
<fieldset>
<?php
echo $this->Form->input('frequency_code');
echo $this->Form->input('frequency_name');
?>
</fieldset>
<?php echo $this->Form->end('Save Frequency');
?>
</div>
