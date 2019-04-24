<?php

namespace AppelSponsorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@AppelSponsor/Default/index.html.twig');
    }
}
