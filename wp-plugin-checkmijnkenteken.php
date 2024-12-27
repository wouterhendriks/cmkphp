<?php
/*
Plugin Name: checkmijnkenteken.nl: Precheck, betaling en generatie
Plugin URI:
Description: Verzorgd de kentekencheck, betaling en generatie van de PDF rapporten
Version: 1.0
Author: Dtch. Digitals
Author URI: https://dtchdigitals.com/nl/
Copyright:
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Installatie hook voor aanmaken tabellen

   register_activation_hook( __FILE__, 'checkmijnkenteken_plugin_activate' );

// Dwing sessies af

   add_action('init', function() {
      if (!session_id()) {
         session_start();
      }
   }, 1);

// Class initialiseren

   $plugin_checkmijnkenteken = new plugin_checkmijnkenteken();

// Ingevoerde kenteken altijd opschonen

   if ( isset( $_GET[ 'kenteken' ] ) ) {
      $_GET[ 'kenteken' ] = $plugin_checkmijnkenteken->kenteken_cleanup( $_GET[ 'kenteken' ] );
   }

// Class plugin_checkmijnkenteken
   class plugin_checkmijnkenteken {

      private $kenteken = false;
      private $tellerstand = false;
      private $emailadres = false;
      private $params_url = false;

      private $cache_enabled = false;
      private $cache_dir;
      private $pdf_dir;
      private $path;

      public function __construct() {

         // Timezone instellen/overrulen

            date_default_timezone_set( 'Europe/Amsterdam' );

         // Gebruikte paden bepalen

            $upload_dir = wp_get_upload_dir();

            $this->path = plugin_dir_path( __FILE__ );
            $this->cache_dir = $upload_dir[ 'basedir' ] . '/cmk-cache/';
            $this->pdf_dir = ABSPATH . '/pdf/pdf_output/';

         // Includes laden

            $this->load_includes();

      }

      public function load_includes() {

         require_once( $this->path . '/vendor/autoload.php' );
         require_once( $this->path . '/includes/mollie-payment.php' );
         require_once( $this->path . '/includes/dashboard.php' );

         require_once( $this->path . '/includes/class.moneybird.php' );
         require_once( $this->path . '/includes/class.rdw-koppeling.php' );
         require_once( $this->path . '/includes/class.cartalk-koppeling.php' );
         require_once( $this->path . '/includes/class.autodisk-koppeling.php' );
         require_once( $this->path . '/includes/class.pdf.php' );

      }

      public function set_kenteken( $kenteken ) {
         $this->kenteken = $this->kenteken_cleanup( $kenteken );
      }

      public function set_tellerstand( $tellerstand ) {
         $tellerstand = (int)preg_replace( '/[^0-9]/', '', $tellerstand );
         $this->tellerstand = $tellerstand;
      }

      public function set_emailadres( $emailadres ) {
         $this->emailadres = $emailadres;
      }

      public function set_params_url( $params_url ) {
         $this->params_url = $params_url;
      }

      public function get_kenteken() {
         return $this->kenteken;
      }
      public function get_tellerstand() {
         return $this->tellerstand;
      }
      public function get_emailadres() {
         return $this->emailadres;
      }

      public function get_params_url() {
         return $this->params_url;
      }

      public function get_path() {
         return $this->path;
      }

      public function get_pdf_dir() {
         return $this->pdf_dir;
      }

      public static function kenteken_cleanup( $kenteken ) {
         $kenteken = preg_replace( '/[^0-9A-Z]/', '', strtoupper( $kenteken ) );
         return $kenteken;
      }

      public function log_to_db( $kenteken = '', $message = '', $data = array() ) {

         global $wpdb;

         // Insert $wpdb query into wp_checkmijnkenteken_log with fields kenteken, message and data

         if ( empty( $kenteken ) || $this->kenteken !== false ) {
            $kenteken = $this->kenteken;
         }

         $logdata = array(
            'kenteken' => $kenteken,
            'message' => $message,
            'data' => json_encode( $data )
         );

         $wpdb->insert( 'wp_checkmijnkenteken_log', $logdata );
      }

      public function maak_kenteken_leesbaar( $kenteken ) {

         $tekens = str_split( strtoupper( $kenteken ) );
         $opgemaakt_kenteken = '';
         $huidige_tekensoort = ( is_numeric( current( $tekens ) ) ) ? 'cijfer' : 'letter';

         foreach ( $tekens as $teken ) {

            if ( is_numeric( $teken ) && $huidige_tekensoort != 'cijfer' ) {
               $huidige_tekensoort = 'cijfer';
               $opgemaakt_kenteken .= '-';
            } elseif ( ! is_numeric( $teken ) && $huidige_tekensoort != 'letter' ) {
               $huidige_tekensoort = 'letter';
               $opgemaakt_kenteken .= '-';
            }

            $opgemaakt_kenteken .= $teken;

         }

         $opgemaakt_kenteken = preg_replace( '/(\w{2})(\w{2})/', '$1-$2', $opgemaakt_kenteken );

         return $opgemaakt_kenteken;
      }

      public function precheck( $kenteken, $use_cache = true ) {

         // Check input

            if ( empty( $kenteken ) ) {
               return false;
            }

            $this->log_to_db( $kenteken, 'precheck starting' );

         // Basis opzetten

            $this->load_includes();
            $this->set_kenteken( $kenteken );

         // RDW data ophalen met cache support

            $rdw_data = false;

            if ( $use_cache == true ) {
               $rdw_data = get_transient( 'precheck_' . $kenteken );
            }

            if ( $rdw_data === false ) {

               $rdw_data = cmk_rdw_koppeling::get_data( true );

               $this->log_to_db( $kenteken, 'precheck done', array( 'rdw_data' => $rdw_data ) );

               if ( $use_cache ) {
                  set_transient('precheck_' . $kenteken,$rdw_data,5*60); // 5 minuten
               }

            }

            if ( ! cmk_rdw_koppeling::valideer( $rdw_data ) ) {
               $this->log_to_db( '', 'precheck failed', array( 'rdw_data' => $rdw_data ) );
               $this->toon_foutmelding( 'Het was niet mogelijk om de gegevens van het kenteken ' . $kenteken . ' op te halen' );
            }

            return $rdw_data;

      }

      public function fetch_remote_data( $method = 'GET', $url = '', $postfields = array(), $format = 'json', $use_cache = '' ) {

         // Pre-request logging

            $this->log_to_db( '', 'plugin_checkmijnkenteken::fetch_remote_data() ', array(
               'method' => $method,
               'url' => $url,
               'postfields' => $postfields,
               'format' => $format,
               'use_cache' => $use_cache,
            ) );

         // Caching

            if ( $use_cache !== true && $use_cache !== false && $this->cache_enabled == true ) {
               $use_cache = true;
            }

            if ( $use_cache ) {
               $cache_seed = $method . $url . print_r( $postfields, true ) . $format;
               $cache_file = $this->cache_dir . sha1( $cache_seed ) . '.json';

               if ( file_exists( $cache_file ) ) {
                  $cache_contents = file_get_contents( $cache_file );
                  $cache_data = json_decode( $cache_contents );

                  $this->log_to_db( '', 'plugin_checkmijnkenteken::fetch_remote_data(): served from cache ', array(
                     'cache_file' => $cache_file,
                     'cache_data' => $cache_data,
                  ) );

                  return $cache_data->cache_data;
               }

            }

         // Request uitvoeren

            $ch = curl_init();

            $curl_options = array(
               CURLOPT_URL => $url,
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => "",
               CURLOPT_MAXREDIRS => 5,
               CURLOPT_TIMEOUT => 10,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_SSL_VERIFYPEER => false,
               CURLOPT_CUSTOMREQUEST => $method,
            );

            if ( sizeof( $postfields ) > 0 ) {
               $curl_options[ CURLOPT_POSTFIELDS ] = $postfields;
            }

            curl_setopt_array( $ch, $curl_options );

            $response = curl_exec( $ch );

            if ( $response === false ) {
               $this->log_to_db( '', 'plugin_checkmijnkenteken::fetch_remote_data( '.$url.' ) curl error: ' . curl_error( $ch ) );
            }

            curl_close( $ch );

         // Response verwerken

            if ( $format == 'json' ) {
               $data = json_decode( $response );
            } else {
               $data = $response;
            }

         // Post-request logging

            $this->log_to_db( '', 'fetch_remote_data() response data', $data );

         // Save in cache

            if ( $use_cache ) {
               $cache_data = new stdClass;
               $cache_data->cache_data = $data;
               file_put_contents( $cache_file, json_encode( $cache_data ) );
               $this->log_to_db( 'fetch_remote_data() cachefile saved ' . $cache_file );
            }

         // Done.

            return $data;

      }

      public function convert_object_to_array( $object ) {
         $json = json_encode( $object );
         $array = json_decode( $json, TRUE );
         return $array;
      }

      public function activecampaign() {

         // Docs: https://github.com/ActiveCampaign/activecampaign-api-php

         // Init ActiveCampaign

            $ac = new ActiveCampaign("https://checkmijnkenteken.api-us1.com", CONFIG_ACTIVECAMPAIGN_API_PASS );
            $ac->set_curl_timeout(15 );

         // Prep. payload

            $contact = array(
               'email' => $this->emailadres,
               'field' =>
               array(
                  '1,0' => $this->kenteken,
                  '2,0' => 'https://checkmijnkenteken.nl/pdf/pdf_output/'.$this->kenteken.'.pdf',
                  '3,0' => $this->tellerstand
               )
            );

         // Do the thing

            $contact_sync = $ac->api("contact/sync", $contact );

         // Check for errors

            if ( ! (int) $contact_sync->success ) {
               $this->log_to_db( '', 'plugin_checkmijnkenteken::activecampaign(): mislukt' );
               return false;
            }

         // Wrap it up

            $this->log_to_db( '', 'plugin_checkmijnkenteken::activecampaign(): gelukt, subscriber_id: ' . $contact_sync->subscriber_id );
            return true;

      }

      // public function send_email() {

      //    $this->log_to_db( '', 'plugin_checkmijnkenteken::email(): sending e-mail' );

      //    // Prep template

      //       $template_file = $this->path . '/templates/email.php';
      //       $kenteken = $this->kenteken;

      //       ob_start();
      //       include( $template_file );
      //       $email_body = ob_get_clean();

      //    // Send mail

      //       $mail = new PHPMailer;
      //       $mail->isSMTP();
      //       $mail->SMTPDebug = SMTP::DEBUG_OFF; //SMTP::DEBUG_SERVER;
      //       $mail->CharSet = 'UTF-8';
      //       $mail->Host = CONFIG_SMTP_HOST;
      //       $mail->Port = 587;
      //       $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      //       $mail->SMTPAuth = true;
      //       $mail->Username = CONFIG_SMTP_USER;
      //       $mail->Password = CONFIG_SMTP_PASS;
      //       $mail->setFrom('contact@checkmijnkenteken.nl', 'Team Checkmijnkenteken');
      //       $mail->addReplyTo('contact@checkmijnkenteken.nl', 'Team Checkmijnkenteken');
      //       $mail->addAddress($this->emailadres);
      //       $mail->addBCC('rapporten@cmkautomotive.eu');
      //       $mail->Subject = '🚘 Jouw kentekenrapport staat voor je klaar 🚘';
      //       $mail->msgHTML( $email_body );

      //    // Wrap it up

      //       if (!$mail->send()) {
      //          $this->log_to_db( '', 'email() failed: ' . $mail->ErrorInfo );
      //          return false;
      //       } else {
      //          $this->log_to_db( '', 'email() send' );
      //          return true;
      //       }

      // }

      public function send_email( $params ) {

         $this->log_to_db( '', 'plugin_checkmijnkenteken::email(): sending e-mail' );

         // Params vs default values

            $to = $this->emailadres;
            if ( isset( $params[ 'to' ] ) ) {
               $to = $params[ 'to' ];
            }

            $subject = "🚘 Jouw kentekenrapport staat voor je klaar 🚘";
            if ( isset( $params[ 'subject' ] ) ) {
               $subject = $params[ 'subject' ];
            }

            $template_file = $this->path . '/templates/email.php';
            if ( isset( $params[ 'template' ] ) ) {
               $template_file = $this->path . '/templates/' . $params[ 'template' ];
            }

            $kenteken = $this->kenteken;

         // Postmark init

            $postmark_server_token = "<hidden>";

         // Get template

            ob_start();
            include($template_file);
            $email_body = ob_get_clean();

         // Prepare the payload

            $payload = array(
               'From' => 'contact@checkmijnkenteken.nl',
               'ReplyTo' => 'contact@checkmijnkenteken.nl',
               'To' => $to,
               'Bcc' => 'rapporten@cmkautomotive.eu',
               'Subject' => $subject,
               'HtmlBody' => $email_body,
               'MessageStream' => 'outbound',
            );

         // Attachment toevoegen

            if ( isset( $params[ 'pdf_attachment_body' ] ) && isset( $params[ 'pdf_attachment_name' ] ) ) {

               // Docs: https://postmarkapp.com/developer/api/email-api
               $payload[ 'Attachments' ] = array(
                  array(
                     'Name' => $params[ 'pdf_attachment_name' ],
                     'Content' => base64_encode( $params[ 'pdf_attachment_body' ] ),
                     'ContentType' => 'application/pdf',
                  )
               );

            }

         // Versturen

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.postmarkapp.com/email");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload) );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               "Accept: application/json",
               "Content-Type: application/json",
               "X-Postmark-Server-Token: " . $postmark_server_token
            ));

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
               $this->log_to_db('', 'email() failed: ' . curl_error($ch));
               curl_close($ch);
               return false;
            }

            curl_close($ch);

         // resultaat verwerken

            $response = json_decode($result, true);

            if (isset($response['Message']) && $response['Message'] == 'OK') {
               $this->log_to_db('', 'email() send');
               return true;
            } else {
               $this->log_to_db('', 'email() failed: ' . $response['Message']);
               return false;
            }

      }

      public function generate_pdf() {
         return cmk_pdf::generate();
      }

      public function update_queue_status( $id, $status ) {

         global $wpdb;

         $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET status = "%s" WHERE id = %d', $status, $id );
         $wpdb->query( $sql );

      }

      public function set_queue_to_genereren() {

         if ( empty( $this->kenteken ) ) {
            return;
         }

         global $wpdb;
         $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET status = "genereren" WHERE kenteken = %s AND status="betaling_gestart"', $this->kenteken );
         $wpdb->query( $sql );

      }

      public function set_payment_details( $payment_details ) {

         if ( empty( $this->kenteken ) ) {
            return;
         }

         global $wpdb;
         $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET payment_details = %s WHERE kenteken = %s AND status="betaling_gestart"', $payment_details, $this->kenteken );
         $wpdb->query( $sql );

      }

      public function add_to_queue( $status = 'genereren' ) {

         global $wpdb;

         $data = array(
            'kenteken'     => $this->kenteken,
            'tellerstand'  => $this->tellerstand,
            'email'        => $this->emailadres,
            'params_url'   => $this->params_url,
            'status'       => $status,
         );

         $wpdb->insert( 'wp_checkmijnkenteken_queue', $data);

         $this->log_to_db( $this->kenteken, 'PDF generatie toegevoegd aan wachtrij', $data );

      }

      public function verwerk_queue_en_genereer_rapporten() {

         global $wpdb;

         $this->log_to_db( 'cronjobs', 'Verwerk queue' );

         echo "--------------------------------------------------\n";
         echo " VERWERK QUEUE EN GENEREER RAPPORTEN \n";
         echo "--------------------------------------------------\n";

         // Status van mislukte items bijwerken

            $sql = "SELECT id,kenteken FROM wp_checkmijnkenteken_queue WHERE status='genereren' AND pogingen >= 5";
            $results = $wpdb->get_results( $sql );

            $mislukte_kentekens = array();

            foreach ( $results as $row ) {
               $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET status = "mislukt_na_5x" WHERE id = %d', $row->id );
               $wpdb->query( $sql );

               $mislukte_kentekens[] = $row->kenteken;
            }

            if ( sizeof( $mislukte_kentekens ) > 0 ) {
               echo "- Markeren als mislukt na 5x: ".implode(',', $mislukte_kentekens)."\n";
               wp_mail( 'hello@comfortstud.io', 'checkmijnkenteken.nl: Generatie rapport mislukt na 5 pogingen', implode( "\n", $mislukte_kentekens ) );
            }

         // Get open queue items

            echo "- Queue ophalen\n";

            // use $wpdb to execute "SELECT * FROM wp_checkmijnkenteken_queue WHERE status='genereren'" and save results in array

            $sql = "SELECT * FROM wp_checkmijnkenteken_queue WHERE status='genereren' AND pogingen < 5";
            $results = $wpdb->get_results( $sql );

            echo "- ".sizeof( $results )." regel(s) in wachtrij\n";

            $this->log_to_db( 'cronjobs', 'Verwerken: ', $results );

         // Door items lopen

            $verwerkte_kentekens = array();

            foreach ( $results as $request ) {

               if ( ! empty( $request->kenteken ) && ! empty( $request->tellerstand ) && ! empty( $request->email ) ) {

                  echo '-- Rapport genereren voor '. $request->kenteken. ':';

                  // Pogingen += 1

                     $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET pogingen = pogingen+1 WHERE id = %d', $request->id );
                     $wpdb->query( $sql );

                  // Dubbele verwerking voorkomen

                     if ( isset( $verwerkte_kentekens[ $request->kenteken ] ) ) {
                        $this->log_to_db( $request->kenteken, 'Dubbel kenteken gedetecteerd en genegeerd' );

                        $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET status = "dubbel, genegeerd" WHERE id = %d', $request->id );
                        $wpdb->query( $sql );

                        echo " Dubbel, genegeerd\n";

                        continue;
                     }

                     $verwerkte_kentekens[ $request->kenteken] = $request->kenteken;

                  // Init en generate

                     $this->set_kenteken( $request->kenteken );
                     $this->set_tellerstand( $request->tellerstand );
                     $this->set_emailadres( $request->email );
                     $this->set_params_url( $request->params_url );

                     $pdf_file = $this->generate_pdf();

                  // Dubbelcheck + afhandeling

                     if ( $pdf_file !== false && file_exists( ABSPATH . $pdf_file ) ) {
                        echo " Gelukt, e-mail versturen\n";
                        $this->log_to_db( $request->kenteken, 'Generatie gelukt' );

                        // Factuur genereren
                        // $cmk_moneybird = new cmk_moneybird();
                        // $salesinvoice_id = $cmk_moneybird->maak_factuur_aan( $this->get_kenteken(), $this->get_emailadres(), $request->payment_details );
                        // $pdf = $cmk_moneybird->get_pdf( $salesinvoice_id );

                        $this->send_email( array(
                           // 'pdf_attachment_body' => $pdf,
                           // 'pdf_attachment_name' => 'factuur-'. $this->get_kenteken() . '.pdf'
                        ) );

                        $sql = $wpdb->prepare( 'UPDATE wp_checkmijnkenteken_queue SET status = "gegenereerd" WHERE id = %d', $request->id );
                        $wpdb->query( $sql );

                     } else {
                        echo " Mislukt\n";
                        $this->log_to_db( $request->kenteken, 'Generatie mislukt', array( 'file' => $pdf_file ) );
                     }

               } else {

                  $this->log_to_db( 'cronjobs', 'Wachtrij item overgeslagen, niet volledig', $request );

               }

            }

      }

      public function get_openstaande_betalingen_queue() {

         // Query uitvoeren

            global $wpdb;

            $sql = "SELECT id,kenteken FROM wp_checkmijnkenteken_queue WHERE status='betaling_gestart'";
            $results = $wpdb->get_results( $sql );

         // Query hapklaar verwerken

            $openstaande_betalingen = array();

            foreach ( $results as $row ) {
               $openstaande_betalingen[ $row->kenteken ] = $row;
            }

         // Done.

            return $openstaande_betalingen;

      }

      public function dubbelcheck_recente_mollie_betalingen() {

         echo "--------------------------------------------------\n";
         echo " OPENSTAANDE MOLLIE BETALINGEN DUBBELCHECKEN \n";
         echo "--------------------------------------------------\n";

         // Openstaande betalingen ophalen

            $openstaande_betalingen = $this->get_openstaande_betalingen_queue();

            if ( sizeof( $openstaande_betalingen ) == 0 ) {
               echo "\n";
               echo "Geen openstaande betalingen in queue om te verwerken\n";
               echo "\n";
               return;
            }

         // Mollie init + betalingen ophalen

            // Docs: https://github.com/mollie/mollie-api-php/tree/master
            $mollie = tn_checkmijnkenteken_init_mollie();
            $payments_orig = (array)$mollie->payments->page();
            $payments = array_reverse( $payments_orig );

         // Door betalingen loopen

            foreach( $payments as $payment ) {

               $createdAt = date( 'Y-m-d H:i', strtotime( $payment->createdAt ) );
               $paidAt = date( 'Y-m-d H:i', strtotime( $payment->paidAt ) );

               $kenteken = preg_replace( '/^\d*\-/', '', $payment->description );

               $kenteken = $this->kenteken_cleanup( $kenteken );

               echo str_pad( $createdAt, 16, ' ' ) . ' [' . $kenteken . '] ' . str_pad( $payment->status, 12, ' ' ) . ': ';

               if ( $payment->status == 'paid' && isset( $openstaande_betalingen[ $kenteken ] ) ) {

                  $payment_details = 'Betaald door ' . $payment->details->consumerName . ' ('.$payment->details->consumerAccount.')';

                  // Factuur aanmaken in Mollie
                  $cmk_moneybird = new cmk_moneybird();
                  $salesinvoice_id = $cmk_moneybird->maak_factuur_aan( $kenteken, $openstaande_betalingen[ $kenteken ]->email, $payment_details, $payment->id );
                  $pdf = $cmk_moneybird->get_pdf( $salesinvoice_id );

                  $this->send_email( array(
                     'to' => $openstaande_betalingen[ $kenteken ]->email,
                     'subject' => 'Hartelijk dank voor het aanvragen van het kentekenrapport',
                     'template' => 'email-factuur.php',
                     'pdf_attachment_body' => $pdf,
                     'pdf_attachment_name' => 'factuur-'. $kenteken . '.pdf'
                  ) );

                  $this->update_queue_status( $openstaande_betalingen[ $kenteken ]->id, 'genereren' );
                  $this->log_to_db( $kenteken, 'Mollie betaling dubbelcheck: Queue status gewijzigd naar "genereren"' );
                  echo 'status bijgewerkt naar "genereren"';
               } else {
                  echo 'geen actie';
               }

               echo "\n";

               // genereren

            }

      }

      public function toon_foutmelding( $melding ) {

         $this->log_to_db( '', 'toon_foutmelding: ' . $melding );

         $template = $this->get_path() . '/templates/foutmelding.php';
         include( $template );
         die();

      }

      public static function prefix_params( $params_url ) {

         // Split params

            $params_orig = array();
            parse_str( $params_url, $params_orig );

         // Nieuwe params opbouwen

            $params_new = array();

            foreach ( $params_orig as $key => $value ) {

               if ( $key == 'utm_content' ) {

                  // Altijd CMK_rapport als utm_content
                  $value = 'CMK_rapport';

               } else {

                  // Niet leeg en nog niet voorzien van CMK_, dan prefixen met CMK_
                  if ( ! empty( $value ) && strpos( $value, 'CMK_' ) === false ) {
                     $value = 'CMK_'. $value;
                  } else {
                     $value = 'CMK_onbekend';
                  }
               }

               $params_new[ $key ] = $value;
            }

         return http_build_query( $params_new );

      }

   }

// Wordt uitgevoerd bij activatie van de plugin

   function checkmijnkenteken_plugin_activate() {

      require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

      $wp_checkmijnkenteken_log_create = '
         CREATE TABLE `wp_checkmijnkenteken_log` (
            `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
            `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `kenteken` varchar(10) NOT NULL DEFAULT "",
            `message` varchar(255) DEFAULT NULL,
            `data` longtext,
            PRIMARY KEY (`id`),
            KEY `kenteken` (`kenteken`,`message`,`timestamp`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      ';

      maybe_create_table( 'wp_checkmijnkenteken_log', $wp_checkmijnkenteken_log_create );

      $wp_checkmijnkenteken_queue_create = '
         CREATE TABLE `wp_checkmijnkenteken_queue` (
            `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
            `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `kenteken` varchar(10) NOT NULL DEFAULT "",
            `tellerstand` varchar(10) NOT NULL DEFAULT "",
            `email` varchar(255) NOT NULL DEFAULT "",
            `status` varchar(32) DEFAULT NULL,
            `pogingen` tinyint(4) DEFAULT "0",
            PRIMARY KEY (`id`),
            KEY `status` (`status`),
            KEY `kenteken` (`kenteken`),
            KEY `timestamp` (`timestamp`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      ';

      maybe_create_table( 'wp_checkmijnkenteken_queue', $wp_checkmijnkenteken_queue_create );

   }
