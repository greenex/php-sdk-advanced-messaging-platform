<?php
/**
 * Send IM Message with multiple destinations
 * NOTE: If you want to test you have to replace <INSERT_TOKEN_HERE> with a valid token and <PHONE_NUMBER> with a mobile phone number including prefix (e.g 356880000001) .
 */

// You have to include the dependencies
use Fortytwo\SDK\AdvancedMessagingPlatform\AdvancedMessagingPlatform;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\DestinationEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMContentEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\RequestBodyEntity;

// Using the Composer autoload
require dirname(__FILE__) . '/../vendor/autoload.php';

// Declaring some dependencies for the Serializer
$root = dirname(__FILE__);
Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    $root . "/../vendor/jms/serializer/src"
);

// To change with a correct token and phone numbers.
const TOKEN = '<INSERT_TOKEN_HERE>';
const NUMBER1 = '<PHONE_NUMBER>';
const NUMBER2 = '<PHONE_NUMBER>';

// Here the code to create and send the message.
try {
    $messaging = new AdvancedMessagingPlatform(TOKEN);

    //Create a 1st destination
    $destination1 = new DestinationEntity();
    $destination[] = $destination1
        ->setNumber(NUMBER1);

    //Create a 2nd destination
    $destination2 = new DestinationEntity();
    $destination[] = $destination2
        ->setNumber(NUMBER2);

    // Prepare the IM content
    $IM = new IMContentEntity();
    $IM->setContent('This is a test IM message from Fortytwo.');

    // Prepare the Request Body
    $request = new RequestBodyEntity();
    $request
        ->addDestinations($destination)
        ->setImContent($IM);

    // Send the IM message
    $response = $messaging->sendMessage($request);

    // Print the response.
    echo $response->getResultInfo()->getDescription() ."\n";

} catch (\Exception $e) {
    echo $e->getMessage();
}
