<?php
/**
 * Created by PhpStorm.
 * User: santiguillen
 * Date: 26/3/18
 * Time: 16:21
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{

    /**
     * @Route("/")
     */
    public function homepage()
    {

        return new Response("Test");

    }
}