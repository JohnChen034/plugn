<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $emailText string */
/* @var $ticket_uuid string */

$ticketUuidLabel = Html::encode($ticket_uuid);
$emailTextLabel = nl2br(Html::encode($emailText));
?>

<p>Ticket not found</p>

<p>Your message wasn't delivered as we do not have a record of this ticket.</p>

<p>Please respond to this email if you require assistance from Plugn's support team.</p>

<b>Ticket ID:</b>
<p><?= $ticketUuidLabel ?></p>

<b>Your message:</b><br/>
<?= $emailTextLabel ?>
