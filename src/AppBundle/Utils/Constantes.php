<?php
namespace AppBundle\Utils;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constantes
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class Constantes {
    //put your code here
    

    
    const PROC_SEPA_CT_AUX = 0.008;
    const COMISSAO_OGONE = 0.10;
    const COMISSAO_EVO_AUX = 0.0045;
    const IVA = 0.23;
    const PERCENTAGEM_LUCRO_BNIE = 0.25;
    const PERCENTAGEM_IMPOSTO_SELO = 0.04;
    
    
    
     public static function COMISSAO_EVO($valorParcelas)
        {
            return self::COMISSAO_EVO_AUX * $valorParcelas;
        }
    
    public static function PROC_SEPA_CT($installment)
        {
            if ($installment == 0)
            {
                return self::PROC_SEPA_CT_AUX;
            }
            else
            {
                return 0;
            }
        }
    
    
    
}
