<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        // replace this example code with whatever you need

        $first_value = rand(0, 9);
        $second_value = rand(0, 9);



        return $this->render('AppBundle:default:index.html.twig', ['first_value' => $first_value, 'second_value' => $second_value]);
    }

    public function emailAction(Request $request) {



        // CONFIG YOUR FIELDS
        //============================================================
        $name = filter_var($request->request->get("name"), FILTER_SANITIZE_STRING) . ' ' . filter_var($request->request->get("last-name"), FILTER_SANITIZE_STRING);

        $emailFrom = filter_var($request->request->get("email"), FILTER_SANITIZE_EMAIL);
        $formMessage = filter_var($request->request->get("message"), FILTER_SANITIZE_STRING);


        $first_value = filter_var($request->request->get("first_value"), FILTER_SANITIZE_NUMBER_INT);
        $second_value = filter_var($request->request->get("second_value"), FILTER_SANITIZE_NUMBER_INT);
        $validation = filter_var($request->request->get("validation"), FILTER_SANITIZE_NUMBER_INT);


        // CONFIG YOUR EMAIL MESSAGE
        //============================================================
        $message = '<p>The following request was sent from: </p>';
        $message .= '<p>Name: ' . $name . '</p>';
        $message .= '<p>Email: ' . $emailFrom . '</p>';
        $message .= '<p>Message: ' . $formMessage . '</p>';


        $subject = 'ParcelaJá - Contacto/Sugestão/Duvida de ' . $name;


        $email_message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('suporte@parcelaja.pt')
                ->setTo('suporte@parcelaja.pt')
                ->setCc('lmiguens@consolidador.com')
                ->setReplyTo($emailFrom)
                ->setBody($message, 'text/html');



        //VALIDACAO ARITMETICA CORRECTA
        if (($first_value + $second_value) == $validation) {


            if (!$this->get('mailer')->send($email_message)) {
                $data['error']['title'] = 'Message could not be sent.';
                //$data['error']['details'] = 'Mailer Error: ' . $mail->ErrorInfo;
                $data['error']['details'] = 'Mailer Error: ';
                return new \Symfony\Component\HttpFoundation\JsonResponse([
                    'success' => false,
                    'data' => $data // Your data here
                ]);
            }

            $data['success']['title'] = 'Message sent.';

            return new \Symfony\Component\HttpFoundation\JsonResponse([
                'success' => true,
                'data' => $data // Your data here
            ]);

            //VALIDACAO ARITMETICA NAO CORRECTA
        } else {
            $data['error']['title'] = 'Message could not be sent.';
            //$data['error']['details'] = 'Mailer Error: ' . $mail->ErrorInfo;
            $data['error']['details'] = 'Aritmetic validation error '. ($first_value + $second_value) . 'and '. $validation  ;
            return new \Symfony\Component\HttpFoundation\JsonResponse([
                'success' => false,
                'data' => $data // Your data here
            ]);
        }



        //return json_encode($data);
    }

    public function testeAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:teste.html.twig', []);
    }

}
