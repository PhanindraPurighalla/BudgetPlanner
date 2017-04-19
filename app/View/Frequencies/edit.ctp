<!-- File: /app/View/Frequencies/edit.ctp -->
<?php echo $this->Html->link(
'Frequencies',
array('controller' => 'frequencies', 'action' => 'index')
); ?>

<div class="frequencies form">
<?php
echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Edit Frequency %s', h($frequency['Frequency']['frequency_code'])); ?></legend>
<?php
echo $this->Form->input('frequency_name');
echo $this->Form->input('id', array('type' => 'hidden'));
?>
</fieldset>
<?php
echo $this->Form->end('Save Frequency');
?>
</div>
