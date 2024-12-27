<?php

   define( 'WP_USE_THEMES', true );
   define( 'BASE_PATH', dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );
   require_once( BASE_PATH. '/wp-load.php' );

   get_header();

   echo '<pre style="padding-top:100px;font-size:12px;">';

   $sql = 'SELECT params_url FROM wp_checkmijnkenteken_queue WHERE params_url IS NOT NULL ORDER BY id DESC LIMIT 0,100';

   global $wpdb;

   $results = $wpdb->get_results( $sql );
   foreach ( $results as $row ) {
      echo '<b>'.$row->params_url. "</b>\n";
      echo '<b>'.plugin_checkmijnkenteken::prefix_params( $row->params_url ). "</b>\n";
      echo '<hr>';
   }
