<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of Contact
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class Contact {
    //put your code here
    
        private $name;
        private $email;
        private $subject;
        private $phone;
        private $message;

        private $firstValue;
        private $secondValue;
        private $validation;
        
        
        function getName() {
            return $this->name;
        }

        function getEmail() {
            return $this->email;
        }

        function getSubject() {
            return $this->subject;
        }

        function getPhone() {
            return $this->phone;
        }

        function getMessage() {
            return $this->message;
        }

        function getFirstValue() {
            return $this->firstValue;
        }

        function getSecondValue() {
            return $this->secondValue;
        }

        function getValidation() {
            return $this->validation;
        }

        function setName($name) {
            $this->name = $name;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        function setSubject($subject) {
            $this->subject = $subject;
        }

        function setPhone($phone) {
            $this->phone = $phone;
        }

        function setMessage($message) {
            $this->message = $message;
        }

        function setFirstValue($firstValue) {
            $this->firstValue = $firstValue;
        }

        function setSecondValue($secondValue) {
            $this->secondValue = $secondValue;
        }

        function setValidation($validation) {
            $this->validation = $validation;
        }


        
    
    
    
    
    
}
