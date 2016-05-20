<?php
/**
 * This Example send an IM Message.
 */

// You have to include the dependencies
// The main class for the SDK
use Fortytwo\SDK\AdvancedMessagingPlatform\AdvancedMessagingPlatform;
// The class who represent the model of the API
// The Destination class
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\DestinationEntity;
// The IM Content class
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMContentEntity;
// Request Body class
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\RequestBodyEntity;

// We bootstrap the SDK.
$root = realpath(dirname(dirname(__FILE__)));
$library = $root . "/src";
$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));

// Using the Composer autoload
require dirname(__FILE__) . '/../vendor/autoload.php';

// Declaring some dependencies for the Serializer
Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    $root . "/vendor/jms/serializer/src"
);


// Here the code to create and send the message.
try {
    $messaging = new AdvancedMessagingPlatform('mytoken');

    //Create a destination
    $destination = new DestinationEntity();
    $destination
        ->setNumber(356123456)
        ->setCustomId('123456789')
    ;

    // Prepare the IM content
    $IM = new IMContentEntity();

    $IM
        ->setChannel('VIBER')
        ->setContent('Hello! This is an IM message from the SDK.')
    ;

    // Prepare the Request Body
    $request = new RequestBodyEntity();
    $request
        ->addDestinations($destination)
        ->setImContent($IM)
        ->setCallbackUrl('https://example.com/im/callback-sales')
        ->setJobId('abc123456')
    ;

    // Send the IM message
    $response = $messaging->sendMessage($request);

    // Print the response.
    print_r($response->getResultInfo()->getDescription());

} catch (\Exception $e) {
    echo $e->getMessage();
}
