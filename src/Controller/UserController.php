<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Handler\AdminHandler;
use App\Form\UserEditionFormType;
use App\Form\UserFormType;
use App\Service\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userManager;

    /**
     * UserController constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/utilisateur/modification/{id}/{by}", name="edit_user")
     * @param Request $request
     * @param User $user
     * @param string $by
     * @return \Symfony\Component\HttpFoundation\Response
     * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function editUser(Request $request, User $user, string $by)
    {
        //Selects appropriate formType according the User role
        $userFormType = 'admin' === $by ? UserFormType::class : UserEditionFormType::class;

        $userForm = $this->createForm($userFormType, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            /** @var User $user */
            $user = $userForm->getData();

            $this->userManager->create($user);
            return $this->redirectToRoute('user_profile', [
                'id' => $user->getId()
            ]);

        }

        return $this->render('user/editUser.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil-utilisateur/{id}", name="user_profile")
     * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function viewUserProfile(User $user)
    {
        return $this->render('user/userProfile.html.twig', [
            'user' => $user
        ]);
    }
}
