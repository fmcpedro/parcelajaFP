<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', []);
    }

    public function emailAction(Request $request) {



        // CONFIG YOUR FIELDS
        //============================================================
        $name = filter_var($request->request->get("name"), FILTER_SANITIZE_STRING);
        $emailFrom = filter_var($request->request->get("email"), FILTER_SANITIZE_EMAIL);
        $formMessage = filter_var($request->request->get("message"), FILTER_SANITIZE_STRING);


        // CONFIG YOUR EMAIL MESSAGE
        //============================================================
        $message = '<p>The following request was sent from: </p>';
        $message .= '<p>Name: ' . $name . '</p>';
        $message .= '<p>Email: ' . $emailFrom . '</p>';
        $message .= '<p>Message: ' . $formMessage . '</p>';


        $email_message = \Swift_Message::newInstance()
               ->setSubject('ParcelaJá - Contacto/Sugestão/Duvida de '+ $name)
                ->setFrom('suporte@parcelaja.pt')
                ->setTo('suporte@parcelaja.pt')
                ->setCc('lmiguens@consolidador.com')
                ->setBody($message, 'text/html');

        
//        $recipients = $this->get('mailer')->send($email_message);
//        return $this->render('AppBundle:default:email.html.twig', []);

//        $response = array();
//        $response["success"] = true;
//        header('Access-Control-Allow-Origin: *');


        if (!$this->get('mailer')->send($email_message)) {
            $data['error']['title'] = 'Message could not be sent.';
            //$data['error']['details'] = 'Mailer Error: ' . $mail->ErrorInfo;
            $data['error']['details'] = 'Mailer Error: ';
            exit;
        }

        $data['success']['title'] = 'Message sent.';

        
        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'success' => true,
            'data'    => $data // Your data here
        ]);
        
        //return json_encode($data);
    }

    public function testeAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:teste.html.twig', []);
    }

}
