<?php

namespace App\Comunication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Email
{
    /**
     * credenciais de acesso
     *  @var string
     */
    const HOST = 'smtp.mailtrap.io';
    const USER = '15059769b53e7d';
    const PASS = '27aa07c29cf493';
    const SECURE = 'TLS';
    const PORT = 587;
    const CHARSET = 'UTF-8';

    /**
     * dados do remetente
     * @var string
     */
    const FROM_EMAIL = 'mailtrap.io@mailtrap.com';
    const FROM_NAME = 'Mailtrap - Teste';

    /**
     * mensagem de erro do envio
     * @var string
     */
    private $error = '';

    /**
     * Método responsável por retornar a mensagem de erro do envio
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Método responsável por enviar um e-mail
     *
     * @param string|array $addresses
     * @param string $subject
     * @param string $body
     * @param string|array $attachments
     * @param string|array $css
     * @param string|array $bccs
     *
     * @return boolean
     */
    public function sendEmail($addresses, $subject, $body, $attachments = [], $css = [], $bccs = [])
    {
        /* limpa a mensagem de erro */
        $this->error = '';

        /* instância de PHPMAILER */
        $phpmailer = new PHPMailer(true);
        try {

            /* credenciais de acesso SMTP */
            $phpmailer->isSMTP(true);
            $phpmailer->Host = self::HOST;
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = self::SECURE;
            $phpmailer->Port = self::PORT;
            $phpmailer->Username = self::USER;
            $phpmailer->Password = self::PASS;
            $phpmailer->CharSet = self::CHARSET;

            /* remetente */
            $phpmailer->setFrom(self::FROM_EMAIL, self::FROM_NAME);

            /* destinatário(s) */
            $addresses = is_array($addresses) ? $addresses : [$addresses];
            foreach ($addresses as $address) {
                $phpmailer->addAddress($address);
            }

            /* anexo(s) */
            $attachments = is_array($attachments) ? $attachments : [$attachments];
            foreach ($attachments as $attachment) {
                $phpmailer->addAttachment($attachment);
            }

            /* cc */
            $css = is_array($css) ? $css : [$css];
            foreach ($css as $cc) {
                $phpmailer->addCC($cc);
            }

            /* bcc */
            $bccs = is_array($bccs) ? $bccs : [$bccs];
            foreach ($bccs as $bcc) {
                $phpmailer->addCC($bcc);
            }

            /* conteúdo do e-mail */
            $phpmailer->isHTML(true);
            $phpmailer->Subject = $subject;
            $phpmailer->Body = $body;

            /* envia o e-mail */
            return $phpmailer->send();

        } catch (PHPMailerException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}
