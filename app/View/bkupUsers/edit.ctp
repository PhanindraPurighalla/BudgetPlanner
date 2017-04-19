<!-- File: /app/View/Users/edit.ctp -->
<h1>Edit User</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('username', array('type' => 'dhfk')); ?> 

<b><p>Current Role: <td><?php echo h($roleDesc); ?></td></b>
<?php
echo $this->Form->input('address');
echo $this->Form->input('contact_no');
echo $this->Form->input('role', array(
'options' => $rolesToSelectFrom
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save User');
?>