<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 08.04.2018
 * Time: 01:26
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CalculDevis;
use AppBundle\Entity\Contact;
use AppBundle\Entity\OptimizerCss;
use AppBundle\Entity\OptimizerJs;
use AppBundle\Form\CalculDevisType;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Twig_Environment;

class WebController extends Controller
{

    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Load Twgig Extension pour optimisation du CSS cssloader
     */
    private function LoadCssLoader(Request $request){
        $ArrayExtensions = $this->twig->getExtension('AppBundle\Twig\AppExtension');


        $csstext = '';
        $jstext = '';
        $kernel= $this->get('kernel');

        $ServerUrl = ($request->server->get('DOCUMENT_ROOT'));

        // Recuperation tous les CSS valeurs des TWIG(s) Twig Extension cssloader
        foreach ($ArrayExtensions->cssArray as $key=>$cssArray){
            $csstext.=\file_get_contents($ServerUrl.$cssArray);
        }
        // Recuperation tous les JS valeurs des TWIG(s) Twig Extension cssloader
        foreach ($ArrayExtensions->jsArray as $key=>$jsArray){
            $jstext.=\file_get_contents($ServerUrl.$jsArray);
        }

        // Class to Optiizers CSS
        $optimcss = new OptimizerCss();
        // Class to Optiizers CSS
        $optimjs = new OptimizerJs();

        // Recuperation CSS File name qui ete deini sur config.yml
        $filecss = $this->container->getParameter('cssFileName');
        $filejs = $this->container->getParameter('jsFileName');

        // Si encore le path n'existe pas on cree
        $fs = new Filesystem();
        $fs->mkdir($ServerUrl.'/css');
        $fs->mkdir($ServerUrl.'/js');

        \file_put_contents($ServerUrl.'/css/'.$filecss,$optimcss->optimizeCss($csstext));
        \file_put_contents($ServerUrl.'/js/'.$filejs,$optimjs->minifyJavascript($jstext));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function IndexPages(Request $request){


        $caluldevis = new CalculDevis();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis);
        $calculdevisform->handleRequest($request);
        if ($calculdevisform->isSubmitted() && $calculdevisform->isValid()) {
            $task = $calculdevisform->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès');
            return $this->redirectToRoute('homepage');
        };


        $htmlRender = $this->render('Pages/homepage.html.twig', array(
            'calculdevisform' => $calculdevisform->createView(),
        ));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }
}