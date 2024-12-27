<?php

   /*

SELECT
	*
FROM
	wp_checkmijnkenteken_log
WHERE
	message LIKE "%Mollie, start betaling%"
	AND
	timestamp > '2024-04-21 15:00:00'
	AND
	timestamp < '2024-04-21 21:00:00'
;

SELECT * FROM wp_checkmijnkenteken_queue WHERE payment_details LIKE '%eijdems%';
