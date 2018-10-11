
<div class="wrap">
    <h1 class="wp-heading-inline">Quotes</h1>
    <a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginQuotesCreateEdit'); ?>" class="page-title-action">Add New</a>
	<?php if (count($quotes)) { ?>
		<table class="wp-list-table widefat plugins">
			<thead>
                <tr>
                    <th>Author</th>
                    <th>Quote</th>
                    <th>Actions</th>
                </tr>
			</thead>
			<tbody>
			<?php foreach ($quotes as $quote): ?>
				<tr>
					<td>
						<?php echo $quote['author']['firstname'], ' ', $quote['author']['lastname'] ?>
					</td>
					<td>
						<?php echo $quote['quote'] ?>
					</td>
					<td>
						<a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginQuotesCreateEdit&id='.$quote['id']); ?>" class="page-title-action">
							Edit
						</a>
						<a href="<?php echo admin_url('admin.php?page=BootcampWpPlugin_PluginQuotesDelete&id='.$quote['id']); ?>" class="page-title-action">
							Delete
						</a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	<?php } ?>
</div>

