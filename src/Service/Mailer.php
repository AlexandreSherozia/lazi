<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 23/04/2019
 * Time: 16:10
 */

namespace App\Service;

use App\Entity\Messenger;
use App\Entity\User;
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
	 * @param      $token
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
    public function sendEmail(Form $form, $token): void
    {
        $emailString = $form->getData()->getEmail();

        //"Objet :" field
        $message = new \Swift_Message('Hey, lazimate');

        //"De :" field
        $message->setFrom('sandrosherozia@gmail.com')
            ->setTo($emailString);

	    $message
		    ->setBody(
			    $this->templating->render(
				    'emailing/emailing_template_message.html.twig', [
				    	'user' => $form->getData(),
					    'token' => $token
				    ]
			    ),
			    'text/html'
		    );

        $this->swift_mailer->send($message);
    }

	public function sendEmailFormPasswordInitializer(User $user): void
	{
		$emailString = $user->getEmail();

		//"Objet :" field
		$message = new \Swift_Message('Forgotten password');

		//"De :" field
		$message->setFrom('sandrosherozia@gmail.com')
			->setTo($emailString);

		$message
			->setBody(
				$this->templating->render(
					'emailing/emailing_template_message.html.twig', [
						'user' => $user,
						'token' => $user->getToken()
					]
				),
				'text/html'
			);

		$this->swift_mailer->send($message);
	}
}