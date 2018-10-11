
<div class="wrap">
	<h1 class="wp-heading-inline">Authors</h1>
	<a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginAuthorsCreateEdit'); ?>" class="page-title-action">Add New</a>
	<?php if (count($authors)) { ?>
		<table class="wp-list-table widefat">
			<thead>
				<tr>
					<th>Name</th>
					<th>Lastname</th>
					<th>MiddleName</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($authors as $author): ?>
				<tr>
					<td>
						<?php echo $author['firstname'] ?>
					</td>
					<td>
						<?php echo $author['lastname'] ?>
					</td>
					<td>
						<?php echo $author['middlename'] ?>
					</td>
					<td>
						<a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginAuthorsCreateEdit&id='.$author['id']); ?>" class="page-title-action">
							Edit
						</a>
						<a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginAuthorsDelete&id='.$author['id']); ?>" class="page-title-action">
							Delete
						</a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	<?php } ?>
</div>

