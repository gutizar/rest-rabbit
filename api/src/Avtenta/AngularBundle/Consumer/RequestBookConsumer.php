<?php

namespace Avtenta\AngularBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RequestBookConsumer implements ConsumerInterface
{
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {
        $data = json_decode($msg->body);
        echo sprintf(
            '%s BOOK REQUESTED: ID %s; AUTHOR %s; TITLE %s; CATEGORY %s' . PHP_EOL,
            $data->timestamp->date,
            $data->book_id,
            $data->book_author,
            $data->book_name,
            $data->book_category
        );
    }
}