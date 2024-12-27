<?php

define( 'WP_USE_THEMES', true );
define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
require_once( BASE_PATH. '/wp-load.php' );

$rdw_info = plugin_checkmijnkenteken::precheck( 'T481ZK', false );
print_r( $rdw_info );