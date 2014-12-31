<?php
namespace Symfotest\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $sesion = $request->getSession();

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } elseif (null != $sesion && $sesion->has(Security::AUTHENTICATION_ERROR)){
            $error = $sesion->get(Security::AUTHENTICATION_ERROR);
            $sesion->remove(Security::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        $lastUsername = (null === $sesion) ? '' : $sesion->get(Security::LAST_USERNAME);

        return $this->render(
            'AcmeSecurityBundle:Security:login.html.twig',
            array(
                'last_name' => $lastUsername,
                'error' => $error
            )
        );
    }
}