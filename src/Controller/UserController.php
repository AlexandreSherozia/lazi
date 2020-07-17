<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Handler\AdminHandler;
use App\Form\UserEditionFormType;
use App\Form\UserFormType;
use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use App\Service\AvatarUploader;
use App\Service\Mailer;
use App\Service\UserManager;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userManager;
	private $avatarUploader;
	private $userRepository;
	private $currentAvatar;

	/**
	 * UserController constructor.
	 *
	 * @param UserManager    $userManager
	 * @param AvatarUploader $avatarUploader
	 * @param UserRepository $userRepository
	 */
    public function __construct(UserManager $userManager, AvatarUploader $avatarUploader, UserRepository $userRepository)
    {
        $this->userManager = $userManager;
	    $this->avatarUploader = $avatarUploader;
	    $this->userRepository = $userRepository;
    }

	/**
	 * @Route("/utilisateur/modification/{slug}", name="edit_user")
	 * @param Request         $request
	 * @param RouteRepository $routeRepository
	 * @param string          $slug
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
	 */
    public function editUser(Request $request,RouteRepository $routeRepository, string $slug)
    {
    	$user = $this->userRepository->findOneBy(['slug' => $slug]);
    	$routes = $routeRepository->findAll();

    	$this->currentAvatar = $user->getAvatar() ?? '';

        $userForm = $this->createForm(UserEditionFormType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            /** @var User $user */
            $user = $userForm->getData();

            if (null === $user->getAvatar()) {
	            $avatarName = $this->currentAvatar;

            } else {
	            $avatar = new File($user->getAvatar());
	            $avatarName = $this->avatarUploader->upload($avatar);
            }
            $this->userManager->create($user, $avatarName);

            return $this->redirectToRoute('edit_user', [
                'slug' => $user->getSlug(),
	            'user' => $user
            ]);
        }
        return $this->render('user/editUser.html.twig', [
            'userForm' => $userForm->createView(),
	        'user' => $user,
	        'menuItems' => $routes
        ]);
    }

	/**
	 * @Route("/send-email-for-password-initializer", name="send_email_for_password_initializer")
	 * @param Request $request
	 *
	 * @param Mailer  $mailer
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function sendEmailFromPasswordInitializer(Request $request,Mailer $mailer)
    {
    	if ($request->request->get('submit_button')) {

    		$email = $request->request->get('email');
    		$user = $this->userRepository->findOneBy(['email' => $email]);

    		if ($user) {

			    $mailer->sendEmailFormPasswordInitializer($user);
			    return $this->redirectToRoute('waiting_for_confirmation',[
			    	'token' => $user->getToken(),
				    'initialize' => true
			    ]);
		    }
		    $this->addFlash('error', 'Désolé, "' .$email . '" nous est inconnu');
		    return $this->redirectToRoute('send_email_for_password_initializer');

	    }
        return $this->render('user/initializePassword.html.twig');
    }

	/**
	 * @Route("/initialize-password", name="initialize_password")
	 * @param Request $request
	 */
    public function initializePassword(Request $request)
    {

    }
}
