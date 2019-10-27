<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 28/01/2019
 * Time: 11:38
 */

namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    private $entityManager;
    private $passwordEncoder;
    private $flashBag;
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * UserManager constructor.
	 *
	 * @param EntityManagerInterface       $entityManager
	 * @param UserPasswordEncoderInterface $passwordEncoder
	 * @param FlashBagInterface            $flashBag
	 * @param UserRepository               $userRepository
	 */
    public function __construct(EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                FlashBagInterface $flashBag, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashBag = $flashBag;
	    $this->userRepository = $userRepository;
    }

    public function create(User $user)
    {
        $this->flashBag->add('success',  $user->getFirstName() . ' ' . $user->getLastName() .' a bien été enregistré !');
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

	/**
	 * @param User   $user
	 * @param string $token
	 *
	 * @return User
	 */
	public function addNewUserToDb(User $user, string $token): User
	{
		$user->setPassword(
			$this->passwordEncoder->encodePassword($user, $user->getPassword())
		);
		$user->setToken($token);
		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return $user;
	}

	public function updateUserIntoDb(User $user, string $imageName): void
	{
		$user->setAvatar($imageName);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}

	public function removeUser(User $user_id): void
	{
		$this->entityManager->remove($user_id);
		$this->entityManager->flush();
	}
}