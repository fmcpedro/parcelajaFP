<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tpos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tpo controller.
 *
 */
class TposController extends Controller
{
    /**
     * Lists all tpo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tpos = $em->getRepository('AppBundle:Tpos')->findAll();

        return $this->render('tpos/index.html.twig', array(
            'tpos' => $tpos,
        ));
    }

    /**
     * Creates a new tpo entity.
     *
     */
    public function newAction(Request $request)
    {
        $tpo = new Tpo();
        $form = $this->createForm('AppBundle\Form\TposType', $tpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tpo);
            $em->flush();

            return $this->redirectToRoute('admin_tpos_show', array('fposid' => $tpo->getFposid()));
        }

        return $this->render('tpos/new.html.twig', array(
            'tpo' => $tpo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tpo entity.
     *
     */
    public function showAction(Tpos $tpo)
    {
        $deleteForm = $this->createDeleteForm($tpo);

        return $this->render('tpos/show.html.twig', array(
            'tpo' => $tpo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tpo entity.
     *
     */
    public function editAction(Request $request, Tpos $tpo)
    {
        $deleteForm = $this->createDeleteForm($tpo);
        $editForm = $this->createForm('AppBundle\Form\TposType', $tpo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tpos_edit', array('fposid' => $tpo->getFposid()));
        }

        return $this->render('tpos/edit.html.twig', array(
            'tpo' => $tpo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tpo entity.
     *
     */
    public function deleteAction(Request $request, Tpos $tpo)
    {
        $form = $this->createDeleteForm($tpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tpo);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tpos_index');
    }

    /**
     * Creates a form to delete a tpo entity.
     *
     * @param Tpos $tpo The tpo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tpos $tpo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tpos_delete', array('fposid' => $tpo->getFposid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
