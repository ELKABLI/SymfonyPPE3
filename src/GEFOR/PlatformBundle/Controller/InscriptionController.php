<?php

namespace GEFOR\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InscriptionController extends Controller
{
    public function home_viewAction()
    {
        return $this->render('GEFORPlatformBundle:Inscription:home_view.html.twig');
    }
}
