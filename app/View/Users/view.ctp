<!-- File: /app/View/Users/view.ctp -->
<h1>Viewing details of <?php echo h($user['User']['username'] ); ?></h1>
<p><small>Created: <?php echo $user['User']['created']; ?></small></p>
<p><b>Role: </b><?php echo h($user['Role']['role_desc'] ); ?></p>

<?php 
if ($loggedInUser['Role']['role_name'] == 'ADMIN') {
echo $this->Html->link(
'Admin Home',
array('controller' => 'users', 'action' => 'admin_home')
);
}
?>

<?php echo $this->Html->link(
'View Transactions',
array('controller' => 'transactions', 'action' => 'view', $user['User']['id'])
); ?>

<?php if ($loggedInUser['Role']['role_name'] != 'ADMIN') {
echo $this->Html->link(
'Transactions',
array('controller' => 'transactions', 'action' => 'recordTransaction', $user['User']['id'])
); 
}
?>

<!-- <?php echo $this->Html->link(
'Raise Leave Request',
array('controller' => 'leaveRequests', 'action' => 'raise_leave_request', $user['User']['id'])
); ?>
-->

<?php echo $this->Html->link(
'Edit User Profile',
array('controller' => 'users', 'action' => 'edit', $user['User']['id'])
); ?>

<?php echo $this->Html->link(
'Change Password',
array('controller' => 'users', 'action' => 'change_password', $user['User']['id'])
); ?>

<?php 
if ($loggedInUser['Role']['role_name'] != 'ADMIN') {
echo $this->Html->link(
'Logout',
array('controller' => 'users', 'action' => 'logout')
); 
}
?>

<table>
<tr>
<th>Id</th>
<th>User Name</th>
<th>Role Desc</th>
<th>Contact No</th>
<th>Last Modified</th>
</tr>
<!-- Here is where we fetch the details of the logged in user -->
<tr>
<td><?php echo $user['User']['id']; ?></td>
<td><?php echo $user['User']['username']; ?></td>
<td><?php echo $user['Role']['role_name'];?></td>
<td><?php echo $user['User']['contact_no']; ?></td>
<td><?php echo $user['User']['modified']; ?></td>
</tr>
<?php unset($user); ?>
</table>