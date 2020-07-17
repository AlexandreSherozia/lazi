<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 28/10/2019
 * Time: 01:18
 */

namespace App\Service;


use App\Entity\Advert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class AdvertManager
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var Security
	 */
	private $security;

	/**
	 * AdvertManager constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 * @param Security               $security
	 */
	public function __construct(EntityManagerInterface $entityManager, Security $security)
	{
		$this->entityManager = $entityManager;
		$this->security = $security;
	}

	public function insert(Advert $advertData)
	{
		$advertData->setAuthor($this->security->getToken()->getUser());
//		dd($advertData->getIsOnMainPage());
		$this->entityManager->persist($advertData);
		$this->entityManager->flush();
	}
}