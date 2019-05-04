<?php


namespace AppBundle\Entity\Traits;


use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Form\EstimationPrixForm;

/**
 * Trait EstimationPrixSubmitForm
 * @package AppBundle\Entity\Traits
 */
trait EstimationPrixSubmitForm
{
    /** @var  */
    private $formEstimationPrix;

    /** @var string */
    private $load_template;

    /** @var  */
    private $custom_twig_company;

    /**
     * @param $userEntity
     */
    public function loadSubmitForm($userEntity, $userEntityGroup) {

        /** @var  $container */
        $container = $this->getConfigurationPool()->getContainer();

        $em = $container->get('doctrine.orm.entity_manager');

        /** @var string $load_template */
        $this->load_template = 'admin/demandedevis/estimation_prix.html.twig';
        $loadFormType = EstimationPrixForm::class;

        $this->custom_twig_company = [];

        // Creat methos for a usung info for societe_id_devis.yml
        if(!is_null($userEntity->getDevisPersonelle())){
            $this->custom_twig_company = array_merge($this->custom_twig_company, $this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['FilesForSendClient'], $this->custom_twig_company, $this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['FilesForSendCompany']);
            $loadFormType = $this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['EstimationPrixForm'];
        }

        $devisObj = $this->object;
        if (strpos(get_class($this->object), 'DevisEnvoye') === false) {

            $devisConfig = $em
                ->getRepository(DevisConfig::class)
                ->findOneBy([
                    'user_id' => $userEntity,
                ]);

            $devisObj = new DevisEnvoye();
            $devisObj->setTva($devisConfig == false ? 20: $devisConfig->getTva());
            $devisObj->setAcompte($devisConfig == false ? 30 : $devisConfig->getAcompte());
            $devisObj->setFranchise($devisConfig == false ? 250 : $devisConfig->getFranchise());
            $devisObj->setValglobale($devisConfig == false ? 20000 : $devisConfig->getValglobale());
            $devisObj->setParobjet($devisConfig == false ? 500 : $devisConfig->getParobjet());
            $devisObj->setValable($devisConfig == false ? 3 : $devisConfig->getValable());
        }

        $this->formEstimationPrix = $container->get('form.factory')->create($loadFormType, $devisObj, [
            //'action' => $container->get('router')->generate('sonata_sendDevis_post', [
            //    'uuid' => $this->object->getUuid(),
            // ]),
        ]);

        $this->formEstimationPrix->handleRequest($this->request);
        if($this->formEstimationPrix->isSubmitted() && $this->formEstimationPrix->isValid()) {

            $json = current(current($this->request->request))['json'];
            $devisconfig = json_decode($json, true);

            /** @var DevisEnvoye $devisenvoye */

            $devisenvoye = $this->formEstimationPrix->getData();
            // Stop autorewrite of existing data
            $devisenvoye->setNom($this->object->getNom());
            $devisenvoye->setTelephone($this->object->getTelephone());
            $devisenvoye->setPortable($this->object->getPortable());
            $devisenvoye->setEmail($this->object->getEmail());
            $devisenvoye->setPrenom($this->object->getPrenom());

            $devisenvoye->setAdresse1($this->object->getAdresse1());
            $devisenvoye->setAdresse2($this->object->getAdresse2());
            $devisenvoye->setCp1($this->object->getCp1());
            $devisenvoye->setCp2($this->object->getCp2());
            $devisenvoye->setVille1($this->object->getVille1());
            $devisenvoye->setVille2($this->object->getVille2());
            $devisenvoye->setEtage1($this->object->getEtage1());
            $devisenvoye->setEtage2($this->object->getEtage2());
            $devisenvoye->setDate1($this->object->getDate1());
            $devisenvoye->setDate2($this->object->getDate2());
            $devisenvoye->setPays1($this->object->getPays1());
            $devisenvoye->setPays2($this->object->getPays2());
            $devisenvoye->setComment1($this->object->getComment1());
            $devisenvoye->setComment2($this->object->getComment2());
            $devisenvoye->setAscenseur1($this->object->getAscenseur1());
            $devisenvoye->setAscenseur2($this->object->getAscenseur2());

            $devisenvoye->setPrestation($this->object->getPrestation());
            $devisenvoye->setVolume($this->object->getVolume());
            $devisenvoye->setBudget($this->object->getBudget());

            $devisenvoye->setUserId($userEntity);
            $devisenvoye->setUserSendId($userEntityGroup);

            $this->em->persist($devisenvoye);
            $this->em->flush();



            if(!is_null($userEntity->getParent())) {
                $userEntity = $userEntity->getParent();
            }

            // $devisenvoye->setDistance($this->object->getDistance());

            /** @var  pdfGenerateService */
            $pdfGenerateService = $this->container->get('pdf.devis.generator');

            $files = [];
            // Check if company have custom pdf for sending Files to Client
            if(!empty($this->custom_twig_company)) {
                $customFiles = $this->container->getParameter('DevisCustom')[$userEntity->getDevisPersonelle()]['FilesForSendClient'];
                foreach ($customFiles as $key => $customFile) {
                    $files[$customFile['Label']] = $pdfGenerateService->pdfGenerate($devisenvoye, $devisconfig, $userEntity, $key, 'S');
                }
            }
            else {
                // Creating PDF Devis
                $files['devis.pdf'] = $pdfGenerateService->pdfGenerate($devisenvoye, $devisconfig, $userEntity, 'devis', 'S');
                //Creating PDF CondGenerlae
                $files['condition_generale'] = $pdfGenerateService->pdfGenerate($devisenvoye, $devisconfig, $userEntity, 'condition_generale', 'S');
                //Creating PDF Déclaration de valeur
                $files['declaration_valeur'] = $pdfGenerateService->pdfGenerate($devisenvoye, $devisconfig, $userEntity, 'declaration_valeur', 'S');
            }

            $flashbag = $this->getRequest()->getSession()->getFlashBag();

            ///admin.send.mail.devis
            $sendDevisMailservice = $this->container->get('admin.send.mail.devis');
            $reponse = $sendDevisMailservice->sendDevisEmailClient('Votre Devis du déménagement', $devisenvoye, $userEntity, $devisconfig, $files);
            if($reponse == true) {

                $flashbag->add('sonata_flash_success','<i class="far fa-check-circle"></i> Votre estimation du devis a bien été envoyé '.$devisenvoye->getNom().' '.$devisenvoye->getPrenom().' ('.$devisenvoye->getEmail().')');
                /*                $this->session->addFlash(
                                    'sonata_flash_success',
                                    '<i class="far fa-check-circle"></i> Votre estimation du devis a bien été envoyé '.$devis->getNom().' '.$devis->getPrenom().' ('.$devis->getEmail().')'
                                ); */
            }
            else {
                $flashbag->add('errore','Errore d\'envie message');
                ///              $this->addFlash('errore','Errore d\'envie message');
            }


        }
    }
}