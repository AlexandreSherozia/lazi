<?php

namespace App\Controller;

use App\Entity\Messenger;
use App\Form\MessengerType;
use App\Repository\ContactRepository;
use App\Repository\MessengerRepository;
use App\Service\Mailer;
use App\Service\MessengerManager;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MailController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas l'autorisation pour cette action !")
 */
class MailController extends AbstractController
{
    private $mailer;
    private $messengerManager;
    private $selectedEmails;
    private $stringifiedEmails;

    /**
     * MailController constructor.
     * @param Mailer $mailer
     * @param MessengerManager $messengerManager
     */
    public function __construct(Mailer $mailer, MessengerManager $messengerManager)
    {
        $this->mailer = $mailer;
        $this->messengerManager = $messengerManager;
    }

    /**
     * @Route("/ffcb-emailing", name="send_email")
     * @param Request $request
     * @param MessengerRepository $messengerRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmail(Request $request, MessengerRepository $messengerRepository): \Symfony\Component\HttpFoundation\Response
    {
        if ($request->request->get('selected_fields')) {

            $this->selectedEmails = array_keys($request->request->get('selected_fields'));
            $this->stringifiedEmails = implode($this->selectedEmails, ' ');
        }
        $form = $this->createForm(MessengerType::class, new Messenger(), [
            'stringifiedEmails' => $this->stringifiedEmails
        ]);
        $messenger = $form->getData();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $this->mailer->sendEmail($messenger, );

            $this->messengerManager->execute($messenger);
            $this->addFlash('success', 'Le mail a été envoyé avec succès !');

            return $this->redirectToRoute('send_email');
        }
        $modelsCount = \count($messengerRepository->findBy(['isDraft' => true]));

        return $this->render('emailing/email_form.html.twig', [
            'messengerForm' => $form->createView(),
            'modelsList' => $messengerRepository->findBy(['isDraft' => true]),
            'modelsListCount' => $modelsCount,
            'models' => 'creation',
        ]);
    }

    /**
     * @param Request $request
     * @param MessengerRepository $messengerRepository
     * @param $header
     * @param $content
     * @return JsonResponse
     * @Route("/ffcb/emailing/record-model/{header}/{content}")
     */
    public function recordEmailModel(Request $request, MessengerRepository $messengerRepository, $header, $content): JsonResponse
    {
        if (($header || $content) && $request->isXmlHttpRequest()) {

            $form = $this->createForm(MessengerType::class, new Messenger());
            $messenger = $form->getData();
            $form->handleRequest($request);

            $this->messengerManager->execute($messenger, $header, $content);

            $countModels = \count($messengerRepository->findBy(['isDraft' => true]));

            return new JsonResponse(
                [
                    'status' => 'ok',
                    'countModels' => $countModels,
                ],
                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @param Request $request
     * @param MessengerRepository $messengerRepository
     * @param $id
     * @return JsonResponse
     * @Route("/delete-model/{id}", name="record_email_model")
     */
    public function deleteEmailModel(Request $request, MessengerRepository $messengerRepository, $id): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {

            $model = $messengerRepository->find($id);

            if ($model) {
                $this->messengerManager->delete($model);
            }

            $countModels = \count($messengerRepository->findBy(['isDraft' => true]));

            return new JsonResponse(
                [
                    'status' => 'ok',
                    'countModels' => $countModels,
                    'modelClass' => $id,
                ],
                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @param Request $request
     * @param MessengerRepository $messengerRepository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/historique-envois", name="emailing_history")
     */
    public function history(Request $request, MessengerRepository $messengerRepository, PaginatorInterface $paginator): \Symfony\Component\HttpFoundation\Response
    {
        $referer = $request->headers->get('referer');
//        dd($referer);
        $drafts = $messengerRepository->findBy(['isDraft' => false]);
//        dd($drafts);
        $pagination = $paginator->paginate(
            $drafts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        $countModels = \count($messengerRepository->findBy(['isDraft' => true]));

        return $this->render('emailing/email_form.html.twig', [
            'modelsList' => $pagination,
            'models' => 'history',
            'modelsListCount' => $countModels,
            'http_referer' => $referer,
        ]);
    }


    /**
     * @param Request $request
     * @param ContactRepository $contactRepository
     * @param string suggestion
     * @return JsonResponse
     * @Route("/ajax-request-email/{suggestion}")
     */
    public function autocompleteEmailsForSending(Request $request,
                                                 ContactRepository $contactRepository,
                                                 string $suggestion): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {

            $contact = $contactRepository->findEmailContainingString($suggestion);

            /*$contacts = [];

            $contacts['email'] = $contact->getEmailContact();*/
            return new JsonResponse($contact->getEmailContact());
        }
    }
}
