
<div class="wrap">
	<h1 class="wp-heading-inline">Quotes</h1>

	<?php if (count($quotes)) { ?>
		<table class="wp-list-table widefat plugins">
			<thead>
			<tr>
				<th>Author</th>
				<th>Quote</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($quotes as $quote): ?>
				<tr>
					<td>
						<?php echo sprintf('%s %s %s', $quote['author']['firstname'], $quote['author']['middlename'], $quote['author']['lastname']); ?>
					</td>
					<td>
						<?php echo $quote['quote'] ?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	<?php } ?>
</div>

