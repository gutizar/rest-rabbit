<?php

namespace Avtenta\AngularBundle\Producer;

use Avtenta\AngularBundle\Entity\Book;

class BookMessageSystem
{
	private $messageQueue;

	public function __construct($messageQueue)
	{
		$this->messageQueue = $messageQueue;
	}

	/**
	 * Publishes a message in the request_book queue
	 * 
	 * @param  Book   $book   Requested entity
	 * @param  string $action Requested action
	 */
	public function queueMessage(Book $book, $action)
	{
		$message = array(
			'action' => $action,
			'id' => $book->getId(),
			'title' => $book->getTitle(),
			'author' => $book->getAuthor(),
			'category' => $book->getCategory(),
			'summary' => $book->getSummary(),
			'publishDate' => $book->getPublishDate()->format('Y-m-d H:i:s')
		);

		$this->messageQueue->setContentType('application/json');
        $this->messageQueue->publish(json_encode($message));
	}
}