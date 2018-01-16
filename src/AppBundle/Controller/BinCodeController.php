<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BinCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bincode controller.
 *
 */
class BinCodeController extends Controller {

    /**
     * Lists all binCode entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $binCodes = $em->getRepository('AppBundle:BinCode')->findAll();

        return $this->render('bincode/index.html.twig', array(
                    'binCodes' => $binCodes,
        ));
    }

    /**
     * https://api.bincodes.com/bin-search/?format=[FORMAT]&api_key=[API_KEY]&country=[COUNTRY]&
      card=[CARD]&bank=[BANK]&type=[TYPE]&level=[LEVEL]&bins=[BINS]
     */
    public function getAllBins($COUNTRY = 'PT') {

//        $KEY = "";
//        
//        $ch = curl_init();
//
//        $params = array('api_key' => $KEY, 'country' => $COUNTRY);
//
//        curl_setopt($ch, CURLOPT_URL, "https://api.bincodes.com/bin-search/?format=xml");
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $response = curl_exec($ch);
//        $data = new SimpleXMLElement($response);
//
//        curl_close($ch);


        $data = "<?xml version='1.0' encoding='utf-8'?>
<root>
  <result>
    <bin>433042</bin>
  </result>
  <result>
    <bin>435255</bin>
  </result>
  <result>
    <bin>447050</bin>
  </result>
  <result_info>
    <total>3</total>
    <display>3</display>
    <error></error>
    <message></message>
  </result_info>
</root>";






        return $data;
    }

    public function getBinCodeObject($BIN) {

//      $PSPID = $this->getContainer()->getParameter('PSPID');
//      $USERID = $this->getContainer()->getParameter('USERID');
//      $PSWD = $this->getContainer()->getParameter('PSWD');
        $KEY = "";

        $ch = curl_init();

        $params = array('api_key' => $KEY, 'bin' => $BIN);

        curl_setopt($ch, CURLOPT_URL, "https://api.bincodes.com/bin/?format=xml");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $data = new SimpleXMLElement($response);

        curl_close($ch);

        return $data;
    }

    public function xml_attribute($object, $attribute) {
        if (isset($object[$attribute]))
            return (string) $object[$attribute];
    }

    /**
     * Import all binCodes from BinCodes.com
     * 
     */
    public function importAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        //1 - Ir procurar todos os BINS de PT
        $bins = $this->getAllBins();


        //2 - Para cada BIN actualizar a base de dados 
        foreach ($bins as $key => $bin) {

            $data = $this->getBinCodeObject($bin);

            $entity = new BinCode();
            $entity->setBin($this->xml_attribute($data, 'bin'));
            $entity->setBank($this->xml_attribute($data, 'bank'));
            $entity->setCard($this->xml_attribute($data, 'card'));
            $entity->setType($this->xml_attribute($data, 'type'));
            $entity->setLevel($this->xml_attribute($data, 'level'));
            $entity->setCountry($this->xml_attribute($data, 'country'));
            $entity->setCountrycode($this->xml_attribute($data, 'countrycode'));
            $entity->setWebsite($this->xml_attribute($data, 'website'));
            $entity->setPhone($this->xml_attribute($data, 'phone'));
            $entity->setState($this->xml_attribute($data, 'state'));

            $em->merge($entity);
            $em->flush();
        }

        return $this->render('bincode/import.html.twig', array());
    }

    /**
     * Creates a new binCode entity.
     *
     */
//    public function newAction(Request $request)
//    {
//        $binCode = new Bincode();
//        $form = $this->createForm('AppBundle\Form\BinCodeType', $binCode);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($binCode);
//            $em->flush();
//
//            return $this->redirectToRoute('admin_bincode_show', array('id' => $binCode->getId()));
//        }
//
//        return $this->render('bincode/new.html.twig', array(
//            'binCode' => $binCode,
//            'form' => $form->createView(),
//        ));
//    }

    /**
     * Finds and displays a binCode entity.
     *
     */
//    public function showAction(BinCode $binCode)
//    {
//        $deleteForm = $this->createDeleteForm($binCode);
//
//        return $this->render('bincode/show.html.twig', array(
//            'binCode' => $binCode,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing binCode entity.
     *
     */
    public function editAction(Request $request, BinCode $binCode) {
        $deleteForm = $this->createDeleteForm($binCode);
        $editForm = $this->createForm('AppBundle\Form\BinCodeType', $binCode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_bincode_edit', array('id' => $binCode->getId()));
        }

        return $this->render('bincode/edit.html.twig', array(
                    'binCode' => $binCode,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a binCode entity.
     *
     */
//    public function deleteAction(Request $request, BinCode $binCode)
//    {
//        $form = $this->createDeleteForm($binCode);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($binCode);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('admin_bincode_index');
//    }

    /**
     * Creates a form to delete a binCode entity.
     *
     * @param BinCode $binCode The binCode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createDeleteForm(BinCode $binCode)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('admin_bincode_delete', array('id' => $binCode->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}
