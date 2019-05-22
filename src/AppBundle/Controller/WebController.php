<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 08.04.2018
 * Time: 01:26
 */

namespace AppBundle\Controller;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\OptimizerCss;
use AppBundle\Entity\OptimizerJs;
use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use AppBundle\Form\RegistrationForm;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\SearchExpression;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Twig_Environment;
use Ddeboer\Imap\Server;

class WebController extends Controller
{

    private $twig;
    private $em;

    public function __construct(Twig_Environment $twig, EntityManagerInterface $em)
    {
        $this->twig = $twig;
        $this->em = $em;
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

        // Recuperation CSS File name qui ete defini sur config.yml
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
        $devis->setPrestation($json['prestation']);
        /// $devis->setDistance($json['distance']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($devis);
        $em->flush();

        return  new JsonResponse($json, 200);
    }



    public function findInArrayIfContent(string $text, array $array) {
        foreach ($array as $key=>$value) {
            if(strpos($value, $text) !== false) {
                return $key;
            }
        }
    }

    /**
     * @param $htmlmail
     * @return array
     */
    public function  readallodemenageur($htmlmail) {

        $dom = new domDocument;
        $dom->loadHTML(mb_convert_encoding($htmlmail, 'HTML-ENTITIES', 'UTF-8'));
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');

        $devisArrayWords = [
            'Nom :' => 'nom',
            'Prénom :' => 'prenom',
            'Tél :' => 'telephone',
            'Email :' => 'email',
            'Adresse :' => 'adresse',
            'Code postal :' => 'cp',
            'Ville départ :' => 'ville',
            'Ville arrivée :' => 'ville',
            'Pays :'=> 'pays',
            'Volume :' => 'volume',
            'Ascenseur :' => 'ascenseur',
        ];

        ///foreach ($tables as $table)
        {
            $tds = $tables[0]->getElementsByTagName('td');
            for($i=1; $i<sizeof($tds);$i++) {

                if(strpos($tds[$i]->textContent, 'Date départ :') !== false)
                {
                    $resultArray['date1'][] = substr($tds[$i]->textContent, strlen('Date départ :')+1);
                }
                else if(strpos($tds[$i]->textContent, 'Date arrivée :') !== false)
                {
                    $resultArray['date2'][] = substr($tds[$i]->textContent, strlen('Date arrivée :')+1);
                }

                if(isset($devisArrayWords[$tds[$i]->textContent])) {
                    $resultArray[$devisArrayWords[$tds[$i]->textContent]][] = $tds[$i+1]->textContent;
                }
            }

        }

        $resultArray['volume'] = str_replace(' (M3)','', $resultArray['volume']);

        return $resultArray;


    }

    /**
     * @param $textmail
     * @return array
     */
    public function readlesartisansdemenageurs($htmlmail){


        $dom = new domDocument;
        $dom->loadHTML(mb_convert_encoding($htmlmail, 'HTML-ENTITIES', 'UTF-8'));
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');



        $devisArrayWords = [
            'Nom' => 'nom',
            'Prénom' => 'prenom',
            'Téléphone fixe' => 'telephone',
            'Adresse email' => 'email',
            'Adresse' => 'adresse',
            'Code Postal' => 'cp',
            'Ville' => 'ville',
            'Pays'=> 'pays',
            ///     'Surface en m2' => 'volume',
            'Type de déménagement' => 'prestation',
            'Estimation du volume' => 'volume',
            'Période de déménagement min' => 'date1',
            'Période de déménagement max' => 'date2',
            'Commentaires' => 'comment'
        ];

        $resultArray = [];
        foreach ($tables as $table) {
            $tds = $table->getElementsByTagName('td');
            for($i=0; $i<sizeof($tds);$i++) {
               if(isset($devisArrayWords[$tds[$i]->textContent])) {
                    $resultArray[$devisArrayWords[$tds[$i]->textContent]][] = $tds[$i+1]->textContent;
                }
            }
        }

        dump($resultArray);
        exit();
        return $resultArray;
    }

    /**
     * @Route("/mailer", name="mailer_page")
     */
    public function MailerPage(Request $request) {


        $resultArray = [];
        $message_html_twig = 'admin/email/standard/devis/send_devis_post.html.twig';

        $server = new Server('world-368.fr.planethoster.net');
        $connection = $server->authenticate('service@espace-demenageur.fr', '3XQ8rzb4vfVMBusSGW');
        $mailboxes = $connection->getMailboxes();
        $mailboxINBOX = $connection->getMailbox('INBOX');


        $search = new SearchExpression();

        $search->addCondition(new Unseen());
        $messages = $mailboxINBOX->getMessages($search);

        foreach ($messages as $message) {

            $textmail = $message->getBodyText();
            if(strpos($textmail,'contact@lesartisansdemenageurs.fr') !== false){
                $resultArray = $this->readlesartisansdemenageurs($message->getBodyHtml());
                dump($resultArray);
            }
            else if(strpos($textmail,'contact@allodemenageur.fr') !== false){
                $resultArray = $this->readallodemenageur($message->getBodyHtml());
                dump($resultArray);
            }

            $user = $this->em->getRepository(User::class)->find(4);
            $this->get('admin.add.devis.user')->AddDevis($user, $resultArray);

        }
        exit();

         return $this->render($message_html_twig, [
            ]);
    }

    /**
     * @Route("/testemailtwig", name="testmailtwig_page")
     */
    public function ShowEmailTwigTest(Request $request) {


        $devis = $this->em->getRepository(DemandeDevis::class)->find(30);

        $userEntity = $this->getUser();
        if(!is_null($userEntity->getParent())) {
            $userEntity = $userEntity->getParent();
        }

        $message_html_twig = 'admin/email/standard/devis/send_devis_post.html.twig';
        // Check if client have personal mail
        if(isset($this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['SenMailCustomForm'])){
            $message_html_twig = $this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['SenMailCustomForm'];
        }


        $message= $this->render($message_html_twig, [
            'societe_info' => $this->getUser(),
            'devis_info' => $devis,
            'prixht' => 1560,
            'formatEmail' => 'html'
        ]);

        return $message;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function IndexPages(Request $request){


        // Get if user is Autheticated?
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = null;
        $usertwig = null;
        if(!is_object($user))
        {
            $loginForm = new User();
            $loginForm = $this->createForm(LoginForm::class, $loginForm, [
                'action' => $this->generateUrl('homepage'),
                'label' => false
            ]);

            $loginForm->handleRequest($request);
            if($loginForm->isSubmitted() && $loginForm->isSubmitted()) {

                $factory = $this->get('security.encoder_factory');
                $user_manager = $this->get('fos_user.user_manager');
                $user = $user_manager->findUserByUsername($request->request->get('login_form')['username']);

                if($user){

                    $encoder = $factory->getEncoder($user);
                    $salt = $user->getSalt();

                    if($encoder->isPasswordValid($user->getPassword(), $request->request->get('login_form')['password'], $salt)) {

                        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                        $this->get('security.token_storage')->setToken($token);
                        $this->get('session')->set('_security_main', serialize($token));

                        // check if user connected already today
                        $this->get('admin.user.connect')->ifConnectToday($user);

                        // save that user connected
                        $this->get('admin.user.connect')->addUserConnect($user);

                        // Fire the login event manually
                        $event = new InteractiveLoginEvent($request, $token);
                        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

                    }
                }
            }

            $form = [
                'loginForm' => $loginForm->createView(),
                'buttonText' => '<a>Creer nouvelle compte</a>',
            ];
        }

        if(is_object($user) && !empty($user->getUserName()) && is_null($user->getFirstName())) {
            $loginForm = new User();
            $loginForm = $this->createForm(RegistrationForm::class, $loginForm, [
                'action' => $this->generateUrl('homepage'),
                'label' => false,
                'attr' => [
                    'class' => 'registration_form'
                ]
            ]);
            $loginForm->handleRequest($request);
            if($loginForm->isSubmitted() && $loginForm->isSubmitted()) {

                $firstName = $request->request->get('registration_form')['firstName'];
                $lastName = $request->request->get('registration_form')['lastName'];
                $companyName = $request->request->get('registration_form')['companyName'];
                $siret = $request->request->get('registration_form')['siret'];
                $codePostal = $request->request->get('registration_form')['codePostal'];
                $country = $request->request->get('registration_form')['country'];
                $city = $request->request->get('registration_form')['city'];
                $street = $request->request->get('registration_form')['street'];


                $user->setFirstName($firstName);
                $user->setCity($city);
                $user->setCompanyName($companyName);
                $user->setSiret($siret);
                $user->setCodePostal($codePostal);
                $user->setLastName($lastName);
                $user->setStreet($street);
                $user->setCountry($country);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }

            $form = [
                'registerForm' => $loginForm->createView(),
                'buttonText' => '',
            ];
        }

        if(is_object($user) && !empty($user->getUserName()) && !is_null($user->getFirstName())) {
            $roles = $user->getRoles()[0];

            if($user->getRoles()[0] = 'ROLE_CLIENT') {
                return $this->redirectToRoute('sonata_admin');
            }

            $usertwig['roles'] = $user->getRoles()[0];
            $usertwig['firstname'] = $user->getFirstName();
            $usertwig['lastname'] = $user->getLastName();

            $form = null;
        }

        $htmlRender = $this->render('Pages/homepage.html.twig', array(
            'form' => $form,
            'user' => $usertwig,

        ));

        $this->LoadCssLoader($request);
        return $htmlRender;
    }
}