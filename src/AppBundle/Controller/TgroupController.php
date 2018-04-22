<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tgroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tgroup controller.
 *
 */
class TgroupController extends Controller
{
    /**
     * Lists all tgroup entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tgroups = $em->getRepository('AppBundle:Tgroup')->findAll();

        return $this->render('tgroup/index.html.twig', array(
            'tgroups' => $tgroups,
        ));
    }

    /**
     * Creates a new tgroup entity.
     *
     */
    public function newAction(Request $request)
    {
        $tgroup = new Tgroup();
        $form = $this->createForm('AppBundle\Form\TgroupType', $tgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tgroup);
            $em->flush();

            return $this->redirectToRoute('tgroup_show', array('fgroupid' => $tgroup->getFgroupid()));
        }

        return $this->render('tgroup/new.html.twig', array(
            'tgroup' => $tgroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tgroup entity.
     *
     */
    public function showAction(Tgroup $tgroup)
    {
        $deleteForm = $this->createDeleteForm($tgroup);

        return $this->render('tgroup/show.html.twig', array(
            'tgroup' => $tgroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tgroup entity.
     *
     */
    public function editAction(Request $request, Tgroup $tgroup)
    {
        $deleteForm = $this->createDeleteForm($tgroup);
        $editForm = $this->createForm('AppBundle\Form\TgroupType', $tgroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tgroup_edit', array('fgroupid' => $tgroup->getFgroupid()));
        }

        return $this->render('tgroup/edit.html.twig', array(
            'tgroup' => $tgroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tgroup entity.
     *
     */
    public function deleteAction(Request $request, Tgroup $tgroup)
    {
        $form = $this->createDeleteForm($tgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tgroup);
            $em->flush();
        }

        return $this->redirectToRoute('tgroup_index');
    }

    /**
     * Creates a form to delete a tgroup entity.
     *
     * @param Tgroup $tgroup The tgroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tgroup $tgroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tgroup_delete', array('fgroupid' => $tgroup->getFgroupid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
