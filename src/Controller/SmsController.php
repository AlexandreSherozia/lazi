<?php

namespace App\Controller;

use App\Entity\SmsApiParams;
use App\Entity\SmsSender;
use App\Form\SmsApiParamFormType;
use App\Form\SmsSenderFormType;
use App\Repository\SmsApiParamsRepository;
use App\Repository\SmsSenderRepository;
use App\Service\SmsApiParamsManager;
use App\Service\SmsSenderManager;
use App\Service\SmsSenderService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
    private $selectedNumbers;
    private $stringifiedNumbers;
    private $smsSenderManager;
    private $smsSenderRepository;

    /**
     * SmsController constructor.
     * @param SmsSenderManager $smsSenderManager
     * @param SmsSenderRepository $smsSenderRepository
     */
    public function __construct(SmsSenderManager $smsSenderManager, SmsSenderRepository $smsSenderRepository)
    {
        $this->smsSenderManager = $smsSenderManager;
        $this->smsSenderRepository = $smsSenderRepository;
    }

    /**
     * @Route("/ffcb-envoi-sms/{sendingResults}", name="send_sms")
     * @param Request $request
     * @param SmsSenderService $senderService
     * @param $sendingResults
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendSms(Request $request, SmsSenderService $senderService, $sendingResults = null): \Symfony\Component\HttpFoundation\Response
    {
        //Retrieves the field which has the name attribute "selected_fields"
        if ($request->request->get('selected_fields')) {

            $this->selectedNumbers = array_keys($request->request->get('selected_fields'));
            $this->stringifiedNumbers = implode($this->selectedNumbers, ',');

        }

        $form = $this->createForm(SmsSenderFormType::class, new SmsSender(), [
            'stringifiedNumbers' => $this->stringifiedNumbers
        ]);

        /** @var SmsSender $smsSender */
        $smsSender = $form->getData();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sendingResults = $senderService->sendSms($smsSender);

            $jsonResults = json_encode($sendingResults);
//            dd($sendingResults);

            //Each sending is logged (history)
            $this->smsSenderManager->execute($smsSender);

            return $this->redirectToRoute('send_sms', [
                'sendingResults' => $jsonResults
            ]);
        }
        $modelsCount = \count($this->smsSenderRepository->findBy(['isDraft' => true]));
        $decodedResults = json_decode($sendingResults);

        return $this->render('sms/smsForm.html.twig', [
            'smsForm' => $form->createView(),
            'models' => 'creation',
            'modelsListCount' => $modelsCount,
            'sendingResults' => $decodedResults,
            'modelsList' => $this->smsSenderRepository->findBy(['isDraft' => true])
        ]);
    }


    /**
     * @param Request $request
     * @param $content
     * @return JsonResponse
     * @Route("/sms/record-model/{content}")
     */
    public function recordEmailModel(Request $request, $content): JsonResponse
    {
        if ($content && $request->isXmlHttpRequest()) {

            $form = $this->createForm(SmsSenderFormType::class, new SmsSender());
            $smsSender = $form->getData();
            $form->handleRequest($request);

            $this->smsSenderManager->execute($smsSender, $content);

            $countModels = \count($this->smsSenderRepository->findBy(['isDraft' => true]));

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
     * @param $id
     * @return JsonResponse
     * @Route("/delete-sms-model/{id}")
     */
    public function deleteEmailModel(Request $request, $id): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {

            $model = $this->smsSenderRepository->find($id);

            if ($model) {
                $this->smsSenderManager->delete($model);
            }

            $countModels = \count($this->smsSenderRepository->findBy(['isDraft' => true]));

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
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/historique-sms", name="sms_sending_history")
     */
    public function history(Request $request, PaginatorInterface $paginator): \Symfony\Component\HttpFoundation\Response
    {
        $referer = $request->headers->get('referer');

        $drafts = $this->smsSenderRepository->findBy(['isDraft' => false]);

        $pagination = $paginator->paginate(
            $drafts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        $countModels = \count($this->smsSenderRepository->findBy(['isDraft' => true]));

        return $this->render('sms/smsForm.html.twig', [
            'modelsList' => $pagination,
            'models' => 'history',
            'modelsListCount' => $countModels,
            'http_referer' => $referer,
        ]);
    }

    /**
     * @param Request $request
     * @param int $objectById
     * @param SmsApiParamsRepository $apiParamsRepository
     * @param SmsApiParamsManager $smsApiParamsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/OVH/api-sms/configurations-des-parametres/{objectById}", name="configure_parameters")
     */
    public function configureSmsApiParameters(Request $request,$objectById,SmsApiParamsRepository $apiParamsRepository,SmsApiParamsManager $smsApiParamsManager)
    {
        $objectById = (int)$objectById;
        //We'll only have the unique smsApiParameter object having the ID 1(including 4 obligatory fields), even if it's modified via URL.
        if (1 !== $objectById) {
            return $this->redirectToRoute('configure_parameters', [
                'objectById' => 1
            ]);
        }
        $smsParam = $apiParamsRepository->find($objectById);

        $form = $this->createForm(SmsApiParamFormType::class, $smsParam);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $smsApi = $form->getData();
            $smsApiParamsManager->execute($smsApi);

            $this->addFlash('success', 'Les paramètres ont été modifiés avec succès !');
            //by default returns at the same form page
        }
        return $this->render('sms/smsApiParametersForm.html.twig', [
            'smsParamsForm' => $form->createView(),

        ]);
    }
}
