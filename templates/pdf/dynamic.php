<?php
include ("../config.php");
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 14-4-2020
 * Time: 12:06
 */

if(!empty($_GET)){
    
    //define variables;
    $kenteken = $_GET["kenteken"];
    $merk = $_GET["merk"];
    $model = $_GET["model"];
    $tellerstand = $_GET["tellerstand"];
    $uitvoering = $_GET["uitvoering"];
    $kleur = $_GET["kleur"];
    $bouwjaar = $_GET["bouwjaar"];
    $nieuwprijs = $_GET["nieuwprijs"];
    $deuren = $_GET["deuren"];
    $vermogen = $_GET["vermogen"];
    //vermogen formatted: 100 KW / 136 PK
    $vermogen = "$vermogen KW / " . number_format($vermogen * 1.362, 0) . " PK";
    $snelheidnaar100km = $_GET["snelheidnaar100km"];
    $topsnelheid = $_GET["topsnelheid"];
    $brandstof = $_GET["brandstof"];
    $vervaldatumapk = $_GET["vervaldatumapk"];
    $maxtrekgewicht = $_GET["maxtrekgewicht"];
    $transmissie = $_GET["transmissie"];
    $versnellingen = $_GET["versnellingen"];
    $aantaleigenaren = $_GET["aantaleigenaren"];
    $importauto = $_GET["importauto"];
    $restbpm = $_GET["restbpm"];
    $inruilwaarde = $_GET["inruilwaarde"];
    $verkoopwaarde = $_GET["verkoopwaarde"];
    $dagentekoop = $_GET["dagentekoop"];
    $autosnutekoop = $_GET["autosnutekoop"];
    $autosverkocht = $_GET["autosverkocht"];
    $image = $_GET["image"];

}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kentekenrapport - <?php echo $kenteken; ?></title>
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
            <p class="license-title"><?php echo $merk; ?> <?php echo $model; ?> | <?php echo $kenteken; ?></p>
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
                <p><strong>Deze Audi A3 had toen hij van de band rolde een nieuwprijs vanaf €35.000,- en is geen import auto. De auto is voor het eerst toegelaten op de weg op 1 januari 2019 en dit maakt de auto inmiddels 1 jaar oud. De auto rijdt van 0 tot 100 km/u in 5,5 seconden en de topsnelheid van de auto is 200 km/u. Het maximum vermogen wat de auto heeft is 180 PK. De auto heeft een gecombineerd gebruik van 1 liter op de 60 kilometer. Het zuinigheidslabel van de Audi A3 is A en hij heeft een CO2-uitstoot van 10 gram per kilometer.</strong></p>
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
                <td class="value"><?php echo $model; ?></td>
            </tr>
            <tr>
                <td class="label">Uitvoering</td>
                <td class="value"><?php echo $uitvoering; ?></td>
            </tr>
            <tr>
                <td class="label">Kleur</td>
                <td class="value"><?php echo $kleur; ?></td>
            </tr>
            <tr>
                <td class="label">Bouwjaar</td>
                <td class="value"><?php echo $bouwjaar; ?></td>
            </tr>
             <tr>
                <td class="label">Kilometerstand</td>
                <td class="value"><?php echo $tellerstand; ?></td>
            </tr>
            <tr>
                <td class="label">Nieuwprijs</td>
                <td class="value">&euro; <?php echo $nieuwprijs; ?>,-</td>
            </tr>
            <tr>
                <td class="label">Aantal deuren</td>
                <td class="value"><?php echo $deuren; ?></td>
            </tr>
        </table>
        <h3>PRESTATIES</h3>
        <table class="car-options">
            <tr>
                <td class="label">Vermogen KW + PK</td>
                <td class="value"><?php echo $vermogen; ?></td>
            </tr>
            <tr>
                <td class="label">0-100 in sec</td>
                <td class="value"><?php echo $snelheidnaar100km; ?></td>
            </tr>
            <tr>
                <td class="label">Topsnelheid</td>
                <td class="value"><?php echo $topsnelheid; ?> km/h</td>
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
        <h3>TECHNISCH</h3>
        <table class="car-options">
            <tr>
                <td class="label">Brandstof</td>
                <td class="value"><?php echo $brandstof; ?></td>
            </tr>
            <tr>
                <td class="label">APK vervaldatum</td>
                <td class="value"><?php echo $vervaldatumapk; ?></td>
            </tr>
            <tr>
                <td class="label">Maximaal trekgewicht</td>
                <td class="value"><?php echo $maxtrekgewicht; ?></td>
            </tr>
            <tr>
                <td class="label">Transmissie</td>
                <td class="value"><?php echo $transmissie; ?></td>
            </tr>
            <tr>
                <td class="label">Versnellingen</td>
                <td class="value"><?php echo $versnellingen; ?></td>
            </tr>
        </table>
        <h3>HISTORIE</h3>
        <table class="car-options">
            <tr>
                <td class="label">Aantal eigenaren</td>
                <td class="value"><?php echo $aantaleigenaren; ?></td>
            </tr>
            <tr>
                <td class="label">Import auto</td>
                <td class="value"><?php echo $importauto; ?></td>
            </tr>
            <tr>
                <td class="label">Rest BPM*</td>
                <td class="value"><?php echo $restbpm; ?></td>
            </tr>
        </table>
        <img class="arrow" src="<?php echo $pdfUrl; ?>/images/arrow.png" alt="Pijl" />
        <p style="margin-top: -35px;"><i style="line-height: 18px;">* Ecus quisimolorem quis estrunt ut audant volupta volupta ate perepedia dolores doluptiatist et rehendusant occatus perum ent vendipsam asi de sum latur, untum, elitios tioreiu ndisit quam lam, inis elescid uciatquo et minus adia consedis simusam que et fugia id qui optas magnimi, veliti rehende ssimet fugitatibus doluptatur? Nimagnim escitias escipsu ndicill igenem facea sitiis duci doluptu reiciam, cusanda sanimpor sam fugiandio.</i></p>
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
                    <h2>&euro; <?php echo $inruilwaarde; ?>,-</h2>
                </div>
            </div>
            <div class="col-2" style="text-align: center;">
                <p style="padding: 0 0 5px 0;"><strong>Re&euml;le verkoopwaarde<br />door Autobedrijf:</strong></p>
                <div class="data-spot">                    
                    <h2>&euro; <?php echo $verkoopwaarde; ?>,-</h2>
                </div>
            </div>
             <div class="clear"></div>
        </div>
        <p><img src="<?php echo $pdfUrl; ?>/images/visual-inruilwaarde.jpg" width="100%" alt="Visual" /></p>
        <p>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorup iendae vendaepro desti abo. Totatusdae. Nam eos entem que consequas doluptibus autem ut di ut earcim ni asinias am sae nobita nullam iur, te nimolen imodipi cabore lam quas volupit issitiam.</p>
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
                    <td><strong style="display: inline-block; margin-left: 5px; margin-right: 5px; position: relative;"><?php echo $dagentekoop; ?></strong></td>
                    <td>dagen verkocht</td>
                </tr>
            </table>
        </div>
        <div id="dashboard-summary" class="col-container">
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard.png" width="100%" alt="Dashboard" /></p>
                <p class="value"><?php echo $dagentekoop; ?></p>
                <p class="text">GEMIDDELD AANTAL DAGEN DAT VERGELIJKBARE AUTO'S TE KOOP STAAN</p>
                <div class="blue-text-block">
                    <p>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut.</p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard.png" width="100%" alt="Dashboard" /></p>
                <p class="value"><?php echo $autosnutekoop; ?></p>
                <p class="text">VERGELIJKBARE AUTO'S NU TE KOOP</p>
                <div class="blue-text-block">
                    <p>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut.</p>
                </div>
            </div>
            <div class="col-3">
                <p class="dashboard-img"><img src="<?php echo $pdfUrl; ?>/images/dashboard.png" width="100%" alt="Dashboard" /></p>
                <p class="value"><?php echo $autosverkocht; ?></p>
                <p class="text">VERGELIJKBARE AUTO'S VERKOCHT</p>
                <div class="blue-text-block">
                    <p>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut.</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <p>Korte uitleg inruil+verkoopwaarde + weergave in metertjes + kleurtjes. Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorup iendae vendaepro desti abo. Totatusdae. Nam eos entem que consequas doluptibus autem ut di ut earcim ni asinias am sae nobita nullam iur, te nimolen imodipi cabore lam quas volupit issitiam. Id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorup iendae vendaepro desti abo. Totatusdae. Nam eos entem que consequas doluptibus autem ut di ut earcim ni asinias am sae nobita nullam iur, te nimolen imodipi cabore lam quas volupit issitiam.</p>
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
                <p><a class="button orange" href="https://wijverkopenuwautowel.nl" target="_blank" title="Direct een bod op je voertuig ontvangen?">DIRECT EEN BOD OP JE VOERTUIG ONTVANGEN?</a></p>
            </div>
            <div class="col-2">
                <p><a class="button blue" href="https://wijverkopenuwautowel.nl" target="_blank" title="Direct contact met 1 van onze specialisten">DIRECT CONTACT MET 1 VAN ONZE SPECIALISTEN</a></p>
            </div>
            <div class="clear"></div>
        </div>
        <p style="padding-top: 20px;"><a href="https://wijverkopenuwautowel.nl" title="WijVerkopenUwAutoWel.nl" target="_blank"><img src="<?php echo $pdfUrl; ?>/images/logo-wijverkopenuwautowel.png" alt="WijVerkopenUwAutoWel.nl" width="200" /></a></p>
        <p>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas int volor am sim earum quatus. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorup iendae vendaepro desti abo. Totatusdae. Pudanda estius exceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorup iendae vendaepro desti abo. Totatusdae.</p>
        <p><a href="https://wijverkopenuwautowel.nl" title="WijVerkopenUwAutoWel.nl" target="_blank">> WijVerkopenUwAutoWel.nl</a></p>        
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
</body>
</html>