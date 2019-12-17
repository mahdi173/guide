<?php


namespace App\Mailer;


use App\Entity\ContactForm;

class SendContactMail
{
    const CONTACT_MAIL  = 'contact@ioplume.com';

    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * SendContactMail constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(ContactForm $contact)
    {
        $body = <<<BODY
<html>
<head></head>

<body>
Bonjour, <br>

Il y'a un nouveau contact sur le site ioplume.com.<br>

Ci-dessous les informations du contact:<br>

Name: $contact->name<br>

Email: $contact->email<br>

Message: $contact->message <br>
</body>
</html>        

BODY;

        $message  = new \Swift_Message($contact->subject, $body, 'text/html', 'UTF-8');
        $message->setTo([self::CONTACT_MAIL]);
        try {
            $this->mailer->send($message);
        }catch (\Exception $exception) {
            throw $exception;
        }
    }
}
