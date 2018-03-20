<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tpurchase;
use AppBundle\Entity\TpurchaseSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tpurchase controller.
 *
 */
class TpurchaseController extends Controller {

    /**
     * Lists all tpurchase entities.
     *
     */
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $tpurchaseSearch = new TpurchaseSearch();
        $searchForm = $this->createForm('AppBundle\Form\TpurchaseSearchType', $tpurchaseSearch);
        $searchForm->handleRequest($request);

        //$cancelForm = $this->createCancelForm($tpurchase);




//        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
//
//            $search = array();
//            
//            
//            $contractNumber = $searchForm["startDate"]->getData();
//            
//            $startDate = $searchForm["startDate"]->getData();
//            $endDate = $searchForm["endDate"]->getData();
//            
//              $group = $searchForm["groupId"]->getData();
//            $subGroup = $searchForm["subgroupId"]->getData();
//            $agency = $searchForm["agencyId"]->getData();
//            $status = $searchForm["status"]->getData();
//            
//
//            if (!empty($startDate)) {
//                $search['startDate'] = $startDate;
//            }
//
//            if (!empty($endDate)) {
//                $search['endDate'] = $endDate;
//            }
//
//          
//
//            $tpurchases = $em->getRepository('AppBundle:Tpurchase')->findBy(array(),array('fpurchaseid' => 'DESC') );
//        } else {
//            $tpurchases = $em->getRepository('AppBundle:Tpurchase')->findBy(array(),array('fpurchaseid' => 'DESC') );
//        }


        $tpurchases = $em->getRepository('AppBundle:Tpurchase')->findBy(array(), array('fpurchaseid' => 'DESC'));


        return $this->render('tpurchase/index.html.twig', array(
                    'tpurchases' => $tpurchases,
                    'search_form' => $searchForm->createView(),
          //          'cancel_form' => $cancelForm->createView(),
        ));
    }

    /**
     * Creates a new tpurchase entity.
     *
     */
//    public function newAction(Request $request) {
//        $tpurchase = new Tpurchase();
//        $form = $this->createForm('AppBundle\Form\TpurchaseType', $tpurchase);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($tpurchase);
//            $em->flush();
//
//            return $this->redirectToRoute('admin_tpurchase_show', array('fpurchaseid' => $tpurchase->getFpurchaseid()));
//        }
//
//        return $this->render('tpurchase/new.html.twig', array(
//                    'tpurchase' => $tpurchase,
//                    'form' => $form->createView(),
//        ));
//    }

    /**
     * Cancel a tpurchase entity.
     *
     */
    public function cancelAction(Request $request, Tpurchase $tpurchase) {
        $form = $this->createCancelForm($tpurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$em->remove($tpurchase);
            
            //1) COLOCAR STATUS CANCELADO
            $tpurchase->setFstatus(2);
            $em->persist($tpurchase);
            $em->flush();

            //2) CRIAR REGISTO DE CANCELAMENTO
            $purchaseCancelation = new \AppBundle\Entity\PurchaseCancelation();
            $purchaseCancelation->setPurchaseId($tpurchase->getFpurchaseid());
                        
            //2.1) PROCURAR ULTIMO PAGAMENTO DA COMPRA
            $tpayment = $em->getRepository('AppBundle:Tpayments')->findLastPayment($tpurchase);
            
            $purchaseCancelation->setInstallmentId($tpayment->getFinstallment()+1);
            $em->persist($purchaseCancelation);
            $em->flush();
            
        }

        return $this->redirectToRoute('admin_tpurchase_index');
    }

    
    
    
    
     /**
     * Return a tpurchase entity.
     *
     */
    public function returnAction(Request $request, Tpurchase $tpurchase) {
        $form = $this->createReturnForm($tpurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$em->remove($tpurchase);
            
            //1) COLOCAR STATUS CANCELADO
            $tpurchase->setFstatus(2);
            $em->persist($tpurchase);
            $em->flush();

            //2) CRIAR REGISTO DE RETORNO
            $purchaseReturn = new \AppBundle\Entity\PurchaseReturn();
            $purchaseReturn->setPurchaseId($tpurchase->getFpurchaseid());
                        
            //2.1) PROCURAR ULTIMO PAGAMENTO DA COMPRA
            $tpayment = $em->getRepository('AppBundle:Tpayments')->findLastPayment($tpurchase);
            
            $purchaseReturn->setInstallmentId($tpayment->getFinstallment()+1);
            $em->persist($purchaseReturn);
            $em->flush();

        }

        return $this->redirectToRoute('admin_tpurchase_index');
    }
    
    
    
         /**
     * Return a tpurchase entity.
     *
     */
    public function failAction(Request $request, Tpurchase $tpurchase) {
        $form = $this->createReturnForm($tpurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$em->remove($tpurchase);
            
            //1) COLOCAR STATUS CANCELADO
            $tpurchase->setFstatus(2);
            $em->persist($tpurchase);
            $em->flush();

            //2) CRIAR REGISTO DE INCUMPRIMENTO
            $purchaseFail = new \AppBundle\Entity\PurchaseFail();
            $purchaseFail->setPurchaseId($tpurchase->getFpurchaseid());
                        
            //2.1) PROCURAR ULTIMO PAGAMENTO DA COMPRA
            $tpayment = $em->getRepository('AppBundle:Tpayments')->findLastPayment($tpurchase);
            
            $purchaseFail->setInstallmentId($tpayment->getFinstallment()+1);
            $em->persist($purchaseFail);
            $em->flush();

        }

        return $this->redirectToRoute('admin_tpurchase_index');
    }
    
    
    
    
    
    
    
    
    /**
     * Finds and displays a tpurchase entity.
     *
     */
//    public function showAction(Tpurchase $tpurchase) {
//        $deleteForm = $this->createDeleteForm($tpurchase);
//
//        return $this->render('tpurchase/show.html.twig', array(
//                    'tpurchase' => $tpurchase,
//                    'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing tpurchase entity.
     *
     */
    public function editAction(Request $request, Tpurchase $tpurchase) {
        $cancelForm = $this->createCancelForm($tpurchase);
        $returnForm = $this->createReturnForm($tpurchase);
        $failForm = $this->createFailForm($tpurchase);
        
       
        
        
        $editForm = $this->createForm('AppBundle\Form\TpurchaseType', $tpurchase);
        $editForm->handleRequest($request);
        
        

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->get('session')->getFlashBag()->add(
                    'notice', 'Purchase updated successfully!'
            );

            return $this->redirectToRoute('admin_tpurchase_edit', array('fpurchaseid' => $tpurchase->getFpurchaseid()));
        }

        return $this->render('tpurchase/edit.html.twig', array(
                    'tpurchase' => $tpurchase,
                    'edit_form' => $editForm->createView(),
                    'cancel_form' => $cancelForm->createView(),
                    'return_form' => $returnForm->createView(),
                   'fail_form' => $failForm->createView(),
        ));
    }

    /**
     * Deletes a tpurchase entity.
     *
     */
    public function deleteAction(Request $request, Tpurchase $tpurchase) {
        $form = $this->createDeleteForm($tpurchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tpurchase);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tpurchase_index');
    }

    /**
     * Creates a form to delete a tpurchase entity.
     *
     * @param Tpurchase $tpurchase The tpurchase entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Tpurchase $tpurchase) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_tpurchase_delete', array('fpurchaseid' => $tpurchase->getFpurchaseid())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Creates a form to cancel a tpurchase entity.
     *
     * @param Tpurchase $tpurchase The tpurchase entity
     *
     * @return Form The form
     */
    private function createCancelForm(Tpurchase $tpurchase) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_tpurchase_cancel', array('fpurchaseid' => $tpurchase->getFpurchaseid())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
    
    
        /**
     * Creates a form to return a tpurchase entity.
     *
     * @param Tpurchase $tpurchase The tpurchase entity
     *
     * @return Form The form
     */
    private function createReturnForm(Tpurchase $tpurchase) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_tpurchase_return', array('fpurchaseid' => $tpurchase->getFpurchaseid())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
    
    
          /**
     * Creates a form to return a tpurchase entity.
     *
     * @param Tpurchase $tpurchase The tpurchase entity
     *
     * @return Form The form
     */
    private function createFailForm(Tpurchase $tpurchase) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_tpurchase_fail', array('fpurchaseid' => $tpurchase->getFpurchaseid())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
    

}
