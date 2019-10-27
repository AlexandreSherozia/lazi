<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Logger;
use App\Form\ContactCompleteType;
use App\Form\Handler\ContactHandler;
use App\Repository\ContactRepository;
use App\Service\LoggerManager;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    private $contactHandler;
    private $contactRepository;
    private $loggerManager;

    /**
     * ContactController constructor.
     * @param ContactHandler $contactHandler
     * @param ContactRepository $contactRepository
     * @param LoggerManager $loggerManager
     */
    public function __construct(ContactHandler $contactHandler,
                                ContactRepository $contactRepository,
                                LoggerManager $loggerManager)
    {
        $this->contactHandler = $contactHandler;
        $this->contactRepository = $contactRepository;
        $this->loggerManager = $loggerManager;
    }

    /**
     * This route is used when creating contact from Admin panel, not while entreprise creation
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/contact/creation", name="create_contact")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function createContactFromScratch(Request $request)
    {

        $form = $this->createForm(ContactCompleteType::class, new Contact());

        if ($this->contactHandler->handle($form, $request)) {

            $this->addFlash('success', 'Le contact "' .$form->getData()->getPrenom() . ' ' . $form->getData()->getNom() .'" a bien été créé !');
            $this->loggerManager->log('Contact',$form->getData()->getPrenom() . ' ' . $form->getData()->getNom(),'Création');

            return $this->redirectToRoute('show_contact', [
                'id' => $form->getData()->getId(),
                'entreprise' => 'inconnue',
            ]);
        }

        return $this->render('forms/contactEdition.html.twig', [
            'contactForm' => $form->createView(),
            'action' => 'creation',
        ]);
    }

    /**
     * @param Request $request
     * @param string $entreprise
     * @param Contact $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/entreprise-{entreprise}/contact{id}/modification", name="edit_contact")
     * @IsGranted("ROLE_ADMIN", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function editContact(Request $request, string $entreprise, Contact $id)
    {
        $contact = $id;
        $syndicatContacts= new ArrayCollection();
        $commissionContacts= new ArrayCollection();
        $contactConseilAdmins= new ArrayCollection();

        foreach ( $id->getSyndicatContacts() as $syndicatContact ) {
            $syndicatContacts->add(clone $syndicatContact);
        }
        foreach ( $id->getCommissionsContacts() as $commissionsContact ) {
            $commissionContacts->add(clone $commissionsContact);
        }
        foreach ( $id->getContactConseilAdministrations() as $contactConseilAdmin ) {
            $contactConseilAdmins->add(clone $contactConseilAdmin);
        }
        $form = $this->createForm(ContactCompleteType::class, $contact);

        if ($this->contactHandler->handle($form, $request, $syndicatContacts, $commissionContacts, $contactConseilAdmins)) {

            $this->addFlash('success', 'Le contact "' .$form->getData()->getPrenom() . ' ' . $form->getData()->getNom() .'" a bien été modifié !');
            $this->loggerManager->log('Contact',$form->getData()->getPrenom() . ' ' . $form->getData()->getNom(),'Modification');

            return $this->redirectToRoute('show_contact', [
                'entreprise'=> $entreprise,
                'id' => $id->getId()
            ]);
        }
        return $this->render('forms/contactEdition.html.twig', [
            'contactForm' => $form->createView(),
            'entreprise' => $entreprise,
            'action' => 'edition',
            'contact' => $contact,
            'contactData' => $contact->getPrenom().' ' .$contact->getNom(),
        ]);
    }


    /**
     * @param string $entreprise
     * @param Contact $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/entreprise-{entreprise}/contact{id}/consultation", name="show_contact")
     * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function showContact(string $entreprise, Contact $id): Response
    {
        return $this->render('contact/showContact.html.twig', [
            'contact' => $id,
            'entreprise' => $entreprise
        ]);
    }

    /**
     * @Route("/contacts/liste", name="list_contacts")
     * @return \Symfony\Component\HttpFoundation\Response
     * @IsGranted("ROLE_USER", message="Vous n'avez pas l'autorisation pour cette action !")
     */
    public function listContacts(): Response
    {
        $contacts = $this->contactRepository->findAllWithEntreprise();

        return $this->render('contact/contactsList.html.twig', [
            'contacts' => $contacts
        ]);
    }


    /*public function getRefererRoute(Request $request)
    {
        //look for the referer route
        $referer = $request->headers->get('referer');
        $lastPath = substr($referer, strpos($referer, $request->getBaseUrl()));
        $lastPath = str_replace($request->getBaseUrl(), '', $lastPath);

        $matcher = $this->get('router')->getMatcher();
        $parameters = $matcher->match($lastPath);
        $route = $parameters['_route'];

        return $route;
    }*/

}
