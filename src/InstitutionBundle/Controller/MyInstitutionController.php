<?php

namespace InstitutionBundle\Controller;

use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Form\InstitutionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/mes-etablissements")
 * @Security("has_role('ROLE_USER')")
 */
class MyInstitutionController extends Controller
{
    /**
     * @Route("", name="account_institutions")
     */
    public function listAction(Request $request)
    {

        return $this->render('InstitutionBundle:MyInstitution:list.html.twig', [
            'institutions' => $this->getUser()->getInstitutions()
        ]);
    }

    /**
     * @Route("/modification/{slug}", name="account_institution_edit")
     * @ParamConverter("institution", class="InstitutionBundle:Institution", options={"slug" = "slug"})
     */
    public function editAction(Request $request, Institution $institution)
    {


        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isValid()) {



        }



        return $this->render('InstitutionBundle:MyInstitution:edit.html.twig', [
            'institution'   => $institution,
            'form'          => $form->createView()
        ]);
    }
}
