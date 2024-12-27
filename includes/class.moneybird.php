<?php

   /*

      DOCS
      - https://developer.moneybird.com/
      - https://developer.moneybird.com/php-with-curl/

      API key aanmaken
      - Inloggen op https://moneybird.com/user/applications/new
      - API voor persoonlijk gebruik selecteren
      - Toegang tot facturen
      - Bearer instellen

   */

   class cmk_moneybird {

      private $administration_id = false;
      private $plugin_checkmijnkenteken;

      public function __construct() {

         global $plugin_checkmijnkenteken;
         $this->plugin_checkmijnkenteken = $plugin_checkmijnkenteken;

         // MONEYBIRD_BEARER ingesteld?

            if ( ! defined( 'MONEYBIRD_BEARER' ) ) {
               echo '<p>MONEYBIRD_BEARER niet ingesteld</p>';
               return;
            }

      }

      public function get_contacts() {
         // Docs: https://developer.moneybird.com/api/contacts/
         return $this->request( 'contacts' );
      }

      public function get_workflows() {
         // Docs: https://developer.moneybird.com/api/workflows/
         return $this->request( 'workflows' );
      }

      public function maak_factuur_aan( $kenteken, $emailadres, $payment_details = '', $transaction_identifier = '' ) {

         // Docs: https://developer.moneybird.com/api/sales_invoices/#post_sales_invoices

         // Description opbouwen

            $description = 'Rapportage voor kenteken ' . $kenteken . ' aangevraagd door ' . $emailadres;

            if ( ! empty ( $payment_details ) ) {
               $description .= "\n" . $payment_details;
            }

         // Factuur aanmaken

            $data = array(
               'sales_invoice' => array(
                  'reference' => $kenteken,
                  'contact_id' => MONEYBIRD_CONTACT_ID,
                  'prices_are_incl_tax' => true,
                  'details_attributes' => array(
                     array(
                        'description' => $description,
                        'price' => 3.65
                     )
                  )
               )
            );

            if ( defined( 'MONEYBIRD_FLOW_ID' ) ) {
               $data[ 'workflow_id' ] = MONEYBIRD_WORKFLOW_ID;
            }

            $sales_invoice = $this->request( 'sales_invoices', 'post', $data );
            $sales_invoice_id = $sales_invoice->id;

            $this->plugin_checkmijnkenteken->log_to_db( $kenteken, 'Factuur aangemaakt', array( 'sales_invoice' => $sales_invoice));

         // Status 'verstuurd' instellen

            $send = $this->request( 'sales_invoices/'.$sales_invoice_id.'/send_invoice', 'PATCH', array(
               'sales_invoice_sending' => array(
                  'delivery_method' => 'Manual',
               )
            ) );

            $this->plugin_checkmijnkenteken->log_to_db( $kenteken, 'Factuur als verzonden gemarkeerd', array( 'send' => $send));

         // Betaling registreren

            $payment = $this->request( 'sales_invoices/'.$sales_invoice_id.'/payments', 'post', array(
               'payment' => array(
                  'transaction_identifier' => $transaction_identifier,
                  'payment_date' => date('Y-m-d H:i:s e'),
                  'price' => 3.65
               )
            ) );

            $this->plugin_checkmijnkenteken->log_to_db( $kenteken, 'Factuur als betaald gemarkeerd', array( 'payment' => $payment));

         return $sales_invoice_id;

      }

      function get_pdf( $sales_invoice_id ) {

         $response = $this->request( 'sales_invoices/'.$sales_invoice_id.'/download_pdf', 'get' );

         if ( strpos( $response, 'This resource has been moved' ) === 0 ) {
            $pdf_url = str_replace( 'This resource has been moved temporarily to ', '', $response );
            $pdf_url = preg_replace( '/\.$/', '', $pdf_url );
            return file_get_contents( $pdf_url );
         }

      }

      function get_administrations() {
         return $this->request( 'administrations', 'get', array(), false );
      }

      function get_administration_id() {

         if ( $this->administration_id !== false ) {
            return $this->administration_id;
         }

         $administrations = $this->get_administrations();
         $administration = current($administrations);

         $this->administration_id = $administration->id;

         return $this->administration_id;
      }

      public function request( $url, $method='get', $data = false, $add_administration_id = true ) {

         $headers = array(
            'Content-Type: application/json',
            sprintf('Authorization: Bearer %s', MONEYBIRD_BEARER)
         );

         $request_url = 'https://moneybird.com/api/v2/';

         if ( $add_administration_id === true ) {
            $request_url .= $this->get_administration_id(). '/';
         }

         $request_url .= $url;

         $curl = curl_init( $request_url );

         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

         // curl set method
         if ( strtolower( $method ) == 'post' ) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode( $data ) );
         } elseif ( strtolower( $method ) != 'get' ) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper( $method ) );
         }

         $response = curl_exec($curl);
         $data = json_decode( $response );

         return $data;

      }

   }