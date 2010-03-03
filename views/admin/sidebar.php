<div class="box">
	<h3 class="yellow">Newsletters</h3>
	
	<div class="box-container">
		<ul class="list-links">
			<li><a href="/admin/newsletters/edit_newsletter">New Newsletter</a></li>
			<li><a href="/admin/newsletters/">Drafts (<?=$this->newsletters->count('draft')?>)</a></li>
			<li><a href="/admin/newsletters/index/sent">Sent (<?=$this->newsletters->count('sent')?>)</a></li>
			<li><a href="/admin/newsletters/index/trash">Trash (<?=$this->newsletters->count('trash')?>)</a></li>
		</ul>
	</div>
</div>

<div class="box">
	<h3>Recipients</h3>
	
	<div class="box-container">
		<ul class="list-links">
			<li><a href="/admin/newsletters/recipients">Recipients (<?=$this->newsletters->count('recipients')?>)</a></li>
			<li><a href="/admin/newsletters/edit_recipient">Add Recipients</a></li>
			<li><?php echo anchor('admin/newsletters/export', 'Export Recipients'); ?></li>
			<li><?php echo anchor('admin/newsletters/batch_add_recipients', 'Import Recipients'); ?></li>
		</ul>
	</div>
</div>

<div class="box">
	<h3>Groups</h3>
	
	<div class="box-container">
	<ul class="list-links">
		<li><a href="/admin/newsletters/groups">Groups (<?=$this->newsletters->count('groups')?>)</a></li>
		<li><a href="/admin/newsletters/edit_group">Add a Group</a></li>
	</ul>
	</div>
</div>