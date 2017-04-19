<!-- File: /app/View/LtsHolidays/admin_home.ctp -->

<div class="adminHome form">
<fieldset>
<legend><?php echo __('LTS Entity Management'); ?></legend>

<ul>
<li>
<?php echo $this->Html->link(
'Role Management',
array('controller' => 'ltsRoles', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Leave Type Management',
array('controller' => 'leaveTypes', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Request Status Management',
array('controller' => 'ltsStatuses', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'User Management',
array('controller' => 'users', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Holiday Management',
array('controller' => 'ltsHolidays', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Logout',
array('controller' => 'users', 'action' => 'logout')
); ?>
</li>
</ul>

</fieldset>
</div>
