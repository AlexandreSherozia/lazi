<?php

namespace App\Form\Handler;

use App\Service\AvatarUploader;
use App\Service\Mailer;
use App\Service\UserManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class UserHandler
{
	protected $form,
		$request,
		$userManager,
		$imageUploader,
		$currentAvatar,
		$mailer;

	/**
	 * UserHandler constructor.
	 *
	 * @param UserManager $userManager
	 * @param AvatarUploader $avatarUploader
	 * @param Mailer $mailer
	 */
	public function __construct(UserManager $userManager,
		AvatarUploader $avatarUploader, Mailer $mailer)
	{
		$this->userManager = $userManager;
		$this->imageUploader = $avatarUploader;
		$this->mailer = $mailer;
	}

	/**
	 * Processing the user form
	 *
	 * @param string  $type purpose of the form
	 *                      (registration or edition of a user profile)
	 * @param Form    $form
	 * @param Request $request
	 *
	 * @return bool
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function process(string $type, Form $form, Request $request): bool
	{

		$this->currentAvatar = $form->getData()->getAvatar();
		$form->handleRequest($request);

//		dd($form->getData());
		if ($form->isSubmitted() /*&& $form->isValid()*/) {
			if ($type === 'new') {
				// the process is for a registration
				$token = $this->tokenizerForAccountValidation();
				$this->onSuccessNew($form, $token);
				$this->mailer->sendEmail($form, $token);

				return true;
			}
			if ($type === 'edit') {
				// the process is for edition
				$this->onSuccessEdit($form);

				return true;
			}
		}

		return false;
	}

	protected function onSuccessNew(Form $form, $token): void
	{
		$userFormData = $form->getData();
		$this->userManager->addNewUserToDb($userFormData, $token);
	}

	/**
	 *
	 * @param Form $form
	 */
	protected function onSuccessEdit(Form $form): void
	{
		$userFormData = $form->getData();

		if ($userFormData->getAvatar() === null) {
			$avatarName = $this->currentAvatar;

			if ($avatarName === null) {
				$avatarName = '';
			}

			$this->userManager->updateUserIntoDb($userFormData, $avatarName);
		} else {
			$avatar = new File($userFormData->getAvatar());
			$avatarName = $this->imageUploader->upload($avatar);
			$this->userManager->updateUserIntoDb($userFormData, $avatarName);
		}
	}

	public function tokenizerForAccountValidation(): string
	{
		return md5(uniqid('token', true));
	}
}
