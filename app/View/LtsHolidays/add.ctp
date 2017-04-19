<!-- app/View/LtsHolidays/add.ctp -->

<?php echo $this->Html->link(
'Holidays Home',
array('controller' => 'ltsHolidays', 'action' => 'index')
); ?>

<div class="Holidays form">
<?php echo $this->Form->create('LtsHoliday'); ?>
<fieldset>
<legend><?php echo __('Add a holiday'); ?></legend>
<?php echo $this->Form->input('hol_name', array('label' => 'Occasion'));
echo $this->Form->input('hol_dt', array('label' => 'Holiday Date'));
echo $this->Form->input('is_flexi');
?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>