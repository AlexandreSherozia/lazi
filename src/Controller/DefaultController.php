<?php

namespace App\Controller;

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
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * DefaultController constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {

        $contactsStats = $this->contactRepository->getContactStats();

        return $this->render('default/index.html.twig', [
            'contactStats' => $contactsStats,

        ]);
    }
}
