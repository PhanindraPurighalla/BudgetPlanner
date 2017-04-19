<!-- File: /app/View/Categories/index.ctp -->
<?php $this->extend('/Common/index');
$this->assign('title', 'Category Configuration');

$this->start('navbar');
?>
<li>
<?php echo $this->Html->link(
'Add Category',
array('controller' => 'categories', 'action' => 'add')
); ?>
</li>
<?php $this->end(); ?>

<div class="categories form">
<?php echo $this->Form->create('Category', array('type'=>'get','url' => array('page'=>'1')));?>
<fieldset>
<legend><?php echo __('Search Category'); ?></legend>
<?php
    echo $this->Form->input('transaction_category');
    echo $this->Form->input('description');
?>
</fieldset>
<?php echo $this->Form->end(__('Search Category')); ?>
</div>

<table>
<tr>
<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
<th><?php echo $this->Paginator->sort('category_code', 'Category Code'); ?></th>
<th><?php echo $this->Paginator->sort('category_desc', 'Category Desc'); ?></th>
<th>Action</th>
<th>Created</th>
</tr>
<!-- Here is where we loop through our $severities array, printing out severities info -->
<?php foreach ($categories as $category): ?>
<tr>
<td><?php 	echo $category['Category']['id']; ?></td>
<td><?php 	echo $category['Category']['category_code']; ?></td>
<td><?php 	echo $category['Category']['category_desc']; ?></td>
<td><?php 	echo $this->Form->postLink('Delete',
										array('action' => 'delete', $category['Category']['id']),
										array('confirm' => 'Are you sure?')
										);
			echo "  "; 
			echo $this->Html->link('Edit',
									array('action' => 'edit', $category['Category']['id'])
								  );
?>
</td>
<td><?php echo $category['Category']['created']; ?></td>
</tr>
<?php endforeach; ?>
<?php unset($category); ?>
</table>