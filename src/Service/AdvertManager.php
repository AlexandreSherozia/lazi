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

class AdvertManager
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * AdvertManager constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function insert(Advert $advert)
	{
		$this->entityManager->persist($advert);
		$this->entityManager->flush();
	}
}