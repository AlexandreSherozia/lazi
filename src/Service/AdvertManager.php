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

	public function insert(Advert $advert)
	{
		$advert->setAuthor($this->security->getToken()->getUser());
		$this->entityManager->persist($advert);
		$this->entityManager->flush();
	}
}