<?php

define( 'WP_USE_THEMES', true );
define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
require_once( BASE_PATH. '/wp-load.php' );

$plugin_checkmijnkenteken->set_kenteken( 'T481ZK');
$plugin_checkmijnkenteken->set_tellerstand( 41000 );
$plugin_checkmijnkenteken->set_emailadres( 'hello@comfortstud.io' );
$plugin_checkmijnkenteken->set_params_url( '' );

$plugin_checkmijnkenteken->generate_pdf();
// $plugin_checkmijnkenteken->send_email();
