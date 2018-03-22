<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils) {

        $flashbag = $this->get('session')->getFlashBag();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($errors = $authenticationUtils->getLastAuthenticationError()) {
            $flashbag->add(
                    'flash_errors', $errors->getMessageKey()
            );
        }

        return $this->render('@App/Login/login.html.twig', array(
                    "username" => $lastUsername
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        $flashbag = $this->get('session')->getFlashBag();
        $this->addFlash(
                'flash_infos', 'You were logged out.'
        );
    }

}
