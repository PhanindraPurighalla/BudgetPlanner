<!-- File: /app/View/Types/edit.ctp -->
<?php echo $this->Html->link(
'Types',
array('controller' => 'types', 'action' => 'index')
); ?>

<div class="types form">
<?php
echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Edit Transaction Type %s', h($type['Type']['type_code'])); ?></legend>
<?php
echo $this->Form->input('type_desc');
echo $this->Form->input('id', array('type' => 'hidden'));
?>
</fieldset>
<?php
echo $this->Form->end('Save Transaction Type');
?>
</div>
