<?php
//include ("../config.php");
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
    <title>Kentekenrapport - [94-HSX-9]</title>
    <style>

       @font-face {
            font-family: 'noto_sans_krbold';
            src: url('fonts/notosanskr-bold-webfont.woff2') format('woff2'),
                 url('fonts/notosanskr-bold-webfont.woff') format('woff');
            font-weight: normal;
            font-style: normal;

        }

        @font-face {
            font-family: 'noto_sans_kr_regularregular';
            src: url('fonts/notosanskr-regular-webfont.woff2') format('woff2'),
                 url('fonts/notosanskr-regular-webfont.woff') format('woff');
            font-weight: normal;
            font-style: normal;

        }

        @page {
            padding: 0 !important;
            margin: 0 !important;
        }

        html {
            display: block;
            position: relative;
            width: 794px;
        }

        body {
            margin: 0;
            padding: 0;
            background: #FFF;
            height: auto;
            width: 794px;
            font-family: 'noto_sans_kr_regularregular', sans-serif;
            font-size: 16px;
            line-height: 1;
        }

        h1 {
            color: #000;
            font-family: 'noto_sans_kr_regularregular', sans-serif;
            font-size: 36px;
            line-height: 1;
            font-weight: 700;
            margin: 0;
            padding: 0 0 10px 0;
        }

         h2 {
            color: #000;
            text-transform: uppercase;
            font-family: 'noto_sans_kr_regularregular', sans-serif;
            font-size: 36px;
            line-height: 1;
            font-weight: 700;
            margin: 0;
            padding: 0 0 10px 0;
        }

        h3 {
            color: #29abe2;   
            font-family: 'noto_sans_kr_regularregular', sans-serif;
            font-size: 18px;
            line-height: 1;
            font-weight: 700;
            margin: 0;
            padding: 0 0 10px 0;
        }

        p {
            color: #000;
            font-family: 'noto_sans_kr_regularregular', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            font-weight: 400;
            margin: 0;
            padding: 0 0 30px 0;
        }

        img {
            display: block;
            line-height: 0;
        }

        .page-break { 
            page-break-before: always; 
        }

        .col-2 {
            width: 50%;
            position: relative;
            float: left;
        }

        .page {
            width: 794px;
            height: 1123px;
            position: relative;
        }

        .front-page-header {            
            position: relative;
            text-align: center;
            padding: 50px 0;
        }
            .front-page-logo {
                margin: 0 auto;
            }

        .front-page-hero {
            position: relative;
            width: 100%;
            height: 853px;
        }

        .clear {
            clear: both;
        }

        .front-page-report-title {
            position: absolute;
            bottom: -30px;
            left: -50px;
            background-image: url('images/front-page-title-spot.png');
            background-repeat: no-repeat;
            width: 668px;
            height: 334px;
            padding: 120px 100px 0 140px;
            box-sizing: border-box;
            z-index: 2;
        }

            .license-title {
                text-transform: uppercase;
                color: #29abe2;   
                font-weight: 700;
                margin: 0;
                padding: 0;
                font-size: 24px;
                line-height: 1.2;
            }

        img.front-page-image {
            width: 100%;
            height: auto;
        }

        .front-page-footer {
            height: 100px;
            width: 100%;
            background: #FFF;
            position: relative;
        }


        .default-page-header {
            position: relative;
            text-align: right;
            padding: 50px;
        }
             .default-page-header img {
                 display: inline-block;
            }


        .default-page-content {
            padding: 0 50px;            
            position: relative;
        }

        table.car-options {
            width: 100%;
            margin: 0 0 30px 0;
            padding: 0;
        }
    

            table.car-options td {
                padding: 10px 20px;
                color: #000;
                font-family: 'noto_sans_kr_regularregular', sans-serif;
                font-size: 16px;
                line-height: 1.6;
                font-weight: 400;
                margin: 0;
            }

            table.car-options td.label {
                background: #29abe2;
                color: #FFF;
                width: 240px;
            }

            table.car-options td.value {
                background: #EEE;
            }

        .default-page-footer {
            text-align: center;
            padding: 50px;
            position: relative;
        }

            .default-page-footer .company {
                position: absolute;
                bottom: 25px;
                right: 50px;
            }
            
            .page-number {
                display: inline-block;
                background: url('images/page-number-bg.png');
                text-align: center;
                height: 39px;
                width: 72px;
            }

            .page-number p {
                padding: 5px 0 0 0;
                margin: 0;
                font-weight: 700;
            }

    </style>
</head>

<body>
    <div id="page-1" class="page front-page">
        <div class="front-page-header">
            <img class="front-page-logo" src="images/logo-front-page.png" alt="Logo" />
        </div>
        <div class="front-page-hero">
            <img class="front-page-image" src="images/front-page-header.jpg" alt="Header" />
            <div class="front-page-report-title">
                <h1>Kenteken Rapport</h1>
                <p class="license-title">VOLKSWAGEN GOLF | 94-HSX-9</p>
            </div>
        </div>
        <div class="front-page-footer">
        </div>
    </div>

    <div class="page-break"></div>

    <div id="page-2" class="page front-page">
        <div class="default-page-header">
            <img class="default-page-logo" src="images/logo-default-page.png" alt="Logo" />
        </div>
        <div class="default-page-content">
            <h1>Volkswagen Golf</h1>

            <div class="col-2">
                <h3>94-HSX-9</h3>
                <p><strong>Ra vendi doloreius ut veliquia dolorestem re plitatest lam res que delestias aut quas intvolor am sim earum quatus. Pudanda estiusexceris nobit, id quo milit alit quae dis non et adi sequiderias magnim labori ut es dolorupiendae vendaepro desti abo. Totatusdae. Nam eos entem que consequas doluptibus autem ut di ut earcim ni asinias am sae nobita nullam iur, te nimolen imodipi cabore lam quas volupit issitiam.</strong></p>
            </div>

            <div class="col-2">
                <p><img src="images/image-car.jpg" alt="" /></p>

                <div class="license-plate">
                    <p>94-HSX-9</p>
                </div>
            </div>

            <div class="clear"></div>

            <h3>ALGEMEEN</h3>
            <table class="car-options">
                <tr>
                    <td class="label">Merk</td>
                    <td class="value">Volkswagen</td>
                </tr>
                <tr>
                    <td class="label">Model</td>
                    <td class="value">Golf</td>
                </tr>
                <tr>
                    <td class="label">Uitvoering</td>
                    <td class="value">1.4 TSI Highline</td>
                </tr>
                <tr>
                    <td class="label">Kleur</td>
                    <td class="value">Zwart</td>
                </tr>
                <tr>
                    <td class="label">Bouwjaar</td>
                    <td class="value">2009</td>
                </tr>
                <tr>
                    <td class="label">Nieuwprijs</td>
                    <td class="value">&euro; 25.650,-</td>
                </tr>
                <tr>
                    <td class="label">Aantal deuren</td>
                    <td class="value">5</td>
                </tr>
            </table>

            <h3>PRESTATIES</h3>
            <table class="car-options">
                <tr>
                    <td class="label">Vermogen KW + PK</td>
                    <td class="value">90Kw</td>
                </tr>
                <tr>
                    <td class="label">0-100 in sec</td>
                    <td class="value">10.1</td>
                </tr>
                <tr>
                    <td class="label">Topsnelheid</td>
                    <td class="value">222 km/h</td>
                </tr>
            </table>

        </div>
        <div class="default-page-footer">
            <div class="page-number"><p>2</p></div>
            <p class="company">Kentekenrapport checkmijnkenteken.nl</p>
            <div class="clear"></div>
        </div>
    </div>

    <div class="page-break"></div>

</body>
</html>