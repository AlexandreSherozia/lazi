<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use App\Repository\ContactRepository;
use App\Repository\EnterpriseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function index()
    {
	    $adverts = $this->advertRepository->findAll();

        return $this->render('default/index.html.twig', [
            'adverts' => $adverts,

        ]);
    }
}
