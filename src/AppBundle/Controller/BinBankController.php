<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BinBank;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Binbank controller.
 *
 */
class BinBankController extends Controller
{
    /**
     * Lists all binBank entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $binBanks = $em->getRepository('AppBundle:BinBank')->findAll();

        return $this->render('binbank/index.html.twig', array(
            'binBanks' => $binBanks,
        ));
    }

    /**
     * Creates a new binBank entity.
     *
     */
    public function newAction(Request $request)
    {
        $binBank = new Binbank();
        $form = $this->createForm('AppBundle\Form\BinBankType', $binBank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($binBank);
            $em->flush();
            
             $this->get('session')->getFlashBag()->add(
                    'notice', 'Banco com código BIN registado!'
            );

            //return $this->redirectToRoute('admin_binbank_show', array('id' => $binBank->getId()));
             return $this->redirectToRoute('admin_binbank_edit', array('id' => $binBank->getId()));
        }

        return $this->render('binbank/new.html.twig', array(
            'binBank' => $binBank,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a binBank entity.
     *
     */
    public function showAction(BinBank $binBank)
    {
        $deleteForm = $this->createDeleteForm($binBank);

        return $this->render('binbank/show.html.twig', array(
            'binBank' => $binBank,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing binBank entity.
     *
     */
    public function editAction(Request $request, BinBank $binBank)
    {
        $deleteForm = $this->createDeleteForm($binBank);
        $editForm = $this->createForm('AppBundle\Form\BinBankType', $binBank);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            
            $this->get('session')->getFlashBag()->add(
                    'notice', 'Banco com código BIN actualizado!'
            );

            return $this->redirectToRoute('admin_binbank_edit', array('id' => $binBank->getId()));
        }

        return $this->render('binbank/edit.html.twig', array(
            'binBank' => $binBank,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a binBank entity.
     *
     */
    public function deleteAction(Request $request, BinBank $binBank)
    {
        $form = $this->createDeleteForm($binBank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($binBank);
            $em->flush();
        }

        return $this->redirectToRoute('admin_binbank_index');
    }

    /**
     * Creates a form to delete a binBank entity.
     *
     * @param BinBank $binBank The binBank entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BinBank $binBank)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_binbank_delete', array('id' => $binBank->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
