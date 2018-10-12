<?php
/*
    "WordPress Plugin Template" Copyright (C) 2018 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

include_once('BootcampWpPlugin_InstallIndicator.php');

class BootcampWpPlugin_LifeCycle extends BootcampWpPlugin_InstallIndicator {

    public function install() {

        // Initialize Plugin Options
        $this->initOptions();

        // Initialize DB Tables used by the plugin
        $this->installDatabaseTables();

        // Other Plugin initialization - for the plugin writer to override as needed
        $this->otherInstall();

        // Record the installed version
        $this->saveInstalledVersion();

        // To avoid running install() more then once
        $this->markAsInstalled();
    }

    public function uninstall() {
        $this->otherUninstall();
        $this->unInstallDatabaseTables();
        $this->deleteSavedOptions();
        $this->markAsUnInstalled();
    }

    /**
     * Perform any version-upgrade activities prior to activation (e.g. database changes)
     * @return void
     */
    public function upgrade() {
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=105
     * @return void
     */
    public function activate() {
        // Create post object
	    $my_post = array(
		    'post_title'    => 'Author\'s Quotes',
		    'post_content'  => '[bootcamp-wp-plugin-authors-quotes]',
		    'post_status'   => 'publish',
		    'post_type'     => 'page',
	    );

	    // Insert the post into the database
	    $postId = wp_insert_post( $my_post, '' );
	    $this->addOption('postId', $postId);
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=105
     * @return void
     */
    public function deactivate() {
    	$postId = $this->getOption('postId');
    	wp_delete_post($postId);

    	$this->deleteOption('postId');
    	$this->deleteOption('apiKey');
    	$this->deleteOption('_installed');
    	$this->deleteOption('_version');
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return void
     */
    protected function initOptions() {
    }

    public function addActionsAndFilters() {
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
    }

    /**
     * Override to add any additional actions to be done at install time
     * See: http://plugin.michael-simpson.com/?page_id=33
     * @return void
     */
    protected function otherInstall() {
    }

    /**
     * Override to add any additional actions to be done at uninstall time
     * See: http://plugin.michael-simpson.com/?page_id=33
     * @return void
     */
    protected function otherUninstall() {
    }




    public function addAdminMenu() {
	    $this->requireExtraPluginFiles();
	    $displayName = $this->getPluginDisplayName();
	    $optionsSlug = $this->getPageSlug('Options');
	    add_menu_page(
		    $displayName,
		    $displayName,
		    'manage_options',
		    $optionsSlug,
		    array($this, 'settingsPage')
	    );

	    add_submenu_page(
		    $optionsSlug,
		    'Options',
		    'Options',
		    'manage_options',
		    $optionsSlug,
		    array($this, 'settingsPage')
	    );

	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-backend-api-client.php');
	    $client = new BootcampBackendApiClient($this->getOption('apiKey'));

	    $this->addAdminAuthorsPages($client);
	    $this->addAdminQuotesPages($client);
    }

    public function addAdminAuthorsPages($client)
    {
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-wp-plugin-authors.php');
	    $authorsWrapper = new BootcampWpPluginAuthors($client);

	    add_submenu_page(
		    $this->getPageSlug('Options'),
		    'Authors',
		    'Authors',
		    'manage_options',
		    $this->getPageSlug('Authors'),
		    array($authorsWrapper, 'index')
	    );

	    add_submenu_page(null,
		    '',
		    '',
		    'manage_options',
		    $this->getPageSlug('AuthorsCreateEdit'),
		    array($authorsWrapper, 'update')
	    );

	    add_submenu_page(null,
		    '',
		    '',
		    'manage_options',
		    $this->getPageSlug('AuthorsDelete'),
		    array($authorsWrapper, 'delete')
	    );
    }

    public function addAdminQuotesPages($client)
    {
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-wp-plugin-quotes.php');
	    $quotesWrapper = new BootcampWpPluginQuotes($client);

	    add_submenu_page(
		    $this->getPageSlug('Options'),
		    'Quotes',
		    'Quotes',
		    'manage_options',
		    $this->getPageSlug('Quotes'),
		    array($quotesWrapper, 'index')
	    );

	    add_submenu_page(null,
		    '',
		    '',
		    'manage_options',
		    $this->getPageSlug('QuotesCreateEdit'),
		    array($quotesWrapper, 'update')
	    );

	    add_submenu_page(null,
		    '',
		    '',
		    'manage_options',
		    $this->getPageSlug('QuotesDelete'),
		    array($quotesWrapper, 'delete')
	    );
    }

    public function printRandomQuote()
    {
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-backend-api-client.php');
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-wp-plugin-quotes.php');
	    $client = new BootcampBackendApiClient($this->getOption('apiKey'));
	    $quotesWrapper = new BootcampWpPluginQuotes($client);

	    $quote = $quotesWrapper->getRandomQuote();

	    if ($quote) {
	    	$postId = $this->getOption('postId');
	    	$post = get_post($postId);
		    echo "<blockquote>".$quote['quote']."<cite style='color: #999999;'><a href='".$post->guid."?authorId=".$quote['authorId']."'>".$quote['author']."</a></cite></blockquote>";
	    }
    }

    public function showAuthorsQuotes()
    {
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-backend-api-client.php');
	    require_once(ABSPATH . 'wp-content/plugins/bootcamp-wp-plugin/lib/bootcamp-wp-plugin-quotes.php');
	    $client = new BootcampBackendApiClient($this->getOption('apiKey'));
	    $quotesWrapper = new BootcampWpPluginQuotes($client);

	    $quotesWrapper->getAuthorsQuotes();
    }


    protected function getPageSlug($name) {
    	return get_class($this) . $name;
    }









	protected function requireExtraPluginFiles() {
		require_once(ABSPATH . 'wp-includes/pluggable.php');
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	}

    /**
     * @param  $name string name of a database table
     * @return string input prefixed with the WordPress DB table prefix
     * plus the prefix for this plugin (lower-cased) to avoid table name collisions.
     * The plugin prefix is lower-cases as a best practice that all DB table names are lower case to
     * avoid issues on some platforms
     */
    protected function prefixTableName($name) {
        global $wpdb;
        return $wpdb->prefix .  strtolower($this->prefix($name));
    }


    /**
     * Convenience function for creating AJAX URLs.
     *
     * @param $actionName string the name of the ajax action registered in a call like
     * add_action('wp_ajax_actionName', array(&$this, 'functionName'));
     *     and/or
     * add_action('wp_ajax_nopriv_actionName', array(&$this, 'functionName'));
     *
     * If have an additional parameters to add to the Ajax call, e.g. an "id" parameter,
     * you could call this function and append to the returned string like:
     *    $url = $this->getAjaxUrl('myaction&id=') . urlencode($id);
     * or more complex:
     *    $url = sprintf($this->getAjaxUrl('myaction&id=%s&var2=%s&var3=%s'), urlencode($id), urlencode($var2), urlencode($var3));
     *
     * @return string URL that can be used in a web page to make an Ajax call to $this->functionName
     */
    public function getAjaxUrl($actionName) {
        return admin_url('admin-ajax.php') . '?action=' . $actionName;
    }

}
