<?php

namespace Avtenta\AngularBundle\Controller;

use Avtenta\AngularBundle\Entity\Message;
use Avtenta\AngularBundle\Form\MessageType;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChatController extends Controller
{
	public function publishAction($id)
	{
		return $this->processForm(new Message(), $id);
	}

	private function processForm(Message $entity, $chatId)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new MessageType(), $entity);
		$form->bind($this->getRequest());

		if ($form->isValid())
		{
			$em->persist($entity);
			$em->flush();
			
			$response = new Response();
			$response->setStatusCode(201);

			$msg = array(
				'action' => 'POST',
				'chatId' => $chatId,
				'content' => $entity->getContent()
			);

			$this->get('logger')->info($entity->__toString());

			$this->get('old_sound_rabbit_mq.chat_producer')->setContentType('application/json');
	        $this->get('old_sound_rabbit_mq.chat_producer')->publish(json_encode($msg));

			return $response;
		}

		return View::create($form, 400);
	}
}