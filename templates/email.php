<?php
	$baseUrl = 'https://checkmijnkenteken.nl/assets/rapport_email_notificatie/';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="Generator" content="EditPlus®">
		<meta name="Author" content="">
		<meta name="Keywords" content="">
		<meta name="Description" content="">
		<title>Checkmijnkenteken.nl - Kentekenrapport</title>
	</head>
	<body style="background-color: #EFEFEF; margin: 0; padding: 30px 0; font: 400 sem/1.9 Noto Sans KR,sans-serif; color: #000000;">
		<table class="container" style="background-color: #FFF; width: 600px; margin: 0 auto; padding: 0; border-spacing: 0; border-collapse: collapse; border: 0;">
			<tr>
				<td class="header-top" style="text-align: center; padding: 20px 0; margin: 0; width: 600px;">
					<a href="https://checkmijnkenteken.nl" target="_blank" title="Checkmijnkenteken.nl">
						<img class="logo" width="229" height="52" src="<?php echo $baseUrl; ?>/email-logo.png" alt="Checkmijnkenteken.nl" style="display: block; width: 229px; height: 52px; margin: 0 auto; line-height: 0;" />
					</a>			
				</td>
			</tr>
			<tr>
				<td class="header-hero" style="width: 600px; border-bottom: 10px solid #29abe2; padding: 0; margin: 0;">
					<img class="header" width="229" height="52" src="<?php echo $baseUrl; ?>/email-header.jpg" alt="Checkmijnkenteken.nl" style="display: block; width: 600px; height: 275px; margin: 0 auto; line-height: 0;" />
				</td>
			</tr>
			<tr>
				<td class="content-main" style="width: 600px; padding: 30px; margin: 0;">
					<h1 style="color: #29abe2; font: 700 1.25em/1.5 Noto Sans KR,sans-serif; text-transform: uppercase; margin: 0 0 20px 0; padding: 0;">Jouw kentekenrapport staat voor je klaar</h1>
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #000000; margin: 0; padding: 0 0 20px 0;">Bedankt voor het downloaden van jouw kenteken rapport voor kenteken <?php echo $kenteken; ?> via Checkmijnkenteken.nl. In dit rapport vind je alle informatie om een goed beeld te krijgen van jouw auto. </p>
					<a href="https://checkmijnkenteken.nl/pdf/pdf_output/<?php echo $kenteken;?>.pdf" style="padding: 10px 40px; border: 1px solid #ea5b0c; border-radius: 8px; font: 600 1em/2 Noto Sans KR,sans-serif; text-transform: uppercase; text-decoration: none; color: #fff; background: #ea5b0c; margin: 0; text-align: center;margin-bottom:20px;display: block;">Bekijk kentekenrapport</a>
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #000000; margin: 0; padding: 0 0 20px 0;">Hierin vind je onder andere alle informatie over:
						<ul style="font: 400 1em/1.9 Noto Sans KR,sans-serif;">
							<li>Gemiddeld aantal dagen dat vergelijkbare auto’s te koop staan.</li>
							<li>De historie van je auto.</li>
							<li>Hoeveel je auto waard is.</li>
						</ul>
					</p>
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #000000; margin: 0; padding: 0 0 20px 0;"><em>Dit en veel meer staat voor je klaar in het kentekenrapport <a href="https://checkmijnkenteken.nl/pdf/pdf_output/<?php echo $kenteken;?>.pdf">https://checkmijnkenteken.nl/kentekenrapport/<?php echo $kenteken;?></a></em></p>
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #000000; margin: 0; padding: 0 0 20px 0;">Met vriendelijke groet,</p>
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #29abe2;">Team Checkmijnkenteken.nl</p>
				</td>
			</tr>
			<tr>
				<td class="footer-top" style="background: #dff2fb; width: 600px; padding: 20px 30px; margin: 0;">
					<p style="font: 400 1em/1.9 Noto Sans KR,sans-serif; color: #000000; margin: 0; padding: 0 0 10px 0;"><em>Ps. Heb je nog vragen over jouw persoonlijke rapport? Neem dan gerust contact met ons op via <a href="mailto:contact@checkmijnkenteken.nl">contact@checkmijnkenteken.nl</a>.</em></p>
				</td>
			</tr>
			<tr>
				<td class="footer" style="width: 600px; padding: 30px 30px 10px 30px; margin: 0; background: #29abe2;">
					<p style="font: 400 0.875em/1.9 Noto Sans KR,sans-serif; color: #FFFFFF; margin: 0; padding: 0 0 20px 0; text-align: center;">Je ontvangt deze mail, omdat je het kentekenrapport van Checkmijnkenteken.nl hebt gekocht</p>
				</td>
			</tr>
		</table>  
	</body>
</html>
