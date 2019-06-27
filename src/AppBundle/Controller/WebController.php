<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 08.04.2018
 * Time: 01:26
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CalculDevis;
use AppBundle\Entity\Carton;
use AppBundle\Entity\CartonsForm;
use AppBundle\Entity\Contact;
use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\GardeMeube;
use AppBundle\Entity\OptimizerCss;
use AppBundle\Entity\OptimizerJs;
use AppBundle\Entity\Prestation;
use AppBundle\Entity\SEO;
use AppBundle\Entity\VisiteTechnique;;
use AppBundle\Form\CalculDevisType;
use AppBundle\Form\CartonForm;
use AppBundle\Form\ContactForm;
use AppBundle\Form\DevisForm;
use AppBundle\Form\GardeMeubleForm;
use AppBundle\Form\VisiteTechniqueForm;
use AppBundle\Service\AddDevisBase;
use AppBundle\Service\CalculPrixService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Twig_Environment;

class WebController extends Controller
{

    private $twig;
    private $addDevisService;
    private $calculPrixService;
    protected $requestStack;


    public function __construct(Twig_Environment $twig, AddDevisBase $addDevisBase, CalculPrixService $calculPrixService, RequestStack $requestStack)
    {
        $this->twig = $twig;
        $this->addDevisService = $addDevisBase;
        $this->calculPrixService = $calculPrixService;
        $this->requestStack = $requestStack;
    }

    /*
     * Load All another elements of the web site
     */
    private function getWebElements(){

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

        $seo = $this->getDoctrine()->getManager()->getRepository(SEO::class);

        // We get INFO SEP Path of Url page
        $seo_page = $seo->findBy([
            'url' => $this->requestStack->getCurrentRequest()->getPathInfo(),
        ]);

        return array(
            'bande' => $bande,
            'societe' => $societe,
            'articles' => $articles,
            'imagebandes' => $imagebande,
            'social' => $social,
            'seo_page' => $seo_page,
        );
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
     * @Route("/set_devis_ayax", name="setdevisayax")
     */
    public function setDevisAyax(Request $request) {

        $json = json_decode($request->get('json_devis'), true);

        $id_prestation = $json['prestation'];
        switch ($json['prestation']) {
            case 'Economique':
                $id_prestation = 1;
                break;
            case 'Standard':
                $id_prestation = 2;
                break;
            case 'Luxe':
                $id_prestation = 3;
                break;
            default:
                $id_prestation = 1;
        };

        $prestation = $this->getDoctrine()->getRepository(Prestation::class)->find($id_prestation);

        $devis = new DemandeDevis();

        $devis->setNom($json['nom']);
        $devis->setPrenom($json['prenom']);
        $devis->setTelephone($json['telephone']);
        $devis->setPortable($json['portable']);
        $devis->setEmail($json['email']);
        $devis->setDate1($json['date1']);
        $devis->setDate2($json['date2']);
        $devis->setCp1($json['cp1']);
        $devis->setCp2($json['cp2']);
        $devis->setVille1($json['ville1']);
        $devis->setVille2($json['ville2']);
        $devis->setPays1($json['pays1']);
        $devis->setPays2($json['pays2']);
        $devis->setPrestation($prestation);
        $devis->setVolume($json['volume']);
        $devis->setEtage1($json['etage1']);
        $devis->setEtage2($json['etage2']);
        $devis->setAscenseur1($json['ascenseur1']);
        $devis->setAscenseur2($json['ascenseur2']);
       /// $devis->setDistance($json['distance']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();

        return  new JsonResponse($json, 200);
    }

    /**
     * @Route("/get_cp_ville", name="getcpville")
     */
    public function GetCpVillePage(Request $request){

        $result = [];
        $getcp = $request->get('cp');
        $connection = $this->getDoctrine()->getManager()->getConnection();

        $query = "SELECT cp,ville FROM code_postal WHERE cp LIKE ?";
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

        $demandedevis = new DemandeDevis();
        $demandedevis->setNom($this->get('session')->get('tasktotal')->getNom());
        $demandedevis->setPrenom($this->get('session')->get('tasktotal')->getPrenom());
        $demandedevis->setTelephone($this->get('session')->get('tasktotal')->getTelephone());
        $demandedevis->setPortable($this->get('session')->get('tasktotal')->getPortable());
        $demandedevis->setEmail($this->get('session')->get('tasktotal')->getEmail());


        $demandedevis->setDate1($this->get('session')->get('tasktotal')->getDate1());
        $demandedevis->setCp1($this->get('session')->get('tasktotal')->getCp1());
        $demandedevis->setAdresse1($this->get('session')->get('tasktotal')->getAdresse1());
        $demandedevis->setPays1($this->get('session')->get('tasktotal')->getPays1());
        $demandedevis->setEtage1($this->get('session')->get('tasktotal')->getEtage1());
        $demandedevis->setAscenseur1($this->get('session')->get('tasktotal')->getAscenseur1());
        $demandedevis->setComment1($this->get('session')->get('tasktotal')->getComment1());

        if(empty($this->get('session')->get('tasktotal')->getDate2())) {
            $demandedevis->setDate2($this->get('session')->get('tasktotal')->getDate1());
        }
        else {
            $demandedevis->setDate2($this->get('session')->get('tasktotal')->getDate2());
        }
        $demandedevis->setCp2($this->get('session')->get('tasktotal')->getCp2());
        $demandedevis->setAdresse2($this->get('session')->get('tasktotal')->getAdresse2());
        $demandedevis->setPays2($this->get('session')->get('tasktotal')->getPays2());
        $demandedevis->setEtage2($this->get('session')->get('tasktotal')->getEtage2());
        $demandedevis->setAscenseur2($this->get('session')->get('tasktotal')->getAscenseur2());
        $demandedevis->setComment2($this->get('session')->get('tasktotal')->getComment2());


        $prestation = 1;
        switch ($this->get('session')->get('tasktotal')->getPrestation()) {
            case 'Standard':
                $prestation = 2;
                break;
            case 'Économique':
                $prestation = 1;
                break;
            case 'Luxe':
                $prestation = 3;
                break;
        }

        $prestationEntity = $this->getDoctrine()->getManager()->getRepository(Prestation::class)->find($prestation);
        $demandedevis->setPrestation($prestationEntity);
        $demandedevis->setVolume($this->get('session')->get('tasktotal')->getVolume());

        $em = $this->getDoctrine()->getManager();
        $em->persist($demandedevis);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $em->persist($this->get('session')->get('tasktotal'));
        $em->flush();


///        $this->addDevisService->AddDevis($this->get('session')->get('tasktotal'),$this->getDoctrine()->getManager());
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
     * @Route("/visite-technique ", name="visitetechniquepage")
     */
    public function VisiteTechniquePage(Request $request) {
        $visite_technique = new VisiteTechnique();
        $visite_technique_form = $this->createForm(VisiteTechniqueForm::class, $visite_technique, [
            'action' => $this->generateUrl('visitetechniquepage'),
        ]);

        $visite_technique_form->handleRequest($request);
        if($visite_technique_form->isSubmitted() && $visite_technique_form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite_technique_form->getData());
            $em->flush();

            $this->addFlash('success','Votre demande a bien été prise en compte');
            return $this->redirectToRoute('visitetechniquepage');
        }

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'devisform' => $visite_technique_form->createView(),
            'class_top_block' => 'devis_page',
        ],
        $this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }


    /**
     * @Route("/garde-meuble ", name="gardemeuble")
     */
    public function GardeMeulePage(Request $request) {
        $garde_meuble = new GardeMeube();
        $garde_meuble_form = $this->createForm(GardeMeubleForm::class, $garde_meuble, [
            'action' => $this->generateUrl('gardemeuble'),
        ]);

        $garde_meuble_form->handleRequest($request);
        if($garde_meuble_form->isSubmitted() && $garde_meuble_form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($garde_meuble_form->getData());
            $em->flush();

            $this->addFlash('success','Votre demande a bien été prise en compte');
            return $this->redirectToRoute('gardemeuble');
        }

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'devisform' => $garde_meuble_form->createView(),
            'class_top_block' => 'devis_page',
        ],
        $this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;

    }
    /**
     * @Route("/cartons", name="cartonspage")
     */
    public function CartonsPage(Request $request){
        $contact = new Contact();
        $contactform = $this->createForm(ContactForm::class, $contact, [
            'action' => $this->generateUrl('cartonspage'),
        ]);
        $contactform->handleRequest($request);
        if($contactform->isSubmitted() && $contactform->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactform->getData());
            $em->flush();

            $this->addFlash('success','Votre message a bien été prise en compte');
            return $this->redirectToRoute('cartonspage');
        }

        $carton = new CartonsForm();
        $cartonForm  = $this->createForm(CartonForm::class, $carton, [
            'action' => $this->generateUrl('cartonspage')
        ]);
        $cartonForm->handleRequest($request);
        if($cartonForm->isSubmitted() && $cartonForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Creating Key list for carton  reciving from Array
            $carton_key = [];
            // Get all Key from Json
            foreach (json_decode($cartonForm->getData()->getCartonJson()) as $key=>$carton_array) {
                $carton_key[] = $key;
            }

            // Make new Carton Array in Carton class
            // Create query SQL
            $cartonsPersist = $em->getRepository(Carton::class)
                ->findBy(['code_carton' => $carton_key])
            ;
            // Make cartonPersist in to class
            $cartonForm->getData()->setCarton($cartonsPersist);

            // Save new Data Form
            $em->persist($cartonForm->getData());
            $em->flush();

            $this->addFlash('success','Votre demande cartons pris en compte');
            return $this->redirectToRoute('cartonspage');
        }

        //Get all Cartons Docrtine
        $allCartons = $this->getDoctrine()->getRepository(Carton::class)->findAll();

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'devisform' => $contactform->createView(),
            'cartonsform' => $cartonForm->createView(),
            'class_top_block' => 'cartons_page',
            'allCartons' => $allCartons,
            'imageBlockStop' => true,
        ],

        $this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }
    /**
     * @Route("/avis", name="avispage")
     */
    public function AvisPage(Request $request) {
        $caluldevis = new CalculDevis();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis,array(
            'action' => $this->generateUrl('prixpage'),
        ));

        $prestation_top_text = '';

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge(array(
            'calculdevisform' => $calculdevisform->createView(),
            'prestation_top_text' => $prestation_top_text,
            'moyen_avis' => 4.8,
            'imageBlockStop' => true,
        ), $this->getWebElements()));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }

    /**
     * @Route("/contact", name="contactpage")
     */
    public function ContactPage(Request $request){

        $contact = new Contact();
        $contactform = $this->createForm(ContactForm::class, $contact, [
            'action' => $this->generateUrl('contactpage'),
        ]);
        $contactform->handleRequest($request);
        if($contactform->isSubmitted() && $contactform->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactform->getData());
            $em->flush();

            $this->addFlash('success','Votre message a bien été prise en compte');
            return $this->redirectToRoute('contactpage');
        }
        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'devisform' => $contactform->createView(),
        ],
        $this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }

    /**
     * @Route("/prestation", name="prestation")
     * @Route("/assurance", name="assurance")
     * @Route("/location", name="locationpage")
     */
    public function PrestationPage(Request $request){
        $caluldevis = new CalculDevis();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis,array(
            'action' => $this->generateUrl('prixpage'),
        ));

        $prestation_top_text = '';

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge(array(
            'calculdevisform' => $calculdevisform->createView(),
            'prestation_top_text' => $prestation_top_text,
        ), $this->getWebElements()));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }


    /**
     * @Route("/espace-demenageur", name="espacedemenageurpage")
     */
    public function EspaceDemenageur(Request $request){

        $csrf_token = $this->has('security.csrf.token_manager') ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue() : null;


        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;





        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'imageBlockStop' => true,
            "csrf_token" => $csrf_token,
            "last_username" => $lastUsernameKey,
        ],$this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }
    /**
     * It will make all subdomains for the web site
     *
     * @Route("/", name="strasbourgpage", host="{subdomains}.xn--dmnagements-bbbb.fr")
     */
    public function SubDomainsPage (Request $request, $subdomains) {

        $caluldevis = new CalculDevis();
        $calculdevisform = $this->createForm(CalculDevisType::class,$caluldevis,array(
            'action' => $this->generateUrl('prixpage'),
        ));


        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'subdomains' => $subdomains,
            'calculdevisform' => $calculdevisform->createView(),
        ],$this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }

    /**
     * @Route("/mentions-legales", name="mentionslegalespage")
     */
    public function MentionLegalesPage(Request $request){

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([

        ],$this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }
    /**
     * @Route("/devis", name="devispage")
     */
    public function DevisPage(Request $request){

        $demandedevis = new DemandeDevis();
        $devisform = $this->createForm(DevisForm::class,$demandedevis);
        $devisform->handleRequest($request);
        if($devisform->isSubmitted() && $devisform->isSubmitted()){
            $em = $this->getDoctrine()->getManager();

            // Get Villes Depart et Arrive
            $ville1 = substr( $devisform->getData()->getCp1(),6);
            $ville2 = substr( $devisform->getData()->getCp2(),6);

            // Set Villes in CsClass Array
            $devisform->getData()->setVille1($ville1);
            $devisform->getData()->setVille2($ville2);


            /// IDEOTIZMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM!!!!
            ///
            ///

            $prestation = 1;
            switch ($devisform->getData()->getPrestation()) {
                case 'Standard':
                    $prestation = 2;
                    break;
                case 'Économique':
                    $prestation = 1;
                    break;
                case 'Luxe':
                    $prestation = 3;
                    break;
            }
            $prestationEntity = $this->getDoctrine()->getManager()->getRepository(Prestation::class)->find($prestation);
            $devisform->getData()->setPrestation($prestationEntity);


            $em->persist($devisform->getData());
            $em->flush();

            $this->addFlash('success','Votre demande de devis a bien été prise en compte');
            return $this->redirectToRoute('devispage');

        }


        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge([
            'devisform' => $devisform->createView(),
            'class_top_block' => 'devis_page',
        ],$this->getWebElements()));
        $this->LoadCssLoader($request);
        return $htmlRender;
    }



    /**
     * @Route("/prix", name="prixpage")
     * @Route("/declaration-de-valeur", name="declarationdevaleurpage")
     */
    public function PrixPages(Request $request){

        $totalprix = null;
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
            $totalprix = $this->calculPrixService->GetCalculPrix($resultino);
        }
        else if($form_step>1)
        {
            $this->removeFormStep();
            return $this->redirectToRoute('prixpage');
        }

        $htmlRender = $this->render('Pages/homepage.html.twig',array_merge( array(
            'calculdevisform' => $calculdevisform->createView(),
            'calculdevisresult' => $resultino,
            'calculdevisresult1' => $totalprix,
        ),$this->getWebElements()));

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

        $htmlRender = $this->render('Pages/homepage.html.twig', array_merge(array(
            'calculdevisform' => $calculdevisform->createView(),
        ), $this->getWebElements()));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }
}