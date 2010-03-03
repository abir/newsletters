<?php
$fields=array('name','email','id');
isset($recipient) ? $action='Edit':$action='Add';
foreach($fields as $field)
{
	if(set_value($field))
		$$field=set_value($field);
	elseif(isset($recipient))
		foreach($recipient as $user){$$field=$user->$field;}
	else
		$$field='';
}
?>
<div class="box">
	<h3><?=$action?> Recipient</h3>				
	<div class="box-container">	
			<?=form_open($this->uri->uri_string(),'class="crud"')?>
			<ol>
				<li>
					<label for="name">Recipient Name</label>
					<input type="text" name="name" value="<?=$name?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				<li class="even">
					<label for="email">Email</label>
					<input type="text" name="email" value="<?=$email?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
			<li>
				<label for="group_id[]">Groups</label>
			<?if(isset($groups)):?>
				<?if(count($groups)==1):?>
					<?foreach($groups as $group):?>
						<?=htmlentities($group->group_name)?>
						<input type="hidden" name="group[]" value="<?=$group->id?>" />
					<?endforeach;?>
				<?else:?>
					<?foreach($groups as $group):?>
						<?
						$user_groups=array();
						if(isset($recipient)):
							foreach($this->newsletters->user_groups($id) as $user_group):
								$user_groups[]=$user_group->group_id;
							endforeach;
						endif;
						in_array($group->id,$user_groups) ? $checked=' checked="checked"' : $checked='';
						?>
						<span>
							<input type="checkbox"<?=$checked?> name="group[]" value="<?=$group->id?>"><?=htmlentities($group->group_name)?>
						</span>&nbsp;&nbsp;&nbsp;
					<?endforeach?>
				<?endif?>
			<?endif?>
			</li>
			<li class="even">
				<button type="submit"><span>Save</span></button>
				<div class="button"><a href="http://localhost/admin/newsletters/recipients" class="ajax">Cancel</a></div>
			</li>
		</ol>
		<?=form_close()?>
	</div>
</div>