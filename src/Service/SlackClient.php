<?php


namespace App\Service;


use Doctrine\Common\Annotations\Annotation\Required;
use Nexy\Slack\Client;
use App\Helper\LoggerTrait;
use Psr\Log\LoggerInterface;


class SlackClient
{
    use LoggerTrait;
    /**
     * @var Client
     */
    private $slack;


    public function __construct(Client $slack)
    {

        $this->slack = $slack;
    }

    public function SendMessage(string $from,string $message){

        $this->logInfo('Beaming a message to Slack!', [
            'message' => $message
        ]);

        $message = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost')
            ->setText($message);
        $this->slack->sendMessage($message);
    }

    /**
     * @required
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger){
        $this->logger = $logger;
    }
}