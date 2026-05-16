<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $emailFrom string */
/* @var $emailText string */
/* @var $ticket_uuid string */

$emailFromLabel = Html::encode($emailFrom);
$ticketUuidLabel = Html::encode($ticket_uuid);
$emailTextLabel = nl2br(Html::encode($emailText));
?>

<p>Your message wasn't delivered because you do not have access to this conversation from the email address you used.</p>

<p>Please confirm that you're responding to emails using the same email address you signed up with on Plugn.</p>

<b>Email address you used:</b>
<p><?= $emailFromLabel ?></p>

<b>Ticket ID:</b>
<p><?= $ticketUuidLabel ?></p>

<b>Your message:</b><br/>

<?= $emailTextLabel ?>
