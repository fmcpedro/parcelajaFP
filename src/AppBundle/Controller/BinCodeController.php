<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BinCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function checkBinAction($binCodeNumber) {

        $em = $this->getDoctrine()->getManager();

        $binCode = new BinCode();
        $binCode = $em->getRepository('AppBundle:BinCode')->find($binCodeNumber);

        // TRUE -> BIN=(EXISTENTE) && CARD=(VISA || MASTERCARD) && TYPE=(CREDIT) && VALID=(TRUE) && OURSTATE=(TRUE) 
        // TRUE -> BIN=(INEXISTENTE)
        //BIN existe
        if ($binCode != NULL):
            if (($binCode->getCard() == "VISA" || $binCode->getCard() == "MASTERCARD" ) && $binCode->getType() == "CREDIT" && $binCode->getValid() == TRUE && $binCode->getOurstate() == TRUE):
                $output = TRUE;
            else:
                $output = FALSE;
            endif;

        //BIN não existe
        else:
            $output = TRUE;
        endif;

        return new JsonResponse($output);
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

                $entity = $em->getRepository('AppBundle:BinCode')->find($bin->bin);

                if ($entity == null) {
                    $entity = new BinCode();
                    $entity->setBin($bin->bin);
                    $entity->setOurstate(1);
                } else {
//                $entity->setBank($obj->bank);
//                $entity->setCard($obj->card);
//                $entity->setType($obj->type);
//                $entity->setLevel($obj->level);
//                $entity->setCountry($obj->country);
//                $entity->setCountrycode($obj->countrycode);
//                $entity->setWebsite($obj->website);
//                $entity->setPhone($obj->phone);
//                $entity->setValid($obj->valid);
                }

                $em->merge($entity);
                $em->flush();
            }
        }


        $binCodes = $em->getRepository('AppBundle:BinCode')->findAll();

        return $this->render('bincode/index.html.twig', array(
                    'binCodes' => $binCodes,
        ));
    }

    /**
     * Import all binCodes from BinCodes.com
     * https://api.bincodes.com/bin/?format=json&api_key=fcf66fc0bdff574708c47602a4ce90aa&bin=515735
     */
    public function importBinDetailsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        //1) ir buscar os BINS que ainda não têm details
        $binCodes = $em->getRepository('AppBundle:BinCode')->findBy(['bank' => NULL]);

        $KEY = "fcf66fc0bdff574708c47602a4ce90aa";

        foreach ($binCodes as $key => $binCode) {

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

            $entity = $em->getRepository('AppBundle:BinCode')->findOneBy(['bin' => $obj->bin]);

            //nunca vai acontecer!!!!
            if ($entity == null) {
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
            } else {
                //vai actualizar aqui
                $entity->setBank($obj->bank);
                $entity->setCard($obj->card);
                $entity->setType($obj->type);
                $entity->setLevel($obj->level);
                $entity->setCountry($obj->country);
                $entity->setCountrycode($obj->countrycode);
                $entity->setWebsite($obj->website);
                $entity->setPhone($obj->phone);
                $entity->setValid($obj->valid);
            }

            $em->merge($entity);
            $em->flush();
        }

        $binCodes = $em->getRepository('AppBundle:BinCode')->findAll();

        return $this->render('bincode/index.html.twig', array(
                    'binCodes' => $binCodes,
        ));
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
        //$deleteForm = $this->createDeleteForm($binCode);
        $editForm = $this->createForm('AppBundle\Form\BinCodeType', $binCode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_bincode_edit', array('bin' => $binCode->getBin()));
        }

        return $this->render('bincode/edit.html.twig', array(
                    'binCode' => $binCode,
                    'edit_form' => $editForm->createView(),
//                    'delete_form' => $deleteForm->createView(),
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

 