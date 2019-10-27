<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Handler\UserHandler;
use App\Form\UserRegisterType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegistrationController extends AbstractController
{
	/**
	 * @var UserHandler
	 */
	private $userHandler;
	/**
	 * @var UserManager
	 */
	private $userManager;

	/**
	 * UserRegistrationController constructor.
	 *
	 * @param UserHandler $userHandler
	 * @param UserManager $userManager
	 */
	public function __construct(UserHandler $userHandler, UserManager $userManager)
	{

		$this->userHandler = $userHandler;
		$this->userManager = $userManager;
	}

	/**
	 * @Route("/registration", name="user_registration")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function register(Request $request)
	{
		$user = new User();
		$form = $this->createForm(UserRegisterType::class, $user);

		if($this->userHandler->process('new',$form, $request)) {
//			dd($request->request->all());
			return $this->redirectToRoute('waiting_for_confirmation');
		}
		return $this->render('user_registration/index.html.twig',  [
			'userRegisterForm' => $form->createView()
		]);
	}
    /*public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
    	$user = new User();
    	$form = $this->createForm(UserRegisterType::class, $user);
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {
			dd($form);
    		$data = $form->getData();
    		$password = $passwordEncoder->encodePassword($user,$data->getPassword());

    		$user->setPassword($password);
			$user->setRoles($user->getRoles());

    		$em = $this->getDoctrine()->getManager();
    		$em->persist($user);
    		$em->flush();

    		return $this->redirectToRoute('app_homepage');
	    }

        return $this->render('user_registration/index.html.twig', [
            'userRegisterForm' => $form->createView()
        ]);
    }*/

	/**
	 * Inform that a mail has been sent after registration
	 *
	 * @Route("/waiting-for-confirmation", name="waiting_for_confirmation")
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function confirm()
	{
		return $this->render('mail/confirm.html.twig');
	}
}
