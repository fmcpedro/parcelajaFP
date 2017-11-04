<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WsPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Wspost controller.
 *
 */
class WsPostController extends Controller
{
    /**
     * Lists all wsPost entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wsPosts = $em->getRepository('AppBundle:WsPost')->findAll();

        return $this->render('wspost/index.html.twig', array(
            'wsPosts' => $wsPosts,
        ));
    }

    /**
     * Creates a new wsPost entity.
     *
     */
    public function newAction(Request $request)
    {
        $wsPost = new Wspost();
        $form = $this->createForm('AppBundle\Form\WsPostType', $wsPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wsPost);
            $em->flush();

            return $this->redirectToRoute('admin_post_edit', array('id' => $wsPost->getId()));
        }

        return $this->render('wspost/new.html.twig', array(
            'wsPost' => $wsPost,
            'form' => $form->createView(),
        ));
    }

//    /**
//     * Finds and displays a wsPost entity.
//     *
//     */
//    public function showAction(WsPost $wsPost)
//    {
//        $deleteForm = $this->createDeleteForm($wsPost);
//
//        return $this->render('wspost/show.html.twig', array(
//            'wsPost' => $wsPost,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing wsPost entity.
     *
     */
    public function editAction(Request $request, WsPost $wsPost)
    {
        $deleteForm = $this->createDeleteForm($wsPost);
        $editForm = $this->createForm('AppBundle\Form\WsPostType', $wsPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_post_edit', array('id' => $wsPost->getId()));
        }

        return $this->render('wspost/edit.html.twig', array(
            'wsPost' => $wsPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wsPost entity.
     *
     */
    public function deleteAction(Request $request, WsPost $wsPost)
    {
        $form = $this->createDeleteForm($wsPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wsPost);
            $em->flush();
        }

        return $this->redirectToRoute('admin_post_index');
    }

    /**
     * Creates a form to delete a wsPost entity.
     *
     * @param WsPost $wsPost The wsPost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WsPost $wsPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_post_delete', array('id' => $wsPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
