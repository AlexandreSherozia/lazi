<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 18/12/2019
 * Time: 20:02
 */

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

	/**
	 * Checks the user account before authentication.
	 *
	 * @throws AccountStatusException
	 */
	public function checkPreAuth(UserInterface $user)
	{
		//add some customized restrictions
		if (!$user instanceof User) {
			return;
		}

		if (!$user->isEnabled()) {
			throw new \RuntimeException('Sorry, you have not yet activated your account !');
		}
	}

	/**
	 * Checks the user account after authentication.
	 *
	 * @throws AccountStatusException
	 */
	public function checkPostAuth(UserInterface $user)
	{
		// TODO: Implement checkPostAuth() method.
	}
}