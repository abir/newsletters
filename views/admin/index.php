<?php echo form_open('admin/newsletters/action/newsletters');?>

<div class="box">

	<h3><?php echo lang('newsletters_'.$type.'_title');?></h3>				

	<div class="box-container">	
	
		<?php if (!empty($newsletters)): ?>
				
			<table border="0" class="table-list">    
				<thead>
					<tr>
						<th><?php echo form_checkbox('action_to_all');?></th>
						<th><?php echo lang('newsletters_post_label');?></th>
						<th class="width-10"><?php echo lang('newsletters_date_label');?></th>
						<?php if($type=='sent'): ?>
							<th class="width-10"><span><?php echo lang('newsletters_date_sent_label');?></span></th>
						<?php endif; ?>
						<th class="width-10"><span><?php echo lang('newsletters_actions_label');?></span></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($newsletters as $mail): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $mail->id);?></td>
							<td><?php echo $mail->subject;?></td>
							<td><?php echo $mail->created;?></td>
							<?php if($type=='sent'): ?>
							<td><?php echo $mail->date_sent;?></td>
							<?php endif; ?>
							<td>
								<?php echo anchor('admin/newsletters/preview/' . $mail->id, lang('newsletters_view_label'), 'rel="modal-large" class="iframe" target="_blank"'); ?>
								<?php if($type=='draft'): ?>
								| <?php echo anchor('admin/newsletters/edit_newsletter/' . $mail->id, lang('newsletters_edit_label'));?>
								| <?php echo anchor('admin/newsletters/confirm_send/' . $mail->id, lang('newsletters_send_label')); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>	
			</table>
			
			<?php if($type=='trash'): ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete','restore') )); ?>
			<?php else: ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('trash') )); ?>
			<?php endif; ?>

		<?php else: ?>
			<p><?php echo lang('newsletters_no_articles');?></p>
		<?php endif; ?>
	</div>
</div>

<?php echo form_close();?>