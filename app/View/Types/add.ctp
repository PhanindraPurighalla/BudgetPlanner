<!-- File: /app/View/Types/add.ctp -->
<?php echo $this->Html->link(
'Types',
array('controller' => 'types', 'action' => 'index')
); ?>

<div class="types form">
<legend><?php echo __('Add Transaction Type'); ?></legend>
<?php
echo $this->Form->create();
?>
<fieldset>
<?php
echo $this->Form->input('type_code');
echo $this->Form->input('type_desc');
?>
</fieldset>
<?php echo $this->Form->end('Save Transaction Type');
?>
</div>
