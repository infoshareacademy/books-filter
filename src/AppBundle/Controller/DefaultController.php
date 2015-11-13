<?php

namespace AppBundle\Controller;

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
        $result = $this->callApi('GET', $this->container->getParameter('api_url'));
//        var_dump($result);
        //Creating new instance of BookFilter class
        $bookfilter = new BookFilter();
//      var_dump($bookfilter);
        //Takes a JSON encoded string and converts it into PHP object of arrays"
        $decodedJson = json_decode($result);
//        var_dump($decodedJson);
        if ($decodedJson === null || !property_exists($decodedJson, 'item')){
            $logger->error('niepoprawny format danych');
            return new JsonResponse(['error' => 'niepoprawny format']);
        }
        $filteredOutBooks = $bookfilter->filter($decodedJson->item,['wyboru']);
        return new JsonResponse($filteredOutBooks);
    }

    private function callApi($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
