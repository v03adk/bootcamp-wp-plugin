
<div class="wrap">
	<h1 class="wp-heading-inline"><?php if ($quote) echo 'Edit '; else echo 'Create ' ?>Quote</h1>

	<?php if ($error) { ?>
		<h1 class="wp-heading-inline" style="color:red;"><?php echo $error; ?></h1>
	<?php } ?>

	<?php
		$action = admin_url('admin.php?page=BootcampWpPlugin_PluginQuotesCreateEdit');
		if ($quote) {
			$action .= '&id='.$quote['id'];
		}
		$action .= '&noheader=true';
	?>

    <?php
        if (count($authors) === 0) {
            echo sprintf('<br/><br/><a class="page-title-action" href="%s">Add authors first</a>', admin_url('admin.php?page=BootcampWpPlugin_PluginAuthorsCreateEdit'));
        }
        else {
    ?>
        <form action="<?php echo $action; ?>" method="post">
            <table class="wp-list-table">
                <tbody>
                    <tr>
                        <td>
                            Author *
                        </td>
                        <td>
                            <select name="quote[author]" <?php if ($quote) echo 'disabled=disabled'; ?> required>
                                <?php
                                    foreach ($authors as $author) {
                                        echo sprintf('<option value="%s" %s>%s</option>', $author['id'], ($quote && $quote['author']['id'] == $author['id'] ? 'selected=selected' : ''), $author['firstname'] . ' ' . $author['lastname']);
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Quote *
                        </td>
                        <td>
                            <textarea name="quote[quote]" required ><?php if ($quote) echo $quote['quote']; ?></textarea>
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
    <?php } ?>
</div>
