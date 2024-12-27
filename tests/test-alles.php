<?php

   $allowed_ips = array(
      '::1',
      '127.0.0.1',
      '217.123.141.55',
      '83.174.137.222'
   );

   if ( ! in_array( $_SERVER[ 'REMOTE_ADDR' ], $allowed_ips ) ) {
      die( 'Geen toegang voor ' . $_SERVER[ 'REMOTE_ADDR' ] );
   }

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   echo '<pre>';

   // $plugin_checkmijnkenteken->set_kenteken( 'test' );
   // $plugin_checkmijnkenteken->set_kenteken( '00-AAZ-1' );
   $plugin_checkmijnkenteken->set_kenteken( '00-PTD-1' );
   $plugin_checkmijnkenteken->set_tellerstand( '100000' );
   $plugin_checkmijnkenteken->set_emailadres( 'hello@comfortstud.io' );

   echo '<b>kenteken: ' . $plugin_checkmijnkenteken->get_kenteken() . "</b>\n";
   echo '<b>tellerstand: ' . $plugin_checkmijnkenteken->get_tellerstand() . "</b>\n";
   echo '<b>emailadres: ' . $plugin_checkmijnkenteken->get_emailadres() . "</b>\n";

   echo '<hr>';
   echo "<p><b>get_rdwdata();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->get_rdwdata();
   print_r( $data );

   echo '<hr>';
   echo "<p><b>activecampaign();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->activecampaign();
   print_r( $data );

   echo '<hr>';
   echo "<p><b>get_cartalkdata();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->get_cartalkdata();
   print_r( $data );

   echo '<hr>';
   echo "<p><b>get_tco_data();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->get_tco_data();
   print_r( $data );

   echo '<hr>';
   echo "<p><b>generate_pdf();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->generate_pdf();
   print_r( $data );

   echo '<hr>';
   echo "<p><b>send_email();</b></b><br><br>";
   $data = $plugin_checkmijnkenteken->send_email();
   print_r( $data );

   die( '-' );
