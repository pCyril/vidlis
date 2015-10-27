<?php

namespace Vidlis\UserBundle\Controller;

use FOS\UserBundle\Controller\ResettingController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResettingController extends BaseController
{
    public function sendEmailAction() {
        /** @var Request $request */
        $request = Request::createFromGlobals();
        if($request->isXmlHttpRequest()){

            $username = $request->request->get('username');
            /** @var $user UserInterface */
            $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
            if (null === $user) {
                return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:request.html.'.$this->getEngine(), array('invalid_username' => $username));
            }
            if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
                return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:passwordAlreadyRequested.html.'.$this->getEngine());
            }
            if (null === $user->getConfirmationToken()) {
                /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }
            $this->container->get('fos_user.mailer')->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->container->get('fos_user.user_manager')->updateUser($user);
            return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:checkEmail.html.'.$this->getEngine(), array(
                'email' => $username,
            ));
        }else{
            return parent::sendEmailAction($request);
        }
    }

    /**
     *
     * @param type $message
     * @param array $params
     * @return type
     */
    private function trans($message, array $params = array())
    {
        return $this->container->get('translator')->trans($message, $params, 'FOSUserBundle');
    }
}