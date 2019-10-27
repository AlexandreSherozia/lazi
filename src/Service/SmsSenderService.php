<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21/05/2019
 * Time: 17:13
 */

namespace App\Service;


use App\Entity\SmsSender;
use App\Repository\SmsApiParamsRepository;
use Ovh\Api;
use Ovh\Exceptions\InvalidParameterException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class SmsSenderService
{
    private $smsApiParamsRepository;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * SmsSenderService constructor.
     * @param SmsApiParamsRepository $smsApiParamsRepository
     * @param FlashBagInterface $flashBag
     */
    public function __construct(SmsApiParamsRepository $smsApiParamsRepository, FlashBagInterface $flashBag)
    {
        $this->smsApiParamsRepository = $smsApiParamsRepository;
        $this->flashBag = $flashBag;
    }

    public function sendSms(SmsSender $smsSender)
    {
        $applicationKey = ''; $applicationSecret = ''; $endpoint = ''; $consumer_key = '';

        $smsApiParams = $this->smsApiParamsRepository->find(1);
        if ($smsApiParams) {
            $applicationKey = $smsApiParams->getApplicationKey();
            $applicationSecret = $smsApiParams->getApplicationSecret();
            $consumer_key = $smsApiParams->getConsumerKey();
            $endpoint = $smsApiParams->getEndPoint();
        }

        try {

            $ovh = new Api(
                $applicationKey,
                $applicationSecret,
                $endpoint,
                $consumer_key
            );
            $message = $smsSender->getMessage();
            $phoneNumbers = $smsSender->getRecipientTo();

            $phoneNumbers = explode(' ',$phoneNumbers);

            $content = (object)[
                'charset' => 'UTF-8',
                'class' => 'phoneDisplay',
                'coding' => '7bit',
                'message' => $message,
                'noStopClause' => true,
                'priority' => 'high',
                'receivers' => $phoneNumbers,
                'sender' => 'Atout Libre',
                'senderForResponse' => false,
                'validityPeriod'=> 2880
            ];
            $smsServices = $ovh->get('/sms/');

            $sendingResults = $ovh->post('/sms/' . $smsServices[0] . '/jobs/', $content);

            $this->flashBag->add('success', 'Le service OVH a été consommé avec succès !');

            return $sendingResults;
//            $sentResult = $ovh->get('/sms/' . $smsServices[0] . '/jobs/'); //is empty on each sending
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
//            $traceAsString = $e->getTraceAsString();

            $this->flashBag->add('error', $errorMessage);
            return null;
        }
    }
}