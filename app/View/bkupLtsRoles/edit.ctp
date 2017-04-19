<!-- File: /app/View/LtsRoles/edit.ctp -->
<h1>Edit Role</h1>
<?php
echo $this->Form->create();
echo $this->Form->input('role_code');
echo $this->Form->input('role_desc');
echo $this->Form->input('remarks', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Role');
?>