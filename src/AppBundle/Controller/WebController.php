<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 08.04.2018
 * Time: 01:26
 */

namespace AppBundle\Controller;


use AppBundle\Entity\OptimizerCss;
use AppBundle\Entity\OptimizerJs;
use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use AppBundle\Form\RegistrationForm;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
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
                $tel = $request->request->get('registration_form')['tel'];
                $mobile = $request->request->get('registration_form')['mobile'];
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
                $user->setTel($tel);
                $user->setMobile($mobile);
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
 ;
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