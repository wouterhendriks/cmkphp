# CheckMijnKenteken Plugin Flow

## 1. Form Submission
The process starts with a Gravity Form (ID: 5) submission. The form collects:
- Email address (input_1)
- License plate number (input_2)
- Current mileage (input_5)
- UTM tracking parameters (input_9993 through input_9999)

The submission is intercepted by the `gform_confirmation_5` filter, which initiates the process by adding the request to a queue.

**File:** `includes/mollie-payment.php`
```php
add_filter('gform_confirmation_5', 'tn_checkmijnkenteken_start_mollie_payment', 10, 4);
function tn_checkmijnkenteken_start_mollie_payment($confirmation, $form, $entry, $is_ajax) {
    $email = rgpost('input_1', true);
    $kenteken = rgpost('input_2', true);
    $tellerstand = rgpost('input_5', true);

    $plugin_checkmijnkenteken->add_to_queue('betaling_gestart');
}
```

## 2. Payment Processing
After form submission, a Mollie payment is initiated. The payment:
- Has a fixed amount of €3.65
- Includes the entry ID and license plate in the description
- Redirects to a confirmation page after completion
- Sets up a payment session that will be verified later

**File:** `includes/mollie-payment.php`
```php
$payment = $mollie->payments->create([
    'amount' => [
        'currency' => 'EUR',
        'value' => '3.65'
    ],
    'description' => $entry['id'] . '-' . $kenteken,
    'redirectUrl' => $confirmation['redirect'],
]);
```

## 3. Payment Confirmation & Initial Actions
Once payment is confirmed, several actions are triggered:
- The payment status is logged to the database
- Queue status is updated to 'genereren'
- Customer data is prepared for ActiveCampaign sync
- Process logging begins for tracking the report generation

**File:** `includes/mollie-payment.php`
```php
if ($payment->isPaid()) {
    $plugin_checkmijnkenteken->log_to_db($kenteken, 'betaald, start rapport generatie');
    $plugin_checkmijnkenteken->set_queue_to_genereren();
    $plugin_checkmijnkenteken->activecampaign();
}
```

## 4. ActiveCampaign Integration
Customer data is synchronized with ActiveCampaign CRM:
- Email address is used as the primary identifier
- License plate number is stored as a custom field
- Current mileage is recorded for future reference
- Contact is tagged for marketing automation

**File:** `wp-plugin-checkmijnkenteken.php`
```php
public function activecampaign() {
    $contact = array(
        'email' => $this->emailadres,
        'field[%KENTEKEN%,0]' => $this->kenteken,
        'field[%TELLERSTAND%,0]' => $this->tellerstand
    );
    $contact_sync = $ac->api("contact/sync", $contact);
}
```

## 5. Moneybird Invoice Generation
An invoice is automatically generated in Moneybird:
- Creates a new sales invoice with customer details
- Includes payment reference from Mollie
- Generates a PDF version of the invoice
- Prepares the invoice for email delivery

**File:** `includes/mollie-payment.php`
```php
$cmk_moneybird = new cmk_moneybird();
$salesinvoice_id = $cmk_moneybird->maak_factuur_aan(
    $plugin_checkmijnkenteken->get_kenteken(),
    $plugin_checkmijnkenteken->get_emailadres(),
    $payment_details,
    $bestelling['mollie_payment_id']
);
$pdf = $cmk_moneybird->get_pdf($salesinvoice_id);
```

## 6. Data Retrieval
The system collects data from three different providers:
- RDW: Official vehicle registration and technical specifications
- CarTalk: Market data and vehicle history
- AutoDisk: Cost calculations and maintenance predictions
Each provider's data is validated before proceeding.

**File:** `includes/class.pdf.php`
```php
public static function generate() {
    $rdwdata = cmk_rdw_koppeling::get_data();
    $cartalk_data = cmk_cartalk_koppeling::get_data();
    $tco_data = cmk_autodisk_koppeling::get_tco_data();
}
```

## 7. PDF Generation
A comprehensive PDF report is generated using DOMPDF:
- Uses professional templates from `/templates/pdf/`
- Includes branding and styling
- Combines data from all providers
- Creates a multi-page report with detailed vehicle information
- Saves the file for email attachment

**File:** `includes/class.pdf.php`
```php
$dompdf = new DOMPDF($options);
$dompdf->loadHtml($PDFContent);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
file_put_contents($pdf_output_file, $output);
```

## 8. Email Sending
Two emails are sent to the customer:
1. Invoice email with Moneybird PDF
2. Report email with the generated vehicle report
Emails are sent using Postmark for reliable delivery and tracking.

**File:** `wp-plugin-checkmijnkenteken.php`
```php
public function send_email($params) {
    $payload = array(
        'From' => 'contact@checkmijnkenteken.nl',
        'ReplyTo' => 'contact@checkmijnkenteken.nl',
        'To' => $to,
        'Bcc' => 'rapporten@cmkautomotive.eu',
        'Subject' => $subject,
        'HtmlBody' => $email_body,
        'MessageStream' => 'outbound',
        'Attachments' => array(
            array(
                'Name' => $params['pdf_attachment_name'],
                'Content' => base64_encode($params['pdf_attachment_body']),
                'ContentType' => 'application/pdf',
            )
        )
    );
}
```

## 9. Queue Processing (Cronjobs)
Two automated processes ensure reliable processing:

### Payment Check
Runs every 15 minutes to verify payment status of pending orders:
- Fetches recent payments from Mollie
- Updates order status in the queue
- Triggers report generation for paid orders
- Handles failed payments appropriately

**File:** `includes/mollie-payment.php`
```php
function tn_checkmijnkenteken_sync_mollie_payments() {
    $payments = $mollie->payments->page(null, $aantal_betalingen);
    tn_checkmijnkenteken_sync_mollie_payments_process_page($payments);
}
```

### Report Generation
Runs every 5 minutes to process the generation queue:
- Picks up orders with 'genereren' status
- Attempts report generation up to 5 times
- Handles temporary API failures gracefully
- Updates order status upon completion

**File:** `cronjobs/genereer-rapporten.php`
```php
// Runs every 5 minutes to process queue items with status 'genereren'
$plugin_checkmijnkenteken->generate_pdf();
$plugin_checkmijnkenteken->send_email();
```

## Key Files
- Main Plugin: `wp-plugin-checkmijnkenteken.php`
- RDW Integration: `class.rdw-koppeling.php`
- CarTalk Integration: `class.cartalk-koppeling.php`
- AutoDisk Integration: `class.autodisk-koppeling.php`
- PDF Generation: `class.pdf.php`
- PDF Templates: `/templates/pdf/`

## Additional Information

### Queue System States
- `betaling_gestart`: Initial state when form is submitted
- `genereren`: State after payment confirmation, ready for PDF generation
- Maximum of 5 retry attempts for report generation

### Data Providers
1. **RDW (Rijksdienst voor het Wegverkeer)**
   - Official vehicle registration data
   - Vehicle specifications
   - Registration status

2. **CarTalk**
   - Market value information
   - Vehicle history
   - Comparable vehicles data

3. **AutoDisk**
   - Total Cost of Ownership (TCO) calculations
   - Maintenance predictions
   - Running costs estimates

### Error Handling & Logging
- Detailed logging throughout the process via `log_to_db()`
- Payment verification cronjob every 15 minutes
- Report generation cronjob every 5 minutes
- Validation checks for each data provider:
  ```php
  if (!cmk_rdw_koppeling::valideer($rdwdata)) {
      return false;
  }
  if (!cmk_cartalk_koppeling::valideer($cartalk_data)) {
      return false;
  }
  if (!cmk_autodisk_koppeling::valideer($tco_data)) {
      return false;
  }
  ```

### Admin Interface
- **CMK Queue**: Monitor all items in the queue
- **CMK Log**: Detailed process logging
- **CMK Manual**: Manual report generation
- **CMK Moneybird**: MoneyBird ID management