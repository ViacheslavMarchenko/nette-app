<?php

declare(strict_types=1);

namespace App\Mail;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class MailFactory
{
    private $from = 'Five-Photos <info@five-photos.com>';
    
    public static function mailRequest($subject, $message){
        $self = new MailFactory();
        
        $mail = new Message;
        $mail->setFrom($self->from)
            ->addTo('julya.marchenko@gmail.com')
        	->setSubject($subject)
        	->setHtmlBody($message);

        try {
            $mailer = new \Nette\Mail\SendmailMailer;
            $mailer->send($mail);
        } catch (SendException $e) {
            Debugger::log($e, 'mailexception');
        }
    }
    
    public static function mailRessetPass($email, $subject, $message){
        $self = new MailFactory();
        
        $mail = new Message;
        $mail->setFrom($self->from)
            ->addTo($email)
        	->setSubject($subject)
        	->setHtmlBody($message);

        try {
            $mailer = new \Nette\Mail\SendmailMailer;
            $mailer->send($mail);
        } catch (SendException $e) {
            Debugger::log($e, 'mailexception');
        }
    }
}