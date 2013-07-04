<?php

namespace Avtenta\AngularBundle\Producer;

use Avtenta\AngularBundle\Entity\Message;

class ChatMessageSystem
{
	private $messageQueue;

	public function __construct($messageQueue)
	{
		$this->messageQueue = $messageQueue;
	}

	/**
	 * Publishes a message in the chat queue
	 * 
	 * @param  Message $message Requested entity
	 * @param  string $action Requested action
	 */
	public function queueMessage(Message $message, $action, $chatId)
	{
		$msg = array(
			'action' => $action,
			'chatId' => $chatId,
			'id' => $message->getId(),
			'content' => $message->getContent()
		);

		$this->messageQueue->setContentType('application/json');
        $this->messageQueue->publish(json_encode($msg));
	}
}