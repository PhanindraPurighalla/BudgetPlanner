<?php echo $this->Form->create();?> 
<?php echo $this->Form->input('id');?> 
<?php echo $this->Form->input('current_password',array('type'=>'password'));?> 
<?php echo $this->Form->input('password',array('label'=>'New password','value'=>''));?> 
<?php echo $this->Form->input('password_confirmation',array('label'=>'confirm your password','type'=>'password', 'value'=>''));?> 
<?php echo $this->Form->end('change');?>