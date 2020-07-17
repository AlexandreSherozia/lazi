<?php

namespace App\Controller;

use App\Entity\Route as RouteAlias;
use App\Form\RouteType;
use App\Repository\RouteRepository;
use App\Service\AdminManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
	/**
	 * @var AdminManager
	 */
	private $adminManager;
	/**
	 * @var RouteRepository
	 */
	private $routeRepository;

	/**
	 * AdminController constructor.
	 *
	 * @param AdminManager    $adminManager
	 * @param RouteRepository $routeRepository
	 */
	public function __construct(AdminManager $adminManager, RouteRepository $routeRepository)
	{
		$this->adminManager = $adminManager;
		$this->routeRepository = $routeRepository;
	}

	/**
	 * @Route("/admin/add-menu-item", name="add_menu_item")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function index(Request $request)
    {
		$newRoute = new RouteAlias();
		$form = $this->createForm(RouteType::class, $newRoute);

		$form->handleRequest($request);

		$menuItems = $this->routeRepository->findAll();
		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			$this->adminManager->addMenu($data);

			return $this->redirectToRoute('create_advert');
		}
        return $this->render('admin/index.html.twig', [
            'routeForm' => $form->createView(),
	        'menuItems' => $menuItems,
	        'create' => true,
        ]);
    }
}
