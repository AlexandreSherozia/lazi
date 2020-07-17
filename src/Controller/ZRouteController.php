<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Handler\UserHandler;
use App\Form\UserRegisterType;
use App\Repository\RouteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function array_key_exists;

class ZRouteController extends AbstractController
{
	/**
	 * @param                     $route
	 * @param RouteRepository     $routeRepository
	 * @param PaginatorInterface  $paginator
	 * @param Request             $request
	 *
	 * @return Response
	 * @Route("/{route}", name="{route}")
	 */
    public function index($route, RouteRepository $routeRepository, PaginatorInterface $paginator, Request $request)
    {
	    $loadedRoute = $routeRepository->findOneBy(['route' => $route]);
	    $menuItems = $routeRepository->findAll();

	    $advertPersistentColl = $loadedRoute ? $loadedRoute->getAdverts() : null;
	    $adverts = $advertPersistentColl ? $advertPersistentColl->getValues() : null;

	    $pagination = $paginator->paginate(
		    $adverts,
		    $request->query->getInt('page', 1),
		    5
	    );

        return $this->render('route/index.html.twig', [
            'route' => $loadedRoute,
            'menuItems' => $menuItems,
	        'adverts' => $pagination,
        ]);
    }


}
