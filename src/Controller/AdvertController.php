<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/10/2019
 * Time: 22:59
 */

namespace App\Controller;


use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use App\Service\AdvertManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdvertController
 * @package App\Controller
 */
class AdvertController extends AbstractController
{
	/**
	 * @var AdvertRepository
	 */
	private $advertRepository;

	/**
	 * AdvertController constructor.
	 *
	 * @param AdvertRepository $advertRepository
	 */
	public function __construct(AdvertRepository $advertRepository)
	{
		$this->advertRepository = $advertRepository;
	}


	/**
	 * @param Request       $request
	 * @param AdvertManager $advertManager
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Route("/admin/create-advert", name="create_advert")
	 */
	public function makeMainAdvert(Request $request, AdvertManager $advertManager)
	{
		$form = $this->createForm(AdvertType::class, new Advert());

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$advert = $form->getData();
			$advertManager->insert($advert);

			return $this->redirectToRoute('app_homepage');
		}
		return $this->render('/forms/advert_create_edit.html.twig', [
			'advertForm' => $form->createView(),
		]);
	}
}