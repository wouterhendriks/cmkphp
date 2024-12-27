<?php

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   $plugin_checkmijnkenteken->set_kenteken( $_GET[ 'kenteken' ] );
   $plugin_checkmijnkenteken->set_tellerstand( $_GET[ 'tellerstand' ] );
   $plugin_checkmijnkenteken->set_emailadres( $_GET[ 'email' ] );
   $plugin_checkmijnkenteken->set_params_url( $_GET['params_url'] );

   $data = $plugin_checkmijnkenteken->generate_pdf();

   header( 'Content-type: application/json' );
   echo json_encode( $data );
