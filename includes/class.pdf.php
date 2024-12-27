<?php

   use Dompdf\Dompdf;
   use Dompdf\Options;

   class cmk_pdf {

      public static function generate() {

         global $plugin_checkmijnkenteken;

         $plugin_checkmijnkenteken->log_to_db( '', 'plugin_checkmijnkenteken::generate_pdf(): starting...' );

         // Rendering voorbereiden

            $rdwdata = cmk_rdw_koppeling::get_data();
            if ( ! cmk_rdw_koppeling::valideer( $rdwdata ) ) {
               return false;
            }

            $cartalk_data = cmk_cartalk_koppeling::get_data();
            if ( ! cmk_cartalk_koppeling::valideer( $cartalk_data ) ) {
               return false;
            }

            $tco_data = cmk_autodisk_koppeling::get_tco_data();
            if ( ! cmk_autodisk_koppeling::valideer( $tco_data ) ) {
               return false;
            }

         // TCO data verwerken

            if ( isset( $tco_data[ 'TCO_Uitkomst' ][ 'TCO_Valid' ] ) && $tco_data[ 'TCO_Uitkomst' ][ 'TCO_Valid' ] == 'True' ) {

               $displayTco = true;
               $AfschrijvingEnRente = $tco_data[ 'TCO_Uitkomst' ][ 'AfschrijvingEnRente' ];
               $ReparatieEnOnderhoud = $tco_data[ 'TCO_Uitkomst' ][ 'ReparatieEnOnderhoud' ];
               $Banden = $tco_data[ 'TCO_Uitkomst' ][ 'Banden' ];
               $MRB = $tco_data[ 'TCO_Uitkomst' ][ 'MRB' ];
               $Verzekering = $tco_data[ 'TCO_Uitkomst' ][ 'Verzekering' ];
               $TCO_Totaal = $tco_data[ 'TCO_Uitkomst' ][ 'TCO_Totaal' ];
               $BrandstofTCO = $tco_data[ 'TCO_Uitkomst' ][ 'Brandstof' ];
               $TCO_TotaalInBrandstof = $tco_data[ 'TCO_Uitkomst' ][ 'TCO_TotaalInBrandstof' ];

            } else {

               $displayTco = false;

            }

         // Cartalk data verwerken

            // ! Alleen leesbaar gemaakt, niet herschreven/verbeterd
            // NOTITIE: Er lijkt nieuwe data te zijn en ook data gewijzigd te zijn. Voor nou buiten scope

            if ( ! isset( $cartalk_data[ 'status' ][ 'message' ][ 'type' ] ) || $cartalk_data[ 'status' ][ 'message' ][ 'type' ] != 'success' ) {

               $plugin_checkmijnkenteken->log_to_db( '', 'plugin_checkmijnkenteken::generate_pdf(): harde exit vanwege ontbrekende cartalk data' );
               return false;

            } else {
               
               // Merk uit commerciele informatie(1) of RWD(0)
               if ( ! empty( $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'merk' ] ) ) {
                  $merk = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'merk' ];
               } else {
                  $merk = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'rdwmerk' ];
               }

               // Model uit commerciele informatie(1) of RWD(0)
               if( ! empty($cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'model' ] ) ) {
                  $model = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'model' ];
               } else {
                  $model = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'rdwhandelsbenaming' ];
               }

               $uitvoering = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'uitvoering' ];
               $kleur = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'kleur1' ];
               $voertuigsoort = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'voertuigsoort' ];
               $zitplaatsen = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'aantalzitplaatsen' ];
               $bouwjaar = substr($cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatinginternationaal' ], 0, 4);
               $nieuwprijs = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'nieuwprijs' ];
               $catalogusprijs = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'catalogusprijs' ];
               $deuren = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'carrosserie' ][ 'deuren' ];
               $vermogen = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'vermogeninkw' ];

               if( ! empty( $rdwdata[ 'fuel' ][ 'nominaal_continu_maximumvermogen' ] ) ) {
                  $vermogen2 = round($rdwdata[ 'fuel' ][ 'nominaal_continu_maximumvermogen' ]);
               } else {
                  $vermogen2 = 0;
               }

               $aandrijving = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'aandrijving' ];
               $snelheidnaar100km = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'acceleratie' ];
               $carrosserie = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'carrosserie' ];
               $topsnelheid = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'topsnelheid' ];
               $brandstof = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'brandstofsoort' ];
               $vervaldatumapk = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'apkvervaldatum' ];
               $maxtrekgewicht = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'laadvermogen' ];
               $transmissie = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'transmissie' ];
               $versnellingen = $cartalk_data[ 'responseData' ][1][ 'data' ][0][ 'versnellingen' ];
               $aantaleigenaren = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'aantaleigenaren' ];

               if( $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatinginternationaal' ] !== $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatingnationaal' ]){
                  //date is different so car was imported
                  //datum toelating internationaal is eerst geregistreerde datum 
                  $eerstetoelating = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatinginternationaal' ];
                  $importauto = "Ja";
               } else {
                  //datum toelating nationionaal is eerst geregistreerde datum 
                  $eerstetoelating = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatingnationaal' ];
                  $importauto = "Nee";
               }

               $eerstetoelatinginternationaal = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatinginternationaal' ];
               $eerstetoelatingnationaal = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'datumeerstetoelatingnationaal' ];
               $restbpm = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'restbpm' ];
               $inruilwaarde = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'waardebepaling' ][ 'waarden' ][ 'inkoopprijs' ][ 'bedrag' ][ 'waarde' ];
               $verkoopwaarde = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'waardebepaling' ][ 'waarden' ][ 'verkoopprijs' ][ 'bedrag' ][ 'waarde' ];
               $dagentekoop = "20";
               $autosnutekoop = "100";
               $autosverkocht = "75";

               $image = $cartalk_data[ 'responseData' ][2][ 'data' ][0][ 'imageurl' ];

               $laatstetenaamstelling = $rdwdata[ 'info' ][ 'datum_tenaamstelling' ];
               $cilinderaantal = $rdwdata[ 'info' ][ 'aantal_cilinders' ];
               $cilinderinhoud = $rdwdata[ 'info' ][ 'cilinderinhoud' ];
               $zuinigheidslabel = @$rdwdata[ 'info' ][ 'zuinigheidsclassificatie' ]; // ! Was zuinigheidslabel, niet altijd aanwezig (voor nieuwere auto's?)
               $verbruikbuiten = @$rdwdata[ 'fuel' ][ 'brandstofverbruik_stad' ];
               $verbruikbinnen = @$rdwdata[ 'fuel' ][ 'brandstofverbruik_buiten' ];

               if ( isset( $rdwdata[ 'fuel' ][ 'brandstof_verbruik_gecombineerd_wltp' ] ) ) {
                  $verbruikgecombineerd = $rdwdata[ 'fuel' ][ 'brandstof_verbruik_gecombineerd_wltp' ];
               } else {
                  $verbruikgecombineerd = $rdwdata[ 'fuel' ][ 'brandstofverbruik_gecombineerd' ];
               }

               $co2uitstoot = $rdwdata[ 'fuel' ][ 'co2_uitstoot_gecombineerd' ];
               $wokstatus = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'wokstatus' ];
               // $wokbegin = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'wokbegin' ];
               // $wokeind = @$cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'wokeinde' ]; // ! Niet altijd aanwezig
               $brutobpm = $rdwdata[ 'info' ][ 'bruto_bpm' ];
               $restbpm = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'restbpm' ];
               $wamverzekerd = $rdwdata[ 'info' ][ 'wam_verzekerd' ];
               $terugroepactie = $rdwdata[ 'info' ][ 'openstaande_terugroepactie_indicator' ];
               $wielbasis = $rdwdata[ 'info' ][ 'wielbasis' ];
               $massaledigvoertuig = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'massaleegvoertuig' ];
               $massarijklaar = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'massarijklaar' ];
               $toegestanemaximummassa = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'maximummassa' ];
               $laadvermogen = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'laadvermogen' ];
               $maximumgewichtaanhangerongeremd = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'maximummassaongeremd' ];
               $maximumgewichtaanhangergeremd = $cartalk_data[ 'responseData' ][0][ 'data' ][0][ 'maximummassageremd' ];
               $variant = $rdwdata[ 'info' ][ 'variant' ];
               $uitvoering2 = $rdwdata[ 'info' ][ 'uitvoering' ];
               $typegoedkeuringsnummer = $rdwdata[ 'info' ][ 'typegoedkeuringsnummer' ];
               $plaatschasisnummer = @$rdwdata[ 'info' ][ 'plaats_chassisnummer' ];
               $stadagenautovergelijkbaar = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'marktdagenAanbod' ][ 'vergelijkbaar' ];
               $autostekoop = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'vergelijkbareVoertuigen' ][ 'teKoop' ];
               $autosverkocht = $cartalk_data[ 'responseData' ][3][ 'data' ][0][ 'marktdagenAanbod' ][ 'aantalVoertuigenVerkocht' ];

               if ( $autostekoop > 0 && $autosverkocht > 0) {
                  $verwachtestadagen = round($autostekoop / $autosverkocht * 45);
               } else {
                  $verwachtestadagen = 'onbekend';
               }

               if ( empty( $stadagenautovergelijkbaar ) ) {
                  $stadagenautovergelijkbaar = '?';
               }

            }

         // PDF data opbouwen
            
            $pdf_data = array(
               'aandrijving' => $aandrijving,
               'aantaleigenaren' => $aantaleigenaren,
               'autosnutekoop' => $autosnutekoop,
               'autostekoop' => $autostekoop,
               'autosverkocht' => $autosverkocht,
               'bouwjaar' => $bouwjaar,
               'brandstof' => $brandstof,
               'brutobpm' => $brutobpm,
               'carrosserie' => $carrosserie,
               'catalogusprijs' => $catalogusprijs,
               'cilinderaantal' => $cilinderaantal,
               'cilinderinhoud' => $cilinderinhoud,
               'co2uitstoot' => $co2uitstoot,
               'dagentekoop' => $dagentekoop,
               'deuren' => $deuren,
               'eerstetoelating' => $eerstetoelating,
               'eerstetoelatinginternationaal' => $eerstetoelatinginternationaal,
               'eerstetoelatingnationaal' => $eerstetoelatingnationaal,
               'image' => $image,
               'importauto' => $importauto,
               'inruilwaarde' => $inruilwaarde,
               'kenteken' => $plugin_checkmijnkenteken->maak_kenteken_leesbaar( $plugin_checkmijnkenteken->get_kenteken() ),
               'kleur' => $kleur,
               'laadvermogen' => $laadvermogen,
               'laatstetenaamstelling' => $laatstetenaamstelling,
               'massaledigvoertuig' => $massaledigvoertuig,
               'massarijklaar' => $massarijklaar,
               'maximumgewichtaanhangergeremd' => $maximumgewichtaanhangergeremd,
               'maximumgewichtaanhangerongeremd' => $maximumgewichtaanhangerongeremd,
               'maxtrekgewicht' => $maxtrekgewicht,
               'merk' => $merk,
               'model' => $model,
               'nieuwprijs' => $nieuwprijs,
               'plaatschasisnummer' => $plaatschasisnummer,
               'restbpm' => $restbpm,
               'restbpm' => $restbpm,
               'snelheidnaar100km' => $snelheidnaar100km,
               'stadagenautovergelijkbaar' => $stadagenautovergelijkbaar,
               'tellerstand' => ( ! empty( $plugin_checkmijnkenteken->get_tellerstand() ) ? $plugin_checkmijnkenteken->get_tellerstand() : 'Onbekend' ),
               'terugroepactie' => $terugroepactie,
               'toegestanemaximummassa' => $toegestanemaximummassa,
               'topsnelheid' => $topsnelheid,
               'transmissie' => $transmissie,
               'typegoedkeuringsnummer' => $typegoedkeuringsnummer,
               'uitvoering' => $uitvoering,
               'uitvoering2' => $uitvoering2,
               'variant' => $variant,
               'verbruikbinnen' => $verbruikbinnen,
               'verbruikbuiten' => $verbruikbuiten,
               'verbruikgecombineerd' => $verbruikgecombineerd,
               'verkoopwaarde' => $verkoopwaarde,
               'vermogen' => $vermogen,
               'vermogen2' => $vermogen2,
               'versnellingen' => $versnellingen,
               'vervaldatumapk' => $vervaldatumapk,
               'verwachtestadagen' => $verwachtestadagen,
               'voertuigsoort' => $voertuigsoort,
               'wamverzekerd' => $wamverzekerd,
               'wielbasis' => $wielbasis,
               // 'wokbegin' => $wokbegin,
               // 'wokeind' => $wokeind,
               'wokstatus' => $wokstatus,
               'zitplaatsen' => $zitplaatsen,
               'zuinigheidslabel' => $zuinigheidslabel,
               'params_url' => plugin_checkmijnkenteken::prefix_params( $plugin_checkmijnkenteken->get_params_url() )
            );

            if ( $displayTco === true ) {
               $pdf_data[ 'afschrijvingenrente' ] = $AfschrijvingEnRente;
               $pdf_data[ 'banden' ] = $Banden;
               $pdf_data[ 'brandstoftco' ] = $BrandstofTCO;
               $pdf_data[ 'mrb' ] = $MRB;
               $pdf_data[ 'reparatieenonderhoud' ] = $ReparatieEnOnderhoud;
               $pdf_data[ 'tco_available' ] = "true";
               $pdf_data[ 'tco_totaal' ] = $TCO_Totaal;
               $pdf_data[ 'tco_totaalinbrandstof' ] = $TCO_TotaalInBrandstof;
               $pdf_data[ 'verwachtestadagen' ] = $verwachtestadagen;
               $pdf_data[ 'verzekering' ] = $Verzekering;
               $pdf_data[ 'verwachtestadagen' ] = $verwachtestadagen;
               $pdf_data[ 'zuinigheidslabel' ] = $zuinigheidslabel;
            }

         // PDF genereren

            $pdf_template_file = $plugin_checkmijnkenteken->get_path() . '/templates/pdf/index.php';
            $pdf_output_file = $plugin_checkmijnkenteken->get_pdf_dir() . $plugin_checkmijnkenteken->get_kenteken() . '.pdf';

            ob_start();
            include( $pdf_template_file );
            $PDFContent = ob_get_clean();

            // echo $PDFContent;
            // die();

            $options = new Options();
            // $options->set('isRemoteEnabled', true);
            $options->set('isRemoteEnabled', true );
            $options->set('fontHeightRatio', 1);

            $dompdf = new DOMPDF($options);
            $dompdf->setHttpContext(
               stream_context_create([
                  'ssl' => [
                     'allow_self_signed'=> TRUE,
                     'verify_peer' => FALSE,
                     'verify_peer_name' => FALSE,
                  ]
               ])
            );
            $dompdf->loadHtml($PDFContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents( $pdf_output_file, $output );

            $plugin_checkmijnkenteken->log_to_db( '', 'plugin_checkmijnkenteken::generate_pdf(): done. Generated ' . $pdf_output_file );

            return '/pdf/pdf_output/' . $plugin_checkmijnkenteken->get_kenteken() . '.pdf';      
      }
   }
