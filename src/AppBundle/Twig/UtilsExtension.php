<?php

namespace AppBundle\Twig;

use Twig_Environment;
use Symfony\Component\Intl\Intl;
use AppBundle\Utils\Utils;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class UtilsExtension extends \Twig_Extension {

    protected $twig;
    protected $pathFunction;
    private $container;
    private $translator;

    public function __construct($container, Translator $translator) {
        $this->container = $container;
        $this->translator = $translator;
    }

    protected function getPathFunction() {
        if (empty($this->pathFunction)) {
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
        $path_function = $this->getPathFunction();
        $title = $post->getTitle();
        $slug = Utils::slugify($title);

        return call_user_func($path_function, 'post', array(
            'title' => $slug,
        ));
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

}
