<?php

namespace Avtenta\AngularBundle\Controller;

use Avtenta\AngularBundle\Entity\Book;
use Avtenta\AngularBundle\Form\BookType;
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

        $this->get('book_messaging_system')->queueMessage($entity, 'GET');

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
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new BookType(), $book);
        $form->bind($this->getRequest());

        $isNew = $em->getRepository('AvtentaAngularBundle:Book')->findBy(array(
            'title' => $book->getTitle())) == null;

        $statusCode = ($isNew) ? 201 : 204;

        if ($form->isValid())
        {
            $em->persist($book);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (201 == $statusCode)
            {
                $response->headers->set('Location',
                    $this->generateUrl('avtenta_api_book_get', array(
                        'id' => $book->getId()), true)
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }
}
