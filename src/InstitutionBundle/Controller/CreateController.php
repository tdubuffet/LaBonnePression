<?php

namespace InstitutionBundle\Controller;

use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Form\AssignCodeType;
use InstitutionBundle\Form\InstitutionCodeType;
use InstitutionBundle\Form\InstitutionType;
use InstitutionBundle\Form\SearchLocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/etablissement")
 * @Security("has_role('ROLE_USER')")
 */
class CreateController extends Controller
{
    /**
     * @Route("/code", name="institution_create_step_code")
     */
    public function assignCodeAction(Request $request)
    {
        $formCode = $this->createForm(AssignCodeType::class);

        $formCode->handleRequest($request);

        if($formCode->isValid() && $formCode->isSubmitted()) {

            $secretCode = $formCode->getData()->getSecretCode();

            $result = $this->getDoctrine()
                ->getRepository('InstitutionBundle:Institution')
                ->findOneBy([
                    'secretCode' => strtoupper($secretCode)
                ]);
        }


        return $this->render('InstitutionBundle:Create:assign-code.html.twig', [
            'code' => $formCode->createView(),
            'institution' => (isset($result)) ? $result : null
        ]);
    }

    /**
     * @Route("/code/{secretCode}", name="institution_create_step_2")
     * @ParamConverter("institution", class="InstitutionBundle:Institution", options={"secretCode" = "secretCode"})
     */
    public function editInformationContactAction(Request $request, Institution $institution)
    {

        $form = $this->createForm(InstitutionCodeType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $institution->setAccount($this->getUser());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('institution_create_step_modeation', [
                'slug' => $institution->getSlug()
            ]);
        }


        return $this->render('InstitutionBundle:Create:edit-institution.html.twig', [
            'institution' => $institution,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/moderation/{slug}", name="institution_create_step_modeation")
     * @ParamConverter("institution", class="InstitutionBundle:Institution", options={"slug" = "slug"})
     */
    public function moderationAction(Request $request, $institution)
    {
        return $this->render('InstitutionBundle:Create:moderation.html.twig', [
            'institution' => $institution
        ]);
    }
}
