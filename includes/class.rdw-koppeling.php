<?php

   use RDWOA\RDW;

   class cmk_rdw_koppeling {

      public static function get_data( $as_object = false ) {

         global $plugin_checkmijnkenteken;

         // TODO: cmk_rdw_koppeling::get_data() $as_object er uit schrijven?

         // Docs: https://github.com/jeffreyvr/rdw-opendata-php

         $plugin_checkmijnkenteken->log_to_db( '', 'cmk_rdw_koppeling::get_data()', array( 'as_object', $as_object ) );

         // Data object samenstellen
   
            $data = new stdClass();
   
            $data->info = cmk_rdw_koppeling::rdw_get_data_onderdeel( $plugin_checkmijnkenteken->get_kenteken(), 'info' );
            $data->fuel = cmk_rdw_koppeling::rdw_get_data_onderdeel( $plugin_checkmijnkenteken->get_kenteken(), 'brandstof' );
            $data->body = cmk_rdw_koppeling::rdw_get_data_onderdeel( $plugin_checkmijnkenteken->get_kenteken(), 'carrosserie' );
            $data->precheck = cmk_cartalk_koppeling::precheck( $plugin_checkmijnkenteken->get_kenteken() );
   
            // ? Lijken niet meer gebruikt te worden, geven bovendien een foutmelding bij inschakeling
            // 'bodySpecific' => cmk_rdw_koppeling::rdw_get_data_onderdeel( $plugin_checkmijnkenteken->get_kenteken(), 'carrosserieSpecifiek' ),
            // 'vehicleClass' => cmk_rdw_koppeling::rdw_get_data_onderdeel( $plugin_checkmijnkenteken->get_kenteken(), 'voertuigklasse' ),
   
         // Afronden
   
            if ( $as_object ) {
               $plugin_checkmijnkenteken->log_to_db( $plugin_checkmijnkenteken->get_kenteken(), 'get_rdwdata(): returned as object', $data );
               return $data;
            } else {
               $plugin_checkmijnkenteken->log_to_db( $plugin_checkmijnkenteken->get_kenteken(), 'get_rdwdata(): returned as array', $data );
               return $plugin_checkmijnkenteken->convert_object_to_array( $data );
            }

      }

      public static function rdw_get_data_onderdeel( $kenteken, $onderdeel ) {

         global $plugin_checkmijnkenteken;

         $data = RDW::get( $kenteken, $onderdeel );
   
         if ( ! is_object( $data ) ) {
            $plugin_checkmijnkenteken->log_to_db( '', 'cmk_rdw_koppeling::rdw_get_data_onderdeel('.$kenteken. ','.$onderdeel.') misluikt', $dat );

            $data = array( 'status' => 'failed' );
         }
   
         return $data;
   
      }

      public static function valideer( $data ) {

         global $plugin_checkmijnkenteken;

         $resultaat = true;
         $redenen = array();


         // Altijd omzetten naar een array. Kan, afhankelijk van de aanroep van get_data een object zijn
         $data = $plugin_checkmijnkenteken->convert_object_to_array( $data );

         if ( isset( $data[ 'info' ][ 'status' ] ) && $data[ 'info' ][ 'status' ] == 'failed' ) {
            $resultaat = false;
            $redenen[] = '$data[info]->status = failed';
         }
         if ( isset( $data[ 'fuel' ][ 'status' ] ) && $data[ 'fuel' ][ 'status' ] == 'failed' ) {
            $resultaat = false;
            $redenen[] = '$data[fuel]->status = failed';
         }
         if ( isset( $data[ 'body' ][ 'status' ] ) && $data[ 'body' ][ 'status' ] == 'failed' ) {
            $resultaat = false;
            $redenen[] = '$data[body]->status = failed';
         }

         if ( isset( $data[ 'precheck' ][ 'cartalk_availability' ] ) && $data['precheck' ][ 'cartalk_availability' ] !== true ) {
            $resultaat = false;
            $redenen[] = '$data[precheck][cartalk_availability] != true';
         }

         if ( $resultaat !== true ) {
            $plugin_checkmijnkenteken->log_to_db( $plugin_checkmijnkenteken->get_kenteken(), 'cmk_rdw_koppeling::valideer() mislukt', $redenen );
         }

         return $resultaat;

      }

   }
