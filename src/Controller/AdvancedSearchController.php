<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Cotisation;
use App\Entity\Entreprise;
use App\Entity\Syndicat;
use App\Form\AdvancedSearchType;
use App\Form\SearchCriteriaType;
use App\Form\SearchCriteriumType;
use App\Model\Search\AdvancedSearch;
use App\Model\Search\SearchCriteria;
use App\Repository\ContactRepository;
use App\Repository\CotisationRepository;
use App\Service\QueryStringBuilder;
use phpDocumentor\Reflection\Types\String_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdvancedSearchController
 * @package App\Controller
 * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
 */
class AdvancedSearchController extends AbstractController
{
    private $results;
    private $searchCriterion;
    private $memberShipStatus = [];
    private $etablissements;
    private $queryString;

    /**
     * @Route("/recherche-avancee/{entity}", name="advanced_search")
     * @param Request $request
     * @param string $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function advancedSearch(Request $request, string $entity): Response
    {
        $advancedSearchForm = $this->createForm(AdvancedSearchType::class, new AdvancedSearch(), [
            'entityFormType' => $entity,
        ]);
        $advancedSearchForm->handleRequest($request);

        $forEmailSending = $request->request->get('for_email');
        $forSmsSending = $request->request->get('for_sms');
        $sendingRouteName = $forEmailSending === 'on' ? 'send_email' : 'send_sms';

        if ($advancedSearchForm->isSubmitted() && $advancedSearchForm->isValid()) {

            $this->searchCriterion = $advancedSearchForm->getData();

            $class = 'App\Entity' .'\\' .\ucfirst($entity);

            $repository = $this->getDoctrine()->getRepository($class);

            $this->results = $repository->retrieveAllData($this->searchCriterion, $forEmailSending, $forSmsSending);

            if ('entreprise' === $entity) {
                $this->etablissements = $repository->extractEtablissementsFromExistingQuery($this->results);
            }

            $this->redirectToRoute('advanced_search', [
                'advancedSearchForm' => $advancedSearchForm->createView(),
                'entity' => $entity,
                'etablissements' => $this->etablissements,
                'advancedSearchResults' => $this->results,
                'etatAdhesions' => $this->memberShipStatus,
                'forEmailSending' => $forEmailSending,
                'forSmsSending' => $forSmsSending,
                'formRouteName' => $sendingRouteName,
            ]);
        }
        return $this->render('advanced_search/advanced_search.html.twig', [
            'advancedSearchForm' => $advancedSearchForm->createView(),
            'entity' => $entity,
            'etablissements' => $this->etablissements,
            'advancedSearchResults' => $this->results,
            'etatAdhesions' => $this->memberShipStatus,
            'forEmailSending' => $forEmailSending,
            'forSmsSending' => $forSmsSending,
            'formRouteName' => $sendingRouteName,
        ]);
    }

    /*public function advancedSearch(Request $request, string $entity, $breadCrumb): Response
    {
        if ($breadCrumb===1) {
            $string = current($request->server)['QUERY_STRING'];
            dd($string);
        }
        $advancedSearchForm = $this->createForm(AdvancedSearchType::class, new AdvancedSearch(), [
            'entityFormType' => $entity,
            'action' => $this->generateUrl('advanced_search', [
                'entity' => $entity,
            ])
        ]);
        $advancedSearchForm->handleRequest($request);

        $forEmailSending = $request->request->get('for_email');
        $forSmsSending = $request->request->get('for_sms');
        $sendingRouteName = $forEmailSending === 'on' ? 'send_email' : 'send_sms';

        if ($advancedSearchForm->isSubmitted() && $advancedSearchForm->isValid()) {

            $this->searchCriterion = $advancedSearchForm->getData();

            $class = 'App\Entity' .'\\' .\ucfirst($entity);

            $repository = $this->getDoctrine()->getRepository($class);

            $this->results = $repository->retrieveAllData($this->searchCriterion, $forEmailSending, $forSmsSending);

            if ('entreprise' === $entity) {
                $this->etablissements = $repository->extractEtablissementsFromExistingQuery($this->results);
            }
            $params = $request->request->all()['advanced_search']['searchCriteria'];
            $queryString = '';
            foreach ($params as $parameter) {

                $queryString .= '/+entity=' .$parameter['entity'] . '&field=' . $parameter['field'] . '&value=' . $parameter['term'] ;
            }
            $this->queryString = urlencode($queryString);

            $this->redirectToRoute('advanced_search', [
                'advancedSearchForm' => $advancedSearchForm->createView(),
                'entity' => $entity,
                'breadCrumb'=>false,
                'queryString' => $this->queryString,
                'etablissements' => $this->etablissements,
                'advancedSearchResults' => $this->results,
                'etatAdhesions' => $this->memberShipStatus,
                'forEmailSending' => $forEmailSending,
                'forSmsSending' => $forSmsSending,
                'formRouteName' => $sendingRouteName,
            ]);
        }
        return $this->render('advanced_search/advanced_search.html.twig', [
            'advancedSearchForm' => $advancedSearchForm->createView(),
            'entity' => $entity,
            'breadCrumb'=>false,
            'queryString' => $this->queryString,
            'etablissements' => $this->etablissements,
            'advancedSearchResults' => $this->results,
            'etatAdhesions' => $this->memberShipStatus,
            'forEmailSending' => $forEmailSending,
            'forSmsSending' => $forSmsSending,
            'formRouteName' => $sendingRouteName,
        ]);
    }*/

    // BEFORE ADVANCED SEARCH IS SUBMITTED
    /**
     * @param Request $request
     * @return Response
     * @Route("searchCriteria/corresponding-fields", name="corresponding-field-select")
     */
    public function getCorrespondingFieldSelect(Request $request): Response
    {
        $searchCriteria = new SearchCriteria();
        $searchCriteria->setEntity($request->query->get('entity'));

        $form = $this->createForm(SearchCriteriumType::class, $searchCriteria);

        if (!$form->has('field')) {
            return new Response(null,200);
        }
        return $this->render('advanced_search/field.html.twig', [
            'advancedSearch' => $form->createView()
        ]);
    }
}
