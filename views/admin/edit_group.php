<?php
$fields=array('group_name','group_description','id','group_public');
isset($groups) ? $action='Edit':$action='Add';
foreach($fields as $field):
	if(set_value($field)) $$field=set_value($field);
	elseif(isset($groups)) foreach($groups as $group){$$field=$group->$field;}
	else $$field='';
endforeach;
?>
<div class="box">
	<h3>Newsletter Groups</h3>				
	<div class="box-container">	
		<?=form_open($this->uri->uri_string(),'class="crud"')?>
			<ol>
				<li>
					<label for="group_name">Group Name</label>
					<input type="text" class="width-20" name="group_name" value="<?=$group_name?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				<li class="even">
					<label for="group_description">Group Description</label>
					<input type="text" class="width-30" name="group_description" value="<?=$group_description?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				<li>
					<label for="group_public">Allow public signup?</label>
					Yes <?php echo form_radio('group_public','1',$group_public==1 ? true:false); ?>&nbsp;&nbsp;&nbsp;
					No <?php echo form_radio('group_public','0',$group_public==0 ? true:false); ?>
				</li>
				<li class="even">
					<button type="submit"><span>Save</span></button>
					<div class="button"><a href="/admin/newsletters/groups" class="ajax">Cancel</a></div>
				</li>
			</ol>
		<?=form_close()?>
	</div>
</div>