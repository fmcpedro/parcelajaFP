<?php

namespace AppBundle\Twig;

use Twig_Environment;
use Symfony\Component\Intl\Intl;
use AppBundle\Utils\Utils;
use Symfony\Component\Translation\Translator;


use Symfony\Component\DependencyInjection\ContainerInterface;




class UtilsExtension extends \Twig_Extension {

    protected $twig;
    protected $pathFunction;
    private $container;
    private $translator;


    public function __construct(ContainerInterface $container, Translator $translator) {
        $this->container = $container;
        $this->translator = $translator;
    }

    protected function getPathFunction() {

        dump($this);
        
        if (empty($this->pathFunction) ) {
            $this->pathFunction = $this->twig->getFunction('path')->getCallable();
        }

        
        
        return $this->pathFunction;
    }

    public function initRuntime(Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function getName() {
        return 'App Utils';
    }

    public function getFunctions() {
        return array(
            // Intl helper functions.
            new \Twig_SimpleFunction('intl_country_name', array($this, 'intl_country_name')),
            new \Twig_SimpleFunction('intl_locale_name', array($this, 'intl_locale_name')),
            new \Twig_SimpleFunction('url_to_post', array($this, 'url_to_post')),
            // Other helpers
            new \Twig_SimpleFunction('sk_build_query', array($this, 'sk_build_query')),
            new \Twig_SimpleFunction('slugify', array($this, 'slugify')),
            new \Twig_SimpleFunction('unslugify', array($this, 'unslugify')),
            new \Twig_SimpleFunction('month_name', array($this, 'month_name')),
            new \Twig_SimpleFunction('start_and_end_week', array($this, 'start_and_end_week')),
        );
    }

    /**
     * Intl helper functions.
     */
    public function intl_country_name($country_code) {
        return Intl::getRegionBundle()->getCountryName($country_code);
    }

    public function intl_locale_name($locale_code) {
        return Intl::getLocaleBundle()->getLocaleName($locale_code);
    }

    public function url_to_post($post) {
        //$path_function = $this->getPathFunction();
        
        //$path_function = "path";
        $title = $post->getTitle();
        $slug = Utils::slugify($title);

        

        
        return "vla";
        
//        return call_user_func($path_function, 'post', array(
//            'title' => $slug,
//        ));
//        
//        
        
        
    }

    /*
     * Other helpers.
     */

    public function sk_build_query($array) {
        return html_build_query($array);
    }

    public function slugify($string) {
        return Utils::slugify($string);
    }

    public function unslugify($string) {
        return Utils::unslugify($string);
    }

    public function month_name($monthNum) {

        $dateObj = \DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        return $monthName;
    }

    function start_and_end_week($week, $year) {

        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret['week_start'] . " - " . $ret['week_end'];
    }

}
