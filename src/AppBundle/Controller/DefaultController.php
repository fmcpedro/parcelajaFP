<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Utils\Utils;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {

        return $this->render('AppBundle:default:v2_index.html.twig');
    }

    public function paraClientesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $agencias = $em->getRepository('AppBundle:Tagency')->findBy(array('fstate' => 1));
        $grupos = $em->getRepository('AppBundle:TGroup')->findBy(array('fstate' => 1));
        
        //$subGrupos = $em->getRepository('AppBundle:TSubGroup')->findBy(array('fstate' => 1));
        $subGrupos = $em->getRepository('AppBundle:TSubGroup')->findAll();
        
        
        //dump($subGrupos);
        //dump($agencias);
        

        return $this->render('AppBundle:default:v2_para_clientes.html.twig', array(
                    'agencias' => $agencias,
                    'sub_grupos' => $subGrupos,
                    'grupos' => $grupos
        ));
    }

    public function comoFuncionaAction(Request $request) {

        return $this->render('AppBundle:default:v2_como_funciona.html.twig');
    }

    public function blogAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:WsPost')->findAll();

        return $this->render('AppBundle:default:v2_blog.html.twig', array(
                    'posts' => $posts
        ));
    }

    public function postAction($title) {

        $em = $this->getDoctrine()->getManager();
        $unslug = Utils::unslugify($title);

        $post = $em->getRepository('AppBundle:WsPost')->findOneBy(array('title' => $unslug));
        $posts = $em->getRepository('AppBundle:WsPost')->findAll();

        return $this->render('AppBundle:default:v2_post.html.twig', array(
                    'posts' => $posts,
                    'post' => $post));
    }

    public function contactosAction(Request $request) {

        $contact = new Contact();
        $contact->setFirstValue(rand(0, 9));
        $contact->setSecondValue(rand(0, 9));

        $form = $this->createForm('AppBundle\Form\WsContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $name = $form["name"]->getData();
            $email = $form["email"]->getData();
            $subject = $form["subject"]->getData();
            $phone = $form["phone"]->getData();
            $message = $form["message"]->getData();

            $firstValue = $form["firstValue"]->getData();
            $secondValue = $form["secondValue"]->getData();
            $validation = $form["validation"]->getData();

//            //VALIDACAO ARITMETICA CORRECTA
            if (($firstValue + $secondValue) != $validation) {
                $form->get('validation')->addError(new \Symfony\Component\Form\FormError('Validação aritmetica incorrecta!'));
            }

            if ($form->isValid()) {
//                            //enviar email   
                // CONFIG YOUR EMAIL MESSAGE
                //============================================================
                $body = '<p>The following request was sent from: </p>';
                $body .= '<p>Name: ' . $name . '</p>';
                $body .= '<p>Email: ' . $email . '</p>';
                $body .= '<p>Subject: ' . $subject . '</p>';
                $body .= '<p>Phone: ' . $phone . '</p>';
                $body .= '<p>Message: ' . $message . '</p>';

                $emailSubject = 'ParcelaJá - Contacto/Sugestão/Duvida de ' . $name;

                $email_message = Swift_Message::newInstance()
                        ->setSubject($emailSubject)
                        ->setFrom('suporte@parcelaja.pt')
                        ->setTo('suporte@parcelaja.pt')
                        ->setCc('lmiguens@consolidador.com')
                        ->setReplyTo($email)
                        ->setBody($body, 'text/html');

                $this->get('mailer')->send($email_message);

                $this->get('session')->getFlashBag()->add('notice', 'Obrigado por nos contactar!');
                return $this->redirectToRoute('contactos');
            }
        }

        return $this->render('AppBundle:default:v2_contactos.html.twig', array(
                    'contact' => $contact,
                    'form' => $form->createView(),
        ));



        return $this->render('AppBundle:default:v2_contactos.html.twig');
    }

    public function faqsAction(Request $request) {

        return $this->render('AppBundle:default:v2_faqs.html.twig');
    }

    public function empregoAction(Request $request) {

        return $this->render('AppBundle:default:v2_emprego.html.twig');
    }

    public function noticiasAction(Request $request) {


        $em = $this->getDoctrine()->getManager();
        $noticias = $em->getRepository('AppBundle:WsMedia')->findAll();

        return $this->render('AppBundle:default:v2_noticias.html.twig', array(
                    'noticias' => $noticias)
        );
    }

    public function legalAction(Request $request) {

        return $this->render('AppBundle:default:v2_legal.html.twig');
    }

    public function pciAction(Request $request) {

        return $this->render('AppBundle:default:v2_pci.html.twig');
    }
    
    public function cookiesAction(Request $request) {

        return $this->render('AppBundle:default:v2_cookies.html.twig');
    }

    public function emailAction(Request $request) {

        // CONFIG YOUR FIELDS
        //============================================================
        //$name = filter_var($request->request->get("name"), FILTER_SANITIZE_STRING) . ' ' . filter_var($request->request->get("last-name"), FILTER_SANITIZE_STRING);
        $name = filter_var($request->request->get("name"), FILTER_SANITIZE_STRING);
        $email = filter_var($request->request->get("email"), FILTER_SANITIZE_EMAIL);
        $subject = filter_var($request->request->get("subject"), FILTER_SANITIZE_STRING);
        $phone = filter_var($request->request->get("phone"), FILTER_SANITIZE_STRING);
        $message = filter_var($request->request->get("message"), FILTER_SANITIZE_STRING);

        $first_value = filter_var($request->request->get("first_value"), FILTER_SANITIZE_NUMBER_INT);
        $second_value = filter_var($request->request->get("second_value"), FILTER_SANITIZE_NUMBER_INT);
        $validation = filter_var($request->request->get("validation"), FILTER_SANITIZE_NUMBER_INT);


        // CONFIG YOUR EMAIL MESSAGE
        //============================================================
        $body = '<p>The following request was sent from: </p>';
        $body .= '<p>Name: ' . $name . '</p>';
        $body .= '<p>Email: ' . $email . '</p>';
        $body .= '<p>Subject: ' . $subject . '</p>';
        $body .= '<p>Phone: ' . $phone . '</p>';
        $body .= '<p>Message: ' . $message . '</p>';


        $emailSubject = 'ParcelaJá - Contacto/Sugestão/Duvida de ' . $name;


        $email_message = Swift_Message::newInstance()
                ->setSubject($emailSubject)
                ->setFrom('suporte@parcelaja.pt')
                ->setTo('suporte@parcelaja.pt')
                ->setCc('lmiguens@consolidador.com')
                ->setReplyTo($email)
                ->setBody($body, 'text/html');



        //VALIDACAO ARITMETICA CORRECTA
        if (($first_value + $second_value) == $validation) {

            if (!$this->get('mailer')->send($email_message)) {
                $data['error']['title'] = 'Message could not be sent.';
                //$data['error']['details'] = 'Mailer Error: ' . $mail->ErrorInfo;
                $data['error']['details'] = 'Mailer Error: ';
                return new JsonResponse([
                    'success' => false,
                    'data' => $data // Your data here
                ]);
            }

            $data['success']['title'] = 'Message sent.';

            return new JsonResponse([
                'success' => true,
                'data' => $data // Your data here
            ]);

            //VALIDACAO ARITMETICA NAO CORRECTA
        } else {
            $data['error']['title'] = 'Message could not be sent.';
            //$data['error']['details'] = 'Mailer Error: ' . $mail->ErrorInfo;
            $data['error']['details'] = 'Aritmetic validation error ' . ($first_value + $second_value) . 'and ' . $validation;
            return new JsonResponse([
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
