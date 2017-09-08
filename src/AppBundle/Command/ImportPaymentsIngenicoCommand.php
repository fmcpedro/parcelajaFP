<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Command;

use AppBundle\Entity\TpaymentsTaxaDesconto;
use AppBundle\Entity\TpaymentsTaxaServico;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of ImportIngenicoPaymentsCommand
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class ImportPaymentsIngenicoCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand {

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('app:import-payments-ingenico')

                // the short description shown while running "php bin/console list"
                ->setDescription('Import/update payments from last 5 days.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to import payments from ingenico from last 5 days ...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'START - Importing Payments from Ingenico...',
            '===================================',
        ]);


     $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        //$em = $this->getDoctrine()->getManager();
        
        $payments = $em->getRepository('AppBundle:Tpayments')->findLastDaysPayments(30);
        
        foreach ($payments as $key => $payment) {
            
            $data = $this->getIngenicoObject($payment->getFpayid());
            
            
            $entity = new \AppBundle\Entity\IngenicoPayment();
            $entity->setOrderId($this->xml_attribute($data, 'orderID'));
            $entity->setPayId(intval($this->xml_attribute($data, 'PAYID')));
            $entity->setPayIdSub($this->xml_attribute($data, 'PAYIDSUB'));
            $entity->setNcStatus($this->xml_attribute($data, 'NCSTATUS'));
            $entity->setNcError($this->xml_attribute($data, 'NCERROR'));
            $entity->setNcErrorPlus($this->xml_attribute($data, 'NCERRORPLUS'));
            $entity->setAcceptance($this->xml_attribute($data, 'ACCEPTANCE'));
            $entity->setStatus($this->xml_attribute($data, 'STATUS'));
            $entity->setIpcty($this->xml_attribute($data, 'IPCTY'));
            $entity->setCccty($this->xml_attribute($data, 'CCCTY'));
            $entity->setEci($this->xml_attribute($data, 'ECI'));
            $entity->setCvcCheck($this->xml_attribute($data, 'CVCCheck'));
            $entity->setAavCheck($this->xml_attribute($data, 'AAVCheck'));
            $entity->setVc($this->xml_attribute($data, 'VC'));
            $entity->setAmount($this->xml_attribute($data, 'amount'));
            $entity->setCurrency($this->xml_attribute($data, 'currency'));
            $entity->setPm($this->xml_attribute($data, 'PM'));
            $entity->setBrand($this->xml_attribute($data, 'BRAND'));
            $entity->setCardNo($this->xml_attribute($data, 'CARDNO'));
            $entity->setScoring($this->xml_attribute($data, 'SCORING'));
            $entity->setScoCategory($this->xml_attribute($data, 'SCO_CATEGORY'));

            $em->merge($entity); //it's important to use result of function, not the same element
            $em->flush();
            
        }
        
        
      // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            count($payments).' updated from Ingenico...',
            '==========================================',
            'END',
        ]);
        
    }

    
      function getIngenicoObject($payID) {

        $PSPID = $this->getContainer()->getParameter('PSPID');
        $USERID = $this->getContainer()->getParameter('USERID');
        $PSWD = $this->getContainer()->getParameter('PSWD');
          
          
          
        $ch = curl_init();
        $params = array('PAYID' => $payID, 'PSPID' => $PSPID, 'USERID' => $USERID, 'PSWD' => $PSWD);

        curl_setopt($ch, CURLOPT_URL, "https://secure.ogone.com/ncol/prod/querydirect.asp");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $data = new \SimpleXMLElement($response);
        
        //dump($data);
        curl_close($ch);

        return $data;
    }

    public function xml_attribute($object, $attribute) {
        if (isset($object[$attribute]))
            return (string) $object[$attribute];
    }

    
    
}
