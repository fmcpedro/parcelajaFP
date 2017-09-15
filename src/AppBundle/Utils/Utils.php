<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Utils;
/**
 * Description of Utils
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class Utils {
    //put your code here
    

        static function  getClienteData($propriedade, $clientData) {
        if ($propriedade == "nome") {
            if (preg_match('/»fld_id_0«(.*?)»fld_id_1«/', $clientData, $display) === 1) {
                return $display[1];
            }
        } elseif ($propriedade == "sobrenome") {
            if (preg_match('/»fld_id_1«(.*?)»fld_id_2«/', $clientData, $display) === 1) {
                return $display[1];
            }
        } elseif ($propriedade == "nif") {
            if (preg_match('/»fld_id_2«(.*?)»fld_id_3«/', $clientData, $display) === 1) {
                return $display[1];
            }
        } elseif ($propriedade == "cartaoCidadao") {
            if (preg_match('/»fld_id_3«(.*?)»/', $clientData, $display) === 1) {
                return $display[1];
            }
        }
    }
    
    
    
    static function getTipoTransacao($purchase){
        
        
            //apenas são criados os pagamentos de compras após 10-03-2017
            $purchase_date = strtotime($purchase->getFpurchasedate()->format('d-m-Y'));
            $start_date = strtotime('10-03-2017');


            //se a data da compra for maior que a data de inicio da parceria
            if ($purchase_date >= $start_date):
                if ($purchase->getFmonthdata() == 1):
                    //se for uma pagamento numa unica vez = SC(sem credito)
                    $tipoTransacao = "SC";
                else:
                    //dentro da parceria AC=(a credito)
                    $tipoTransacao = "AC";
                endif;
            else:
                //antes da parceria com o banco = PP(pre-parceria)
                $tipoTransacao = "PP";
            endif;
        
        
    }
    
    
    
    
}
