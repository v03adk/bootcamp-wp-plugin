=== Bootcamp WP Plugin ===


== Description ==

Random Quote WP Plugin

Implemented:
- Plugin activate/deactivate (add/remove frontend page with short code to show all author's quotes)
- Options page to save api key
- CRUD page for authors
- CRUD page for quotes (only quote itself can be edited, not author)
- show random quote on every non-admin page (author's name is a link for all author's quotes)
- show all author's quotes on separate page

Not implemented:
- pagination in both CRUD
- perfect UI

TODO:
- get rid of usage of global arrays like GET, POST, SERVER
- better error handling in CRUDs
- enhance code quality overall


Notes:
- application is running on http://bootcamp-wp.unnam.de/
- thanks to http://plugin.michael-simpson.com/ (this guy actually saved me). I downloaded his template and quickly read articles on his site and this gave me enough information to "light" understand how to develop plugins for wordpress.
- my code is in the `lib` directory. also in `BootcampWpPlugin_Plugin.php` and `BootcampWpPlugin_LifeCycle.php`
- you can regenerate api key on backend (provide different url) and start integration from the scratch