<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 11/10/2018
 * Time: 22:48
 */

namespace AppBundle\Controller;
use AppBundle\Entity\CalculDevis;
use Sonata\AdminBundle\Controller\CRUDController;


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
    public function returnPDFResponseFromHTML($html){

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

        $filename = '/ourcodeworld_pdf_demo';
        $img_file = $pdf_dir.'admin/calculdevis/pdf/image/bacpap8.png';

        $pdf->Image(
            $img_file,
            -50, 0, 600, 485,
            'PNG', '', '', false, 300, '',
            false, false, 0, false, false,
            false
        );
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        $pdf->setPageMark();
        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->StartTransform();
        $pdf->Rotate(-270);
        $pdf->writeHTMLCell(100,0,20,80, '<strong style="font-size: 18px; color: #a72222; text-transform: uppercase;">Départ</strong>', 0);
        $pdf->writeHTMLCell(100,0,18,178, '<strong style="font-size: 18px; color: #a72222; text-transform: uppercase;">Arrivée</strong>', 0);
        $pdf->StopTransform();


        $pdf->Output($filename, 'I');
    }


    // pdf Devis action pour affihser DEVIS
    public function pdfdevisAction(){


        // Get Id for Find Calcul Devis
        $repository = $this->getDoctrine()->getRepository(CalculDevis::class);
        $devis = $repository->findOneBy(['id' => $this->getRequest()->get('id')]);

        // Get Info of Societe pdf
        $societe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Societe');
        $societe = $societe->findOneBy(array('siege' => true));

        $htmlRender = $this->renderView('admin/calculdevis/pdf/devis_pdf.html.twig', [
            'devis_num' => 'DEVIS-13-10-2018',
            'devis_info' => $devis,
            'devis_price' =>   $this->getRequest()->get('price'),
            'societe_info' => $societe,
        ]);

        return $this->returnPDFResponseFromHTML($htmlRender);
    }
}