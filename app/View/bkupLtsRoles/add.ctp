<!-- File: /app/View/LtsRoles/add.ctp -->
<h1>Add Role</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('role_code');
echo $this->Form->input('role_desc');
echo $this->Form->input('remarks', array('rows' => '3'));
echo $this->Form->end('Save Role');
?>