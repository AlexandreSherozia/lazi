<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 04/03/2019
 * Time: 15:28
 */

namespace App\Form\Handler;


use App\Service\DepartmentManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class DepartmentHandler
{
    /**
     * @var DepartmentManager
     */
    private $departmentManager;


    /**
     * DepartmentHandler constructor.
     * @param DepartmentManager $departmentManager
     */
    public function __construct(DepartmentManager $departmentManager)
    {
        $this->departmentManager = $departmentManager;
    }

    public function handle(Form $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $department = $form->getData();

            $this->departmentManager->create($department);
            return true;
        }
        return false;
    }
}