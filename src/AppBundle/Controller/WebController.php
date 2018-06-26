<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 08.04.2018
 * Time: 01:26
 */

namespace AppBundle\Controller;


use AppBundle\AppBundle;
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
use Symfony\Component\Form\FormInterface;
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
        $connection = $this->getDoctrine()->getManager()->getConnection();

        $query = "SELECT cp,ville FROM  cp_ville WHERE cp LIKE ?";
        $newresult = $connection->executeQuery($query, array('%'.$getcp.'%'), array(\PDO::PARAM_STR))->fetchAll();

         foreach ($newresult as $index=>$value){
               $result[] = [$value['cp'],$value['ville']];
         }
        return  new JsonResponse($result);
    }

    public function MergeArrayObj($task, $formarray){


        $getters = array_filter(get_class_methods(new CalculDevis()), function($method) {
            return 'get' === substr($method, 0, 3);
        });

        foreach ($getters as $value){
            //dump($formarray->{$value}());
           /// dump($task->{$value}());
        }

        $obj_merged = array_merge((array) $task, (array) $formarray);

//        dump($formarray->{'getNom'}());
 //       dump($formarray);
  //      dump($task);
   //     dump($obj_merged);
        foreach ($formarray as $key=>$value){
     //       dump($key);
        }

      exit();
    }

    public function getFormStep(){
        $form_step = 1;
        if(!is_null($this->get('session')->get('form_step')))
        {
            $form_step = $this->get('session')->get('form_step');
        }
        return $form_step;
    }

    public function setFormStep($form_step){
        $this->get('session')->set('form_step',$form_step);
    }

    public function removeFormStep(){
        $this->get('session')->remove('form_step');
        $this->get('session')->remove('tasktotal');

    }

    public function SaveStepValues(FormInterface $FormInterface,$class){

        if(is_null(($tasktotal = $this->get('session')->get('tasktotal')))){
            $this->get('session')->set('tasktotal',$FormInterface->getData());
        }
        else{

           /// dump(get_class_methods($FormInterface->getConfig()->getDataClass()));
            foreach (get_class_methods ($class) as $obj){
                if(strpos($obj,'set') !== false || strpos($obj,'get') !== false)
                {
                    if( strpos($obj,'get') !== false){
                        if(($taskval = $FormInterface->getData()->{$obj}()) != null ){
                            $tasktotal->{str_replace('get','set',$obj)}($taskval);
                        }
                    }
                }
            }
            $this->get('session')->set('tasktotal',$tasktotal);
        }
    }

    public function SaveFormValues(){
        $em = $this->getDoctrine()->getManager();
        $em->persist($this->get('session')->get('tasktotal'));
        $em->flush();
    }
    public function CheckFiniStep(){
        $caluldevisType = new CalculDevisType();
        if($caluldevisType->GetMaxStep() < $this->getFormStep())
        {
            //Enregistrer tout les values all steps
            $this->SaveFormValues();
            $this->removeFormStep();
            $this->addFlash(
                'succes',
                'Your changes were saved!'
            );
            return true;
        }
        return false;
    }

    /**
     * @Route("/contact", name="contactpage")
     */
    public function ContactPage(Request $request){

        $this->addFlash('success','Bonjour Ruben');
        $htmlRender = $this->render('Pages/homepage.html.twig', array(
        ));

        $this->LoadCssLoader($request);
        return $htmlRender;

    }

    /**
     * @Route("/prix", name="prixpage")
     */
    public function PrixPages(Request $request){

        $caluldevis = new CalculDevis();
        $form_step = $this->getFormStep();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis, array(
            'form_step' => $form_step,
        ));

        $resultino = null;

        $calculdevisform->handleRequest($request);
        if($calculdevisform->isSubmitted()) {

            if($calculdevisform->isValid())
            {
                $this->SaveStepValues($calculdevisform, new CalculDevis());
                $form_step++;
                $this->setFormStep($form_step);
                if($this->CheckFiniStep()==true)
                {
                    $this->addFlash('success','Votre demande de devis a bien été prise en compte');
                    return $this->redirectToRoute('prixpage');
                }
            }

            $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis,array(
                'form_step' => $form_step,
            ));
            $calculdevisform->handleRequest($request);
            $resultino = $this->get('session')->get('tasktotal');
        }
        else if($form_step>1)
        {
            $this->removeFormStep();
            return $this->redirectToRoute('prixpage');
        }


        $bande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Bande');
        $bande = $bande->findBy(array(),array('id' => 'DESC'),3);

        $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Articles');
        $articles = $articles->findBy(array('namePage' => 'homepage'));

        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $imagebande = $this->getDoctrine()->getManager()->getRepository('AppBundle:ImageBande');
        $imagebande = $imagebande->findBy(array(),array('id' => 'DESC'),10);

        $social = $this->getDoctrine()->getManager()->getRepository('AppBundle:Social');
        $social =  $social->findAll();

        $htmlRender = $this->render('Pages/homepage.html.twig', array(
            'calculdevisform' => $calculdevisform->createView(),
            'calculdevisresult' => $resultino,
            'bande' => $bande,
            'societe' => $societe,
            'articles' => $articles,
            'imagebandes' => $imagebande,
            'social' => $social,
        ));

        $this->LoadCssLoader($request);
        return $htmlRender;

    }

    /**
     * @Route("/", name="homepage")
     */
    public function IndexPages(Request $request){
        $caluldevis = new CalculDevis();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis,array(
            'action' => $this->generateUrl('prixpage'),
        ));

        $bande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Bande');
        $bande = $bande->findBy(array(),array('id' => 'DESC'),3);

        $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Articles');
        $articles = $articles->findBy(array('namePage' => 'homepage'));

        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $imagebande = $this->getDoctrine()->getManager()->getRepository('AppBundle:ImageBande');
        $imagebande = $imagebande->findBy(array(),array('id' => 'DESC'),10);

        $social = $this->getDoctrine()->getManager()->getRepository('AppBundle:Social');
        $social =  $social->findAll();

        $htmlRender = $this->render('Pages/homepage.html.twig', array(
            'calculdevisform' => $calculdevisform->createView(),
            'bande' => $bande,
            'societe' => $societe,
            'articles' => $articles,
            'imagebandes' => $imagebande,
            'social' => $social,
        ));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }
}