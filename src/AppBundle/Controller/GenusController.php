<?php
/**
 * Created by PhpStorm.
 * User: PiotrTutak
 * Date: 14.10.2017
 * Time: 17:15
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GenusController extends Controller
{
    /**
     * @Route("/genus/{genusName}",name="genus")
     */

    public function indexAction(Request $request, $genusName)
    {
        $notes = [
            'Octopus asked me a riddle, outsmarted me',
            'I counted 8 legs... as they wrapped around me',
            'Inked!'
        ];

        return $this->render('genus/show.html.twig', array(
            'name' => $genusName,
            'notes' => $notes
        ));
    }
/*   public function showAction($genusName)
    {
        $notes = [
            'Octopus asked me a riddle, outsmarted me',
            'I counted 8 legs... as they wrapped around me',
            'Inked!'
        ];

        return $this->render('genus/get.html.twig', array(
            'name' => $genusName,
            'notes' => $notes
        ));
    }
*/
}