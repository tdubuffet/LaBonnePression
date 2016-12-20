<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use FOS\UserBundle\Form\Type\UsernameFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\AccountType;

class DefaultController extends Controller
{


    /**
     * @Route("/mon-profil", name="account_edit")
     * @Template()
     */
    public function editAction(Request $request)
    {

        $user = $this->getUser();


        $account = $this->createForm(AccountType::class, $user);
        $account->handleRequest($request);

        if ($account->isValid() && $account->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush($user);

            $this->get('session')->getFlashBag()->add('success', 'Modification validée.');
        }

        $password = $this->createForm(ChangePasswordFormType::class, $user);
        $password->handleRequest($request);

        if ($password->isValid() && $password->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush($user);

            $this->get('session')->getFlashBag()->add('success', 'Changement du mot de passe validé. Merci de vous connecter avec votre mot de passe à la prochaine connexion.');
        }


        return [
            'account'   => $account->createView(),
            'password'  => $password->createView(),
        ];
    }


}
