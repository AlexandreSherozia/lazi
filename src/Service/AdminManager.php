<?php


namespace App\Service;


use App\Entity\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class AdminManager
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * AdminManager constructor.
	 *
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function addMenu(Route $route)
	{
//		dd($route);
		$routeName = str_replace(' ','_',$route->getName());//et enlever tous les cractères spéciaux
		$pathParams = str_replace(' ','-', $route->getName());
		$route->setRoute($pathParams);
		$route->setRouteName($routeName);
		$this->entityManager->persist($route);
		$this->entityManager->flush();
	}
}