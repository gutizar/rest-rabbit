<?php

namespace Avtenta\AngularBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Avtenta\AngularBundle\Entity\Book;
use Avtenta\AngularBundle\Form\BookType;

/**
 * Book controller.
 *
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * Lists all Book entities.
     *
     * @Route("/", name="book")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AvtentaAngularBundle:Book')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Book entity.
     *
     * @Route("/", name="book_create")
     * @Method("POST")
     * @Template("AvtentaAngularBundle:Book:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Book();
        $form = $this->createForm(new BookType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('book_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Book entity.
     *
     * @Route("/new", name="book_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Book();
        $form   = $this->createForm(new BookType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Book entity.
     *
     * @Route("/{id}", name="book_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvtentaAngularBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Book entity.
     *
     * @Route("/{id}/edit", name="book_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvtentaAngularBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $editForm = $this->createForm(new BookType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Book entity.
     *
     * @Route("/{id}", name="book_update")
     * @Method("PUT")
     * @Template("AvtentaAngularBundle:Book:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AvtentaAngularBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BookType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('book_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Book entity.
     *
     * @Route("/{id}", name="book_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AvtentaAngularBundle:Book')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Book entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('book'));
    }

    /**
     * Creates a form to delete a Book entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
