<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use App\Repository\ContactRepository;
use App\Repository\EnterpriseRepository;
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
	 * DefaultController constructor.
	 *
	 * @param AdvertRepository $advertRepository
	 */
	public function __construct(AdvertRepository $advertRepository)
    {
	    $this->advertRepository = $advertRepository;
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

	    $paginatation = $paginator->paginate(
		    $adverts, /* query NOT result */
		    $request->query->getInt('page', 1), /*page number*/
		    5 /*limit per page*/
	    );

        return $this->render('default/index.html.twig', [
            'adverts' => $paginatation,

        ]);
    }
}
