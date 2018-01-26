<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BinBank;
use AppBundle\Entity\BinCode;
use SimpleXMLElement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
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

    //https://api.bincodes.com/bin-search/?format=json&api_key=fcf66fc0bdff574708c47602a4ce90aa&country=PT&card=VISA&bank=BANCO BEST
    //https://api.bincodes.com/bin-search/?format=json&api_key=fcf66fc0bdff574708c47602a4ce90aa&country=PT&card=VISA&bank=BANCO BPI

    public function importBinListAction() {

        // para cada registo na tabela de Bin Banks, fazer chamada ao serviço e se o Bin não existir, inserir os Bins na tabela Bin Codes

        $em = $this->getDoctrine()->getManager();
        $binBanks = $em->getRepository('AppBundle:BinBank')->findAll();

        foreach ($binBanks as $key => $binBank) {

            $KEY = "fcf66fc0bdff574708c47602a4ce90aa";

            $query = http_build_query([
                'api_key' => $KEY,
                'country' => $binBank->getCountryCode(),
                'card' => $binBank->getBrand(),
                'bank' => $binBank->getBank()
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "https://api.bincodes.com/bin-search/?format=json&" . $query);
            $result = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($result);

            foreach ($obj->result as $bin) {
                $entity = new BinCode();
                $entity->setBin($bin->bin);
                $em->merge($entity);
                $em->flush();
            }
        }

        return $this->render('bincode/importBinList.html.twig');
    }

//    public function getBinCodeObject($BIN) {
//
////      $PSPID = $this->getContainer()->getParameter('PSPID');
////      $USERID = $this->getContainer()->getParameter('USERID');
////      $PSWD = $this->getContainer()->getParameter('PSWD');
//        $KEY = "fcf66fc0bdff574708c47602a4ce90aa";
//
//        $ch = curl_init();
//
//        $params = array('api_key' => $KEY, 'bin' => $BIN);
//
//        curl_setopt($ch, CURLOPT_URL, "https://api.bincodes.com/bin/?format=xml");
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $response = curl_exec($ch);
//        $data = new SimpleXMLElement($response);
//
//        curl_close($ch);
//
//        return $data;
//    }

//    public function xml_attribute($object, $attribute) {
//        if (isset($object[$attribute]))
//            return (string) $object[$attribute];
//    }

    /**
     * Import all binCodes from BinCodes.com
     * https://api.bincodes.com/bin/?format=json&api_key=9fc53b3db09ca830488d19546a4fc2a1&bin=515735
     */
    public function importBinDetailsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        
        //1) ir buscar os BINS que ainda não têm details
        $binCodes = $em->getRepository('AppBundle:BinCode')->findBy(['bank'=>NULL]);

        $KEY = "fcf66fc0bdff574708c47602a4ce90aa";

        foreach ($binCodes as $key => $binCode) {

            echo "bin code = " . $binCode->getBin();
            
            
            $query = http_build_query([
                'api_key' => $KEY,
                'bin' => $binCode->getBin(),
            ]);

            //2) invocar o serviço para pedir os detalhes do BIN
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "https://api.bincodes.com/bin/?format=json&" . $query);
            $result = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($result);
            

            //3) actualizar a tabela dos BINS com os detalhes
            $entity = new BinCode();
            $entity->setBin($obj->bin);
            $entity->setBank($obj->bank);
            $entity->setCard($obj->card);
            $entity->setType($obj->type);
            $entity->setLevel($obj->level);
            $entity->setCountry($obj->country);
            $entity->setCountrycode($obj->countrycode);
            $entity->setWebsite($obj->website);
            $entity->setPhone($obj->phone);
            $entity->setValid($obj->valid);

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
     * @return Form The form
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
