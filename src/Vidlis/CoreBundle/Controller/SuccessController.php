<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SuccessController extends Controller
{

    /**
     * @Route("/loginSuccess", name="_loginSuccess")
     * @Template()
     */
    public function loginAction()
    {
        return [];
    }


    /**
     * @Route("/logoutSuccess", name="_logoutSuccess")
     * @Template()
     */
    public function logoutAction()
    {
        return [];
    }
}