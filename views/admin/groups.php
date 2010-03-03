<div class="box">

	<h3>Newsletter Groups</h3>				
	
	<div class="box-container">	

		<table border="0" class="table-list"> 
			<thead>
				<tr>
					<th>Group Name</th>
					<th>Group Description</th>
					<th>Signup</th>
					<th>Users</th>
					<th>Date Created</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($groups as $group):?>
				<tr>
					<td><strong><a href="/admin/newsletters/groups/<?=$group->id?>"><?=htmlentities($group->group_name)?></a></strong></td>
					<td><?=htmlentities($group->group_description)?></td>
					<td><?php echo $group->group_public==1 ? 'Public' : 'Private'; ?></td>
					<td><?=$this->newsletters->count('recipients',$group->id)?></td>
					<td><?=$group->created?></td>
					<td><?=$group->modified?></td>
					<td>
						<a href="/admin/newsletters/edit_group/<?=$group->id?>">Edit</a> |
						<a href="/admin/newsletters/delete_group/<?=$group->id?>" class="confirm">Delete</a>
					</td>
				</tr>
				<?endforeach?>
			</tbody>
		</table>


		
<?php if(isset($recipients)): ?>
</div>
</div>
<div class="box">

	<h3><?php if(count($recipients) > 1) echo count($recipients); ?> Recipients in "<?php echo htmlentities($group->group_name); ?>"</h3>
	
	<div class="box-container">	


	<table border="0" class="table-list">   
	<thead>
		<tr>
			<th>Recipient Name</th>
			<th>Recipient Email</th>
			<th>Created</th>
			<th>Groups</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?if(empty($recipients)):?>
		<tr>
			<td colspan="6"><p class="notice message">There are no recipients in this group.</p></td>
		</tr>
		<?else:?>
		
		
		
		<?foreach($recipients as $recipient):?>
		<tr>
			<td><?=htmlentities($recipient->name)?></td>
			<td><?=$recipient->email?></td>
			<td><?=$recipient->created?></td>
			<td>
			<?$groups=$this->newsletters->user_groups($recipient->id)?>
			<?foreach($groups as $group):?>
				<a class="nowrap" href="/admin/newsletters/groups/<?=$group->group_id?>"><strong><?=htmlentities($group->group_name)?></strong></a>
			<?endforeach?>
			</td>
			<td><a href="/admin/newsletters/edit_recipient/<?=$recipient->id?>">Edit</a> |
			<a href="/admin/newsletters/delete_recipient/<?=$recipient->id?>" class="confirm">Delete</a></td>
		</tr>
		<?endforeach?>
		
		
		
		<?endif?>
	</tbody>
	</table>
<?endif?>

</div>
</div>

