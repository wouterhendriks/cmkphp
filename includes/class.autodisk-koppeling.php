<?php

   class cmk_autodisk_koppeling {

      public static function get_tco_data() {

         global $plugin_checkmijnkenteken;

         // Prep payload

         $params = http_build_query( array(
               'nDebiteurNummer'          => CONFIG_TCO_DEBITEUR,
               'strGebruikersnaam'        => CONFIG_TCO_USER,
               'strWachtwoord'            => CONFIG_TCO_PASS,
               'strKenteken'              => $plugin_checkmijnkenteken->get_kenteken(),
               'nKilometerStand'          => $plugin_checkmijnkenteken->get_tellerstand(),
               'nInzetLooptijd'           => 0, // standaard waarde
               'nInzetKmPerJaar'          => 13000, // standaard waarde
               'sngRentePercentage'       => 0, // standaard waarde
               'nAantalMaandenInBezit'    => 0, // standaard waarde
            ) );

         // Aanvraag uitvoeren

            $url = 'https://scr.autodisk.nl/wsTCO_Client/wsTCO.asmx/wsCalculeerTCO?' . $params;
            $tco_xml_raw = $plugin_checkmijnkenteken->fetch_remote_data( 'GET', $url, array(), 'raw' );

         // Response verwerken en omzetten naar een array

            $tco_xml = simplexml_load_string( $tco_xml_raw, "SimpleXMLElement", LIBXML_NOCDATA );
            $tco_data = $plugin_checkmijnkenteken->convert_object_to_array( $tco_xml );

            $plugin_checkmijnkenteken->log_to_db( '', 'cmk_autodisk_koppeling->get_tco_data()', $tco_data );

         // Afronden

            return $tco_data;

      }

      public static function valideer( $data ) {

         global $plugin_checkmijnkenteken;

         $resultaat = true;
         $redenen = array();

         // if ( ! isset( $data[ 'TCO_Uitkomst' ] ) ) {
         //    $resultaat = false;
         //    $redenen[] = '$data[TCO_Uitkomst] niet beschikbaar';
         // }
         // if ( ! isset( $data[ 'TCO_VerfijnBerekening' ] ) ) {
         //    $resultaat = false;
         //    $redenen[] = '$data[TCO_VerfijnBerekening] niet beschikbaar';
         // }
         // if ( ! isset( $data[ 'TCO_Auto' ] ) ) {
         //    $resultaat = false;
         //    $redenen[] = '$data[TCO_Auto] niet beschikbaar';
         // }

         // if ( $resultaat !== true ) {
         //    $plugin_checkmijnkenteken->log_to_db( $plugin_checkmijnkenteken->get_kenteken(), 'cmk_autodisk_koppeling::valideer() mislukt', $redenen );
         // }

         return $resultaat;

      }

   }
