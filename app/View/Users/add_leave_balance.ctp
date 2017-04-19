<!-- File: /app/View/Users/add_leave_balance.ctp -->
<h1>Add Leave Balance</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('username', array('disabled' => 'disabled'));
echo $this->Form->input('leave_type_id', array(
'options' => $rolesToSelectFrom
));
echo $this->Form->input('leave_type_balance');
echo $this->Form->input('user_id', array('type' => 'hidden'));
echo $this->Form->end('Add Leave Balance');
?>