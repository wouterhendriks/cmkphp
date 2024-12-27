<?php

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   // system('clear');

   $plugin_checkmijnkenteken->dubbelcheck_recente_mollie_betalingen();
   $plugin_checkmijnkenteken->verwerk_queue_en_genereer_rapporten();
