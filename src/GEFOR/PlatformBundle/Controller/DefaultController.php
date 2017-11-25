<?php

namespace GEFOR\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GEFORPlatformBundle:Default:index.html.twig');
    }
}
