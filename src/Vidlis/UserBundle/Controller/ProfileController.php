<?php

namespace Vidlis\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\PlayedQuery;


class ProfileController extends BaseController
{
    /**
     * Show the user
     * @Template()
     */
    public function showAction()
    {
        /** @var Request $request */
        $request = Request::createFromGlobals();
        $data = [];
        $data['title'] = 'You profile';
        if ($request->isXmlHttpRequest()) {
            /** @var TimedTwigEngine $templating */
            $data['content'] = $this->container->get('templating')->render('VidlisUserBundle:Profile:show_content.html.twig', $this->showContentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $data;
    }

    /**
     * @Template("VidlisUserBundle:Profile:show_content.html.twig")
     */
    public function showContentAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $data = ['connected' => false];

            return $data;
        }

        $em = $this->container->get('doctrine')->getManager();
        $playedQuery = new PlayedQuery($em);
        $videosPlayed = $playedQuery->getLastPlayed(24, $user);
        $data = ['user' => $user, 'connected' => true, 'videosPlayed' => $videosPlayed];

        return $data;
    }

    /**
     * Edit the user
     */
    public function editAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('fos_user_success', 'profile.flash.updated');

            return new RedirectResponse($this->getRedirectionUrl($user));
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }

    /**
     * Generate the redirection url when editing is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('fos_user_profile_show');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
