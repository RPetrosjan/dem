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
use Symfony\Component\HttpFoundation\JsonResponse;


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


    public function sendpdfdevisAction() {


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

        $docpdf = new DocPDF();
        $docpdf->setPrice($devis_priceht);
        $docpdf->addIdDevis($devis);
        $docpdf->setAcompte($devis_accompte);
        $docpdf->setTva($devis_tva);

        $em = $this->getDoctrine()->getManager();
        $em->persist($docpdf);
        $em->flush();

        return new JsonResponse([
            'status' => 'ok',
        ]);
    }

    // pdf Devis action pour affihser DEVIS
    public function pdfdevisAction(){

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

        $htmlRender = $this->renderView('admin/calculdevis/pdf/devis/devis_pdf_part1.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'devis_info' => $devis,
            'distance' => '25km',
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
}