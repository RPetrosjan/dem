<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 25/01/2019
 * Time: 23:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\MesDevis;
use AppBundle\Entity\User;
use AppBundle\Field\CustomFiledInterface;
use AppBundle\Form\DevisConfigForm;
use AppBundle\Form\MaSocieteForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AdminController
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{


    /** @var null|object  */
    private $userEntity;

    /** @var EntityManager */
    private $em;

    /** @var  TokenStorageInterface */
    private $tokenStorage;

    private $pdfGenerateService;

    /**
     * AdminController constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage) {

        $user= $tokenStorage->getToken()->getUser();
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->userEntity = $this->getUserEntity();
    }

    /**
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param DemandeDevis $devis
     * @param array $param
     * @return DevisEnvoye
     */
    private function DemandeDevisToDevisEnvoye($devis, array $param) {
        /** @var DevisEnvoye $devisEnvoye */
        $devisEnvoye = new DevisEnvoye();
        $devisEnvoye->setNom($devis->getNom());
        $devisEnvoye->setPrenom($devis->getPrenom());
        $devisEnvoye->setTelephone($devis->getTelephone());
        $devisEnvoye->setEmail($devis->getEmail());
        $devisEnvoye->setDate1($devis->getDate1());
        $devisEnvoye->setDate2($devis->getDate2());
        $devisEnvoye->setAdresse1($devis->getAdresse1());
        $devisEnvoye->setAdresse2($devis->getAdresse2());
        $devisEnvoye->setCp1($devis->getCp1());
        $devisEnvoye->setCp2($devis->getCp2());
        $devisEnvoye->setVille1($devis->getVille1());
        $devisEnvoye->setVille2($devis->getVille2());
        $devisEnvoye->setEtage1($devis->getEtage1());
        $devisEnvoye->setEtage2($devis->getEtage2());
        $devisEnvoye->setAscenseur1($devis->getAscenseur1());
        $devisEnvoye->setAscenseur2($devis->getAscenseur2());
        $devisEnvoye->setVolume($devis->getVolume());
        $devisEnvoye->setPrestation($devis->getPrestation());

        $devisEnvoye->setPrixht($param['prixht']);
        $devisEnvoye->setTva($param['tva']);
        $devisEnvoye->setAcompte($param['acompte']);
        $devisEnvoye->setFranchise($param['franchise']);
        $devisEnvoye->setValglobale($param['valglobale']);
        $devisEnvoye->setParobjet($param['parobjet']);
        $devisEnvoye->setValable($param['valable']);
        $devisEnvoye->setDistance($param['distance']);

        $devisEnvoye->setUserId($this->getUserEntity());
        $devisEnvoye->setDevisNumber($this->generateRandomString(5));

        return $devisEnvoye;
    }



    // TODO: REMOVE IN FUTURE !!!!!!!!!!!!!!!!!!!!!!!!
    /**
     * @param Request $request
     * @param $uuid
     * @return RedirectResponse
     */
    public function sendDevisPost(Request $request, $uuid, \Swift_Mailer $mailer) {


        $json = current(current($request->request))['json'];
        $devisconfig = json_decode($json, true);
        dump($devisconfig);

       /// $devisconfig = json_decode($json, true);
        exit();

        /*
        $prixht = $request->request->get('estimation_prix_form')['group1']['prixht'];
        $tva = $request->request->get('estimation_prix_form')['group1']['tva'];
        $acompte = $request->request->get('estimation_prix_form')['group2']['acompte'];
        $franchise = $request->request->get('estimation_prix_form')['group3']['franchise'];
        $valglobale = $request->request->get('estimation_prix_form')['group3']['valglobale'];
        $parobjet = $request->request->get('estimation_prix_form')['group3']['parobjet'];
        $valable = $request->request->get('estimation_prix_form')['group4']['valable'];
        $distance = $request->request->get('estimation_prix_form')['group4']['distance'];
        */

        $devis = $this->em->getRepository(DemandeDevis::class)->findOneBy([
            'uuid' => $uuid,
        ]);

        // We check if found devis with uuid in DemandeDevis
        if(is_null($devis)) {
            // If null we check if devis uuid from MesDevis
            $devis = $this->em->getRepository(MesDevis::class)->findOneBy([
                'uuid' => $uuid,
            ]);
        }

        // Check if devis null it will be check in DevisEnvoyer
        if(is_null($devis)) {
            $devis = $this->getDoctrine()
                ->getRepository(DevisEnvoye::class)
                ->findOneBy([
                    'uuid' => $request->get('uuid'),
                ]);
        }


        if(!is_null($devis)) {
            // Check If we have class in DevisEnvoye
            if (strpos(get_class($devis), 'DevisEnvoye') === false) {
                $devis = $this->DemandeDevisToDevisEnvoye($devis, [
                    'prixht' => $prixht,
                    'tva'    => $tva,
                    'acompte'=> $acompte,
                    'franchise' => $franchise,
                    'valglobale' => $valglobale,
                    'parobjet'   => $parobjet,
                    'valable'   => $valable,
                    'distance'  => $distance
                ]);

            } else {
                $devis->setPrixht($prixht);
                $devis->setTva($tva);
                $devis->setAcompte($acompte);
                $devis->setFranchise($franchise);
                $devis->setValglobale($valglobale);
                $devis->setParobjet($parobjet);
                $devis->setValable($valable);
                $devis->setDistance($distance);

            }
        }

        $this->em->persist($devis);
        $this->em->flush();

        $societe = $this->getUser();
        if(!is_null($this->getUser()->getParent())) {
            $societe = $this->getUser()->getParent();
        }

        $message = (new \Swift_Message('Votre Devis du déménagement'))
            ->setFrom([$this->container->getParameter('mailer_user') => $societe->getCompanyName()])
            ->setTo($devis->getEmail())
            ->setReplyTo($societe->getCompanyEmail())
            ///->setBcc('contact@demenagement-express.fr', 'Ruben Admin')
            ->setBody(
                $this->renderView(
                    'admin/email/standard/devis/send_devis_post.html.twig',[
                        'devis_info' => $devis,
                        'societe_info' => $societe,
                        'prixht' =>  $prixht,
                        'formatEmail' => 'html'
                    ]
                ),
                'text/html'
            )

            ->addPart(
                $this->renderView(
                    'admin/email/standard/devis/send_devis_post.html.twig',[
                        'devis_info' => $devis,
                        'societe_info' => $societe,
                        'prixht' =>  $prixht,
                        'formatEmail' => 'text'
                    ]
                ),
                'text/plain'
            )
            ;

        /** @var  pdfGenerateService */
        $this->pdfGenerateService = $this->container->get('pdf.devis.generator');
        // Creating PDF Devis
        $pdfDevis = $this->pdfGenerateService->pdfGenerate($devis, $societe, 'devis', 'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfDevis, 'devis.pdf', 'application/pdf');
        $message->attach($attachment);

        //Creating PDF CondGenerlae
        $pdfCondGen = $this->pdfGenerateService->pdfGenerate($devis, $societe, 'condition_generale', 'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfCondGen, 'Condition Generale.pdf', 'application/pdf');
        $message->attach($attachment);

        //Creating PDF Déclaration de valeur
        $pdfDecVal = $this->pdfGenerateService->pdfGenerate($devis, $societe, 'declaration_valeur', 'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfDecVal, 'Déclaration de valeur.pdf', 'application/pdf');
        $message->attach($attachment);

        if ($reponse = $mailer->send($message)) {
            $this->addFlash(
                'sonata_flash_success',
                '<i class="far fa-check-circle"></i> Votre estimation du devis a bien été envoyé '.$devis->getNom().' '.$devis->getPrenom().' ('.$devis->getEmail().')'
            );
        }
        else {
            $this->addFlash('errore','Errore d\'envie message');
        }

        return new RedirectResponse($request->headers->get('referer'));

       // $this->render('')

    }
    /**
     * Get User Entity
     *
     * @return null|object
     */
    public function getUserEntity() {

        $user = $this->tokenStorage->getToken()->getUser();
        if(!is_null($user->getParent())) {
            $user = $user->getParent();
        }

        return $this
            ->em
            ->getRepository(User::class)
            ->find($user->getId());
    }

    private $vars = array();

    /**
     * @Route("espace/app/soustraitance/{uuid}", requirements={"uuid" : "^(?!list)[^\/]+"} ,name="sous_traitance_info")
     * @param $uuid
     */
    public function getInfoSousTraitance($uuid) {

        $object = $this->em->getRepository(MesDevis::class)->findBy([
            'uuid' => $uuid,
        ]);

        $myCustomInterface = new CustomFiledInterface();
        $myCustomInterface->setName('prenom');
        $myCustomInterface->setType('text');


        /*
        $fieldDescription = FieldDescriptionInterface::class;
        $fieldDescription->setName('elements');
        dump($fieldDescription);
        exit();
        */

        $filedDescription = new FieldDescriptionCollection();
        $filedDescription->add($myCustomInterface);

        dump($filedDescription);


        return $this->render('admin/soustraitance_info_view.html.twig', [
            'admin' => [
                'show' => $filedDescription,
            ]
        ]);
    }


    /**
     * @Route("espace/app/{adminpage}/{uuid}/{type}",  requirements={"type" = "pdf"} ,name="devis_show_pdf")
     * @param $adminpage
     * @param $uuid
     * @param $type
     * @return
     */
     public function DevisShowPdf(Request $request, $adminpage, $uuid, $type) {

         $class = null;
         switch ($adminpage) {
             case 'demandedevis':
                 $class =  DemandeDevis::class;
                 break;
             case 'mesdevis':
                 $class =  MesDevis::class;
                 break;
             case 'devisenvoye':
                 $class =  DevisEnvoye::class;
                 break;
         }

        if(!is_null($class)) {
            $devis = $this->getDoctrine()
                ->getRepository($class)
                ->findOneBy([
                    'uuid' => $uuid,
                ]);

            if(!is_null($devis)) {
                return $this->container->get('pdf.devis.generator')->pdfShowDevis($devis, 'I');
            }
        }
        exit();
     }

    /**
     * @Route("espace/app/devisenvoye/{uuid}/{type}",  requirements={"type" = "devis|declaration_valeur|condition_generale|facture|lettre_chargement|lettre_dechargement"} ,name="devis_doc_generator")
     * @param $uuid
     * @param $type
     * @return
     */
    public function DevisDocsPdfGenerator(Request $request, $uuid, $type) {

        /** @var DevisEnvoye $devis */
        $devis = $this->getDoctrine()
            ->getRepository(DevisEnvoye::class)
            ->findOneBy([
               'uuid' => $uuid,
            ]);


        // TODO::Remove in future

/*
        $htmlRender = $this->render('admin/pdf/standard/test.html.twig', [
            'devisConfig' => null,
            'devisInfo' => $devis,
            'societeInfo' => $this->getUserEntity()
        ]);

        return $htmlRender;
*/


        /// pdfGenerate($devis, array $devisconfig, User $societe, $type_df, $type_output, array $twig_custom = null) {

        return $this->container->get('pdf.devis.generator')->pdfGenerate($devis, null, $this->getUserEntity(), $type, 'I');
    }

    /**
     * @Route("espace/app/devisprevisualise/{uuid}/{type}/{json}",  requirements={"type" = "devis|declaration_valeur|condition_generale|facture|lettre_chargement|lettre_dechargement"} ,name="devis_prev_doc_generator")
     * @param Request $request
     * @return
     * @throws \Exception
     */
    public function DevisPrevisualiserPdfGenerator(Request $request) {


        $json = $request->get('json');
        $devisconfig = json_decode($json, true);


        /** @var DevisEnvoye $devis */
        $devis = $this->getDoctrine()
            ->getRepository(DemandeDevis::class)
            ->findOneBy([
                'uuid' => $request->get('uuid'),
                ]);

        // Check if devis null it will be check in DevisEnvoyer
        if(is_null($devis)) {
            $devis = $this->getDoctrine()
                ->getRepository(DevisEnvoye::class)
                ->findOneBy([
                    'uuid' => $request->get('uuid'),
                ]);
        }

        // Check if devis null it will be check in MesDevis

        if(is_null($devis)) {
            $devis = $this->getDoctrine()
                ->getRepository(MesDevis::class)
                ->findOneBy([
                    'uuid' => $request->get('uuid'),
                ]);
        }

        if(!is_null($devis))  {
            return $this->container->get('pdf.devis.generator')->pdfGenerate($devis, $devisconfig, $this->getUserEntity(), $request->get('type'), 'I');
        }
        else {
            throw new NotFoundHttpException('Devis not found '.$request->get('uuid'));
        }
    }

    function unsetValue(array $array, $value, $strict = TRUE)
    {
        if(($key = array_search($value, $array, $strict)) !== FALSE) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * @Route("espace/app/ma-societe", name="masociete")
     * @param Request $request
     * @return Response
     */
    public function DevisConfigMaSocietePages(Request $request) {

        $this->container->get('admin.facture')->addFacture(1, rand(5, 15), "PayPal");

        // Get info user for fulling Form
        $maSocieteConfig =  $this->em->getRepository(User::class)->find($this->userEntity);
        $company_icon = '/'.$maSocieteConfig->getWebPath();

        //Generate form
        $maSocieteForm = $this->createForm(MaSocieteForm::class, $maSocieteConfig, [
            'action' => $this->generateUrl('masociete'),
            'label' => false,
            'attr' => [
                'company_icon' => $company_icon,
            ]
        ]);


        $maSocieteForm->handleRequest($request);
        if($maSocieteForm->isSubmitted() && $maSocieteForm->isValid()) {

            /** @var DevisConfig $devisConfig */
            $maSocieteData= $maSocieteForm->getData();
            $this->em->persist($maSocieteData);
            $this->em->flush();

            $this->addFlash(
                'sonata_flash_success',
                '<i class="far fa-check-circle"></i> Les données sont mises à jour'
            );

            return $this->redirectToRoute('masociete');
        }

        return $this->render('admin/custom_view.html.twig', array(
            'form' => $maSocieteForm->createView(),
            'company_icon' => $company_icon,
        ));
    }

    /**
     * @Route("espace/app/devisconfig", name="devisconfig")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function DevisConfigPages(Request $request){

        //Check if user have DevisConfig in DataBase
        /** @var DevisConfig $devisConfig */
        $devisConfig = current($this->getDoctrine()
            ->getRepository(DevisConfig::class)
            ->findBy([
                'user_id' => $this->userEntity,
            ]));

        if(empty($devisConfig)) {
            $devisConfig = new DevisConfig();
        }


        $load_class = DevisConfigForm::class;
        if(!is_null($this->userEntity->getDevisPersonelle())) {
            $class = $this->userEntity->getDevisPersonelle();
            $load_class = "AppBundle\Form\Custom\\".$class;
        }


        /** @var Form $devisConfigForm */
        $devisConfigForm = $this->createForm($load_class, $devisConfig, [
            'action' => $this->generateUrl('devisconfig'),
            'label' => false,
            'attr' => [
                'class' => 'registration_form'
            ]
        ]);





        $devisConfigForm->handleRequest($request);
        if($devisConfigForm->isSubmitted() && $devisConfigForm->isSubmitted()) {

            // Trouver les donnes /normalement single par cette entrepirse et supprimer avant d'ajouter
            $devisConfig = $this->getDoctrine()
                ->getRepository(DevisConfig::class)
                ->findBy([
                    'user_id' => $this->userEntity,
                ]);

            // Peut arrive une errore que un user a plusiers donnes
            if(!empty($devisConfig)) {
                foreach ($devisConfig as $obj) {
                    $this->em->remove($obj);
                }
                $this->em->flush();

                $this->addFlash(
                    'sonata_flash_success',
                    '<i class="far fa-check-circle"></i> Les données sont mises à jour'
                );
            }
            else{
                $this->addFlash(
                    'sonata_flash_success',
                    '<i class="far fa-check-circle"></i> Les valeurs sont enregistré'
                );
            }

            /** @var DevisConfig $devisConfig */
            $devisConfig = $devisConfigForm->getData();
            $devisConfig ->setUserId($this->userEntity);
            $this->em->persist($devisConfig);
            $this->em->flush();

            return $this->redirectToRoute('devisconfig');
        }

        return $this->render('admin/custom_view.html.twig', array(
            'form' => $devisConfigForm->createView(),
        ));
    }

}