<html><head><body>
   <pre>
<?php

   $allowed_ips = array(
      '127.0.0.1',
      '217.123.141.55',
      '83.174.137.222',
      '217.67.238.38',
   );

   // if ( ! in_array( $_SERVER[ 'REMOTE_ADDR' ], $allowed_ips ) ) {
   //    die( 'Geen toegang voor ' . $_SERVER[ 'REMOTE_ADDR' ] );
   // }

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   error_reporting( E_ALL );
   ini_set( 'display_errors', true );

   $kenteken = 'ZG326X';
   $tellerstand = 75547;

   // $kenteken = '00PDT1';
   // $tellerstand = 130000;

   // $plugin_checkmijnkenteken->set_kenteken( 'test' );
   // $plugin_checkmijnkenteken->set_kenteken( '00-AAZ-1' );
   // $plugin_checkmijnkenteken->set_kenteken( 'H-221-TG' );
   $plugin_checkmijnkenteken->set_kenteken( $kenteken );
   // $plugin_checkmijnkenteken->set_kenteken( '36-BA-82' );
   // $plugin_checkmijnkenteken->set_kenteken( '84-VR-VT' );
   $plugin_checkmijnkenteken->set_tellerstand( $tellerstand );
   // $plugin_checkmijnkenteken->set_tellerstand( '72000' );
   // $plugin_checkmijnkenteken->set_emailadres( 'test@teamnijhuis.nl' );
   $plugin_checkmijnkenteken->set_emailadres( 'hello@comfortstud.io' );

   $response = $plugin_checkmijnkenteken->generate_pdf();

   var_dump( $response );
