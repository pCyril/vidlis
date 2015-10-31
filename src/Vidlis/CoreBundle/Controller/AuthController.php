<?php
namespace Vidlis\CoreBundle\Controller;

use FOS\UserBundle\FOSUserBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Vidlis\CoreBundle\GoogleApi\Client;
use Vidlis\UserBundle\Entity\User;

/**
 * Class AuthController
 *
 * Manage Youtube Connexion
 */
class AuthController extends Controller
{

    /** @var  Client */
    protected $client;

    /**
     * GET youtube connextion token
     * @Route("/authconfirmation", name="_youtubeauthentication")
     */
    public function authAction()
    {
        $this->initialize();
        
        $data = [];
        $auth = 'false';
        $session = $this->getRequest()->getSession();
        
        if ($this->getRequest()->query->get('code')) {
            if (strval($session->get('stateYoutube')) !== strval($this->getRequest()->query->get('state'))) {
                die('The session state did not match.');
            }

            $this->client->authenticate();
            $session->set('token', $this->client->getAccessToken());
            $auth = 'true';
        }

        if ($session->get('token')) {
          $this->client->setAccessToken($session->get('token'));
        }
        
        $data['auth'] = $auth;

        return $this->render('VidlisCoreBundle:Auth:auth.html.twig', $data);
    }

    /**
     * Init YoutubeAuthentication Token
     */
    public function initialize()
    {
        $OAUTH2_CLIENT_ID = $this->container->getParameter('OAUTH2_CLIENT_ID');
        $OAUTH2_CLIENT_SECRET = $this->container->getParameter('OAUTH2_CLIENT_SECRET');
        $this->client = new Client();
        $this->client->setClientId($OAUTH2_CLIENT_ID);
        $this->client->setClientSecret($OAUTH2_CLIENT_SECRET);
        $this->client->setScopes('https://gdata.youtube.com');
        $redirect = filter_var($this->generateUrl('_youtubeauthentication', array(), UrlGeneratorInterface::ABSOLUTE_URL),
          FILTER_SANITIZE_URL);
        $this->client->setRedirectUri($redirect);
    }


    /**
     * @Route("/loginRemote", name="_logInRemote")
     */
    public function logInRemoteAction()
    {
        $status = true;
        $message = [];
        $message['error'] = '';
        $request = $this->getRequest();
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository("VidlisUserBundle:User")
            ->findOneByUsername($username);

        if (!$user) {
            $user = $this->getDoctrine()
                ->getManager()
                ->getRepository("VidlisUserBundle:User")
                ->findOneByEmail($username);
        }

        if (!$user instanceof User) { // User not found
            $message['status'] = 'FAIL';
            $message['error'] = 'Utilisateur non trouvé';
            $status = false;
        }

        if (!$this->checkUserPassword($user, $password)) { // Wrong password
            $message['status'] = 'FAIL';
            $message['error'] = 'Mauvais mot de passe';
            $status = false;
        }

        $this->loginUser($user);
        $response = new Response(
            json_encode(['status' => $status, 'login' => $user->getUsername(), "message" => $message['error']]),
            201,
            array(
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json'
            )
        );

        return $response;
    }

    protected function loginUser(User $user)
    {
        $security = $this->get('security.context');
        $providerKey = $this->container->getParameter('fos_user.firewall_name');
        $roles = $user->getRoles();
        $token = new UsernamePasswordToken($user, null, $providerKey, $roles);
        $security->setToken($token);
    }

    protected function logoutUser()
    {
        $security = $this->get('security.context');
        $token = new AnonymousToken(null, new User());
        $security->setToken($token);
        $this->get('session')->invalidate();
    }

    protected function checkUserPassword(User $user, $password)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        if (!$encoder) {
            return false;
        }

        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }
}
