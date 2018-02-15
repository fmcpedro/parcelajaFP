<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tagency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tagency controller.
 *
 */
class TagencyController extends Controller
{
    /**
     * Lists all tagency entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tagencies = $em->getRepository('AppBundle:Tagency')->findAll();

        return $this->render('tagency/index.html.twig', array(
            'tagencies' => $tagencies,
        ));
    }

    /**
     * Creates a new tagency entity.
     *
     */
    public function newAction(Request $request)
    {
        $tagency = new Tagency();
        $form = $this->createForm('AppBundle\Form\TagencyType', $tagency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tagency);
            $em->flush();
            
            
             $this->get('session')->getFlashBag()->add(
                    'notice', 'Loja criada com sucesso!'
            );

//            return $this->redirectToRoute('admin_agency_show', array('fagencyid' => $tagency->getFagencyid()));
            return $this->redirectToRoute('admin_agency_edit', array('fagencyid' => $tagency->getFagencyid()));
        }

        return $this->render('tagency/new.html.twig', array(
            'tagency' => $tagency,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tagency entity.
     *
     */
//    public function showAction(Tagency $tagency)
//    {
//        $deleteForm = $this->createDeleteForm($tagency);
//
//        return $this->render('tagency/show.html.twig', array(
//            'tagency' => $tagency,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing tagency entity.
     *
     */
    public function editAction(Request $request, Tagency $tagency)
    {
        $deleteForm = $this->createDeleteForm($tagency);
        $editForm = $this->createForm('AppBundle\Form\TagencyType', $tagency);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->get('session')->getFlashBag()->add(
                    'notice', 'Loja actualizada com sucesso!'
            );

            return $this->redirectToRoute('admin_agency_edit', array('fagencyid' => $tagency->getFagencyid()));
        }

        return $this->render('tagency/edit.html.twig', array(
            'tagency' => $tagency,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tagency entity.
     *
     */
    public function deleteAction(Request $request, Tagency $tagency)
    {
        $form = $this->createDeleteForm($tagency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tagency);
            $em->flush();
        }

        return $this->redirectToRoute('admin_agency_index');
    }

    /**
     * Creates a form to delete a tagency entity.
     *
     * @param Tagency $tagency The tagency entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tagency $tagency)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_agency_delete', array('fagencyid' => $tagency->getFagencyid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
