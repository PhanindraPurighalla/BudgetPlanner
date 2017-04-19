<!-- File: /app/View/Common/index.ctp -->
<!-- This is a common view file for all index pages -->
<h1><?php echo $this->fetch('title'); ?></h1>
<div class="next actions">
    <h3>Things you can do next</h3>
    <ul>
	<?php echo $this->fetch('navbar'); ?>	
	<li>
		<?php 
				$this->start('adminHome');
				echo $this->Html->link(
				'Admin Home',
				array('controller' => 'users', 'action' => 'admin_home')); 
				$this->end();
				echo $this->fetch('adminHome');
		?>
	</li>
    <li>
		<?php 	$this->startIfEmpty('roleMgmt');
				echo $this->Html->link(
				'Role Configuration',
				array('controller' => 'roles', 'action' => 'index')); 
				$this->end();
				echo $this->fetch('roleMgmt');
		?>
	</li>
	<li>
		<?php 	$this->startIfEmpty('userMgmt');
				echo $this->Html->link(
				'User Configuration',
				array('controller' => 'users', 'action' => 'index')); 
				$this->end();
				echo $this->fetch('userMgmt');
		?>
	</li>
	<li>
		<?php 	$this->startIfEmpty('categoryMgmt');
				echo $this->Html->link(
				'Category Configuration',
				array('controller' => 'categories', 'action' => 'index')); 
				$this->end();
				echo $this->fetch('categoryMgmt');
		?>
	</li>	
	<li>
		<?php 	$this->startIfEmpty('typeMgmt');
				echo $this->Html->link(
				'Type Configuration',
				array('controller' => 'types', 'action' => 'index')); 
				$this->end();
				echo $this->fetch('typeMgmt');
		?>
	</li>
	<li>
		<?php 	$this->startIfEmpty('frequencyMgmt');
				echo $this->Html->link(
				'Frequency Configuration',
				array('controller' => 'frequencies', 'action' => 'index')); 
				$this->end();
				echo $this->fetch('frequencyMgmt');
		?>
	</li>
	<li>
		<?php 	$this->startIfEmpty('reports');
				echo $this->Html->link(
				'Reports',
				array('controller' => 'transactions', 'action' => 'reports')); 
				$this->end();
				echo $this->fetch('reports');
		?>
	</li>
	<li>
		<?php 	$this->start('logout');
				echo $this->Html->link(
				'Logout',
				array('controller' => 'users', 'action' => 'logout')); 
				$this->end();
				echo $this->fetch('logout');
		?>	
	</li>	
    </ul>
</div>

<?php echo $this->fetch('content'); ?>

<!-- Pagination settings -->
<?php 
echo $this->Paginator->counter(
    'Page {:page} of {:pages}, showing {:current} records out of
     {:count} total, starting on record {:start}, ending on {:end}'
);
echo $this->Paginator->prev(
  ' << ' . __('previous'),
  array(),
  null,
  array('class' => 'prev disabled')
);
echo $this->Paginator->numbers();
echo $this->Paginator->next(
  ' >> ' . __('next'),
  array(),
  null,
  array('class' => 'next disabled')
);
?>