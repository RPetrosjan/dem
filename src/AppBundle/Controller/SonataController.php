<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 11/10/2018
 * Time: 22:48
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\DocPDF;
use Sonata\AdminBundle\Controller\CRUDController;
use Swift_Attachment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Page Sonata Controller for  generating and making new route
 *
 * Class SonataController
 * @package AppBundle\Controller
 *
 */

class SonataController extends CRUDController
{

    // Generation du PDF
    public function returnPDFResponseFromHTML(){

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        // remove default footer
        $pdf->setPrintFooter(false);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf_dir  = __DIR__.'/../../../webTwig/';

        \TCPDF_FONTS::addTTFfont($pdf_dir."admin/calculdevis/pdf/font/OpenSans.ttf", 'TrueTypeUnicode', "", 32);


        $img_file = $pdf_dir.'admin/calculdevis/pdf/image/bacpap8.png';

        $pdf->Image(
            $img_file,
            -50, 0, 600, 485,
            'PNG', '', '', false, 300, '',
            false, false, 0, false, false,
            false
        );
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);





        return $pdf;


    }

    public function sendpdfdevisAction(\Swift_Mailer $mailer) {

        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(DemandeDevis::class);
        $devis = $repository->findOneBy(['id' => $this->getRequest()->get('id')]);

        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $devis_priceht = $this->getRequest()->get('priceht');
        if(is_numeric($devis_priceht) == false) {
            $devis_priceht = 0;
        }

        $devis_tva = $this->getRequest()->get('tva');
        if(is_numeric($devis_tva) == false) {
            $devis_tva = 0;
        }

        $devis_accompte = $this->getRequest()->get('acompte');
        if(is_numeric($devis_accompte) == false) {
            $devis_accompte = 0;
        }

        $franchise = $this->getRequest()->get('franchise');
        if(is_numeric($franchise) == false) {
            $franchise = 0;
        }

        $valeur_globale = $this->getRequest()->get('valeur_globale');
        if(is_numeric($valeur_globale) == false) {
            $valeur_globale = 0;
        }

        $par_objet = $this->getRequest()->get('par_objet');
        if(is_numeric($par_objet) == false) {
            $par_objet = 0;
        }

        $valable = $this->getRequest()->get('valable');
        if(is_numeric($valable) == false) {
            $valable = 0;
        }

        $randomname = $this->getRequest()->get('randomName');
        if(empty($randomname)) {
            $randomname = 'not-randomname';
        }

        $docpdf = new DocPDF();
        $docpdf->setPrice($devis_priceht);
        $docpdf->addIdDevis($devis);
        $docpdf->setAcompte($devis_accompte);
        $docpdf->setTva($devis_tva);
        $docpdf->setFranchise($franchise);
        $docpdf->setValeurGlobale($valeur_globale);
        $docpdf->setParObjet($par_objet);
        $docpdf->setValable($valable);
        $docpdf->setRandomname($randomname);
        $docpdf->setEmail($devis->getEmail());

        $em = $this->getDoctrine()->getManager();
        $em->persist($docpdf);
        $em->flush();


        $referer = $this->getRequest()
            ->headers
            ->get('referer');


        $message = (new \Swift_Message('Votre Devis du déménagement'))
            ->setFrom([$societe->getEmail() => $societe->getNamesociete()])
            ->setTo($devis->getEmail())
            ->setBody(
                $this->renderView(
                    'email/demandedevis/demandededevis.html.twig',[
                        'devis_info' => $devis,
                        'request' => $this->getRequest()->query->all(),
                        'societe_info' => $societe,
                        'plain' => 'html'
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'email/demandedevis/demandededevis.html.twig',[
                        'devis_info' => $devis,
                        'request' => $this->getRequest()->query->all(),
                        'societe_info' => $societe,
                        'plain' => 'text'
                    ]
                ),
                'text/plain'
            )
        ;


        // Creating PDF Devis
        $pdfDevis = $this->GenerateDevisPdf($this->getRequest()->get('id'), 'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfDevis, 'devis.pdf', 'application/pdf');
        $message->attach($attachment);

        //Creating PDF CondGenerlae
        $pdfCondGen = $this->GenerateCondGeneralePdf($this->getRequest()->get('id'),'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfCondGen, 'Condition Generale.pdf', 'application/pdf');
        $message->attach($attachment);

        //Creating PDF Déclaration de valeur
        $pdfDecVal = $this->GenerateDeclValeur($this->getRequest()->get('id'),'S');
        // Attach PDF as String in Mail
        $attachment = new Swift_Attachment($pdfDecVal, 'Déclaration de valeur.pdf', 'application/pdf');
        $message->attach($attachment);

        // Creating PDF Declaration de Valeur
        $htmlRender = $this->renderView('admin/calculdevis/pdf/devis/devis_pdf_part1.html.twig', [
            'devis_info' => $devis,
            'distance' => '25km',
            'request' => $this->getRequest()->query->all(),
            'societe_info' => $societe,
        ]);



        if ($mailer->send($message))
        {
            $this->addFlash('success','Votre devis été bien envoyée');
        }
        else
        {
            $this->addFlash('success','Votre devis été bien envoyée');
        }



        return new RedirectResponse($referer);

    }

    public function pdfdecvalAction() {

        return $this->GenerateDeclValeur($this->getRequest()->get('id'),'I');
    }


    public function pdfcondgenAction() {

        return $this->GenerateCondGeneralePdf($this->getRequest()->get('id'),'I');

    }

    public function pdflettredechrgAction() {


        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(DemandeDevis::class);
        $devis = $repository->findOneBy(['id' => $this->getRequest()->get('id')]);

        $devis_priceht = $this->getRequest()->get('priceht');
        if(is_numeric($devis_priceht) == false) {
            $devis_priceht = 0;
        }

        $devis_tva = $this->getRequest()->get('tva');
        if(is_numeric($devis_tva) == false) {
            $devis_tva = 0;
        }

        $devis_accompte = $this->getRequest()->get('acompte');
        if(is_numeric($devis_accompte) == false) {
            $devis_accompte = 0;
        }

        $htmlRender = $this->renderView('admin/calculdevis/pdf/lettre_dechargement/lettre_dechargement.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'societe_info' => $societe,
            'devis_info' => $devis,
            'distance' => '25km',
            'request' => $this->getRequest()->query->all(),
            'devis_priceht' => $devis_priceht,
            'devis_tva' => $devis_tva,
            'devis_accompte' => $devis_accompte,
            'societe_info' => $societe,
        ]);


        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, 'I');

    }

    public function pdflettrechrgAction() {

        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(DemandeDevis::class);
        $devis = $repository->findOneBy(['id' => $this->getRequest()->get('id')]);

        $devis_priceht = $this->getRequest()->get('priceht');
        if(is_numeric($devis_priceht) == false) {
            $devis_priceht = 0;
        }

        $devis_tva = $this->getRequest()->get('tva');
        if(is_numeric($devis_tva) == false) {
            $devis_tva = 0;
        }

        $devis_accompte = $this->getRequest()->get('acompte');
        if(is_numeric($devis_accompte) == false) {
            $devis_accompte = 0;
        }

        $htmlRender = $this->renderView('admin/calculdevis/pdf/lettre_chargement/lettre_chargement.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'societe_info' => $societe,
            'devis_info' => $devis,
            'distance' => '25km',
            'request' => $this->getRequest()->query->all(),
        ]);


        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, 'I');

    }
    public function pdffactureAction() {
        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(DemandeDevis::class);
        $devis = $repository->findOneBy(['id' => $this->getRequest()->get('id')]);

        $devis_priceht = $this->getRequest()->get('priceht');
        if(is_numeric($devis_priceht) == false) {
            $devis_priceht = 0;
        }

        $devis_tva = $this->getRequest()->get('tva');
        if(is_numeric($devis_tva) == false) {
            $devis_tva = 0;
        }

        $devis_accompte = $this->getRequest()->get('acompte');
        if(is_numeric($devis_accompte) == false) {
            $devis_accompte = 0;
        }

        $htmlRender = $this->renderView('admin/calculdevis/pdf/facture/facture_pdf.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'societe_info' => $societe,
            'devis_info' => $devis,
            'distance' => '25km',
            'devis_priceht' => $devis_priceht,
            'devis_tva' => $devis_tva,
            'devis_accompte' => $devis_accompte,
            'request' => $this->getRequest()->query->all(),
        ]);


        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, 'I');
    }

    public function GenerateDeclValeur($id_devis, $type_output) {
        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $htmlRender = $this->renderView('admin/calculdevis/pdf/dec_valeurs/dec_valeurs_pdf.html.twig', [
            'societe_info' => $societe,
            'request' => $this->getRequest()->query->all(),
        ]);

        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, $type_output);
    }

    public function GenerateCondGeneralePdf($id_devis, $type_output) {
        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $htmlRender = $this->renderView('admin/calculdevis/pdf/cond_generales/cond_generales_pdf.html.twig', [
            'societe_info' => $societe,
            'request' => $this->getRequest()->query->all(),
        ]);


        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, $type_output);
    }

    public function GenerateDevisPdf($id_devis,$type_output) {
        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(DemandeDevis::class);
        $devis = $repository->findOneBy(['id' => $id_devis]);

        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));


        $htmlRender = $this->renderView('admin/calculdevis/pdf/devis/devis_pdf_part1.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'devis_info' => $devis,
            'distance' => '25km',
            'request' => $this->getRequest()->query->all(),
            'societe_info' => $societe,
        ]);

        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, $type_output);
    }

    // pdf Devis action pour affihser DEVIS
    public function pdfdevisAction(){

        return $this->GenerateDevisPdf($this->getRequest()->get('id'),'I');
    }
}