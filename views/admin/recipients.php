<?php echo form_open('admin/newsletters/action/recipients');?>
<div class="box">

	<h3>Newsletter Recipients</h3>		


<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>	

	
	<div class="box-container">	
<?if(empty($recipients)):?>
<p>
	There are no recipients to display.<br /><br />
	<a href="/admin/newsletters/edit_recipient">Add a recipient</a>
</p>
<?else:?>
	<table border="0" class="table-list">    
		<thead>
			<tr>
				<th><?php echo form_checkbox('action_to_all');?></th>
				<th>Date Registered</th>
				<th>Recipient Name</th>
				<th>Recipient Email</th>
				<th>Groups</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?foreach($recipients as $recipient):?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $recipient->id);?></td>
				<td><?=$recipient->created?></td>
				<td><?=htmlentities($recipient->name)?></td>
				<td><?=$recipient->email?></td>
				<td>
				<?$groups=$this->newsletters->user_groups($recipient->id)?>
				<?count($groups) > 1 ? $delimiter=' &nbsp; ' : $delimiter='';?>
				<?foreach($groups as $group):?>
					<a href="/admin/newsletters/groups/<?=$group->group_id?>"><strong><?=htmlentities($group->group_name)?></strong></a><?=$delimiter?>
				<?endforeach?>
				</td>
				<td>
					<a href="/admin/newsletters/edit_recipient/<?=$recipient->id?>">Edit</a>
				</td>
			</tr>
			<?endforeach?>
		</tbody>
	</table>
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			<?endif?>
	</div>
	
	<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>


	
</div>
<?php echo form_close();?>