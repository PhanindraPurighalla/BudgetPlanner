<!-- File: /app/View/Users/admin_home.ctp -->

<div class="adminHome form">
<fieldset>
<legend><?php echo __('Budget Planner Management'); ?></legend>

<ul>
<li>
<?php echo $this->Html->link(
'Role Configuration',
array('controller' => 'roles', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Category Configuration',
array('controller' => 'categories', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Type Configuration',
array('controller' => 'types', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'User Configuration',
array('controller' => 'users', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Frequency Configuration',
array('controller' => 'frequencies', 'action' => 'index')
); ?>
</li>

<li>
<?php echo $this->Html->link(
'Reports',
array('controller' => 'transactions', 'action' => 'reports')
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
