<?php

namespace App\Controller;

use App\Repository\LoggerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoggerController extends AbstractController
{
    /**
     * @Route("/historique", name="logger")
     * @param Request $request
     * @param LoggerRepository $loggerRepository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request,LoggerRepository $loggerRepository, PaginatorInterface $paginator)
    {
        $logs = $loggerRepository->findAll();
        $pagination = $paginator->paginate(
            $logs, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('logger/logs.html.twig', [
            'history' => $pagination,
        ]);
    }
}
