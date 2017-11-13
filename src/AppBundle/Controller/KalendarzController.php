<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class KalendarzController extends Controller
{
    /**
     * @Route("/kalendarz/show",name="kalendarz")
     */
    public function indexAction()
    {
        return $this->render('show.html.twig', array(
        ));
    }

}
