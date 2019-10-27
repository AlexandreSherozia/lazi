<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 20/02/2019
 * Time: 01:10
 */

namespace App\Form\Handler;


use App\Entity\Syndicat;
use App\Service\SyndicatManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SyndicatHandler
{
    private $syndicatManager;

    /**
     * SyndicatHandler constructor.
     * @param SyndicatManager $syndicatManager
     */
    public function __construct(SyndicatManager $syndicatManager)
    {
        $this->syndicatManager = $syndicatManager;
    }

    /**
     * @param Form $form
     * @param Request $request
     * @return bool
     */
    public function handle(Form $form, Request $request): bool
    {
        /** @var Syndicat $syndicat */
        $syndicat = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->syndicatManager->create($syndicat);
            return true;
        }

        return false;
    }
}