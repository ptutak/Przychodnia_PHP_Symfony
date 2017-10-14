<?php
/**
 * Created by PhpStorm.
 * User: PiotrTutak
 * Date: 14.10.2017
 * Time: 17:15
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class GenusController
{
    /**
     * @Route("/genus")
     */
    public function showAction(){
        return new Response("Hello");
    }
}