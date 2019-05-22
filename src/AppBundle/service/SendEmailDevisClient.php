<?php


namespace AppBundle\service;


use AppBundle\Entity\User;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SendEmailDevisClient
 * @package AppBundle\service
 */
class SendEmailDevisClient
{

    /** @var ContainerInterface  */
    private $container;

    /** @var Swift_Mailer  */
    private $mailer;

    /** @var object|\Symfony\Bundle\TwigBundle\TwigEngine  */
    private $renderView;

    /**
     * SendEmailDevisClient constructor.
     * @param ContainerInterface $container
     * @param Swift_Mailer $mailer
     */
    public function __construct(ContainerInterface $container, Swift_Mailer $mailer) {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->renderView = $container->get('templating');
    }

    /**
     * @param $titleMessage
     * @param $devis
     * @param User $societe
     * @param array $devisconf
     * @param array $files
     */
    public function sendDevisEmailClient($titleMessage, $devis, User $societe, User $userEntityGroup = null, array $devisConfig = null, array $files = [], $message_html_twig = null) {

        if(is_null($message_html_twig)) {
            $message_html_twig = 'admin/email/standard/devis/send_devis_post.html.twig';
        }

        if(is_null($devisConfig)) {
            $devisConfig = $devis;
        }

        // $titleMessage = 'Votre Devis du déménagement'
        $message = (new \Swift_Message($titleMessage))
            ->setFrom([$this->container->getParameter('mailer_user') => $societe->getCompanyName()])
            ->setTo($devis->getEmail())
            ->setReplyTo($societe->getCompanyEmail())
            ->setBody(
                $this->renderView->render(
                    $message_html_twig, [
                        'devis_info' => $devis,
                        'societe_info' => $societe,
                        'devisConfig' =>  $devisConfig,
                        'formatEmail' => 'html'
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView->render(
                    $message_html_twig, [
                        'devis_info' => $devis,
                        'societe_info' => $societe,
                        'devisConfig' =>  $devisConfig,
                        'formatEmail' => 'text'
                    ]
                ),
                'text/plain'
            )
        ;

        if(sizeof($files)>0) {
            foreach ($files as $title=>$file) {
                $attachment = new Swift_Attachment($file, $title, 'application/pdf');
                $message->attach($attachment);
            }
        }

        if ($reponse = $this->mailer->send($message)) {
            return true;
        }
        else {
            return false;
        }
    }
}