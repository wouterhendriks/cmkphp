<?php

   class cmk_cartalk_koppeling {

      public static function precheck() {

         global $plugin_checkmijnkenteken;

            $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck()' );
   
         // Return voorbereiden
   
            $return_ok = new stdClass();
            $return_fail = new stdClass();
   
            $return_ok->cartalk_availability = true;
            $return_fail->cartalk_availability = false;
   
         // Cartalk vragen of er informatie beschikbaar is
   
            $params = array(
               'reference' 				=> CONFIG_CARTALK_reference,
               'user' 						=> CONFIG_CARTALK_user,
               'password' 					=> CONFIG_CARTALK_password,
               'transactionType' 		=> 'ert',
               'parameters[kenteken]' 	=> $plugin_checkmijnkenteken->get_kenteken(),
            );
            $response = $plugin_checkmijnkenteken->fetch_remote_data( 'POST', 'https://voertuiginfo.cartalk.nl/2.1/Rest/Transaction/ertprecheck', $params, 'json' );
   
         // Foutafhandeling
   
            if ( ! is_object( $response ) ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck(): geen geldig object ontvangen', $response );
               return $return_fail;
            }
      
            if ( sizeof( $response->responseData ) == 0 ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck(): error', $response );
               return $return_fail;
            }
      
            $cartalk_data = current( current( $response->responseData )->data );
   
         // Kijken of object beschikbaar is
   
            if ( $cartalk_data->beschikbaar != "1" ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck(): niet beschikbaar' );
               return $return_fail;
            }
   
         // Bouwjaar mag niet ouder zijn dan 25 jaar
   
            if ( $cartalk_data->bouwjaar + 25 < date( 'Y' ) ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck(): niet beschikbaar, ouder dan 25 jaar' );
               return $return_fail;
            }
   
         // Alles prima

            $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::precheck(): ok' );
            return $return_ok;
   
      }

      public static function get_data() {

         global $plugin_checkmijnkenteken;

         $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::get_data()' );

         // Payload prep.

            $params = array(
               'reference' 				=> CONFIG_CARTALK_reference,
               'user' 						=> CONFIG_CARTALK_user,
               'password' 					=> CONFIG_CARTALK_password,
               'transactionType' 		=> 'ert',
               'parameters[kenteken]' 	=> $plugin_checkmijnkenteken->get_kenteken(),
               'parameters[valuation]' => 1,
            );

            if ( $plugin_checkmijnkenteken->get_tellerstand() > 0 ) {
               $params[ 'parameters[tellerstand]' ] = $plugin_checkmijnkenteken->get_tellerstand();
            }

         // Aanvraag uitvoeren

            $response = $plugin_checkmijnkenteken->fetch_remote_data( 'POST', 'https://voertuiginfo.cartalk.nl/2.1/Rest/Transaction/vehicleValuation', $params, 'json' );

         // Foutafhandeling

            if ( ! isset( $response->status->message->type ) ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::get_data(): ongeldige/onbekende response', $response );
               return false;
            }

            if ( $response->status->message->type == 'error' ) {
               $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::get_data(): error', $response );
               return false;
            }

         // Afronden

            $plugin_checkmijnkenteken->log_to_db( '', 'cmk_cartalk_koppeling::get_data(): done', $response );

            return $plugin_checkmijnkenteken->convert_object_to_array( $response );

      }

      public static function valideer( $data ) {

         global $plugin_checkmijnkenteken;

         $resultaat = true;
         $redenen = array();

         if ( ! isset( $data[ 'status' ][ 'message' ][ 'type' ] ) ) {

            $resultaat = false;
            $redenen[] = '$data[status][message][type] niet beschikbaar';

         } else {

            if ( $data[ 'status' ][ 'message' ][ 'type' ] != 'success' ) {

               $resultaat = false;
               $redenen[] = '$data[status][message][type] != success';
   
            }

         }

         if ( $resultaat !== true ) {
            $plugin_checkmijnkenteken->log_to_db( $plugin_checkmijnkenteken->get_kenteken(), 'cmk_cartalk_koppeling::valideer() mislukt', $redenen );
         }

         return $resultaat;

      }

   }
