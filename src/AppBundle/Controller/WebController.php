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
use AppBundle\Entity\CpVille;
use AppBundle\Entity\OptimizerCss;
use AppBundle\Entity\OptimizerJs;
use AppBundle\Form\CalculDevisType;
use AppBundle\Repository\BandeRepository;
use AppBundle\Repository\CalculDevisRepository;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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
     * @Route("/get_cp_ville", name="getcpville")
     */
    public function GetCpVillePage(Request $request){

        $result = [];

        $getcp = $request->get('cp');

        if(strlen($getcp)==5){
            $product = $this->getDoctrine()
                ->getRepository(CpVille::class)
                ->findBy(array(
                    'cp' => $getcp,
                ));

            foreach ($product as $index=>$value){
                $result[] = [$value->getCp(),$value->getVille()];
            }
        }

        /*
        $ServerUrl = ($request->server->get('DOCUMENT_ROOT'));

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $csvdata = \file_get_contents($ServerUrl."/../laposte_hexasmal.csv");
        $csvdata = $serializer->decode($csvdata,'csv');

        $getcp = 65200;
        $resultville = [];




        $em = $this->getDoctrine()->getManager();
        $arraycpville=[];
        $vartxt = [];

        foreach ($csvdata as $index=>$value){
            $villecsv = explode(';',$value['Code_commune_INSEE;Nom_commune;Code_postal;Libelle_acheminement;Ligne_5;coordonnees_gps']);
          ///
            //  if($villecsv[2] == $getcp)
            {
                $cpville = new CpVille();
                $cpville->setCp($villecsv[2])->setVille($villecsv[3]);
                $em->persist($cpville);
            }
        }

        $em->flush(); */


        return  new JsonResponse($result);

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


        $bande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Bande');
        $bande = $bande->findBy(array(),array('id' => 'DESC'),5);

        $htmlRender = $this->render('Pages/homepage.html.twig', array(
            'calculdevisform' => $calculdevisform->createView(),
            'bande' => $bande,
        ));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }
}