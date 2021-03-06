<?php
namespace Fortytwo\SDK\AdvancedMessagingPlatform;

use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\TextEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\RequestBodyEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\DestinationEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMActionEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMContentEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMImageEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\SMSContentEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Entities\UbiquityContentEntity;
use Fortytwo\SDK\AdvancedMessagingPlatform\Values\NoBlankValue;

class RequestBodyEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateClass()
    {
        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\RequestBodyEntity',
            new RequestBodyEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\DestinationEntity',
            new DestinationEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMActionEntity',
            new IMActionEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMContentEntity',
            new IMContentEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\IMImageEntity',
            new IMImageEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\SMSContentEntity',
            new SMSContentEntity()
        );

        $this->assertInstanceOf(
            'Fortytwo\SDK\AdvancedMessagingPlatform\Entities\UbiquityContentEntity',
            new UbiquityContentEntity()
        );
    }

    public function testEntities()
    {
        $destination = new DestinationEntity();

        $destination
            ->setNumber('35611111111')
            ->setCustomId('123456')
            ->setParams(array('KEY' => 'plop'))
        ;



        $SMSContent = new SMSContentEntity();

        $SMSContent
            ->setMessage('Hello world!')
            ->setEncoding('GSM7')
            ->setRoute('G1')
            ->setUdh('1010101')
            ->setSenderId('aaa54686')
            ->setSenderId('54686')
            ->setPid('15')
            ->setTtl('3600')
        ;

        $IMAction = new IMActionEntity();
        $IMAction
            ->setTitle('click here!')
            ->setTargetUrl('https://www.fortytwo.com/regsiter/')
        ;

        $IMImage = new IMImageEntity();
        $IMImage
            ->setUrl('https://www.fortytwo.com/wp-content/themes/fortytwo/assets/img/fortytwo-light-small.png')
        ;

        $IMContent = new IMContentEntity();
        $IMContent
            ->setChannel('VIBER')
            ->setSenderId('549689')
            ->setContent('Hello This is a message')
            ->setTtl('3600')
            ->setExpiryText('Message expired.')
            ->addImage($IMImage)
            ->addAction($IMAction)
        ;

        $text = new TextEntity();
        $text->setText('This is an Ubiquity text.');

        $message = new UbiquityContentEntity();
        $message
            ->addText($text)
            ->addImage($IMImage)
            ->addAction($IMAction)
        ;

        $request = new RequestBodyEntity();

        $request
            ->addDestinations(array($destination))
            ->setJobId('9846348900')
            ->setMessage($message)
            ->setSmsContent($SMSContent)
            ->setImContent($IMContent)
            ->setMessagePlan('FEATURE_RICH')
            ->setCallbackUrl('https://www.fortytwo.com/')
            ->setReplyUrl('https://www.fortytwo.com/replyurl')
            ->setPromotional(true)
        ;


        $this->assertEquals(
            "9846348900",
            $request->getJobId()
        );

        $this->assertEquals(
            "FEATURE_RICH",
            $request->getMessagePlan()
        );

        $this->assertEquals(
            "https://www.fortytwo.com/",
            $request->getCallbackUrl()
        );

        $this->assertEquals(
            "https://www.fortytwo.com/replyurl",
            $request->getReplyUrl()
        );

        # Destinations
        $this->assertEquals(
            "35611111111",
            $request->getDestinations()[0]->getNumber()
        );

        $this->assertEquals(
            "123456",
            $request->getDestinations()[0]->getCustomId()
        );

        $this->assertArrayHasKey(
            "KEY",
            $request->getDestinations()[0]->getParams()
        );

        # SMS Content
        $this->assertEquals(
            "Hello world!",
            $request->getSmsContent()->getMessage()
        );

        $this->assertEquals(
            "GSM7",
            $request->getSmsContent()->getEncoding()
        );

        $this->assertEquals(
            "G1",
            $request->getSmsContent()->getRoute()
        );

        $this->assertEquals(
            "1010101",
            $request->getSmsContent()->getUdh()
        );

        $this->assertEquals(
            "54686",
            $request->getSmsContent()->getSenderId()
        );

        $this->assertEquals(
            "15",
            $request->getSmsContent()->getPid()
        );

        $this->assertEquals(
            "3600",
            $request->getSmsContent()->getTtl()
        );

        $this->assertEquals(
            "This is an Ubiquity text.",
            $request->getMessage()->getTexts()[0]->getText()
        );

        # IM action
        $this->assertEquals(
            "click here!",
            $request->getImContent()[0]->getActions()[0]->getTitle()
        );
        $this->assertEquals(
            "https://www.fortytwo.com/regsiter/",
            $request->getImContent()[0]->getActions()[0]->getTargetUrl()
        );

        # IM Image
        $this->assertEquals(
            "https://www.fortytwo.com/wp-content/themes/fortytwo/assets/img/fortytwo-light-small.png",
            $request->getImContent()[0]->getImages()[0]->getUrl()
        );

        # IM Content
        $this->assertEquals(
            "VIBER",
            $request->getImContent()[0]->getChannel()
        );

        $this->assertEquals(
            "549689",
            $request->getImContent()[0]->getSenderId()
        );

        $this->assertEquals(
            "Hello This is a message",
            $request->getImContent()[0]->getContent()
        );

        $this->assertEquals(
            "3600",
            $request->getImContent()[0]->getTtl()
        );

        $this->assertEquals(
            "Message expired.",
            $request->getImContent()[0]->getExpiryText()
        );

        $this->assertContains(
            'VIBER',
            $request->toJSON()
        );

        $this->assertEquals(
            true,
            $request->getPromotional()
        );
    }

    /**
     * @expectedException Exception
     */
    public function testValidationException()
    {
        $IMImage = new IMImageEntity();
        $IMImage
            ->setUrl('balbla')
        ;
    }

    public function testNoBlank()
    {
        $this->assertEquals(
            "test",
            (string)new NoBlankValue('test')
        );
    }
}
