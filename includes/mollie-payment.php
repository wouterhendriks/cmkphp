<?php

function tn_checkmijnkenteken_init_mollie() {

	/*
		Docs:
		https://github.com/mollie/mollie-api-php
		https://docs.mollie.com/reference/v2/payments-api/create-payment
	*/

	// require_once( 'vendor/autoload.php' );
	$mollie = new \Mollie\Api\MollieApiClient();
	$mollie->setApiKey( TN_MOLLIE_KEY );

	return $mollie;

}

// 1: Start mollie-payment na form-submission (id 5 hardcoded)

add_filter( 'gform_confirmation_5', 'tn_checkmijnkenteken_start_mollie_payment', 10, 4 );
function tn_checkmijnkenteken_start_mollie_payment( $confirmation, $form, $entry, $is_ajax ) {

	global $plugin_checkmijnkenteken;

	unset($_SESSION['dd_gf_form_payment_submit']);

	$email = rgpost( 'input_1', true );
	$kenteken = rgpost( 'input_2', true );
	$tellerstand = rgpost( 'input_5', true );

	$params = array(
		'utm_source'			=> rgpost( 'input_9997', true ),
		'utm_medium'			=> rgpost( 'input_9998', true ),
		'utm_campaign'			=> rgpost( 'input_9999', true ),
		'utm_term'				=> rgpost( 'input_9996', true ),
		'utm_content'			=> rgpost( 'input_9995', true ),
		'gclid'					=> rgpost( 'input_9994', true ),
		'client_id'				=> rgpost( 'input_9993', true ),
	);

	$mollie = tn_checkmijnkenteken_init_mollie();

	$plugin_checkmijnkenteken->set_kenteken( $kenteken );
	$plugin_checkmijnkenteken->set_tellerstand( $tellerstand );
	$plugin_checkmijnkenteken->set_emailadres( $email );
	$plugin_checkmijnkenteken->set_params_url( http_build_query( $params ) );

	$plugin_checkmijnkenteken->log_to_db( $kenteken, 'Mollie, start betaling', array(
		'tellerstand' => $tellerstand,
		'email' => $email,
	) );

	$plugin_checkmijnkenteken->add_to_queue( 'betaling_gestart' );

	$payment = $mollie->payments->create([
		'amount' => [
			'currency' => 'EUR',
			'value' => '3.65'
		],
		'description' => $entry[ 'id' ] . '-' . $kenteken,
		'redirectUrl' => $confirmation[ 'redirect' ],
	]);

	$bestelling = array(
		'mollie_payment_id' => $payment->id,
		'email' => $email,
		'kenteken' => $kenteken,
		'tellerstand' => preg_replace( '/[^0-9]/', '', $tellerstand ),
		'entry_id' => $entry[ 'id' ]
	);

	$_SESSION[ 'tn_checkmijnkenteken_bestelling' ] = $bestelling;

	return array( 'redirect' => $payment->getCheckoutUrl() );

}

// 2. Na succesvolle betaling: voer gform_ideal_fulfillment uit

add_action('wp_head', 'tn_checkmijnkenteken_trigger_verzending_van_rapport' );
function tn_checkmijnkenteken_trigger_verzending_van_rapport() {

	if ( get_the_ID() == 311 ) { // hardcoded: bedankt pagina
		
		if ( isset( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ] ) && is_array( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ] ) && isset( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ][ 'mollie_payment_id' ] ) ) {
			
			global $plugin_checkmijnkenteken;

			$url            = '';
			$data           = $_SESSION;
			$data_array     = array(
				'gclid',
				'utm_campaign',
				'utm_medium',
				'utm_source',
				'utm_term'
			);
		
			$counter = 1;
		
			foreach( $data_array as $key ) {
				$val = 'onbekend';
				if( array_key_exists( $key, $data ) ) {
					if( $data[$key] ) $val = $data[$key];
				} 
				$url .= ($counter > 1 ? '&' : '' ) . urlencode($key) . '=CMK_'. urlencode($val); 
				$counter++;
			}
		
			// Get base URL parameters
			$params_url = $url . '&utm_content=CMK_rapport';
		
			$bestelling = $_SESSION[ 'tn_checkmijnkenteken_bestelling' ];

			$plugin_checkmijnkenteken->set_kenteken( $bestelling[ 'kenteken' ] );
			$plugin_checkmijnkenteken->set_tellerstand( $bestelling[ 'tellerstand' ] );
			$plugin_checkmijnkenteken->set_emailadres( $bestelling[ 'email' ] );
			$plugin_checkmijnkenteken->set_params_url( $params_url );

			$mollie = tn_checkmijnkenteken_init_mollie();
			$payment = $mollie->payments->get( $bestelling[ 'mollie_payment_id' ] );

			$payment_details = 'Betaald door ' . $payment->details->consumerName . ' ('.$payment->details->consumerAccount.')';

			// Betaalstatus opslaan bij form-entry

				// GFAPI::update_entry_property( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ][ 'entry_id'], 'payment_status', $payment->status );				
				GFAPI::update_entry_field( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ][ 'entry_id'], 9992, $payment->status );				

			// Rapport genereren

			if ( $payment->isPaid() ) {

				// Generatie niet direct starten maar verplaatsen naar de queue
				$plugin_checkmijnkenteken->log_to_db( $bestelling[ 'kenteken' ], 'tn_checkmijnkenteken_trigger_verzending_van_rapport(): betaald, start rapport generatie', $payment );

				// payment_details opslaan

				$plugin_checkmijnkenteken->set_payment_details( $payment_details );

				// $plugin_checkmijnkenteken->generate_pdf();
				$plugin_checkmijnkenteken->set_queue_to_genereren();
				// $plugin_checkmijnkenteken->send_email();
				$plugin_checkmijnkenteken->activecampaign();

				// Factuur aanmaken in Mollie
				$cmk_moneybird = new cmk_moneybird();
				$salesinvoice_id = $cmk_moneybird->maak_factuur_aan( $plugin_checkmijnkenteken->get_kenteken(), $plugin_checkmijnkenteken->get_emailadres(), $payment_details, $bestelling[ 'mollie_payment_id' ] );
				$pdf = $cmk_moneybird->get_pdf( $salesinvoice_id );

				$plugin_checkmijnkenteken->send_email( array(
					'to' => $plugin_checkmijnkenteken->get_emailadres(),
					'subject' => 'Hartelijk dank voor het aanvragen van het kentekenrapport',
					'template' => 'email-factuur.php',
					'pdf_attachment_body' => $pdf,
					'pdf_attachment_name' => 'factuur-'. $plugin_checkmijnkenteken->get_kenteken() . '.pdf'
				) );

				// wp_remote_get( "https://checkmijnkenteken.nl/pdf/generate-pdf.php?kenteken=" . $kenteken . "&tellerstand=" . $tellerstand . "&email=" . $email );
				// wp_remote_get( "https://checkmijnkenteken.nl/email/email.php?kenteken=" . $kenteken . "&email=" . $email );
				// wp_remote_get( "https://checkmijnkenteken.nl/api/activecampaign.php?kenteken=" . $kenteken . "&email=" . $email . "&tellerstand=" . $tellerstand );


				$_SESSION['dd_gf_form_payment_submit'] = true;

				date_default_timezone_set( 'Europe/Amsterdam' );
				GFAPI::update_entry_field( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ][ 'entry_id'], 9991, date( 'Y-m-d H:i:s' ) );
				unset( $_SESSION[ 'tn_checkmijnkenteken_bestelling' ] );

			} else {

				$plugin_checkmijnkenteken->log_to_db( $bestelling[ 'kenteken' ], 'tn_checkmijnkenteken_trigger_verzending_van_rapport(): betaling mislukt' );

				wp_redirect( get_permalink( 320 ) );
				die();

			}

		}
		
	}

}

if ( isset( $_GET['tn_checkmijnkenteken_sync_mollie_payments'] ) ) {
	tn_checkmijnkenteken_sync_mollie_payments();
}

function tn_checkmijnkenteken_sync_mollie_payments() {

	error_reporting( E_ALL );

	echo '<pre>';

	$mollie = tn_checkmijnkenteken_init_mollie();

	$aantal_betalingen = 50; // max. 250

	$payments = $mollie->payments->page( null, $aantal_betalingen );
	// $payments = $mollie->payments->page();

	tn_checkmijnkenteken_sync_mollie_payments_process_page( $payments );

	// for ( $i=0;$i<20;$i++) {
	// 	if ( $payments->hasNext() ) {
	// 		echo '----------<br>';
	// 		$next_payments = $payments->next();
	// 		tn_checkmijnkenteken_sync_mollie_payments_process_page( $next_payments );
	// 	}
	// }

	die();
}

function tn_checkmijnkenteken_sync_mollie_payments_process_page( $payments ) {

	global $plugin_checkmijnkenteken;

	foreach ( $payments as $payment ) {

		// Info verwerken tot hapklare brokken

			preg_match( '/^(\d*)\-(.*)$/', $payment->description, $matches );
			$entry_id = $matches[ 1 ];
			$kenteken = $matches[ 2 ];
			$status = $payment->status;
			$paid = ( $payment->status == 'paid' );

		// Refunds & chargebacks toevoegen

			if ( $payment->hasRefunds() ) {
				$status .= ' / refunded';
				// echo "Payment has been (partially) refunded.<br />";
			}

			if ( $payment->hasChargebacks() ) {
				$status .= ' / chargeback';
			}

		// Entry bijwerken

			if ( is_numeric( $entry_id ) && $entry_id > 200000 && GFAPI::entry_exists( $entry_id ) ) {

				GFAPI::update_entry_field( $entry_id, 9992, $status );

				$entry = GFAPI::get_entry( $entry_id );

				$rapport_gegenereerd_op = $entry[ 9991 ];

				echo $entry_id . ' | ' . $kenteken . ' | ' . $status . ' | ' . $rapport_gegenereerd_op . '<br>';

				if ( $paid && $rapport_gegenereerd_op == '-' ) {

					$kenteken = $entry[ '2' ];
					$tellerstand = $entry[ '5' ];
					$email = $entry[ '1' ];

					$plugin_checkmijnkenteken->set_kenteken( $kenteken );
					$plugin_checkmijnkenteken->set_tellerstand( $tellerstand );
					$plugin_checkmijnkenteken->set_emailadres( $email );					
					$plugin_checkmijnkenteken->set_params_url( $params_url );

					$plugin_checkmijnkenteken->generate_pdf();
					$plugin_checkmijnkenteken->send_email();
					$plugin_checkmijnkenteken->activecampaign();

					GFAPI::update_entry_field( $entry_id, 9991, date( 'Y-m-d H:i:s' ) . ' (achteraf via cronjob-vangnet)' );

					$plugin_checkmijnkenteken->log_to_db( $kenteken, 'tn_checkmijnkenteken_sync_mollie_payments_process_page(): rapport alsnog gegenereerd via cronjob-vangnet');
					echo '---&gt; rapport alsnog gegenereerd<br>';

				}

			} else {
				echo $entry_id . ' | ' . $kenteken . ': ignored<br>';
			}

	}

}
