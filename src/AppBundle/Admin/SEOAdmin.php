<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 07/10/2018
 * Time: 12:31
 */

namespace AppBundle\Admin;


use AppBundle\Entity\SEO;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SEOAdmin extends AbstractAdmin
{
    private $em;

    public function __construct($code, $class, $baseControllerName, $em) {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }

    protected function configureFormFields(FormMapper $formMapper){


        $formMapper
            ->add('url')
            ->add('title')
            ->add('keywords')
            ->add('description')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('url')
            ->add('title')
            ->add('keywords')
            ->add('description')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {


        $router = $this->getConfigurationPool()->getContainer()->get('router');
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();


        /// We get All router saving in SEO
        $seo_array = $this->em->getRepository(SEO::class)->findAll();
        $array_seo_url = [];
        foreach ($seo_array as $seo_path) {
            $array_seo_url[] = $seo_path->getUrl();
        }



        // Seo Add Path  Array
        $seo_add_array = [];

        // Get All routes fot page site
        foreach ($allRoutes as $route) {
            if(
                strpos($route->getPath(), '_profiler') == false
                && strpos($route->getPath(), '_wdt') == false
                && strpos($route->getPath(), '_error') == false
                && strpos($route->getPath(), 'admin') == false
                && strpos($route->getPath(), 'profile') == false
                && strpos($route->getPath(), 'resetting') == false
                && strpos($route->getPath(), 'register') == false
                && strpos($route->getPath(), 'logout') == false
                && strpos($route->getPath(), 'login') == false
                && strpos($route->getPath(), 'get_cp_ville') == false

            ){
                /// It will be get all Routes non indexet in Entity SEO
                // It well be added in SEO class all path not foundet
                if(array_search($route->getPath(), $array_seo_url) === false) {
                    $seoclass = new SEO();
                    $seoclass->setUrl($route->getPath());
                    $this->em->persist($seoclass);
                    $this->em->flush();
                }
            }
        }


        /*
        $router = $this->container->get('router');
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();
        */

        $listMapper
            ->addIdentifier('url')
            ->addIdentifier('title')
            ->addIdentifier('keywords')
            ->addIdentifier('description')
        ;
    }
}