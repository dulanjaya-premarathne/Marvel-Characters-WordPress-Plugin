<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://dulanjaya@surge.global
 * @since      1.0.0
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 * @author     Dulanjaya <dulanjaya@surge.global>
 */


 require S_MARVEL_PATH . '/vendor/autoload.php';


 use GuzzleHttp\Promise;
 use GuzzleHttp\Middleware;
 use GuzzleHttp\Psr7\Response;
 use GuzzleHttp\Psr7\Request;
 use GuzzleHttp\Exception\BadResponseException;
 use GuzzleHttp\Exception\RequestException;
 use GuzzleHttp\Exception\ClientException; 

class Marvel_Auth {

    
    public function x_auth($public_key = null, $private_key = null)
{
    // Set up the API endpoint and parameters
    $baseUrl = 'https://gateway.marvel.com/v1/public/';
    $endpoint = 'characters'; // You can change this to other Marvel API endpoints

    $timestamp = time();
    $hash = md5($timestamp . $private_key . $public_key);

    // Debug: Print timestamp, public key, private key, and hash
    // echo "Timestamp: $timestamp<br>";
    // echo "Public Key: $public_key<br>";
    // echo "Private Key: $private_key<br>";
    // echo "Hash: $hash<br>";

    // Set up Guzzle client
    $client = new \GuzzleHttp\Client();

    // Make the request
    try {
        $response = $client->request('GET', $baseUrl . $endpoint, [
            'query' => [
                'apikey' => $public_key,
                'ts' => $timestamp,
                'hash' => $hash,
            ],
        ]);

        // Get and display the response
        $responseData = json_decode($response->getBody(), true);
        $api_status_code = $response->getStatusCode();

        // Debug: Print response data and status code
        // echo "Response Data:<pre>";
        // print_r($responseData);
        // echo "</pre>";
        // echo "Status Code: $api_status_code<br>";

        return $api_status_code;
        
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        // Debug: Print Guzzle exception details
        echo "Guzzle Exception:<pre>";
        print_r($e->getResponse()->getBody()->getContents());
        echo "</pre>";

        return $e->getResponse()->getStatusCode();
    }
}


    // public function x_auth($public_key=null,$private_key=null ) {

    //     // Set up the API endpoint and parameters
    //     $baseUrl = 'https://gateway.marvel.com/v1/public/';
    //     $endpoint = 'characters'; // You can change this to other Marvel API endpoints

    //     $timestamp = time();
    //     $hash = md5($timestamp . $public_key . $private_key);

    //     // Set up Guzzle client
    //     $client = new \GuzzleHttp\Client();

    //     // Make the request
    //     $response = $client->request('GET', $baseUrl . $endpoint, [
    //         'query' => [
    //             'apikey' => $public_key,
    //             'ts' => $timestamp,
    //             'hash' => $hash,
    //         ],
    //     ]);

    //     // Get and display the response
    //     $responseData = json_decode($response->getBody(), true);
    //     $api_status_code = $response->getStatusCode();


    //     //  echo  $public_key;
    //     //  echo "<br>";
    //     //  echo  $private_key;

    //     return $api_status_code;

    //     // // Display the decoded JSON data
    //     // echo "Response Data:\n";
    //     // echo '<pre>';
    //     // var_dump($responseData);
    //     // echo '</pre>';
    //     // // print_r($responseData);
    //     // // Display the status code
    //     // echo "Status Code: " . $response->getStatusCode() . "\n";
   
    // }
}



?>