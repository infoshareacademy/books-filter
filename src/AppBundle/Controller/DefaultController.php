<?php

namespace AppBundle\Controller;

use AppBundle\Utils\ApiCaller;
use AppBundle\Utils\PrettyJsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\BookFilter;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //Writes logs to app/logs/dev.log available through app_dev.php
        $logger = $this->get('logger');
        //Calling books api for json file; url config placed in parameters.yml
        $result = (new ApiCaller())->callApi('GET', $this->container->getParameter('api_url'));

        //Takes a JSON encoded string and converts it into PHP object of arrays"
        $decodedJson = json_decode($result);
        //Checking if response is proper JSON or doesn`t have item property though is not a JSON
        if ($decodedJson === null || !property_exists($decodedJson, 'item')){
            $logger->error('niepoprawny format danych');
            return new JsonResponse(['error' => 'niepoprawny format']);
        }
        //Creating new instance of BookFilter class
        $bookfilter = new BookFilter();
        //Returning array of filteres items
        $filteredOutBooks = $bookfilter->filter($decodedJson->item,['wyboru']);
        if ($request->get('format') == 'pretty'){
            return new PrettyJsonResponse($filteredOutBooks);
        }
        return new JsonResponse($filteredOutBooks);
    }
}
