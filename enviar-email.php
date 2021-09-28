<?php

use App\Comunication\Email;

require __DIR__ . '/vendor/autoload.php';

$address = "teste@teste.com";
$subject = "Teste envio de e-mail";
$body = "<b>Olá mundo...</b>";
$body .= "<br><br>";
$body .= "<i>Testando envio de e-mail utiliando o PHPMailer</i>";

$objEmail = new Email();
$sucesso = $objEmail->sendEmail($address, $subject, $body);

echo $sucesso ? 'Email enviado com sucesso' : $objEmail->getError();