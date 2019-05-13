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
        foreach ($tables as $table) {
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $table->textContent) as $line){
                $resultArray[] = $line;
            }
        }

        return  [
            'nom' => [$resultArray[array_search('Nom :',$resultArray)+1]],
            'prenom' => [$resultArray[array_search('Prénom :',$resultArray)+1]],
            'telephone' => [$resultArray[array_search('Tél :',$resultArray)+1]],
            'email' => [$resultArray[array_search('Email :',$resultArray)+1]],
            'adresse' => [
                $resultArray[array_search('Adresse :',$resultArray)+1],
                $resultArray[array_search('Adresse :',$resultArray)+3],
            ],
            'cp' => [
                $resultArray[array_search('Code postal :',$resultArray)+1],
                $resultArray[array_search('Code postal :',$resultArray)+3],
            ],
            'ville' => [
                $resultArray[array_search('Ville départ :',$resultArray)+1],
                $resultArray[array_search('Ville arrivée :',$resultArray)+1],
            ],
            'pays' => [
                $resultArray[array_search('Pays :',$resultArray)+1],
                $resultArray[array_search('Pays :',$resultArray)+3],
            ],
            'etage' => [
                $resultArray[array_search('Etage :',$resultArray)+1],
                $resultArray[array_search('Etage :',$resultArray)+3],
            ],
            'ascenseur' => [
                $resultArray[array_search('Ascenseur :',$resultArray)+1],
                $resultArray[array_search('Ascenseur :',$resultArray)+3],
            ],
            ///     'Surface en m2' => 'volume',
            ///'prestation' => [$resultArray[array_search('Formule :',$resultArray)+1]],
            'prestation' => [substr($resultArray[$this->findInArrayIfContent('Formule :', $resultArray)], strlen('Formule :')+1, 11)],
            'volume' => [$resultArray[array_search('Surface :',$resultArray)+1]],
            'date1' => [substr($resultArray[$this->findInArrayIfContent('Date départ :', $resultArray)], strlen('Date départ :')+1)],
            'date2' => [substr($resultArray[$this->findInArrayIfContent('Date arrivée :', $resultArray)], strlen('Date arrivée :')+1)],
            'comment' => [$resultArray[array_search('Observations :',$resultArray)+1]]
        ];

    }

    /**
     * @param $textmail
     * @return array
     */
    private function readlesartisansdemenageurs($textmail){

        $resultArray = [];

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

        foreach(preg_split("/((\r?\n)|(\r\n?))/", $textmail) as $line){
            foreach ($devisArrayWords as $keys=>$value) {
                if(($pos = strpos($line, $keys)) !== false){
                    $resultArray[$value][] = trim(substr($line, strlen($keys)));
                }
            }
        }

        $resultArray['adresse'][0] = $resultArray['adresse'][2];
        $resultArray['adresse'][1] = $resultArray['adresse'][4];

        $resultArray['email'][0] = substr($resultArray['email'][0],0, strpos($resultArray['email'][0],'<'));

        unset($resultArray['adresse'][2]);
        unset($resultArray['adresse'][3]);
        unset($resultArray['adresse'][4]);

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
                $resultArray = $this->readlesartisansdemenageurs($textmail);
            }
            else if(strpos($textmail,'contact@allodemenageur.fr') !== false){
                $resultArray = $this->readallodemenageur($message->getBodyHtml());
            }

            $this->container->get('admin.add.devis.user')->AddDevis($user, $resultArray);
        }
    }
}