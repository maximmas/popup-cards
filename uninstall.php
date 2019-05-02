<?php

if( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit ();

require_once ( plugin_dir_path( __FILE__ ) . '/classes/class-cj-database.php' );

CJ_Database::delete_table();



