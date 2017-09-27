<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




//php bin/console fos:user:create lmiguens lmiguens@consolidador.com lmiguens
//php bin/console fos:user:activate lmiguens
//php bin/console fos:user:promote lmiguens ROLE_SUPER_ADMIN  

//php bin/console fos:user:create bancobni bni@parcelaja.pt bancobni
//php bin/console fos:user:activate bancobni
//php bin/console fos:user:promote bancobni ROLE_BNI    

//php bin/console fos:user:create cvalente cvalente@parcelaja.pt cvalente
//php bin/console fos:user:activate cvalente
//php bin/console fos:user:promote cvalente ROLE_ADMIN  

//php bin/console fos:user:create rcampanha rcampanha@parcelaja.pt rcampanha
//php bin/console fos:user:activate rcampanha
//php bin/console fos:user:promote rcampanha ROLE_ADMIN  

//php bin/console fos:user:create mquintas mquintas@parcelaja.pt mquintas
//php bin/console fos:user:activate mquintas
//php bin/console fos:user:promote mquintas ROLE_ADMIN  




//  CREATE TABLE `fos_user` (
//  `id` int(11) NOT NULL AUTO_INCREMENT,
//  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
//  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
//  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
//  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
//  `enabled` tinyint(1) NOT NULL,
//  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
//  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `last_login` datetime DEFAULT NULL,
//  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
//  `password_requested_at` datetime DEFAULT NULL,
//  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
//  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
//  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * Description of User
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class User extends BaseUser
{

    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
