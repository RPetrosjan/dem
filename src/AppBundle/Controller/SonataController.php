<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 11/10/2018
 * Time: 22:48
 */

namespace AppBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController;


class SonataController extends CRUDController
{
    public function pdfdevisAction(){

        $htmlRender = $this->renderWithExtraParams('admin/calculdevis/pdf_devis.html.twig');
        return $htmlRender;
    }
}