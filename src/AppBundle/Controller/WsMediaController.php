<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WsMedia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Wsmedia controller.
 *
 */
class WsMediaController extends Controller
{
    /**
     * Lists all wsMedia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wsMedia = $em->getRepository('AppBundle:WsMedia')->findAll();

        return $this->render('wsmedia/index.html.twig', array(
            'wsMedia' => $wsMedia,
        ));
    }

    /**
     * Creates a new wsMedia entity.
     *
     */
    public function newAction(Request $request)
    {
        $wsMedia = new Wsmedia();
        $form = $this->createForm('AppBundle\Form\WsMediaType', $wsMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wsMedia);
            $em->flush();

            return $this->redirectToRoute('admin_media_edit', array('id' => $wsMedia->getId()));
        }

        return $this->render('wsmedia/new.html.twig', array(
            'wsMedia' => $wsMedia,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a wsMedia entity.
     *
     */
//    public function showAction(WsMedia $wsMedia)
//    {
//        $deleteForm = $this->createDeleteForm($wsMedia);
//
//        return $this->render('wsmedia/show.html.twig', array(
//            'wsMedia' => $wsMedia,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing wsMedia entity.
     *
     */
    public function editAction(Request $request, WsMedia $wsMedia)
    {
        $deleteForm = $this->createDeleteForm($wsMedia);
        $editForm = $this->createForm('AppBundle\Form\WsMediaType', $wsMedia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_media_edit', array('id' => $wsMedia->getId()));
        }

        return $this->render('wsmedia/edit.html.twig', array(
            'wsMedia' => $wsMedia,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wsMedia entity.
     *
     */
    public function deleteAction(Request $request, WsMedia $wsMedia)
    {
        $form = $this->createDeleteForm($wsMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wsMedia);
            $em->flush();
        }

        return $this->redirectToRoute('admin_media_index');
    }

    /**
     * Creates a form to delete a wsMedia entity.
     *
     * @param WsMedia $wsMedia The wsMedia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WsMedia $wsMedia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_media_delete', array('id' => $wsMedia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
