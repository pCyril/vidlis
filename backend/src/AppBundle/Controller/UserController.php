<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlayedQuery;
use AppBundle\Entity\PlaylistQuery;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController
{
    /**
     * @Get("/user")
     *
     * @return array
     */
    public function getUserAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail()
        ];
    }

    /**
     * @Get("/user/played")
     *
     * @return array
     */
    public function getLastUserPlayedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playedQuery = new PlayedQuery($em);

        return $playedQuery->getLastPlayed(24, 0, $this->getUser());
    }

    /**
     * @Get("/user/playlists")
     *
     * @return array
     */
    public function getUserPlaylistsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $playlistRepository = $em->getRepository('AppBundle:Playlist');

        return $playlistRepository->findBy(['user' => $this->getUser()]);
    }

    /**
     * @Post("/registration")
     *
     * @param Request $request
     *
     * @return User
     */
    public function postUserRegistrationAction(Request $request)
    {
        /** @var UserManager $userManager */
        $userManager = $this->get('fos_user.user_manager');

        /** @var User $user */
        $user = $userManager->createUser();

        $user->setEmail($request->get('email'))
            ->setUsername($request->get('username'))
            ->setEnabled(true)
            ->setPlainPassword($request->get('password'));

        $userManager->updateUser($user);

        $em = $this->getDoctrine()->getManager();

        $em->flush();

        return $user;
    }
}
