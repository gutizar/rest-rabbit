<?php

namespace Avtenta\AngularBundle\Controller;

use Avtenta\AngularBundle\Entity\Book;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
	/**
	 * @Rest\View
	 */
	public function allAction()
	{
		$em = $this->getDoctrine()->getManager();

		$books = $em->getRepository('AvtentaAngularBundle:Book')->findAll();

		return array(
			'books' => $books
		);
	}

	/**
	 * @Rest\View
	 */
	public function getAction($id)
	{
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvtentaAngularBundle:Book')->find($id);

        if (!$entity)
        {
        	throw $this->createNotFoundException('Book not found');
        }

        $msg = array(
        	'timestamp' => new \DateTime(),
        	'book_id' => $entity->getId(),
        	'book_name' => $entity->getTitle(),
        	'book_author' => $entity->getAuthor(),
        	'book_category' => $entity->getCategory()
        );

        $this->get('old_sound_rabbit_mq.request_book_producer')->setContentType('application/json');
        $this->get('old_sound_rabbit_mq.request_book_producer')->publish(json_encode($msg));

        return array(
        	'book' => $entity
        );
	}

    public function newAction()
    {
        $this->processForm(new Book());
    }

    private function processForm(Book $book)
    {

    }
}
