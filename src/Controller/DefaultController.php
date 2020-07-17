<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use App\Repository\ContactRepository;
use App\Repository\EnterpriseRepository;
use App\Repository\RouteRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{

	/**
	 * @var AdvertRepository
	 */
	private $advertRepository;
	/**
	 * @var RouteRepository
	 */
	private $routeRepository;

	/**
	 * DefaultController constructor.
	 *
	 * @param AdvertRepository $advertRepository
	 * @param RouteRepository  $routeRepository
	 */
	public function __construct(AdvertRepository $advertRepository, RouteRepository $routeRepository)
    {
	    $this->advertRepository = $advertRepository;
	    $this->routeRepository = $routeRepository;
    }

	/**
	 * @Route("/", name="app_homepage")
	 * @param Request            $request
	 * @param PaginatorInterface $paginator
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function index(Request $request, PaginatorInterface $paginator)
    {
	    $adverts = $this->advertRepository->findBy([],['createdAt'=>'DESC']);
	    $menuItems = $this->routeRepository->findAll();

	    $pagination = $paginator->paginate(
		    $adverts,
		    $request->query->getInt('page', 1),
		    5
	    );
        return $this->render('default/index.html.twig', [
            'adverts' => $pagination,
	        'menuItems' => $menuItems

        ]);
    }
}
