<?php
$fields=array('subject','body','id');
foreach($fields as $field)
{
	if(set_value($field))
		$$field=set_value($field);
	elseif(isset($newsletter))
	{
		$action='Edit';
		foreach($newsletter as $mail){$$field=$mail->$field;}
	}
	else
		$$field='';
		$action='Add';
}
?>

<div class="box">
	
	<h3><?php echo lang('newsletters.add_title'); ?></h3>
	
	<div class="box-container">
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
			<ol>
				<li class="even">
					<label for="subject"><?php echo lang('newsletters_subject_label');?></label>
					<?php echo form_input(array('id'=>'subject', 'name'=>'subject', 'value' => $subject)); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				
				<li><label>Template:</label><?=form_dropdown('template',array(1,2,3))?></li>
				
				<li class="even">
					<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $body, 'rows' => 40, 'class'=>'wysiwyg-advanced')); ?>
				</li>
				
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>