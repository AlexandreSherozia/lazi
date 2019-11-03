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
	 * @var AdvertManager
	 */
	private $advertManager;

	/**
	 * AdvertController constructor.
	 *
	 * @param AdvertRepository $advertRepository
	 * @param AdvertManager    $advertManager
	 */
	public function __construct(AdvertRepository $advertRepository, AdvertManager $advertManager)
	{
		$this->advertRepository = $advertRepository;
		$this->advertManager = $advertManager;
	}


	/**
	 * @param Request       $request
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @Route("/admin/create-advert", name="create_advert")
	 */
	public function makeMainAdvert(Request $request)
	{
		$form = $this->createForm(AdvertType::class, new Advert());

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$advertData = $form->getData();
			$this->advertManager->insert($advertData);

			$this->addFlash('success', $advertData->getTitle() .' a été créé avec succès !');

			return $this->redirectToRoute('app_homepage');
		}
		return $this->render('/forms/advert_create_edit.html.twig', [
			'advertForm' => $form->createView(),
			'create' => true,
		]);
	}

	/**
	 * @param Request $request
	 * @Route("/admin/edit-advert/{slug}", name="edit_advert")
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAdvert(Request $request, $slug)
	{
		$advert = $this->advertRepository->findOneBy(['slug'=>$slug]);
		$form = $this->createForm(AdvertType::class, $advert);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$advertData = $form->getData();
			$this->advertManager->insert($advertData);

			$this->addFlash('success', $advertData->getTitle() .' a été mis à jour avec succès !');

			return $this->redirectToRoute('app_homepage');
		}
		return $this->render('forms/advert_create_edit.html.twig', [
			'advertForm' => $form->createView(),
			'edit' => true
		]);
	}
}