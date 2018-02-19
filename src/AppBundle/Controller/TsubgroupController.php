<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tsubgroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tsubgroup controller.
 *
 */
class TsubgroupController extends Controller
{
    /**
     * Lists all tsubgroup entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tsubgroups = $em->getRepository('AppBundle:Tsubgroup')->findAll();

        return $this->render('tsubgroup/index.html.twig', array(
            'tsubgroups' => $tsubgroups,
        ));
    }

    /**
     * Creates a new tsubgroup entity.
     *
     */
    public function newAction(Request $request)
    {
        $tsubgroup = new Tsubgroup();
        $form = $this->createForm('AppBundle\Form\TsubgroupType', $tsubgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tsubgroup);
            $em->flush();
            
             $this->get('session')->getFlashBag()->add(
                    'notice', 'Sub Grupo criado com sucesso!'
            );

            return $this->redirectToRoute('admin_tsubgroup_edit', array('fsubgroupid' => $tsubgroup->getFsubgroupid()));
            //return $this->redirectToRoute('admin_tsubgroup_show', array('fsubgroupid' => $tsubgroup->getFsubgroupid()));
        }

        return $this->render('tsubgroup/new.html.twig', array(
            'tsubgroup' => $tsubgroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tsubgroup entity.
     *
     */
//    public function showAction(Tsubgroup $tsubgroup)
//    {
//        $deleteForm = $this->createDeleteForm($tsubgroup);
//
//        return $this->render('tsubgroup/show.html.twig', array(
//            'tsubgroup' => $tsubgroup,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing tsubgroup entity.
     *
     */
    public function editAction(Request $request, Tsubgroup $tsubgroup)
    {
        $deleteForm = $this->createDeleteForm($tsubgroup);
        $editForm = $this->createForm('AppBundle\Form\TsubgroupType', $tsubgroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
             $this->get('session')->getFlashBag()->add(
                    'notice', 'Sub Grupo actualizado com sucesso!'
            );

            return $this->redirectToRoute('admin_tsubgroup_edit', array('fsubgroupid' => $tsubgroup->getFsubgroupid()));
        }

        return $this->render('tsubgroup/edit.html.twig', array(
            'tsubgroup' => $tsubgroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tsubgroup entity.
     *
     */
    public function deleteAction(Request $request, Tsubgroup $tsubgroup)
    {
        $form = $this->createDeleteForm($tsubgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tsubgroup);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tsubgroup_index');
    }

    /**
     * Creates a form to delete a tsubgroup entity.
     *
     * @param Tsubgroup $tsubgroup The tsubgroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tsubgroup $tsubgroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tsubgroup_delete', array('fsubgroupid' => $tsubgroup->getFsubgroupid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
