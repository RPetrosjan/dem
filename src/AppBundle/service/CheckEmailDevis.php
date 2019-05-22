<?php


namespace AppBundle\service;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\User;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class CheckEmailDevis
 * @package AppBundle\service
 */
class CheckEmailDevis
{

    /** @var EntityManagerInterface  */
    private $em;

    /** @var Container  */
    private $container;

    /**
     * CheckEmailDevis constructor.
     * @param Container $container
     * @param EntityManagerInterface $em
     * @throws \Exception
     */
    public function __construct(Container $container, EntityManagerInterface $em) {
        $this->container = $container;
        $this->em = $em;
    }

    /**
     * @param string $text
     * @param array $array
     * @return int|string
     */
    private function findInArrayIfContent(string $text, array $array) {
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
    private function  readallodemenageur($htmlmail) {

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

    }

    /**
     * @param $textmail
     * @return array
     */
    private function readlesartisansdemenageurs($htmlmail){

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

        return $resultArray;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function CheckDevis(User $user){

        $resultArray = [];
        $server = new Server('world-368.fr.planethoster.net');
        $connection = $server->authenticate('service@espace-demenageur.fr', '3XQ8rzb4vfVMBusSGW');
       /// $mailboxes = $connection->getMailboxes();
        /// // Gett all emials in Folder inbox
        $mailboxINBOX = $connection->getMailbox('INBOX');

        // Filtrer pour recuperer neu letters
        $search = new SearchExpression();
        $search->addCondition(new Unseen());
        // Recevoir all news not unsee
        $messages = $mailboxINBOX->getMessages($search);

        foreach ($messages as $message) {
            $textmail = $message->getBodyText();
            // Check propriataire de devis
            if(strpos($textmail,'contact@lesartisansdemenageurs.fr') !== false){
                $resultArray = $this->readlesartisansdemenageurs($message->getBodyHtml());
            }
            else if(strpos($textmail,'contact@allodemenageur.fr') !== false){
                $resultArray = $this->readallodemenageur($message->getBodyHtml());
            }

            if(!empty($resultArray)) {
                $this->container->get('admin.add.devis.user')->AddDevis($user, $resultArray);
            }

        }
    }
}