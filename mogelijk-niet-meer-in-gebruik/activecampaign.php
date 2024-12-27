<?php

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   $data = $plugin_checkmijnkenteken->activecampaign( $_GET[ 'kenteken' ], $_GET[ 'tellerstand' ], $_GET[ 'email' ] );

   header( 'Content-type: application/json' );
   echo json_encode( $data );

   die();
