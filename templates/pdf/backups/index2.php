<?php
include ("../config.php");
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 14-4-2020
 * Time: 12:06
 */
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kentekenrapport - [GZ-484-T]</title>
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
            <p class="license-title">[Mercedes-benz] [C-klasse]<br />[GZ-484-T]</p>
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
        <h1 style="text-transform: uppercase;">[merk] [model]</h1>
        <div class="col-container">
            <div class="col-2">
                <h3 style="margin-top: -5px;">[kenteken]</h3>
                <p><strong>Deze [Mercedes-benz] [C-klasse] had toen hij van de band rolde een nieuwprijs vanaf €[nieuwprijs] en is [geen import auto]. De auto is voor het eerst toegelaten op de weg op [1 januari 2019] en dit maakt de auto inmiddels [1 jaar] oud.</strong></p>
                <p><strong>De auto rijdt van 0 tot 100 km/u in [5,5] seconden en de topsnelheid van de auto is [200] km/u. Het maximum vermogen wat de auto heeft is [180 PK]. De auto heeft een gecombineerd gebruik van [1 liter op de 60] kilometer. Het zuinigheidslabel van de [merk] [model] is [A] en hij heeft een CO2-uitstoot van [10 gram] per kilometer.</strong></p>
            </div>
            <div class="col-2">
                <p><img class="car-image" src="<?php echo $pdfUrl; ?>/images/image-car.jpg"  width="100%" alt="Auto" /></p>
                <div class="license-plate">
                    <p>[GZ-484-T]</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <h3>ALGEMEEN</h3>
        <table class="car-options">
            <tr>
                <td class="label">Merk</td>
                <td class="value">[Mercedes-benz]</td>
            </tr>
            <tr>
                <td class="label">Model</td>
                <td class="value">[C-klasse] [350 e Estate Lease Edition]</td>
            </tr>
            <tr>
                <td class="label">Uitvoering</td>
                <td class="value">[uitvoering]</td>
            </tr>
            <tr>
                <td class="label">Kleur</td>
                <td class="value">[Grijs]</td>
            </tr>
            <tr>
                <td class="label">Carroserietype</td>
                <td class="value">[Stationcar]</td>
            </tr>
            <tr>
                <td class="label">Aandrijving</td>
                <td class="value">[Achterwiel]</td>
            </tr>
            <tr>
                <td class="label">Transmissie</td>
                <td class="value">[Seqentiële Automaat]</td>
            </tr>
            <tr>
                <td class="label">Versnellingen</td>
                <td class="value">[7]</td>
            </tr>
            <tr>
                <td class="label">Voertuigcategorie</td>
                <td class="value">[Personenauto]</td>
            </tr>
            <tr>
                <td class="label">Aantal zitplaatsen</td>
                <td class="value">[5]</td>
            </tr>
            <tr>
                <td class="label">Datum eerste toelating</td>
                <td class="value">[30-09-2015]</td>
            </tr>
            <tr>
                <td class="label">Laatste tenaamstelling</td>
                <td class="value">[30-09-2015]</td>
            </tr>
            <tr>
                <td class="label">Nieuwprijs</td>
                <td class="value">[€51.995]</td>
            </tr>
            <tr>
               <td class="label">Catalogusprijs</td>
                <td class="value">[€62.572]</td>
            </tr>
            <tr>
                <td class="label">Brandstof</td>
                <td class="value">[hybride (benzine) - plugin]</td>
            </tr>
            <tr>
                <td class="label">Importauto</td>
                <td class="value">[nee]</td>
            </tr>
            <tr>
                <td class="label">Datum eerste afgifte Nederland</td>
                <td class="value">[2009-02-20]</td>
            </tr>
            <tr>
                <td class="label">APK vervaldatum</td>
                <td class="value">[2021-06-24]</td>
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
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
                <td class="value">[155kw / 211PK]</td>
            </tr>
            <tr>
                <td class="label">0- 100 km/h</td>
                <td class="value">[6,2 seconden]</td>
            </tr>
            <tr>
                <td class="label">Topsnelheid</td>
                <td class="value">[246 km/h]</td>
            </tr>
            <tr>
                <td class="label">Aantal cilinders</td>
                <td class="value">[4K]</td>
            </tr>
            <tr>
                <td class="label">Cilinderinhoud</td>
                <td class="value">[1991cc]</td>
            </tr>
            <tr>
                <td class="label">Verbruik buiten bebouwde kom </td>
                <td class="value">[5.1 l/100km]</td>
            </tr>
            <tr>
                <td class="label">Verbruik binnen bebouwde kom </td>
                <td class="value">[8.2 l/100km]</td>
            </tr>
            <tr>
                <td class="label">Verbruik gecombineerd</td>
                <td class="value">[6.2 l/100km]</td>
            </tr>
            <tr>
                <td class="label">Co2 uitstoot</td>
                <td class="value">[144 g/km]</td>
            </tr>
            <tr>
                <td class="label">Zuinigheidslabel </td>
                <td class="value">[A]</td>
            </tr>
        </table>
        <h3>HISTORIE</h3>
        <table class="car-options">
            <tr>
                <td class="label">Import auto</td>
                <td class="value">[Nee]</td>
            </tr>
            <tr>
                <td class="label">Aantal eigenaren</td>
                <td class="value">[2]</td>
            </tr>            
        </table>
        <img class="arrow" src="<?php echo $pdfUrl; ?>/images/arrow.png" alt="Pijl" />
        <p style="margin-top: -35px;"><i style="line-height: 18px;">* Hoeveel eigenaren heeft de auto in het verleden gehad, gaat het om een tweede, derde of misschien wel vierdehands auto. Het aantal eigenaren geeft je hier meer inzicht in. Is de auto 100% Nederlands of gaat het om een import auto?</i></p>
        <h3>WOK (Wachten op keuring)</h3>
        <table class="car-options">
            <tr>
                <td class="label">WOK status gehad in verleden?</td>
                <td class="value">[nee]</td>
            </tr>
            <tr>
                <td class="label">Begin WOK status</td>
                <td class="value">[dd-mm-yyyy]</td>
            </tr>
            <tr>
                <td class="label">Einde WOK status</td>
                <td class="value">[dd-mm-yyyy]</td>
            </tr>
        </table>
        <p>Wachten op keuring is een status die een auto kan krijgen. Deze melding kan door de politie, het RDW of door een schade expert worden afgegeven op een kenteken. Dit gebeurt alleen als een auto dusdanige schades heeft of dat de auto op de een andere manier niet meer aan de veiligheidseisen voldoet om op de openbare weg te mogen rijden.</p>
        <p>Wordt de auto gerepareerd en worden de veiligheidsissues opgelost? Dan kan de WOK melding beëindigd worden maar deze blijft altijd in de boeken staan. Waarschijnlijk zal dit zorgen voor een lagere restwaarde, twijfel over de auto en onzekerheid die niet meer zal verdwijnen. Zijn de veiligheidsissues op een goede manier opgelost? Zijn de reparaties door een ervaren bedrijf uitgevoerd? Allemaal vragen die moeilijk te beantwoorden zijn wanneer een auto een WOK status heeft (gehad).</p>        
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>3</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
        <h3>BPM en rest BPM</h3>
        <table class="car-options">
            <tr>
                <td class="label">Bruto BPM</td>
                <td class="value">[€469]</td>
            </tr>
            <tr>
                <td class="label">Rest BPM</td>
                <td class="value">[€128]</td>
            </tr>
        </table>
        <p>BPM staat voor Belasting voor Personenauto’s en Motorrijwielen. Het gaat om een belasting op auto’s, motoren en bestelauto’s. Bij nieuwe auto’s zit de BPM verrekend in de catalogusprijs en deze wordt berekend aan de hand van de CO2 uitstoot van de auto.</p>        
        <h4>BPM bij nieuwe auto’s</h4>
        <p>Zoals beschreven zit de BPM bij nieuwe auto’s verrekend in de catalogusprijs. De hoogte van de BPM wordt berekend aan de hand van de CO2 uitstoot van de auto. Hoe hoger deze uitstoot, hoe hoger de BPM op de auto. Dit kan dus flink oplopen voor auto’s met veel uitstoot. Dat wordt vooral duidelijk als je de prijzen van auto’s vergelijkt met de prijzen in Duitsland of België, in deze landen hebben ze namelijk geen BPM.</p>
        <h4>BPM bij import auto’s</h4>
        <p>De BPM is een van de redenen waarom mensen een auto importeren. Op een gebruikte auto is slechts een gedeelte van de oorspronkelijke BPM van toepassing.</p>
        <h4>Rest-BPM</h4>
        <p>Het gedeelte BPM wat overblijft op import auto’s wordt ook wel rest-BPM genoemd. Er zijn verschillende manieren om de hoogte van de rest-BPM te berekenen. De consument mag zelf de meest gunstige berekening kiezen. Wanneer een auto met schade wordt geïmporteerd, dan is de rest BPM - in vergelijking met dezelfde auto zonder schade - een stuk lager. (Dit feit wordt vooral gebruikt door louche auto-handelaren die schadeauto’s verkopen als 100% goede auto’s.)</p>
        <h3>Advies</h3>
        <p>“Vergelijk de rest BPM op de auto die je wilt kopen dus altijd even met de rest BPM op eenzelfde auto, om zeker te zijn van jouw zaak.”</p>      
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>4</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
                <td class="value">[20-02-2021]</td>
            </tr>
            <tr>
                <td class="label">WAM verzekerd</td>
                <td class="value">[ja]</td>
            </tr>
            <tr>
                <td class="label">Openstaande terugroepactie</td>
                <td class="value">[nee]</td>
            </tr>
        </table>
        <p>Fabrikanten kunnen voertuigen om verschillende redenen terugroepen. Het komt meestal door oorzaken als tekortkoming in veiligheidseisen van het voertuig en situaties waarbij de fabrikant sjoemelsoftware heeft gebruik. Hier is het dieselschandaal van Volkswagen in 2015 een van de bekendste voorbeelden is. Als het probleem door de fabrikant is opgelost, is het feit dat een auto is teruggeroepen geen probleem. Hieronder wordt aangegeven of het voertuig is teruggeroepen en of het gerelateerde probleem is opgelost.
        <h3>Gewicht en overige informatie</h3>
        <table class="car-options">
            <tr>
                <td class="label">Wielbasis</td>
                <td class="value">[284 cm]</td>
            </tr>
            <tr>
                <td class="label">Massa ledig voertuig</td>
                <td class="value">[1740 kg]</td>
            </tr>
            <tr>
                <td class="label">Massa rijklaar</td>
                <td class="value">[1840 kg]</td>
            </tr>
            <tr>
                <td class="label">Toegestane maximum massa voertuig</td>
                <td class="value">[2305 kg]</td>
            </tr>
            <tr>
                <td class="label">Laadvermogen</td>
                <td class="value">[565 kg]</td>
            </tr>
            <tr>
                <td class="label">Maximum gewicht aanhanger ongeremd</td>
                <td class="value">[640 kg]</td>
            </tr>
            <tr>
                <td class="label">Maximum gewicht aanhanger geremd</td>
                <td class="value">[1300 kg]</td>
            </tr>
            <tr>
                <td class="label">Variant</td>
                <td class="value">[R24MP0]</td>
            </tr>
            <tr>
                <td class="label">Uitvoering</td>
                <td class="value">[NZAAB501]</td>
            </tr>
            <tr>
                <td class="label">Type goedkeuringsnummer</td>
                <td class="value">[e1*2001/116*0242*27]</td>
            </tr>
            <tr>
                <td class="label">Plaats chassisnummer</td>
                <td class="value">[op dwarsbalk v. r. voorzitting]</td>
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
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
                    <h2>&euro; [2046,-]</h2>
                </div>
            </div>
            <div class="col-2" style="text-align: center;">
                <p style="padding: 0 0 5px 0;"><strong>Re&euml;le verkoopwaarde<br />door Autobedrijf:</strong></p>
                <div class="data-spot">                    
                    <h2>&euro; [2400,-]</h2>
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
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
                    <td>Uw auto wordt gemiddeld binnen</td>
                    <td><strong style="display: inline-block; margin-left: 5px; margin-right: 5px; position: relative;">[20]</strong></td>
                    <td>dagen verkocht</td>
                </tr>
            </table>
        </div>
        <div id="dashboard-summary" class="col-container">
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-negative.png" width="100%" alt="Dashboard" /></p>
                <p class="value red-color">[20]</p>
                <p class="text">Gemiddeld aantal dagen dat vergelijkbare auto's te koop staan</p>
                <div class="blue-text-block">
                    <p>Staat een auto korter bij het autobedrijf, dan is dit voordelig voor de inruilwaarde van de auto. Een auto hoeft niet lang bij het autobedrijf te staan en de waarde van de auto zakt dus niet veel terug. Hoe lager het gemiddeld aantal dagen, hoe gunstiger dat voor jou is als verkoper.</p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-neutral.png" width="100%" alt="Dashboard" /></p>
                <p class="value blue-color">[100]</p>
                <p class="text">Vergelijkbare auto’s nu te koop bij autobedrijven</p>
                <div class="blue-text-block">
                    <p>Staan er niet veel vergelijkbare auto’s te koop? Dat is positief voor de inruilwaarde. Heb je de keuze uit veel verschillende vergelijkbare auto’s, dan is er veel concurrentie. Is jouw auto unieker, dan zal de waarde ongetwijfeld hoger liggen.<br />&nbsp;<br />&nbsp;<br /></p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard-positive.png" width="100%" alt="Dashboard" /></p>
                <p class="value green-color">[75]</p>
                <p class="text">Vergelijkbare auto’s verkocht door autobedrijven</p>
                <div class="blue-text-block">
                    <p>Zijn er in de afgelopen 45 dagen veel vergelijkbare auto’s verkocht? Dat is een indicatie dat het een populaire auto is. Hoe hoger dit getal, hoe gunstiger het is voor de inruilwaarde van de auto die je aanbiedt.<br />&nbsp;<br />&nbsp;<br />&nbsp;<br /></p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <h3>Korte uitleg</h3>
        <p>Zoals bij vrijwel alle producten die verkocht worden, de prijs komt tot stand door vraag en aanbod. Bij auto’s op de tweedehands markt gaat dit principe ook op. Stel je voor, er staan 200 auto’s te koop die vergelijkbaar zijn met die van jou. In de afgelopen 45 dagen zijn er dagelijks 4 auto’s verkocht. Dan is de courantheid of gangbaarheid van de auto 50 (200 / 4 = 50), verwachting is dat het ongeveer 50 dagen zal duren voordat jouw auto weer opnieuw is verkocht. Een dealer zal rekening houden met dit gegeven om tot een reële verkoopwaarde en inruilwaarde te komen voor de auto.</p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>7</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
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
        <h3>ZORGELOOS UW AUTO VERKOPEN?</h3>
        <div class="col-container" style="padding-top: 10px;">
            <div class="col-2">
                <p><a class="button orange" href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" target="_blank" title="Direct een bod op je voertuig ontvangen?">DIRECT EEN BOD OP JE VOERTUIG ONTVANGEN?</a></p>
            </div>
            <div class="col-2">
                <p><a class="button blue" href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" target="_blank" title="Direct contact met 1 van onze specialisten">DIRECT CONTACT MET 1 VAN ONZE SPECIALISTEN</a></p>
            </div>
            <div class="clear"></div>
        </div>
        <p style="padding-top: 20px;"><a href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" title="WijVerkopenUwAutoWel.nl" target="_blank"><img src="<?php echo $pdfUrl; ?>/images/logo-wijverkopenuwautowel.png" alt="WijVerkopenUwAutoWel.nl" width="200" /></a></p>
        <h3>Over wijverkopenuwautowel.nl</h3>
        <p>Het team van wijverkopenuwautowel.nl is jong, ambitieus, betrouwbaar en eigenzinnig met een hands-on mentaliteit. Focus op klanten is de rode draad in ons bedrijf en we doen er dan ook alles aan om van elke klantervaring een topervaring te maken.</p>
        <p>Waarom wij voor deze manier van werken hebben gekozen? Het was geen bewuste keuze. Onze bedrijfscultuur is ontstaan door het bij elkaar komen van verschillende specialisten en generalisten met allen dezelfde overeenkomst; onze kernwaarden.</p>
        <p>We bestaan uit mensen die willen doorgroeien, tot het gaatje willen gaan om te verbeteren, zeggen waar het op staat en plezier halen uit ons werk, dat zijn wij! We houden van doorpakken en niet van stilzitten.</p>
        <p>Plezier vind je bij ons niet alleen terug op zakelijk gebied, maar ook in onze onderlinge competitie en strijd, respect voor elkaar en de trots op wat we gezamenlijk aan het opbouwen zijn. Wij zijn wie we zijn!</p>
        <p>Wil jij kennismaken met ons en onze dienstverlening? Het maakt niet uit of je een Audi A1, Fiat Panda, Volkswagen Golf of Porsche Cayenne wilt laten checken. Je vult eenvoudig je kenteken in op onze website en ontvangt binnen no-time een uitgebreid rapport. Met dit rapport kun jij de volgende stap zetten en een slimme beslissing nemen. Waar wacht je nog op? Probeer het vandaag nog uit!</p>
        <p><a href="https://www.wijverkopenuwautowel.nl/?utm_source=Auto-rapport-CMK&utm_medium=CTA-button&utm_campaign=Checkmijnkenteken" title="WijVerkopenUwAutoWel.nl" target="_blank">> WijVerkopenUwAutoWel.nl</a></p>
    </div>
    <div class="default-page-footer">
        <table class="page-footer">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="page-number"><p>8</p></div>
                </td>
                <td>
                    <p class="company" style="text-align: right;">Kentekenrapport checkmijnkenteken.nl</p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>