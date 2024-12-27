<?php

$checkmijnkenteken_dashhboard = new checkmijnkenteken_dashhboard();

class checkmijnkenteken_dashhboard {

   public function __construct() {
      add_action( 'admin_menu', [ $this, 'register_menu_item' ], 200 );
   }

   public function register_menu_item() {

      add_menu_page(
         'CMK queue',     // page title
         'CMK queue',     // menu title
         'edit_posts',   // capability
         'cmk_queue',     // menu slug
         [ $this, 'queue' ], // callback function
			'dashicons-editor-table'
      );

      add_menu_page(
         'CMK log',     // page title
         'CMK log',     // menu title
         'edit_posts',   // capability
         'cmk_log',     // menu slug
         [ $this, 'log' ], // callback function
			'dashicons-editor-table'
      );

      add_menu_page(
         'CMK handmatig',     // page title
         'CMK handmatig',     // menu title
         'edit_posts',   // capability
         'cmk_handmatig',     // menu slug
         [ $this, 'handmatig_toevoegen' ], // callback function
			'dashicons-editor-table'
      );

      add_menu_page(
         'CMK moneybird',     // page title
         'CMK moneybird',     // menu title
         'edit_posts',   // capability
         'cmk_moneybird',     // menu slug
         [ $this, 'moneybird' ], // callback function
			'dashicons-editor-table'
      );

   }

	public function get_queue( $kenteken = '' ) {

		global $wpdb;

		if ( !empty ( $kenteken ) ) {
			$sql = $wpdb->prepare( 'SELECT * FROM wp_checkmijnkenteken_queue WHERE kenteken LIKE "'.$kenteken.'%" ORDER BY timestamp DESC LIMIT 0,2500', $kenteken );
		} else {
			$sql = 'SELECT * FROM wp_checkmijnkenteken_queue ORDER BY timestamp DESC LIMIT 0,2500';
		}

		return $wpdb->get_results( $sql );

	}

	public function get_log( $kenteken = '' ) {

		global $wpdb;

		if ( !empty ( $kenteken ) ) {
			$sql = $wpdb->prepare( 'SELECT * FROM wp_checkmijnkenteken_log WHERE kenteken LIKE "'.$kenteken.'" ORDER BY id ASC LIMIT 0,2500', $kenteken .'%' );
		} else {
			$sql = 'SELECT * FROM wp_checkmijnkenteken_log ORDER BY id DESC LIMIT 0,2500';
		}

		return $wpdb->get_results( $sql );

	}

   public function queue() {

		$kenteken = ( isset( $_GET[ 'kenteken' ] ) ) ? $_GET[ 'kenteken' ] : '';

		$queue = $this->get_queue( $kenteken );

		?>
			<h1>Checkmijnkenteken.nl queue</h1>

			<form method="get" style="margin-bottom:20px;">
				<input type="hidden" name="page" value="cmk_queue">
				<input type="text" name="kenteken" placeholder="Filter op kenteken" value="<?=$kenteken?>">
			</form>

			<p>Hieronder worden de laatste 2500 logregels getoond.</p>

			<table class="logfile wp-list-table widefat fixed striped table-view-list pages" cellspacing="0" cellpadding="0" border="0">
				<thead>
					<th style="width:50px">#</th>
					<th>timestamp</th>
					<th>kenteken</th>
					<th>tellerstand</th>
					<th>email</th>
					<th>status</th>
					<th>pogingen</th>
					<th>params_url</th>
					<th></th>
				</thead>
				<tbody>
					<?php
						foreach( $queue as $line ) {
							?>
							<tr>
								<td><?=$line->id?></td>
								<td><?=$line->timestamp?></td>
								<td><a href="/wp-admin/admin.php?page=cmk_log&kenteken=<?=$line->kenteken?>" title="Naar de log"><?=$line->kenteken?></a></td>
								<td><?=$line->tellerstand?></td>
								<td><?=$line->email?></td>
								<td><?=$line->status?></td>
								<td><?=$line->pogingen?></td>
								<td><?=$line->params_url?></td>
								<td>
									<?php if ( $line->status == 'gegenereerd' ): ?>
										<a target="_blank" href="/pdf/pdf_output/<?=$line->kenteken?>.pdf">pdf</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>

		<?php

   }

   public function log() {

		$kenteken = ( isset( $_GET[ 'kenteken' ] ) ) ? $_GET[ 'kenteken' ] : '';

		$data = $this->get_log( $kenteken );

		?>

			<style>
				tr.data {
					display: none;
				}
				tr.data.tonen {
					display: block;
				}
				tr.data pre {

				}
			</style>

			<script>
				jQuery(function($) {
					$('.toon-data').on('click', function() {

						var target = $(this).data('target');
						$(target).toggleClass('tonen');

					});

				});
			</script>

			<h1>Checkmijnkenteken.nl log</h1>

			<form method="get" style="margin-bottom:20px;">
				<input type="hidden" name="page" value="cmk_log">
				<input type="text" name="kenteken" placeholder="Filter op kenteken" value="<?=$kenteken?>">
			</form>

			<p>Hieronder worden de laatste 2500 logregels getoond.</p>

			<table class="logfile wp-list-table widefat fixed striped table-view-list pages" cellspacing="0" cellpadding="0" border="0">
				<thead>
					<th style="width:50px">#</th>
					<th>timestamp</th>
					<th>kenteken</th>
					<th>message</th>
					<th>data</th>
				</thead>
				<tbody>
					<?php
						foreach( $data as $line ) {

							if ( strpos( $line->data, '{' ) == 0 ) {
								$data = json_decode( $line->data, true );
							} else {
								$data = $line->data;
							}

							if ( is_iterable( $data ) && sizeof( $data ) === 0 ) {
								$data = false;
							}

							?>
							<tr>
								<td><?=$line->id?></td>
								<td><?=$line->timestamp?></td>
								<td><a href="/wp-admin/admin.php?page=cmk_queue&kenteken=<?=$line->kenteken?>" title="Naar de queue"><?=$line->kenteken?></a></td>
								<td><?=$line->message?></td>
								<td><?php if ( $data !== false ): ?>
									<span class="button toon-data" data-target="#line_<?=$line->id?>">Toon data</span>
								<?php endif; ?></td>
							</tr>
							<tr class="data" id="line_<?=$line->id?>">
								<td></td>
								<td colspan="4">
									<?php if ( $data !== false ): ?>
										<pre><?=htmlentities( print_r( $data, true ) )?></pre>
									<?php endif; ?>										
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>

		<?php

   }

	public function handmatig_toevoegen() {

		echo '<h1>CMK handmatig</h1>';

		global $plugin_checkmijnkenteken;

		// Input verwerken

			$actie = ( isset( $_POST[ 'actie' ] ) && ! empty( $_POST[ 'actie' ] ) ) ? $_POST[ 'actie' ]  : '';
			$kenteken = ( isset( $_POST[ 'kenteken' ] ) && ! empty( $_POST[ 'kenteken' ] ) ) ? $_POST[ 'kenteken' ]  : '';
			$tellerstand = ( isset( $_POST[ 'tellerstand' ] ) && ! empty( $_POST[ 'tellerstand' ] ) ) ? $_POST[ 'tellerstand' ]  : '';
			$email = ( isset( $_POST[ 'email' ] ) && ! empty( $_POST[ 'email' ] ) ) ? $_POST[ 'email' ]  : '';

			$kenteken = $plugin_checkmijnkenteken->kenteken_cleanup( $kenteken );

		// Init

			$plugin_checkmijnkenteken->set_kenteken( $kenteken );
			$plugin_checkmijnkenteken->set_tellerstand( $tellerstand );
			$plugin_checkmijnkenteken->set_emailadres( $email );
		?>

		<h2>Toevoegen aan queue</h2>

		<form method="post" style="margin-bottom:20px;">
			<input type="hidden" name="actie" value="toevoegen-aan-queue"><br>
			<input type="text" name="kenteken" placeholder="Kenteken" value="<?=$kenteken?>"><br>
			<input type="text" name="tellerstand" placeholder="Tellerstand" value="<?=$tellerstand?>"><br>
			<input type="text" name="email" placeholder="E-mailadres" value="<?=$email?>"><br>
			<input type="submit" value="Toevoegen aan queue">
		</form>

		<?php

			// Actie: toevoegen-aan-queue

				if ( $actie == 'toevoegen-aan-queue' ) {

					$plugin_checkmijnkenteken->log_to_db( $kenteken, 'Handmatig toegevoegd aan queue', array(
						'kenteken' => $kenteken,
						'tellerstand' => $tellerstand,
						'email' => $email,
					) );
				
					$plugin_checkmijnkenteken->add_to_queue( 'genereren' );

					echo '<p><b>De generatie van ' . $kenteken . ' is toegevoegd aan de queue.</b></p>';

				}

		?>

		<h2>Rapport genereren</h2>

		<form method="post" style="margin-bottom:20px;">
			<input type="hidden" name="actie" value="rapport-genereren"><br>
			<input type="text" name="kenteken" placeholder="Kenteken" value="<?=$kenteken?>"><br>
			<input type="text" name="tellerstand" placeholder="Tellerstand" value="<?=$tellerstand?>"><br>
			<input type="submit" value="Rapport genereren">
		</form>

		<?php
		// Actie: rapport-genereren

		if ( $actie == 'rapport-genereren' ) {

			$plugin_checkmijnkenteken->log_to_db( $kenteken, 'Rapport handmatig gegenereerd', array(
				'kenteken' => $kenteken,
				'tellerstand' => $tellerstand,
			) );
		
			$plugin_checkmijnkenteken->generate_pdf();

			echo '<p><b>Het rapport voor ' . $kenteken . ' is gegenereerd</b></p>';
			echo '<p><a href="/pdf/pdf_output/'.$kenteken.'.pdf" target="_blank">klik hier voor het rapport</a></p>';
			echo '<p><a href="/wp-admin/admin.php?page=cmk_log&kenteken='.$kenteken.'" target="_blank">log bekijken</a></p>';

		}

	}

	public function moneybird() {

		echo '<h1>CMK moneybird</h1>';

		$cmk_moneybird = new cmk_moneybird();

		$administrations = $cmk_moneybird->get_administrations();
		$contacts = $cmk_moneybird->get_contacts();
		$workflows = $cmk_moneybird->get_workflows();

		?>

		<style>
			table {
				border-left: 1px solid #aaa;
			}
			th,td {
				text-align: left;
				padding: 4px 10px 4px 4px;
				border-right: 1px solid #aaa;
				border-bottom: 1px solid #aaa;
			}
		</style>

		<h2>Administraties</h2>

		<table cellspacing="0">
			<tr>
				<th>id</th>
				<th>name</th>
			</tr>
			<?php foreach( $administrations as $administration ):?>
				<tr>
					<td><?=$administration->id?></td>
					<td><?=$administration->name?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h2>Contacten</h2>

		<table cellspacing="0">
			<tr>
				<th>id</th>
				<th>company_name</th>
			</tr>
			<?php foreach ( $contacts as $contact ): ?>
				<tr>
					<td><?=$contact->id?></td>
					<td><?=$contact->company_name?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h2>Workflows</h2>

		<table cellspacing="0">
			<tr>
				<th>id</th>
				<th>type</th>
				<th>name</th>
				<th>active</th>
				<th>created_at</th>
				<th>updated_at</th>
			</tr>
			<?php foreach ( $workflows as $workflow ): ?>
				<tr>
					<td><?=$workflow->id?></td>
					<td><?=$workflow->type?></td>
					<td><?=$workflow->name?></td>
					<td><?=$workflow->active?></td>
					<td><?=$workflow->created_at?></td>
					<td><?=$workflow->updated_at?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<?php

		/*
		echo '<pre>';
		$salesinvoice_id = $cmk_moneybird->maak_factuur_aan( '00-PTD-1', 'hello@comfortstud.io' );
		$pdf = $cmk_moneybird->get_pdf( $salesinvoice_id );

		var_dump($pdf);

		echo '</pre>';
		*/

	}

}
