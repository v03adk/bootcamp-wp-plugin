
<div class="wrap">
	<h1 class="wp-heading-inline"><?php if ($author) echo 'Edit '; else echo 'Create ' ?>Author</h1>

	<?php if ($error) { ?>
		<h1 class="wp-heading-inline" style="color:red;"><?php echo $error; ?></h1>
	<?php } ?>

	<?php
		$action = admin_url('admin.php?page=BootcampWpPlugin_PluginAuthorsCreateEdit');
		if ($author) {
			$action .= '&id='.$author['id'];
		}
		$action .= '&noheader=true';
	?>

	<form action="<?php echo $action; ?>" method="post">
		<table class="wp-list-table">
			<tbody>
				<tr>
					<td>
						First name *
					</td>
					<td>
						<input name="author[firstname]" value="<?php if ($author) echo $author['firstname']; ?>" required />
					</td>
				</tr>
				<tr>
					<td>
						Last name
					</td>
					<td>
						<input name="author[lastname]" value="<?php if ($author) echo $author['lastname']; ?>"/>
					</td>
				</tr>
				<tr>
					<td>
						Middle name
					</td>
					<td>
						<input name="author[middlename]" value="<?php if ($author) echo $author['middlename']; ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" value="Save" class="page-title-action"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
