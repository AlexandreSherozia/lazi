<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 23/04/2019
 * Time: 16:10
 */

namespace App\Service;

use App\Entity\Messenger;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Security;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Mailer
{
    private $templating;
    private $swift_mailer;
    private $connected_user;

    /**
     * Mailer constructor.
     * @param \Twig_Environment $templating
     * @param \Swift_Mailer $swift_mailer
     * @param Security $security
     */
    public function __construct(\Twig_Environment $templating, \Swift_Mailer $swift_mailer, Security $security)
    {
        $this->templating = $templating;
        $this->swift_mailer = $swift_mailer;
        $this->connected_user = $security->getUser();
    }

	/**
	 * @param Form $form
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
    public function sendEmail(Form $form, $token): void
    {
        $emailString = $form->getData()->getEmail();
//        $emailString = 'alexandresherozia@yahoo.fr';

	    // REGLER AVEC LES DONNEES VALIDES

        //"Objet :" field
        $message = new \Swift_Message('Hey, lazimate');

        //"De :" field
        $message->setFrom('sandrosherozia@gmail.com')
            ->setTo($emailString);

        $message
            ->setBody(
                $this->templating->render(
                    'emailing/emailing_template_message.html.twig',
                    array('content' => 'You\'ve registered with success, but you have to validate it' )
                ),
                'text/html'
            );

        $this->swift_mailer->send($message);
    }
}