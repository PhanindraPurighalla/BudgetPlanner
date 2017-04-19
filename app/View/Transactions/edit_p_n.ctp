<!-- app/View/Pns/edit_p_n.ctp -->

<?php echo $this->Html->link(
'Pns',
array('controller' => 'pns', 'action' => 'view', $user['User']['id'])
); ?>

<div class="pns form">
<h1>Editing PN record for <b><?php echo h($pn['Pn']['report_date']); ?></b> <b><?php echo h($pn['Pn']['pn_number']); ?></b></h1>
<?php echo $this->Form->create('Pn'); ?>
<fieldset>
<legend><?php echo __('Edit PN record'); ?></legend>
<?php 
	  echo $this->Form->input('user_id', array('options' => $pndbUsersToSelectFrom, 'selected' => $pn['Pn']['user_id']));
	  echo $this->Form->input('severity_id', array('options' => $severitiesToSelectFrom, 'selected' => $pn['Pn']['severity_id']));
	  echo $this->Form->input('status_id', array('options' => $statusesToSelectFrom, 'selected' => $pn['Pn']['status_id']));
	  echo $this->Form->input('pndb_module_id', array('label' => "Module", 'options' => $pndbModulesToSelectFrom, 'selected' => $pn['Pn']['pndb_module_id']));
      //echo $this->Form->input('start_dt', array('selected' => $pn['Pn']['start_dt']));
      echo $this->Form->input('end_dt', array('selected' => $pn['Pn']['end_dt']));
	  echo $this->Form->input('remarks', array('default' => $pn['Pn']['remarks']));
	  echo $this->Form->input('lead_time', array('default' => $pn['Pn']['lead_time']));
	  echo $this->Form->radio('is_escalated', array('Y' => 'Yes', 'N' => 'No'));
	  echo $this->Form->radio('is_overdue', array('Y' => 'Yes', 'N' => 'No'));
	  echo $this->Form->radio('is_excluded_from_inflow', array('Y' => 'Yes', 'N' => 'No'));
	  echo $this->Form->input('inflow_excl_reason', array('default' => $pn['Pn']['inflow_excl_reason']));
	  echo $this->Form->radio('is_excluded_from_outflow', array('Y' => 'Yes', 'N' => 'No'));
	  echo $this->Form->input('outflow_excl_reason', array('default' => $pn['Pn']['outflow_excl_reason']));
?>
</fieldset>
<?php 
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end(__('Submit')); 
?>
</div>