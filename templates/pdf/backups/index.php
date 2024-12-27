<?php
include ("../config.php");
include ("../functions.php");
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 14-4-2020
 * Time: 12:06
 */

if(!empty($_GET)){
    //define variables;
    $kenteken = $_GET["kenteken"];
    $merk = ucfirst(strtolower($_GET["merk"]));
    $model = ucfirst(strtolower($_GET["model"]));
    $uitvoering = ucfirst($_GET["uitvoering"]);
    $voertuigsoort = ucfirst($_GET["voertuigsoort"]);
    $kleur = ucfirst(strtolower($_GET["kleur"]));
    $bouwjaar = $_GET["bouwjaar"];
    $nieuwprijs = number_format($_GET["nieuwprijs"],2,",",".");
    if(!empty($_GET["catalogusprijs"])){
        $catalogusprijs = "€". number_format($_GET["catalogusprijs"],2,",",".");
    } else {
            $catalogusprijs = "Niet bekend";
    }

    $deuren = $_GET["deuren"];
    $zitplaatsen = $_GET["zitplaatsen"];
    $vermogen = $_GET["vermogen"];
    $aandrijving = ucfirst($_GET["aandrijving"]);
    //vermogen formatted: 100 KW / 136 PK
    $vermogenFormatted = "$vermogen KW / " . number_format($vermogen * 1.362, 0) . " PK";
    $vermogenPK = number_format($_GET["vermogen"] * 1.362, 0);
    $vermogenKW = $_GET["vermogen"];
    $vermogen2KW = $_GET["vermogen2"];
    if($vermogen2KW != 0){
        $vermogen2Formatted = " + $vermogen2KW KW / " . number_format($vermogen2KW * 1.362, 0) . " PK";
    } else {
        $vermogen2Formatted = ""; 
    }
    $snelheidnaar100km = str_replace(".", ",", $_GET["snelheidnaar100km"]);
    $topsnelheid = $_GET["topsnelheid"];
    $brandstof = ucfirst($_GET["brandstof"]);
    $vervaldatumapk = timeFormatChange($_GET["vervaldatumapk"]);
    $maxtrekgewicht = $_GET["maxtrekgewicht"];
    $transmissie = ucfirst($_GET["transmissie"]);
    $versnellingen = $_GET["versnellingen"];
    $aantaleigenaren = $_GET["aantaleigenaren"];
    $importauto = $_GET["importauto"];
    if($importauto == "Ja"){
        $importauto_intext = "een import auto";
    } elseif ($importauto == "Nee") {
        $importauto_intext = "geen import auto";
    }
    $eerstetoelating = timeFormatChange($_GET["eerstetoelating"]);
    $eerstetoelatingDateObject = date_create_from_format ("d-m-Y", $eerstetoelating);

    $datetimeStart = new DateTime(substr($_GET["eerstetoelating"], 0,-4) ."-".substr($_GET["eerstetoelating"], -4, 2)."-".substr($_GET["eerstetoelating"], -2));
    $datetimeNow = new DateTime('NOW');
    $timediff = $datetimeStart->diff($datetimeNow);
    $jarenoud = $timediff->y;
    $restbpm = $_GET["restbpm"];
    $inruilwaarde = $_GET["inruilwaarde"];
    if($inruilwaarde < 250){
        $inruilwaarde = 250;
    }
    $verkoopwaarde = $_GET["verkoopwaarde"];
    if($verkoopwaarde < 500){
        $verkoopwaarde = 500;
    }
    $dagentekoop = $_GET["dagentekoop"];
    $autosnutekoop = $_GET["autosnutekoop"];
    $autosverkocht = $_GET["autosverkocht"];
    $image = $_GET["image"];
    $carrosserie = ucfirst($_GET["carrosserie"]);
    $eerstetoelatingnationaal = timeFormatChange($_GET["eerstetoelatingnationaal"]);
    $eerstetoelatinintergnationaal = timeFormatChange($_GET["eerstetoelatinginternationaal"]);
    $laatsteTenaamstelling = timeFormatChange($_GET["laatstetenaamstelling"]);

    if(!empty($_GET["cilinderinhoud"])){
        $cilinderinhoud = $_GET["cilinderinhoud"];    
    } else {
        $cilinderinhoud = "Niet bekend";
    }

    if(!empty($_GET["cilinderaantal"])){
        $cilinderaantal = $_GET["cilinderaantal"];    
    } else {
        $cilinderaantal = "Niet bekend";
    }
    if(!empty($_GET["zuinigheidslabel"])){
        $zuinigheidslabel = $_GET["zuinigheidslabel"];    
    } else {
        $zuinigheidslabel = "Niet bekend";
    }

    if(!empty($_GET["verbruikgecombineerd"])){
        $verbruikgecombineerd = $_GET["verbruikgecombineerd"];
        $afstandperliter = number_format(100 / $verbruikgecombineerd,1) . " l/100km";
    } else {
        $verbruikgecombineerd = "Niet bekend";
        $afstandperliter = "Niet bekend";
    }
    if(!empty($_GET["verbruikbinnen"])){
        $verbruikbinnen = $_GET["verbruikbinnen"] . " l/100km";
    } else {
        $verbruikbinnen = "Niet bekend";
    }
    if(!empty($_GET["verbruikbuiten"])){
        $verbruikbuiten = $_GET["verbruikbuiten"] . " l/100km";
    } else {
        $verbruikbuiten = "Niet bekend";
    }

    if(!empty($_GET["co2uitstoot"])){
        $co2uitstoot = $_GET["co2uitstoot"]; 
    } else {
        $co2uitstoot = "Niet bekend";
    }


    if($_GET["wokstatus"] == 0){
        $wokstatus = "Nee";    
        // $wokbegin = "Niet van toepassing";
        // $wokeind = "Niet van toepassing";
    } elseif($_GET["wokstatus"] == 1){
        $wokstatus = "Ja";   
        // $wokbegin = timeFormatChange($_GET["wokbegin"]);
        // $wokeind = timeFormatChange($_GET["wokeind"]);
    }

    $brutobpm =  "€" . $_GET["brutobpm"];
    $restbpm = "€" . $_GET["restbpm"];
    $apkvervaldatum = timeFormatChange($_GET["vervaldatumapk"]);
    $wamverzekerd = $_GET["wamverzekerd"];
    $terugroepactie =  $_GET["terugroepactie"];
    $wielbasis = $_GET["wielbasis"];
    $massaledig = $_GET["massaledigvoertuig"];
    $massarijklaar = $_GET["massarijklaar"];
    $maximummassa = $_GET["toegestanemaximummassa"];
    $laadvermogen = $_GET["laadvermogen"];
    $maximumgewichtaanhangerongeremd = $_GET["maximumgewichtaanhangerongeremd"];
    $maximumgewichtaanhangergeremd = $_GET["maximumgewichtaanhangergeremd"];
    $variant = $_GET["variant"];
    $uitvoering2 = $_GET["uitvoering2"];
    $typegoedkeuringsnummer = $_GET["typegoedkeuringsnummer"];
    if(!empty($_GET["plaatschasisnummer"])){
        $plaatschassisnummer = $_GET["plaatschasisnummer"];
    } else {
        $plaatschassisnummer = "Niet bekend";
    }

    //meter 1
    $stadagenautovergelijkbaar = $_GET['stadagenautovergelijkbaar'];
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
    $autostekoop = $_GET['autostekoop'];
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
    $autosverkocht = $_GET['autosverkocht'];
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
    $verwachtestadagen = $_GET['verwachtestadagen'];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kentekenrapport - <?php echo $_GET["kenteken"]; ?></title>
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
        <img class="front-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-front-page.png" alt="Logo" />
    </div>
    <div class="front-page-hero">
        <img class="front-page-image" width="100%" src="<?php echo $pdfUrl; ?>/images/front-page-header.jpg" alt="Header" />
        <div class="front-page-report-title">
            <h1>Kenteken Rapport</h1>
            <p class="license-title"><?php echo $merk; ?> <?php echo $model; ?><br /><?php echo $kenteken; ?></p>
        </div>
    </div>
    <div class="front-page-footer"></div>
</div>
<div class="page-break"></div>
<div id="page-2" class="page default-page">
    <img class="spot-page-2-top" src="<?php echo $pdfUrl; ?>/images/spot-page-2-top.png" alt="" />
    <img class="spot-page-2-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-2-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
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
    <img class="spot-page-3-top" src="<?php echo $pdfUrl; ?>/images/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
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
                <td class="value"><?php echo $cilinderinhoud; ?>cc</td>
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
        <img class="arrow" src="<?php echo $pdfUrl; ?>/images/arrow.png" alt="Pijl" />
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
    <img class="spot-page-3-top" src="<?php echo $pdfUrl; ?>/images/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
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
    <img class="spot-page-3-top" src="<?php echo $pdfUrl; ?>/images/spot-page-3-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
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
    <img class="spot-page-4-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-4-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
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
        <p><img src="<?php echo $pdfUrl; ?>/images/visual-inruilwaarde.jpg" width="100%" alt="Visual" /></p>
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
    <img class="spot-page-5-top" src="<?php echo $pdfUrl; ?>/images/spot-page-5-top.png" alt="" />
   <img class="spot-page-5-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-5-bottom.png" alt="" /> 
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">
        <h3>VERWACHT AANTAL DAGEN TOT VERKOOP</h3>
        <div class="sales-expectation">
            <table>
                <tr>
                    <td>Jouw auto wordt gemiddeld binnen</td>
                    <td><strong style="display: inline-block; margin-left: 5px; margin-right: 5px; position: relative;"><?php echo round($verwachtestadagen); ?></strong></td>
                    <td>dagen verkocht</td>
                </tr>
            </table>
        </div>
        <div id="dashboard-summary" class="col-container">
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-<?php echo $stadagenmeter; ?>.png" width="100%" alt="Dashboard" /></p>
                <p class="value <?php echo $stadagenkleur; ?>"><?php echo $stadagenautovergelijkbaar; ?></p>
                <p class="text">Gemiddeld aantal dagen dat vergelijkbare auto's te koop staan</p>
                <div class="blue-text-block">
                    <p>Staat een auto korter bij het autobedrijf, dan is dit voordelig voor de inruilwaarde van de auto. Een auto hoeft niet lang bij het autobedrijf te staan en de waarde van de auto zakt dus niet veel terug. Hoe lager het gemiddeld aantal dagen, hoe gunstiger dat voor jou is als verkoper.</p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-<?php echo $autostekoopmeter; ?>.png" width="100%" alt="Dashboard" /></p>
                <p class="value <?php echo $autostekoopkleur; ?>"><?php echo $autostekoop; ?></p>
                <p class="text">Vergelijkbare auto’s nu te koop bij autobedrijven</p>
                <div class="blue-text-block">
                    <p>Staan er niet veel vergelijkbare auto’s te koop? Dat is positief voor de inruilwaarde. Heb je de keuze uit veel verschillende vergelijkbare auto’s, dan is er veel concurrentie. Is jouw auto unieker, dan zal de waarde ongetwijfeld hoger liggen.<br />&nbsp;<br />&nbsp;<br /></p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-<?php echo $autosverkochtmeter; ?>.png" width="100%" alt="Dashboard" /></p>
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
<div id="page-6" class="page default-page">
    <img class="spot-page-6-top" src="<?php echo $pdfUrl; ?>/images/spot-page-6-top.png" alt="" />
    <img class="spot-page-3-bottom" src="<?php echo $pdfUrl; ?>/images/spot-page-3-bottom.png" alt="" />
    <div class="default-page-header">
        <img class="default-page-logo" src="<?php echo $pdfUrl; ?>/images/logo-default-page.png" alt="Logo" />
    </div>
    <div class="default-page-content">

        <div class="col-container" style="padding-top: 10px;">

        <!--
            <div class="col-2">
                <p><a class="button blue" href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" target="_blank" title="Direct contact met 1 van onze specialisten">DIRECT CONTACT MET 1 VAN ONZE SPECIALISTEN</a></p>
            </div>
        -->
        <h3>Over checkmijnkenteken.nl</h3>
        <p>Het team van Checkmijnkenteken.nl is jong, ambitieus, betrouwbaar en eigenzinnig met een hands-on mentaliteit. Focus op klanten is de rode draad in ons bedrijf en we doen er dan ook alles aan om van elke klantervaring een topervaring te maken.</p>
        <p>Bij Checkmijnkenteken.nl krijg jij exclusieve data, die normaal alleen voor professionals  beschikbaar is. De data in het rapport wordt onder andere rechtstreeks uit de database van de RDW gehaald. Informatie in het kentekenrapport biedt jou handvatten voor de huidige status en waarde van jouw auto ten opzichte van de markt.</p>
        <p>Deze informatie is waardevol als jij bijvoorbeeld jouw auto wilt verkopen. De informatie uit het rapport wordt namelijk ook door de opkopende autodealer gebruikt.</p>
        <p>Wil je jouw auto verkopen? Checkmijnkenteken.nl tipt je graag over <a href="https://wijverkopenuwautowel.nl">Wijverkopenuwautowel.nl</a>. Net als Checkmijnkenteken.nl een jong en ambitieus bedrijf. Online je auto verkopen was nog nooit zo gemakkelijk. </p>
        <p>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/tick.jpg"/> Een eerlijke prijs voor je auto <br/>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/tick.jpg"/> Ontzorging van A tot Z <br/>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/tick.jpg"/> Ervaren autoverkoopspecialisten <br/>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/tick.jpg"/> Kosteloos en vrijblijvend <br/>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/cross.jpg"/> Geen autoveiling <br/>
            <img style="height:12px; margin-right:5px;" src="<?php echo $pdfUrl; ?>/images/cross.jpg"/> Geen vreemden aan je deur <br/>
        </p>
        <p><a class="button orange" href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" target="_blank" title="Direct een bod op je voertuig ontvangen?">MELD JE AUTO GRATIS AAN</a></p>
        </div>

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
</body>
</html>