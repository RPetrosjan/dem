<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 04/02/2019
 * Time: 23:29
 */

namespace AppBundle\service;



use AppBundle\Entity\DevisConfig;
use AppBundle\Entity\DevisEnvoye;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\KernelInterface;

class PDFDevisGenerator
{
    /** @var Container  */
    private $container;

    /** @var KernelInterface  */
    private $parent;

    /**
     * PDFDevisGenerator constructor.
     * @param EntityManagerInterface $em
     * @param Container $container
     */
    public function __construct(Container $container, KernelInterface $parent) {
        $this->container = $container;
        $this->parent = $parent;
    }

    // Generation du PDF
    public function returnPDFResponseFromHTML(){

        $pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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


        /** @var string $directory */
        $directory = "admin/pdf/standard/font";
        // We get all ttf files for adding font
        /** @var array $fontsttf */
        $fontsttf = scandir($pdf_dir.$directory);
        foreach ($fontsttf as $objectttf) {
            if (stripos($objectttf, "ttf") !== false) {
               \TCPDF_FONTS::addTTFfont($pdf_dir.$directory.'/'.$objectttf, 'TrueTypeUnicode', "", 32);
            }
        }

        $img_file = $pdf_dir.'admin/pdf/standard/image/bacpap8.png';

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

    /**
     * @param mixed $devis
     * @param $type_output
     * @throws \Twig\Error\Error
     */
    public function pdfShowDevis($devis, $type_output) {

        $array_pdf = [
            'pdf_show_devis' => 'admin/pdf/standard/pdf_show_devis.html.twig',
        ];

        $htmlRender = $this->container->get('templating')->render($array_pdf['pdf_show_devis'], [
            'devisInfo' => $devis,
        ]);

        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->writeHTML($htmlRender, true, false, true, false, '');
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, $type_output);
    }

    /**
     * @param $devis
     * @param array $devisconfig
     * @param User $societe
     * @param $type_df
     * @param $type_output
     * @param array|null $twig_custom
     * @return string
     * @throws \Twig\Error\Error
     */
    public function pdfGenerate($devis, array $devisConfig = null, User $societe, $type_df, $type_output, array $twig_custom = null) {

        $array_pdf = [
            'lettre_dechargement' => 'admin/pdf/standard/lettre_dechargement.html.twig',
            'lettre_chargement' => 'admin/pdf/standard/lettre_chargement.html.twig',
            'facture' => 'admin/pdf/standard/facture.html.twig',
            'devis' =>  'admin/pdf/standard/devis.html.twig',
            'condition_generale' => 'admin/pdf/standard/condition_generale.html.twig',
            'declaration_valeur' => 'admin/pdf/standard/declaration_valeur.html.twig',
        ];




        //Check if user enabled custom pdf show
        $custom_twig_company = [];
        if(!is_null($societe->getDevisPersonelle())){
            $custom_twig_company = array_merge($custom_twig_company, $this->container->getParameter('DevisCustom')[$societe->getDevisPersonelle()]['FilesForSendClient'], $this->container->getParameter('DevisCustom')[$societe->getDevisPersonelle()]['FilesForSendCompany']);

            $template = $custom_twig_company[$type_df]['Twig'];
            $pdfName  = $custom_twig_company[$type_df]['Label'];
        }
        else {
            $template = $array_pdf[$type_df];
            $pdfName = $type_df;
        }


        if(!is_null($twig_custom)) {
            $template = $twig_custom;
        }

        if(is_null($devisConfig)) {
            $devisConfig = $devis;
            $devisNumber = $devisConfig->getDevisnumber();
        }
        else {
            $devisNumber = $devisConfig['devisnumber'];
        }

        $htmlRender = $this->container->get('templating')->render($template, [
            'devisConfig' => $devisConfig,
            'devisInfo' => $devis,
            'societeInfo' => $societe
        ]);

        $logo_societe = $this->parent->getProjectDir().'\web\image\\'.$societe->getPath().'\\'.substr($societe->filename, 0, strpos($societe->filename, "?"));

        $pdf = $this->returnPDFResponseFromHTML();
        $pdf->setPageMark();
        $pdf->SetTitle($pdfName.' '.$devisNumber);
        // C:\Users\rpetrosjan\Desktop\ticket\site-admin-symfony\espace-demenageur3\web\image\5c83220050751.png?5c8322005f1c4
        // C:\Users\rpetrosjan\Desktop\ticket\site-admin-symfony\espace-demenageur3\web\image\company_icon\5c83220050751.png
        $pdf->Image($logo_societe, 90, '', 30);
        $pdf->writeHTML($htmlRender, true, false, true, false, '');

        //Arrivée
        // Write HTML PDF page First
        $filename = '/ourcodeworld_pdf_demo';
        return $pdf->Output($filename, $type_output);
    }
}