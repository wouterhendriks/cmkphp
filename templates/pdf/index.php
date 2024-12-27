<?php

// Herschrijven naar include zonder https?
$base_dir = get_site_url() . '/wp-content/plugins/wp-plugin-checkmijnkenteken/templates/pdf/';
$img_dir = get_site_url() . '/wp-content/plugins/wp-plugin-checkmijnkenteken/templates/pdf/images/';

if( ! function_exists( 'timeFormatChange' ) ) {
    function timeFormatChange($timestamp){
        $r = substr($timestamp, -2) . "-" .substr($timestamp, -4, 2) ."-" .substr($timestamp, 0,-4);
        return $r;
    }
}

if(!empty($pdf_data)){
    //define variables;
    $kenteken = $pdf_data["kenteken"];
    $merk = ucfirst(strtolower($pdf_data["merk"]));
    $model = ucfirst(strtolower($pdf_data["model"]));
    $tellerstand = $pdf_data["tellerstand"];
    $uitvoering = ucfirst($pdf_data["uitvoering"]);
    $voertuigsoort = ucfirst($pdf_data["voertuigsoort"]);
    $kleur = ucfirst(strtolower($pdf_data["kleur"]));
    $bouwjaar = $pdf_data["bouwjaar"];
    $nieuwprijs = number_format($pdf_data["nieuwprijs"],2,",",".");

    // if ( isset( $pdf_data[ 'params_url' ] ) && $pdf_data[ 'params_url' ] !== false ) {
    //     $url = $pdf_data[ 'params_url' ];
    // } else {
        //$url = 'https://www.wijverkopenuwautowel.nl/?' . $pdf_data[ 'params_url' ];
		$url = 'https://looping.nl/aanmelden/?license='. $kenteken . '&objecttype=car&' . $pdf_data[ 'params_url' ];
    // }

    if(!empty($pdf_data["catalogusprijs"])){
        $catalogusprijs = "€". number_format($pdf_data["catalogusprijs"],2,",",".");
    } else {
            $catalogusprijs = "Niet bekend";
    }

    /* 
    * TCO additions
    *		'afschrijvingenrente' => $AfschrijvingEnRente,
	*		'reparatieenonderhoud' => $ReparatieEnOnderhoud,
	*		'banden' => $Banden,
	*		'mrb' => $MRB,
	*		'verzekering' => $Verzekering,
	*		'tco_totaal' => $TCO_Totaal,
	*		'brandstoftco' => $BrandstofTCO,
	*		'tco_totaalinbrandstof' => $TCO_TotaalInBrandstof,
	*		'tco_available' => "true"
    */
    if(isset($pdf_data["afschrijvingenrente"])){
        $afschrijvingenrente = str_replace(",",".",$pdf_data["afschrijvingenrente"]);
    }
    if(isset($pdf_data["reparatieenonderhoud"])){
        $reparatieenonderhoud = str_replace(",",".",$pdf_data["reparatieenonderhoud"]);
    }
    if(isset($pdf_data["banden"])){
        $banden = str_replace(",",".",$pdf_data["banden"]);
    }
    if(isset($pdf_data["mrb"])){
        $mrb = str_replace(",",".",$pdf_data["mrb"]);
    }
    if(isset($pdf_data["verzekering"])){
        $verzekering = str_replace(",",".",$pdf_data["verzekering"]);
    }
    if(isset($pdf_data["tco_totaal"])){
        $tco_totaal = str_replace(",",".",$pdf_data["tco_totaal"]);
    }
    if(isset($pdf_data["tco_totaalinbrandstof"])){
        $tco_totaalinbrandstof = str_replace(",",".",$pdf_data["tco_totaalinbrandstof"]);
    }
    if(isset($pdf_data["brandstoftco"])){
        
        $brandstoftco = str_replace(",",".",$pdf_data["brandstoftco"]);
    }

    $deuren = $pdf_data["deuren"];
    $zitplaatsen = $pdf_data["zitplaatsen"];
    $vermogen = $pdf_data["vermogen"];
    $aandrijving = ucfirst($pdf_data["aandrijving"]);
    //vermogen formatted: 100 KW / 136 PK

    if ( ! is_numeric( $vermogen ) ) {

        $vermogenFormatted = "Niet bekend";
        $vermogenPK = "Niet bekend";
        $vermogenKW = "Niet bekend";
        $vermogen2KW = "Niet bekend";
        $vermogen2Formatted = ""; 

    } else {

        $vermogenFormatted = "$vermogen KW / " . number_format($vermogen * 1.362, 0) . " PK";
        $vermogenPK = number_format($pdf_data["vermogen"] * 1.362, 0);
        $vermogenKW = $pdf_data["vermogen"];
        $vermogen2KW = $pdf_data["vermogen2"];
        $vermogen2Formatted = " + $vermogen2KW KW / " . number_format($vermogen2KW * 1.362, 0) . " PK";

    }

    $snelheidnaar100km = str_replace(".", ",", $pdf_data["snelheidnaar100km"]);
    $topsnelheid = $pdf_data["topsnelheid"];
    $brandstof = ucfirst($pdf_data["brandstof"]);
    $vervaldatumapk = timeFormatChange($pdf_data["vervaldatumapk"]);
    $maxtrekgewicht = $pdf_data["maxtrekgewicht"];
    $transmissie = ucfirst($pdf_data["transmissie"]);
    $versnellingen = $pdf_data["versnellingen"];
    $aantaleigenaren = $pdf_data["aantaleigenaren"];
    $importauto = $pdf_data["importauto"];
    if($importauto == "Ja"){
        $importauto_intext = "een import auto";
    } elseif ($importauto == "Nee") {
        $importauto_intext = "geen import auto";
    }

    if(!empty($pdf_data["eerstetoelating"])){
            $eerstetoelating = timeFormatChange($pdf_data["eerstetoelating"]);
            $eerstetoelatingDateObject = date_create_from_format ("d-m-Y", $eerstetoelating);
            $datetimeStart = new DateTime(substr($pdf_data["eerstetoelating"], 0,-4) ."-".substr($pdf_data["eerstetoelating"], -4, 2)."-".substr($pdf_data["eerstetoelating"], -2));
            $datetimeNow = new DateTime('NOW');
            $timediff = $datetimeStart->diff($datetimeNow);
            $jarenoud = $timediff->y;
    } else {
        $eerstetoelating = "Niet bekend";
        $datetimeStart = "Niet bekend";
        $timediff = "Niet bekend";
        $jarenoud = "Niet bekend";

    }


    $restbpm = $pdf_data["restbpm"];
    $inruilwaarde = ( $pdf_data["inruilwaarde"] * 0.9);
    if($inruilwaarde < 250){
        $inruilwaarde = 250;
    }
    $verkoopwaarde = $pdf_data["verkoopwaarde"];
    if($verkoopwaarde < 500){
        $verkoopwaarde = 500;
    }
    $dagentekoop = $pdf_data["dagentekoop"];
    $autosnutekoop = $pdf_data["autosnutekoop"];
    $autosverkocht = $pdf_data["autosverkocht"];
    $image = $pdf_data["image"];
    $carrosserie = ucfirst($pdf_data["carrosserie"]);
    $eerstetoelatingnationaal = timeFormatChange($pdf_data["eerstetoelatingnationaal"]);
    $eerstetoelatinintergnationaal = timeFormatChange($pdf_data["eerstetoelatinginternationaal"]);
    $laatsteTenaamstelling = timeFormatChange($pdf_data["laatstetenaamstelling"]);

    if(!empty($pdf_data["cilinderinhoud"])){
        $cilinderinhoud = $pdf_data["cilinderinhoud"];    
    } else {
        $cilinderinhoud = "Niet bekend";
    }

    if(!empty($pdf_data["cilinderaantal"])){
        $cilinderaantal = $pdf_data["cilinderaantal"];    
    } else {
        $cilinderaantal = "Niet bekend";
    }
    if(!empty($pdf_data["zuinigheidslabel"])){
        $zuinigheidslabel = $pdf_data["zuinigheidslabel"];    
    } else {
        $zuinigheidslabel = "Niet bekend";
    }

    if(!empty($pdf_data["verbruikgecombineerd"])){
        $verbruikgecombineerd = $pdf_data["verbruikgecombineerd"];
        $afstandperliter = number_format(100 / $verbruikgecombineerd,1) . " l/100km";
    } else {
        $verbruikgecombineerd = "Niet bekend";
        $afstandperliter = "Niet bekend";
    }
    if(!empty($pdf_data["verbruikbinnen"])){
        $verbruikbinnen = $pdf_data["verbruikbinnen"] . " l/100km";
    } else {
        $verbruikbinnen = "Niet bekend";
    }
    if(!empty($pdf_data["verbruikbuiten"])){
        $verbruikbuiten = $pdf_data["verbruikbuiten"] . " l/100km";
    } else {
        $verbruikbuiten = "Niet bekend";
    }

    if(!empty($pdf_data["co2uitstoot"])){
        $co2uitstoot = $pdf_data["co2uitstoot"]; 
    } else {
        $co2uitstoot = "Niet bekend";
    }


    if($pdf_data["wokstatus"] == 0){
        $wokstatus = "Nee";    
        // $wokbegin = "Niet van toepassing";
        // $wokeind = "Niet van toepassing";
    } elseif($pdf_data["wokstatus"] == 1){
        $wokstatus = "Ja";   
        // $wokbegin = timeFormatChange($pdf_data["wokbegin"]);
        // $wokeind = timeFormatChange($pdf_data["wokeind"]);
    }
    if(!empty($pdf_data["brutobpm"])){
        $brutobpm =  "€" . $pdf_data["brutobpm"];
    } else {
        $brutobpm =  "€0";
    }
    if(!empty($pdf_data["restbpm"])){
        $restbpm =  "€" . $pdf_data["restbpm"];
    } else {
        $restbpm = "€0";
    }
    $apkvervaldatum = timeFormatChange($pdf_data["vervaldatumapk"]);
    $wamverzekerd = $pdf_data["wamverzekerd"];
    $terugroepactie =  $pdf_data["terugroepactie"];
    $wielbasis = $pdf_data["wielbasis"];
    $massaledig = $pdf_data["massaledigvoertuig"];
    $massarijklaar = $pdf_data["massarijklaar"];
    $maximummassa = $pdf_data["toegestanemaximummassa"];
    $laadvermogen = $pdf_data["laadvermogen"];
    $maximumgewichtaanhangerongeremd = $pdf_data["maximumgewichtaanhangerongeremd"];
    $maximumgewichtaanhangergeremd = $pdf_data["maximumgewichtaanhangergeremd"];
    $variant = $pdf_data["variant"];
    $uitvoering2 = $pdf_data["uitvoering2"];
    $typegoedkeuringsnummer = $pdf_data["typegoedkeuringsnummer"];
    if(!empty($pdf_data["plaatschasisnummer"])){
        $plaatschassisnummer = $pdf_data["plaatschasisnummer"];
    } else {
        $plaatschassisnummer = "Niet bekend";
    }

    //meter 1
    $stadagenautovergelijkbaar = $pdf_data['stadagenautovergelijkbaar'];
    if($stadagenautovergelijkbaar < 90){
        $stadagenmeter = "positive";
        $stadagenkleur = "green-color";
    } elseif($stadagenautovergelijkbaar >= 90 && $stadagenautovergelijkbaar < 180){
        $stadagenmeter = "neutral";
        $stadagenkleur = "blue-color";
    } elseif($stadagenautovergelijkbaar >= 180){
        $stadagenmeter = "negative";
        $stadagenkleur = "red-color";
    }
    $autostekoop = $pdf_data['autostekoop'];
    if($autostekoop < 15){
        $autostekoopmeter = "positive";
        $autostekoopkleur = "green-color";
    } elseif($autostekoop >= 15 && $autostekoop < 30){
        $autostekoopmeter = "neutral";
        $autostekoopkleur = "blue-color";
    } elseif($autostekoop >= 30){
        $autostekoopmeter = "negative";
        $autostekoopkleur = "red-color";
    }
    $autosverkocht = $pdf_data['autosverkocht'];
    if($autosverkocht < 15){
        $autosverkochtmeter = "negative";
        $autosverkochtkleur = "red-color";
    } elseif($autosverkocht >= 15 && $autosverkocht < 30){
        $autosverkochtmeter = "neutral";
        $autosverkochtkleur = "blue-color";
    } elseif($autosverkocht >= 30){
        $autosverkochtmeter = "positive";
        $autosverkochtkleur = "green-color";
    }
    $verwachtestadagen = $pdf_data['verwachtestadagen'];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kentekenrapport - <?php echo $pdf_data["kenteken"]; ?></title>
    <style>
        <?php 
            include ("css/general.php");
            include ("css/text.php");
            include ("css/page.php");
        ?>
    </style>
</head>
<body>
<div id="page-1" class="front-page">
    <div class="front-page-header">
        <img class="front-page-logo" src="<?=$img_dir?>/logo-front-page.png" alt="Logo" />
    </div>
    <div class="front-page-hero">
        <img class="front-page-image" width="100%" src="<?=$img_dir?>/front-page-header.jpg" alt="Header" />
        <div class="front-page-report-title">
            <h1>Kenteken Rapport</h1>
            <p class="license-title"><?php echo $merk; ?> <?php echo $model; ?><br /><?php echo $kenteken; ?></p>
        </div>
    </div>
    <div class="front-page-footer"></div>
</div>
<div class="page-break"></div>
<div id="page-2" class="page default-page">
    <img class="spot-page-2-top" src="<?=$img_dir?>/spot-page-2-top.png" alt="" />
    <img class="spot-page-2-bottom" src="<?=$img_dir?>/spot-page-2-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h1 style="text-transform: uppercase;"><?php echo $merk; ?> <?php echo $model; ?></h1>
        <div class="col-container">
            <div class="col-2">
                <h3 style="margin-top: -5px;"><?php echo $kenteken; ?></h3>
                <p><strong>Deze <?php echo $merk; ?> <?php echo $model; ?> had toen hij van de band rolde een nieuwprijs vanaf €<?php echo $nieuwprijs; ?> en is <?php echo $importauto_intext; ?>. De auto is voor het eerst toegelaten op de weg op <?php echo $eerstetoelating; ?> en dit maakt de auto inmiddels <?php echo $jarenoud;?> jaar oud.</strong></p>
                <p><strong>De auto rijdt van 0 tot 100 km/u in <?php echo $snelheidnaar100km; ?> seconden en de topsnelheid van de auto is <?php echo $topsnelheid;?> km/u. Het maximum vermogen wat de auto heeft is <?php echo $vermogenPK;?> PK. De auto heeft een gecombineerd gebruik van 1 liter op de <?php echo $afstandperliter; ?> kilometer. Het zuinigheidslabel van de <?php echo $merk; ?> <?php echo $model; ?> is <?php echo $zuinigheidslabel;  ?> en hij heeft een CO2-uitstoot van <?php echo $co2uitstoot;?> gram per kilometer.</strong></p>
            </div>
            <div class="col-2">
                <p><img class="car-image" src="<?php echo $image; ?>"  width="100%" alt="Auto" /></p>
                <div class="license-plate">
                    <p><?php echo $kenteken; ?></p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <h3>ALGEMEEN</h3>
        <table class="car-options">
            <tr>
                <td class="label">Merk</td>
                <td class="value"><?php echo $merk; ?></td>
            </tr>
            <tr>
                <td class="label">Model</td>
                <td class="value"><?php echo $model;?> </td>
            </tr>
            <tr>
                <td class="label">Uitvoering</td>
                <td class="value"><?php echo $uitvoering;?></td>
            </tr>
            <tr>
                <td class="label">Kleur</td>
                <td class="value"><?php echo $kleur;?></td>
            </tr>
            <tr>
                <td class="label">Kilometerstand</td>
                <td class="value"><?php echo $tellerstand; ?></td>
            </tr>
            <tr>
                <td class="label">Carroserietype</td>
                <td class="value"><?php echo $carrosserie;?></td>
            </tr>
            <tr>
                <td class="label">Aandrijving</td>
                <td class="value"><?php echo $aandrijving;?></td>
            </tr>
            <tr>
                <td class="label">Transmissie</td>
                <td class="value"><?php echo $transmissie; ?></td>
            </tr>
            <tr>
                <td class="label">Versnellingen</td>
                <td class="value"><?php echo $versnellingen; ?></td>
            </tr>
            <tr>
                <td class="label">Voertuigcategorie</td>
                <td class="value"><?php echo $voertuigsoort; ?></td>
            </tr>
            <tr>
                <td class="label">Aantal zitplaatsen</td>
                <td class="value"><?php echo $zitplaatsen; ?></td>
            </tr>
            <tr>
                <td class="label">Datum eerste toelating</td>
                <td class="value"><?php echo $eerstetoelating; ?></td>
            </tr>
            <tr>
                <td class="label">Laatste tenaamstelling</td>
                <td class="value"><?php echo $laatsteTenaamstelling; ?></td>
            </tr>
            <tr>
                <td class="label">Nieuwprijs</td>
                <td class="value">€<?php echo $nieuwprijs; ?></td>
            </tr>
            <tr>
               <td class="label">Catalogusprijs</td>
                <td class="value"><?php echo $catalogusprijs; ?></td>
            </tr>
            <tr>
                <td class="label">Brandstof</td>
                <td class="value"><?php echo $brandstof; ?></td>
            </tr>
            <tr>
                <td class="label">Importauto</td>
                <td class="value"><?php echo $importauto; ?></td>
            </tr>
            <tr>
                <td class="label">Datum eerste afgifte Nederland</td>
                <td class="value"><?php echo $eerstetoelatingnationaal; ?></td>
            </tr>
            <tr>
                <td class="label">APK vervaldatum</td>
                <td class="value"><?php echo $vervaldatumapk; ?></td>
            </tr>
        </table>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>2</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div id="page-3" class="page default-page">
    <img class="spot-page-3-top" src="<?=$img_dir?>/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?=$img_dir?>/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
         <h3>PRESTATIES</h3>
        <table class="car-options">
            <tr>
                <td class="label">Vermogen</td>
                <td class="value"><?php echo $vermogenFormatted . $vermogen2Formatted; ?></td>
            </tr>
            <tr>
                <td class="label">0 - 100 km/h</td>
                <td class="value"><?php echo $snelheidnaar100km; ?> seconden</td>
            </tr>
            <tr>
                <td class="label">Topsnelheid</td>
                <td class="value"><?php echo $topsnelheid; ?> km/h</td>
            </tr>
            <tr>
                <td class="label">Aantal cilinders</td>
                <td class="value"><?php echo $cilinderaantal; ?></td>
            </tr>
            <tr>
                <td class="label">Cilinderinhoud</td>
                <td class="value"><?php echo $cilinderinhoud ."cc"; ?></td>
            </tr>
            <tr>
                <td class="label">Verbruik buiten bebouwde kom </td>
                <td class="value"><?php echo $verbruikbuiten; ?> </td>
            </tr>
            <tr>
                <td class="label">Verbruik binnen bebouwde kom </td>
                <td class="value"><?php echo $verbruikbinnen; ?> </td>
            </tr>
            <tr>
                <td class="label">Verbruik gecombineerd</td>
                <td class="value"><?php echo $verbruikgecombineerd; ?> </td>
            </tr>
            <tr>
                <td class="label">Co2 uitstoot</td>
                <td class="value"><?php if($co2uitstoot == "Niet bekend"){ echo $co2uitstoot; } else { echo $co2uitstoot . " g/km";}  ?> </td>
            </tr>
            <tr>
                <td class="label">Zuinigheidslabel </td>
                <td class="value"><?php echo $zuinigheidslabel; ?></td>
            </tr>
        </table>
        <h3>HISTORIE</h3>
        <table class="car-options">
            <tr>
                <td class="label">Import auto</td>
                <td class="value"><?php echo $importauto; ?></td>
            </tr>
            <tr>
                <td class="label">Aantal eigenaren</td>
                <td class="value"><?php echo $aantaleigenaren; ?></td>
            </tr>            
        </table>
        <img class="arrow" src="<?=$img_dir?>/arrow.png" alt="Pijl" />
        <p style="margin-top: -35px;"><i style="line-height: 18px;">* Hoeveel Nederlands geregistreerde eigenaren heeft de auto in het verleden gehad, gaat het om een tweede, derde of misschien wel vierdehands auto. Het aantal eigenaren geeft je hier meer inzicht in. Is de auto 100% Nederlands of gaat het om een import auto?</i></p>
        <h3>WOK (Wachten Op Keuring)</h3>
        <table class="car-options">
            <tr>
                <td class="label">Op dit moment een WOK-status?</td>
                <td class="value"><?php echo $wokstatus; ?></td>
            </tr>
            <?php /*
            <tr>
                <td class="label">Begin WOK-status</td>
                <td class="value"><?php echo $wokbegin; ?></td>
            </tr>
            */ ?>
        </table>
        <p>De status Wachten Op Keuring (WOK) wordt toegekend als een voertuig niet meer aan de permanente eisen voldoet. Dit komt voor bij lichte en zware schade aan het voertuig, maar bijvoorbeeld ook bij een uitlaat die te veel geluid maakt, bij ruitfolie die de zichtbaarheid te veel vermindert of bij opgevoerde bromfietsen.</p>
        <p>Verzekeraars, politie en de RDW kunnen een WOK-status toekennen. Het voertuig mag pas weer op de openbare weg komen als het door de RDW is goedgekeurd. De WOK-status wordt dan beëindigd, maar deze blijft altijd in de boeken staan.</p>
        <p>Waarschijnlijk zal dit zorgen voor een lagere restwaarde, twijfel over de auto en onzekerheid die niet meer zal verdwijnen. Zijn de veiligheidsissues op een goede manier opgelost? Zijn de reparaties door een ervaren bedrijf uitgevoerd? Allemaal vragen die moeilijk te beantwoorden zijn wanneer een auto een WOK-status heeft.</p> 
        <p><a class="button orange" href="<?php echo $url; ?>" target="_blank" title="Direct een bod op je voertuig ontvangen?">MELD JE AUTO GRATIS AAN</a></p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>3</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div id="page-3" class="page default-page">
    <img class="spot-page-3-top" src="<?=$img_dir?>/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?=$img_dir?>/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>BPM en rest-BPM</h3>
        <table class="car-options">
            <tr>
                <td class="label">Bruto BPM</td>
                <td class="value"><?php echo $brutobpm; ?></td>
            </tr>
            <tr>
                <td class="label">Rest-BPM</td>
                <td class="value"><?php echo $restbpm; ?></td>
            </tr>
        </table>
        <h4>BPM</h4>
        <p>BPM staat voor Belasting voor Personenauto’s en Motorrijwielen. Het gaat om een belasting op auto’s, motoren en bestelauto’s. Bij nieuwe auto’s zit de BPM verrekend in de catalogusprijs en deze wordt berekend aan de hand van de CO2 uitstoot van de auto.</p>        
        <h4>BPM bij nieuwe auto’s</h4>
        <p>Zoals beschreven zit de BPM bij nieuwe auto’s verrekend in de catalogusprijs. De hoogte van de BPM wordt berekend aan de hand van de CO2 uitstoot van de auto. Hoe hoger deze uitstoot, hoe hoger de BPM op de auto. Dit kan dus flink oplopen voor auto’s met veel uitstoot. Dat wordt vooral duidelijk als je de prijzen van auto’s vergelijkt met de prijzen in Duitsland of België, in deze landen hebben ze namelijk geen BPM.</p>
        <h4>BPM bij import auto’s</h4>
        <p>De BPM is een van de redenen waarom mensen een auto importeren. Op een gebruikte auto is slechts een gedeelte van de oorspronkelijke BPM van toepassing.</p>
        <h4>Rest-BPM</h4>
        <p>Het gedeelte BPM dat overblijft op import auto’s wordt ook wel rest-BPM genoemd. Er zijn verschillende manieren om de hoogte van de rest-BPM te berekenen. De consument mag zelf de meest gunstige berekening kiezen. Wanneer een auto met schade wordt geïmporteerd, dan is de rest-BPM - in vergelijking met dezelfde auto zonder schade - een stuk lager. (Dit feit wordt vooral gebruikt door louche auto-handelaren die schadeauto’s verkopen als 100% goede auto’s.)</p>
        <h4>Advies BPM</h4>
        <p>“Vergelijk de rest-BPM op de auto die je wilt kopen dus altijd even met de rest-BPM op eenzelfde soort auto, om zeker te zijn van jouw zaak. Wijkt het bruto BPM bedrag sterk af van de vergelijkende auto? Dan is de kans aanwezig dat de auto met schade geïmporteerd is.”</p>      
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>4</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div id="page-3" class="page default-page">
    <img class="spot-page-3-top" src="<?=$img_dir?>/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?=$img_dir?>/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>APK en terugroepacties</h3>
        <table class="car-options">
            <tr>
                <td class="label">APK vervaldatum</td>
                <td class="value"><?php echo $apkvervaldatum; ?></td>
            </tr>
            <tr>
                <td class="label">WAM verzekerd</td>
                <td class="value"><?php echo $wamverzekerd; ?></td>
            </tr>
            <tr>
                <td class="label">Openstaande terugroepactie</td>
                <td class="value"><?php echo $terugroepactie; ?></td>
            </tr>
        </table>
        <p>Fabrikanten kunnen voertuigen om verschillende redenen terugroepen. Het komt meestal door oorzaken als tekortkoming in veiligheidseisen van het voertuig en situaties waarbij de fabrikant sjoemelsoftware heeft gebruikt. Hier is het dieselschandaal van Volkswagen in 2015 een van de bekendste voorbeelden van. Als het probleem door de fabrikant is opgelost, is het feit dat een auto is teruggeroepen geen probleem.</p>
        <p>Hierboven wordt aangegeven of het voertuig een openstaande terugroepactie heeft. Indien dit ‘ja’ is dan zul je contact moeten opnemen met de leverancier om te ontdekken wat je moet doen.</p>
        <h3>Gewicht en overige informatie</h3>
        <table class="car-options">
            <tr>
                <td class="label">Wielbasis</td>
                <td class="value"><?php echo $wielbasis; ?> cm</td>
            </tr>
            <tr>
                <td class="label">Massa ledig voertuig</td>
                <td class="value"><?php echo $massaledig; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Massa rijklaar</td>
                <td class="value"><?php echo $massarijklaar; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Toegestane maximum massa voertuig</td>
                <td class="value"><?php echo $maximummassa; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Laadvermogen</td>
                <td class="value"><?php echo $laadvermogen; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Maximum gewicht aanhanger ongeremd</td>
                <td class="value"><?php echo $maximumgewichtaanhangerongeremd; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Maximum gewicht aanhanger geremd</td>
                <td class="value"><?php echo $maximumgewichtaanhangergeremd; ?> kg</td>
            </tr>
            <tr>
                <td class="label">Variant</td>
                <td class="value"><?php echo $variant; ?></td>
            </tr>
            <tr>
                <td class="label">Uitvoering</td>
                <td class="value"><?php echo $uitvoering2; ?></td>
            </tr>
            <tr>
                <td class="label">Type goedkeuringsnummer</td>
                <td class="value"><?php echo $typegoedkeuringsnummer; ?></td>
            </tr>
            <tr>
                <td class="label">Plaats chassisnummer</td>
                <td class="value"><?php echo $plaatschassisnummer; ?></td>
            </tr>
        </table>        
        <p><a class="button orange" href="<?php echo $url; ?>" target="_blank" title="Direct een bod op je voertuig ontvangen?">MELD JE AUTO GRATIS AAN</a></p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>5</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div id="page-4" class="page default-page">
    <img class="spot-page-4-bottom" src="<?=$img_dir?>/spot-page-4-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>DE GESCHATTE HUIDIGE INRUILWAARDE</h3>
        <div class="col-container" style="padding-top: 10px; padding-bottom: 20px;">
            <div class="col-2" style="text-align: center;">
                <p style="padding: 0 0 5px 0;"><strong>Re&euml;le<br />inruilwaarde:</strong></p>
                <div class="data-spot">    
                    <h2>&euro; <?php echo number_format($inruilwaarde,0,",","."); ?></h2>
                </div>
            </div>
            <div class="col-2" style="text-align: center;">
                <p style="padding: 0 0 5px 0;"><strong>Re&euml;le verkoopwaarde<br />door Autobedrijf:</strong></p>
                <div class="data-spot">                    
                    <h2>&euro; <?php echo number_format($verkoopwaarde,0,",","."); ?></h2>
                </div>
            </div>
             <div class="clear"></div>
        </div>
        <p><img src="<?=$img_dir?>/visual-inruilwaarde.jpg" width="100%" alt="Visual" /></p>
        <p>Bij de geschatte huidige inruilwaarde zijn er veel aspecten waar we rekening mee houden. Want wat zit er nu precies tussen de inkoop (inruilwaarde) en verkoopprijs van een auto voor een autobedrijf?</p>
        <p>Het aantal dagen dat er tussen de aankoop en de verkoop van de auto zit, zorgt voor een vermindering in de waarde. Hoe langer de auto (verwacht) bij de garage staat hoe minder een bedrijf aan de auto kan verdienen. Ook krijg je te maken met advertentiekosten, hoe weet een potentiële koper anders dat er auto’s te koop staan?</p>
        <p>Daarnaast maakt het autobedrijf kosten voor de rente en eventuele herstelkosten. Geeft het autobedrijf nog garantie op een tweedehands auto? Deze kosten spelen ook een rol bij de inschatting van de inruilwaarde.</p>
        <p>Zoals je kunt lezen is een auto nog niet zomaar verkocht, een auto verkopen kost ook geld. Al deze kosten en factoren samen zorgen ervoor dat we een reëel beeld kunnen geven van de geschatte huidige inruilwaarde van de auto.</p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>6</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
<div id="page-5" class="page default-page">
    <img class="spot-page-5-top" src="<?=$img_dir?>/spot-page-5-top.png" alt="" />
   <img class="spot-page-5-bottom" src="<?=$img_dir?>/spot-page-5-bottom.png" alt="" /> 
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>VERWACHT AANTAL DAGEN TOT VERKOOP</h3>
        <div class="sales-expectation">
            <table>
                <tr>
                    <td>Jouw auto wordt gemiddeld binnen</td>
                    <td><strong style="display: inline-block; margin-left: 5px; margin-right: 5px; position: relative;"><?=$verwachtestadagen?></strong></td>
                    <td>dagen verkocht</td>
                </tr>
            </table>
        </div>
        <div id="dashboard-summary" class="col-container">
            <div class="col-3">
                <p class="dashboard-img"><img src="<?=$img_dir?>/dashboard-<?php echo $stadagenmeter; ?>.png" width="100%" alt="Dashboard" /></p>
                <p class="value <?php echo $stadagenkleur; ?>"><?php echo $stadagenautovergelijkbaar; ?></p>
                <p class="text">Gemiddeld aantal dagen dat vergelijkbare auto's te koop staan</p>
                <div class="blue-text-block">
                    <p>Staat een auto korter bij het autobedrijf, dan is dit voordelig voor de inruilwaarde van de auto. Een auto hoeft niet lang bij het autobedrijf te staan en de waarde van de auto zakt dus niet veel terug. Hoe lager het gemiddeld aantal dagen, hoe gunstiger dat voor jou is als verkoper.</p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?=$img_dir?>/dashboard-<?php echo $autostekoopmeter; ?>.png" width="100%" alt="Dashboard" /></p>
                <p class="value <?php echo $autostekoopkleur; ?>"><?php echo $autostekoop; ?></p>
                <p class="text">Vergelijkbare auto’s nu te koop bij autobedrijven</p>
                <div class="blue-text-block">
                    <p>Staan er niet veel vergelijkbare auto’s te koop? Dat is positief voor de inruilwaarde. Heb je de keuze uit veel verschillende vergelijkbare auto’s, dan is er veel concurrentie. Is jouw auto unieker, dan zal de waarde ongetwijfeld hoger liggen.<br />&nbsp;<br />&nbsp;<br /></p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?=$img_dir?>/dashboard-<?php echo $autosverkochtmeter; ?>.png" width="100%" alt="Dashboard" /></p>
                <p class="value <?php echo $autosverkochtkleur; ?>"><?php echo $autosverkocht; ?></p>
                <p class="text">Vergelijkbare auto’s verkocht door autobedrijven</p>
                <div class="blue-text-block">
                    <p>Zijn er in de afgelopen 45 dagen veel vergelijkbare auto’s verkocht? Dat is een indicatie dat het een populaire auto is. Hoe hoger dit getal, hoe gunstiger het is voor de inruilwaarde van de auto die je aanbiedt.<br />&nbsp;<br />&nbsp;<br />&nbsp;<br /></p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <h3>Korte uitleg</h3>
        <p>Zoals bij vrijwel alle producten die verkocht worden, komt de prijs tot stand door vraag en aanbod. Bij auto’s op de tweedehands markt gaat dit principe ook op. Stel je voor, er staan 200 auto’s te koop die vergelijkbaar zijn met die van jou. In de afgelopen 45 dagen zijn er dagelijks 4 auto’s verkocht. Dan is de courantheid of gangbaarheid van de auto 50 (200 / 4 = 50), verwachting is dat het ongeveer 50 dagen zal duren voordat jouw auto weer opnieuw is verkocht. Een dealer zal rekening houden met dit gegeven om tot een reële verkoopwaarde en inruilwaarde te komen voor de auto.</p>
        <p><a class="button orange" href="<?php echo $url; ?>" target="_blank" title="Direct een bod op je voertuig ontvangen?">MELD JE AUTO GRATIS AAN</a></p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>7</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>

<?php

    // Floats forceren
    $afschrijvingenrente = floatval( $afschrijvingenrente );
    $reparatieenonderhoud = floatval( $reparatieenonderhoud );
    $verzekering = floatval( $verzekering );
    $banden = floatval( $banden );
    $mrb = floatval( $mrb );
    $brandstoftco = floatval( $brandstoftco );

?>

<div id="page-3" class="page default-page">
    <img class="spot-page-3-top" src="<?=$img_dir?>/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?=$img_dir?>/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>Total Cost of Ownership (TCO)</h3>
        <table class="car-options">
            <tr>
                <td class="label">Afschrijving en rente</td>
                <td class="value"><?php if(!empty($afschrijvingenrente) && $afschrijvingenrente > 0){ echo "€" . number_format($afschrijvingenrente,2,",","."); } else { echo "Niet bekend"; } ?></td>
            </tr>
            <tr>
                <td class="label">Onderhoud en reparatie</td>
                <td class="value"><?php if(!empty($reparatieenonderhoud) && $reparatieenonderhoud > 0){ echo "€" . number_format($reparatieenonderhoud,2,",","."); } else { echo "Niet bekend"; } ?></td>
            </tr>
            <tr>
                <td class="label">Verzekeringskosten</td>
                <td class="value"><?php if(!empty($verzekering) && $verzekering > 0){ echo "€" . number_format($verzekering,2,",","."); } else { echo "Niet bekend"; } ?></td>
            </tr>
            <tr>
                <td class="label">Banden</td>
                <td class="value"><?php if(!empty($banden) && $banden > 0){ echo "€" . number_format($banden,2,",","."); } else { echo "Niet bekend"; } ?></td>
            </tr>
            <tr>
                <td class="label">Motorrijtuigenbelasting (MRB)</td>
                <td class="value"><?php if(!empty($mrb) && $mrb > 0){ echo "€" . number_format($mrb,2,",",".");  } else { echo "Niet bekend"; } ?></td>
            </tr>
            <tr>
                <td class="label">Brandstof</td>
                <td class="value"><?php if(!empty($brandstoftco) && $brandstoftco > 0){ echo "€" . number_format($brandstoftco,2,",","."); } else { echo "Niet bekend"; } ?></td>
            </tr>
        </table>
        <h4>Total Cost of Ownership (TCO)</h4>
        <p>Het bezitten van een auto kan soms voor een onoverzichtelijke kostenpost zorgen. Wat geef je allemaal uit aan jouw auto? Met deze handige Total Cost of Ownership berekening (TCO) kom je snel achter de totale kosten, die jij maandelijks uitgeeft aan jouw auto om hem te bezitten én te gebruiken – van afschrijving tot aan brandstofkosten. Lees hieronder een korte uitleg over alle kosten die onderdeel zijn van onze berekening.</p>        
        <h4>Afschrijving en rente</h4>
        <p>Met afschrijving wordt de maandelijkse waardevermindering van jouw auto bedoeld. De afschrijving wordt berekend door te kijken naar de aanschafwaarde, minus de restwaarde en te delen door het aantal gebruiksjaren.<br/>Rente is daarbij alleen van toepassing als je jouw auto zakelijk of privé gefinancierd hebt. Voor het geleende bedrag betaal je per maand rente.</p>
        <h4>Onderhoud en reparatie</h4>
        <p>Dit zijn alle kosten die je per maand kwijt bent voor onderhoud en reparaties aan jouw huidige auto. Onderhoudskosten zijn preventief en plan je in wanneer jou dat uitkomt, waarbij reparatiekosten helaas niet te voorzien zijn. </p>
        <h4>Verzekeringskosten</h4>
        <p>Zonder verzekering mag je in Nederland niet met jouw auto de weg op. Voor een autoverzekering betaal je per maand een premie. De hoogte van de premie wordt o.a. bepaald door kenmerken van de auto, de gekozen dekking en het aantal gereden kilometers per jaar. </p>
        <h4>Banden</h4>
        <p>Om veilig gebruik te kunnen maken van jouw auto moet hij voorzien zijn van een goede set banden. Afhankelijk van het aantal kilometers dat je rijdt, moeten banden op ten duur een aantal keren vervangen worden.</p>      
        <h4>Motorrijtuigenbelasting (MRB)</h4>
        <p>Voor jouw auto betaal je ook motorrijtuigenbelasting (MRB), ook wel wegenbelasting genoemd. Motorrijtuigenbelasting betaal je standaard per drie maanden. Ook kun je ervoor kiezen om, door middel van een automatische incasso, per maand te betalen. De hoogte van het bedrag wordt bepaalt door het gewicht en het type brandstof van jouw auto.</p>
        <h4>Brandstof</h4>
        <p>Tot slot functioneert een auto niet zonder brandstof. Met brandstof bedoelen we de kosten die gemaakt moeten worden om jouw voertuig te voorzien van benzine, diesel of stroom.</p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>8</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>

<div id="page-6" class="page default-page">
    <img class="spot-page-6-top" src="<?=$img_dir?>/spot-page-6-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?=$img_dir?>/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?=$img_dir?>/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">

        <div class="col-container" style="padding-top: 10px;">

        <!--
            <div class="col-2">
                <p><a class="button blue" href="https://www.wijverkopenuwautowel.nl/?utm_source=CMK&utm_medium=referral&utm_campaign=rapport" target="_blank" title="Direct contact met 1 van onze specialisten">DIRECT CONTACT MET 1 VAN ONZE SPECIALISTEN</a></p>
            </div>
        -->
        <h3>Over checkmijnkenteken.nl</h3>
        <p>Het team van Checkmijnkenteken.nl is jong, ambitieus, betrouwbaar en eigenzinnig met een hands-on mentaliteit. Focus op klanten is de rode draad in ons bedrijf en we doen er dan ook alles aan om van elke klantervaring een topervaring te maken.</p>
        <p>Bij Checkmijnkenteken.nl krijg jij exclusieve data, die normaal alleen voor professionals  beschikbaar is. De data in het rapport wordt onder andere rechtstreeks uit de database van de RDW gehaald. Informatie in het kentekenrapport biedt jou handvatten voor de huidige status en waarde van jouw auto ten opzichte van de markt.</p>
        <p>Deze informatie is waardevol als jij bijvoorbeeld jouw auto wilt verkopen. De informatie uit het rapport wordt namelijk ook door de opkopende autodealer gebruikt.</p>
        <p>Wil je jouw auto verkopen? Checkmijnkenteken.nl tipt je graag over <a href="https://wijverkopenuwautowel.nl">Wijverkopenuwautowel.nl</a>. Net als Checkmijnkenteken.nl een jong en ambitieus bedrijf. Online je auto verkopen was nog nooit zo gemakkelijk. </p>
        <p>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/tick.jpg"/> Een eerlijke prijs voor je auto <br/>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/tick.jpg"/> Ontzorging van A tot Z <br/>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/tick.jpg"/> Ervaren autoverkoopspecialisten <br/>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/tick.jpg"/> Kosteloos en vrijblijvend <br/>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/cross.jpg"/> Geen autoveiling <br/>
            <img style="height:12px; margin-right:5px;" src="<?=$img_dir?>/cross.jpg"/> Geen vreemden aan je deur <br/>
        </p>
        <p><a class="button orange" href="<?php echo $url; ?>" target="_blank" title="Direct een bod op je voertuig ontvangen? Meld je auto gratis aan!">MELD JE AUTO GRATIS AAN</a></p>
        </div>

    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>9</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport Checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>