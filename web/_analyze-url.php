<?
function compress_html($compress)
{
    return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$compress));
}

$ip = $_SERVER['REMOTE_ADDR'];
///$monip = "80.215.204.154";

$monip = "89.158.26.56";
if($_SERVER['REMOTE_ADDR'] == "46.218.250.22")
{
    $monip = $_SERVER['REMOTE_ADDR'];
}

///$monip = "46.218.250.22";
///$monip = "93.209.56.80";
///$monip  = "85.171.50.19";

$maintenance = "no";
$envoyerdevis = "oui";

$photos_societe = "6";

$myphone = "Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 920) like Gecko";

if($_SERVER['HTTP_USER_AGENT'] == $myphone)
{
    global $monip;
    $monip = $_SERVER['REMOTE_ADDR'];
}

if($ip == $monip || $maintenance == "no")
{

    $secure = 100;
    include("m.mobile_detect.php");
    $detect = new Mobile_Detect;
    if ($detect->isMobile())
    {
        $passeulr = parse_url(getenv("HTTP_REFERER"));
        if($passeulr['host'] == "m.demenagement-officiel.fr" || $passeulr['host'] == "demenagement-officiel.fr" )
        {
        }
        else
        {
            //	$url=substr($_SERVER['REQUEST_URI'],0,550);
            //	$redirectto =  "http://m.demenagement-officiel.fr".$url;
            ///	header('Location: '.$redirectto);
        }
    }



    $footertext;
    $expresspage="";

    $adminemail="demenagementexpress@outlook.fr";
    $paypalmail ="contact@demenagement-express.fr";




    $mysql_host = "localhost";
    $mysql_database = "rafdemfr_demenage_express";
    $mysql_user = "rafdemfr_express";
    $mysql_password = "1AQW2ZSX3EDC";

    $ConMySql = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

    if (!$ConMySql){

        global $maintenance;
        $maintenance = "oui";
        if($ip == $monip)
        {
            die('Error Connect (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
    }
    else if (!mysqli_set_charset($ConMySql, "utf8")) {
        echo "Error to start utf8: %s\n".mysqli_error($ConMySql);
    }
    else {
        ////	echo "<br/>Changed encoding to: %s\n". mysqli_character_set_name($ConMySql);
    }

    function clean_input($input)
    {

        $input = htmlspecialchars(strip_tags($input, '<br><br /><br/>'));

        global $ConMySql;
        if(get_magic_quotes_gpc())
        {
            //Remove slashes that were used to escape characters in post.
            $input = stripslashes($input);
        }
        //Remove ALL HTML tags to prevent XSS and abuse of the system.
        ///$input = strip_tags($input);
        //Escape the string for insertion into a MySQL query, and return it.

        $input = mysqli_real_escape_string($ConMySql, $input);
        return $input;
    }

    function is_email($email){
        $s=filter_var($email, FILTER_VALIDATE_EMAIL);
        return !empty($s);
    }

    if(isset($_POST["cpville"]) )
    {
        global $ConMySql;

        $cp1=substr($_POST["cpville"],0,5);
        $cp1=trim(clean_input($cp1));

        $queryville = "SELECT * FROM code_postal  WHERE cp LIKE '$cp1%' AND ville NOT LIKE '%cedex%'";
        $resdemville = mysqli_query($ConMySql,$queryville);

        while($row = mysqli_fetch_array($resdemville))
        {
            ?>
            <div ><a><? echo $row['cp']; ?> <? echo $row['ville']; ?></a></div>
            <?
        }
        exit();
    }

    $url=substr($_SERVER['REQUEST_URI'],0,550);

    function coderville1($data){
        return preg_replace( array('/ /','/%20/'), array('-','-'), $data);
    }
    function coderville($data){
        return preg_replace( array('/ /','/%20/','/É/','/é/','/È/','/è/'), array('-','-','E','e','E','e'), $data);
    }
    function decoderville($data){
        return preg_replace( array('/_/','/-/','/%20/'), array(' ',' ',' '), $data);
    }
    function utf8s($data){
        return preg_replace( array('/\'/','/\+/','/-/','/ /','/"/','/È/','/Ç/','/É/','/Ê/','/à/','/ç/','/è/','/é/','/ê/','/ï/'), array('_','','_','_','','E','C','E','E','a','c','e','e','e','i'), $data);
    }
    function decodernomsociete($data)
    {
        return preg_replace( array('/_/','/-/'), array(' ',' '), $data);
    }
    function decodervillecor($data){
        return preg_replace( array('/_/'), array('-'), $data);
    }


    function DataExpressAdd($date1,$days)
    {
        $getdate1 = explode("/",$date1);
        $date1 = $getdate1[2]."-".$getdate1[1]."-".$getdate1[0];
        $getdate1 = date_create($date1);

        date_add($getdate1, date_interval_create_from_date_string($days.' days'));

        return date_format($getdate1, 'd/m/Y');
    }
    function DataExpressDiff($date1,$date2)
    {

        $getdate1 = explode("/",$date1);
        $date1 = $getdate1[2]."-".$getdate1[1]."-".$getdate1[0];

        $getdate2 = explode("/",$date2);
        $date2 = $getdate2[2]."-".$getdate2[1]."-".$getdate2[0];

        $getdate1 = date_create($date1);
        $getdate2 = date_create($date2);

        $interval = date_diff($getdate1, $getdate2);

        $diff =  array("Y"=>$interval->format('%r%y'),"M"=>$interval->format('%r%m') + 12*($interval->format('%r%y')),"D"=>$interval->format('%r%a'));

        return $diff;
    }

    if(isset($_POST["idnomsociete"]) )
    {
        include("express.cherchesociete.php");
        exit("");
    }

    function checkville($villedem)
    {
        global $ConMySql;
        $queryville = "SELECT * FROM code_postal WHERE ville= '".$villedem."'";
        if ($result = mysqli_query($ConMySql, $queryville))
        {
            if($row = mysqli_fetch_assoc($result))
            {
                return $row['cp'];
            }
            else
            {
                return "Not Found";
            }
        }
    }

    $url=htmlspecialchars(decoderville(clean_input($url)));
    $path = explode('/',$url);


    $notcompress = 1;



    if($path[1]=="compte.html" || $path[1]=="compte" || $path[1]=="sitemap.html" || $path[1]=="sitemap.xml" || $path[1]=="examentest.html" || $path[1]=="setabonement.html" || $path[1]=="screen0X0.html" || $path[1]=="screeniframe.html" )
    {
        global $notcompress;
        $notcompress = 1;
    }

    if($notcompress == 0)
    {
        ob_start('compress_html');
    }

    $secure = 100;


    include("messagerie.php");

    function notfound404()
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="index";
        global $detect;

        $title="410 not found";
        $description = "";
        $keyword ="";

        $secure = 100;

        header("HTTP/1.0 410 Gone");
        include("express.header.php");
        include("express.404.php");
    }


    if( isset($_POST["mail"]) && isset($_POST["password"]))
    {
        include("express.connectuser.php");
        exit();
    }
    if(isset($_POST["SeConnecter"]))
    {
        include("express.GepPanelSeConnecter.php");
        exit();
    }

    if(isset($_POST["GetDataPanelBox"]))
    {
        include("express.GepPanelDateBox.php");
        exit();
    }

    if(isset($_POST["GetPanelAnnonce"]))
    {
        include("express.GepPanelAnonnce.php");
        exit();
    }
    if(isset($_POST["GetPanelAnnonce1"]))
    {
        include("express.GepPanelAnonnce1.php");
        exit();
    }

    if(isset($_POST["timestat"]) && isset($_POST["url"]))
    {
        include("express.stat.user.php");
    }


    else if(isset($_POST["deconex"]))
    {
        if(isset($_REQUEST[session_name()]))
        {
            session_start();
            if(isset($_SESSION['KeySsi']))
            {
                session_destroy();
                echo "dec/*/";
                exit();
            }
        }
    }
    if($path[1]=="devis.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="devis";

        $title = "Devis Déménagement gratuit Déménagement Economique Standard Luxe, Devis garde meubles";
        $description = "Devis déménagement gratuit, rempliez avec précision le formulaire.Devis déménagement sous 24 h. Garde Meubles";
        $keyword = "Devis Déménagement, Devis gratuit, Garde Meubles, Déménagement Economique Standard Luxe";





        if(isset($_POST["crypt"]) && isset($_POST["civil"]) && isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["prenome"]) && isset($_POST["perstel"]) && isset($_POST["tel"]) && isset($_POST["date1"]) && isset($_POST["date2"]) && isset($_POST["adresse"]) && isset($_POST["adresse1"]) && isset($_POST["cp"]) && isset($_POST["cp1"]) && isset($_POST["ville"]) && isset($_POST["ville1"]) && isset($_POST["pays"]) && isset($_POST["pays1"]) && isset($_POST["etage"]) && isset($_POST["etage1"]) && isset($_POST["vol"])  && isset($_POST["budget"]) && isset($_POST["comment1devis"]) && isset($_POST["comment2devis"]))
        {
            include("express.header.php");
            include ("express.devis.user.php");
            include("express.devis.php");
        }
        else if(isset($_POST["crypt"]) && isset($_POST["civil"]) && isset($_POST["nome"]) && isset($_POST["prenome"])  && isset($_POST["tel"]) && isset($_POST["email"]) && isset($_POST["perstel"]) && isset($_POST["date1"]) && isset($_POST["adresse"]) && isset($_POST["ville1"]) && isset($_POST["cp"]) && isset($_POST["asc1"]) && isset($_POST["etage1"]) && isset($_POST["comment1"]) && isset($_POST["date2"]) && isset($_POST["adresse1"]) && isset($_POST["ville2"]) && isset($_POST["cp1"]) && isset($_POST["asc2"]) && isset($_POST["etage2"]) && isset($_POST["comment2"]) && isset($_POST["Prestation"]) && isset($_POST["Volume"]) )
        {
            include ("express.devis.online.php");
            exit();
        }
        else
        {
            include("express.header.php");
            include("express.devis.php");
        }

    }
    else if($path[1]=="demenagement pas cher.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="pas cher";

        $title = "Déménagement pas cher, devis déméngement cout déménagement, frais déménagement";
        $description = "Comment faire un déménagement pas cher, reduire le cout. économiser de l'argent ";
        $keyword = "Demenagement pas cher, demenageur, cout demenagement, service déménagement";

        include("express.header.php");
        include("express.demenagement-pas-cher.php");
    }
    else if($path[1]=="commandes.html" || substr($path[1],0,9) == "commandes" )
    {
        if($path[1]!="commandes.html")
        {

            if(isset($_REQUEST[session_name()]))
            {
                session_start();
            }

            if(!isset($_SESSION['KeySsi']))
            {
                notfound404();
                include("express.footer.php");
                exit();
            }
        }


        if(isset($_POST["iddevis1"]) && isset($_POST["distance"]) && isset($_POST["leprix"]) && isset($_POST["tarifvalable"]))
        {
            $secure = 100;
            include("express.commpte.func.php");
            include("express.commandes.societe.devisenvoyer.php");
            exit();
        }
        else if(isset($_POST["iddevis"]))
        {
            $secure=100;
            global $ip;
            global $monip;
            include("express.commpte.func.php");
            include("express.GetPanelDevis.php");
            exit();
        }

        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="commandes";

        $title = "Déménagement Express Devis gratuit Déménagement Commandes";
        $description = "Actuelles demandes du déménagement de notre societe demenagement-express.";
        $keyword = "Déménagement Devis gratuit, demenagement Commandes, devis société de Déménagement, déménagement";

        include("express.header.php");
        include("express.commandes.php");
    }
    else if($path[1] == "visite technique.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="visite  technique";

        $title = "Déménagement visite technique gratuit";
        $description = "Service déménagement visite technique sans engagement et gratuit sur votre ville";
        $keyword = "Déménagement,visite technique, gratuit, sans engagement, prix, service, prestation";

        include("express.header.php");
        include("express.visite-technique.php");
    }
    else if($path[1] == "garde meuble.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="garde meuble";

        $title = "Déménagement Garde Meuble, Devis garde meuble, Garde meuble stockage, location";
        $description = "Demenagement devis garde meuble, stockage, location, emballage et deballage vos meubles";
        $keyword = "Déménagement, Garde meuble, Devis Garde Meuble, Stockage meubles, Emballage, Location";

        include("express.header.php");
        include("express.devis.php");
    }
    else if($path[1]=="sitemap.xml")
    {
        include "express.websitemap.php";
        exit();
    }
    else if($path[1]=="creercompte.html" || (substr($path[1],0,16) == "creercompte.html"))
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="creercompte";

        $title = "Déménagement Demenageurs inscription, devis lots, espace déménageurs compte";
        $description = "Déménageurs page personnelle, inscription sur notre web site, partenariat déménagement avoir devis gratuit";
        $keyword = "Déménagement, Déménageurs, devis lots, gratuit, compte déménageurs, inscription société déménagement";

        include("express.header.php");
        include("express.creecompte.php");
    }
    else if($path[1]=="sitemap.html" && ($ip == $monip))
    {
        include "express.sitemap.php";
        exit();
    }
    else if((substr($path[1],0,15) == "getarnaque.html") && ($ip == $monip) )
    {
        $title = "Arnaque";
        $description = "";
        $keyword = "";
        $expresspage ="index";

        include("getarnaque.php");
        exit();

    }
        else if( ($path[1] == "devisperdux.html") && ($ip == $monip) )
    {
        $title = "Partenaries";
        $description = "";
        $keyword = "";
        $expresspage ="devis";

        include("express.header.php");
        include("devisperdux.php");
    }
    else if($path[1] == "societes.x52x.hml" )
    {
        if(isset($_POST["email"]) && isset($_POST["reponse"]) )
        {
            include("societes.x52xonline.php");
            exit();
        }
        include("express.header.php");
        include("societes.x52x.php");
    }
    else if((substr($path[1],0,27) == "validervisittechnicque.html") && ($ip == $monip) )
    {
        $title = "Accept Devis";
        $description = "";
        $keyword = "";
        $expresspage ="index";

        include("express.header.php");
        include("validervisittechnicque.php");
    }
    else if((substr($path[1],0,20) == "validerdevisrxs.html") && ($ip == $monip) )
    {
        if(isset($_POST["Disablelien"]))
        {
            include("liensfunc.php");
        }
        else if(isset($_POST["Acceptlien"]))
        {
            include("liensfunc.php");
        }
        $title = "Accept Devis";
        $description = "";
        $keyword = "";
        $expresspage ="index";

        include("express.header.php");
        include("validerdevisrxs.php");
    }
    else if((substr($path[1],0,16) == "deviscalcul.html") && ($ip == $monip) )
    {
        $title = "Devis Calcul en Ligne";
        $description = "";
        $keyword = "";
        $expresspage ="devis";

        include("express.header.php");
        include("deviscalcul.php");
    }

    else if($path[1]=="calcul.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="calcul";

        $title = "Calculer le volume de Déménagement, calculer le prix devis en ligne";
        $description = "Calcul le volume déménagement, chambre adulte, chambre enfants, salon, cout déménagement";
        $keyword = "Déménagement Devis,Calcul volume, prix en ligne, Déménagement chambre, déménagement salon, déménagement maison";

        include("express.header.php");
        include("express.calcul.php");

    }
    else if($path[1]=="compte.html" || $path[1]=="compte")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="compte";
        $NomSociete= "";


        $title = "Demenagement Officiel Compte";
        $description = "";
        $keyword = "";



        include("express.commpte.func.php");

        if (isset($_REQUEST[session_name()]))
        {
            if(isset($_POST["iddevis1"]) && isset($_POST["distance"]) && isset($_POST["leprix"]) && isset($_POST["tarifvalable"]))
            {
                $secure = 100;
                include("express.commandes.societe.devisenvoyer.php");
                exit();
            }
            else if($_POST["SocielAdd"])
            {
                include("checkaddsocialbutton.php");
                exit();
            }
            else if(isset($_POST["iddevis"]) && ($path[2]=="devis transmises.html" || $path[2]=="devis transmises"))
            {
                $secure=100;
                global $ip;
                global $monip;
                include("express.GetPanelDevisTransmises.php");
                exit();
            }
            else if(isset($_POST["SendRepondreAvis"]))
            {
                $secure=100;
                global $ip;
                global $monip;
                include("express.SendRepondreAvis.php");
            }
            else if(isset($_POST["GetPanelRepondre"]))
            {
                $secure=100;
                global $ip;
                global $monip;
                include("express.GepPanelAvisRepondre.php");
                exit();
            }
            else if($path[2]=="devis transmises.html" && isset($_POST["nom_client"]))
            {
                $secure = 100;
                include("express.compte.devi.transmises.envoyer.php");
            }
            else if(isset($_POST["iddevis"]))
            {
                $secure=100;
                global $ip;
                global $monip;
                include("express.GetPanelDevis.php");
                exit();
            }
            if(substr($path[2],0,12) == "facture.html" || substr($path[2],0,9) == "lvel.html" || substr($path[2],0,9) == "lvec.html")
            {
                include("express.compte.facture.imprimer.php");
                exit();
            }


            if(substr($path[2],0,18) == "previsualiser.html")
            {
                include("previsualiser.php");
            }
            else if( ($path[2]=="photos societe.html") && $_SERVER['REQUEST_METHOD'] === 'POST' )
            {
                $secure = 100;
                include("express.photos.upload.php");
            }
            else if(isset($_POST["nomech"]) && isset($_POST["prenomech"]) && isset($_POST["telch"]) && isset($_POST["emailch"]) && isset($_POST["perstelch"])  )
            {
                $secure = 100;
                include("express.change.devis.online.php");
                exit();
            }
            else if($path[2]=="liens.html" && isset($_POST["liens"]))
            {
                $secure = 100;
                include("express.compte.veriflien.php");
                exit();
            }
            else if(isset($_POST["settextid"]) || isset($_POST["textid"]) )
            {
                include ("express.compte.inserttext.php");
                exit();
            }

            $secure = 100;
            include("express.header.php");
            include ("express.compte.php");
        }
        else
        {
            notfound404();
        }

    }
    else if($path[1]=="options.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="option";

        $title = "Déménagement Economique, Déménagement Luxe, Déménagement Standard, Déménagement prestation";
        $description = "Chargement transport et déchargement, Emballage des Tv-Hi-fi,ordinateurs,micro-ondes, Démontage et remontage des meubles si nécessair, Protection du mobilier sous couvertures ou bullpack";
        $keyword = "Déménagement Devis gratuit, Déménagement Luxe, Déménagement Standard, Déménagement Economique, Emballage Déballage, Démontage, Protection";

        include("express.header.php");
        include("express.option.php");
    }
    else if($path[1]=="cond.generales.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="condition";

        $title = "Déménagement condition générales déménagement";
        $description = "Conditions générales contrat de déménagement, Devis demenagement livraison prestation";
        $keyword = "Déménagement-Express, condition générales, Déménagement condition, Devis Déménagement, Contrat, Déménagement entreprise, livraison, realisation, prestation";

        include("express.header.php");
        include("express.conditions.generales.php");
    }
    else if($path[1]=="admin ruben" && $ip == $monip)
    {
        if(isset($_POST["GetAllMailSociete"]))
        {
            global $ConMySql;

            $queryville = "SELECT * FROM express_entreprise  WHERE email LIKE '%@%' ";
            $resdemville = mysqli_query($ConMySql,$queryville);

            while($row = mysqli_fetch_array($resdemville))
            {
                echo $row["email"].",";
            }
            exit();
        }
        else if(isset($_POST["TitleMailSociete"]) && isset($_POST["MessageMailsociete"]))
        {
            $secure = 120;
            include("SendMailsociete.php");
            exit();
        }
        else if(isset($_POST["GetNomSociete"]))
        {
            global $ConMySql;

            $NomSociete=substr($_POST["GetNomSociete"],0,50);
            $NomSociete=clean_input($NomSociete);

            $queryville = "SELECT * FROM express_entreprise  WHERE nom_societe LIKE '$NomSociete%' AND email LIKE '%@%' ";
            $resdemville = mysqli_query($ConMySql,$queryville);

            while($row = mysqli_fetch_array($resdemville))
            {
                ?>
                <div onclick="addnomsociete('<? echo $row['email']; ?>')"><a><? echo $row['nom_societe']; ?></a> </div>
                <?
            }

            exit();
        }
        else if(isset($_POST["javanomsociete"]) )
        {
            global $ConMySql;

            $NomSociete=substr($_POST["javanomsociete"],0,50);
            $NomSociete=clean_input($NomSociete);

            $queryville = "SELECT * FROM express_entreprise  WHERE nom_societe LIKE '$NomSociete%' AND email LIKE '%@%' ";
            $resdemville = mysqli_query($ConMySql,$queryville);

            while($row = mysqli_fetch_array($resdemville))
            {
                ?>
                <div onclick="addnomsociete('<? echo $row['nom_societe']; ?>')"><a><? echo $row['nom_societe']; ?></a> </div>
                <?
            }

            exit();
        }
        include("express.header.php");
        include("express.admin-ruben.php");
    }
    else if($path[1]=="contrat.html" || ($path[1]=="contrat" && strlen($path[2])>5))
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="compte";

        $title = "Le Contrat Déménagement Officiel ";
        $description = "";
        $keyword = "";

        if( (strlen($path[2])>5) && (isset($_GET["nomsociete"]) && isset($_GET["adresse"]) && isset($_GET["nomprenom"])))
        {
            include("express.contratpdf.php");
            exit();
        }
        else if((strlen($path[2])>5) && (isset($_GET["nomsociete1"]) && isset($_GET["adresse1"]) && isset($_GET["nomprenom1"])))
        {
            include("express.contratpdf2.php");
            exit();
        }
        else
        {
            echo $path[2];
            include("express.header.php");
            include("express.contrat.php");
        }
    }
    else if($path[1]=="assurance.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="assurance";

        $title = "Déménagement Assurance, Déménagement Conseil, Déclaration de valeur";
        $description = "Votre contrat de déménagement avec votre déménageur, déclaration de valeur. Multirisque habitation couvre les dommages";
        $keyword = "Déménagement, Assurance, Déménagement dommage, Assurance dommage, Déclaration valeur, dommages";

        include("express.header.php");
        include("express.assurance.php");
    }
    else if(($path[1] == "settextcorriger.html") && ($ip == $monip))
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="admin";

        $title = "Text Corriger";
        $description = "";
        $keyword = "";

        include("express.header.php");
        include("SetTextCorrige.php");
    }
    else if( $path[1]=="actualites" || $path[1]=="actualites.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="actualites";

        if(strlen($path[2])>1)
        {
            $url=substr($path[2],0,100);
            $url=coderville1(htmlspecialchars($url));
            global $ConMySql;

            $secure = 100;

            global $ConMySql;
            $query = "SELECT * FROM express_actualites WHERE URL = '$url' ";
            $resactu = mysqli_query($ConMySql,$query);
            if ($rowactu = mysqli_fetch_assoc($resactu))
            {
                $numberpath = sizeof($path);
                if(strlen($path[$numberpath-1])<1)
                {
                    header('HTTP/1.1 301 Moved Permanently');
                    header("Location: http://www.demenagement-officiel.fr/actualites/".strtolower($url));
                    exit();
                }

                $title = $rowactu['title'];
                $description = $rowactu['description'];
                $keyword = $rowactu['keyword'];

                include("express.header.php");
                include("express.actualites-info.php");
            }
            else
            {
                notfound404();
            }
        }
        else
        {

            $secure = 100;
            $title = "Déménagement actualites, nouvelles, déménagement coût, demenagement coût en ligne";
            $description = "Dernières nouvelles déménagements, conseilles pour votre déménagement, prix déménagement";
            $keyword = "déménagement, nouvelles,conseilles, demenagement coût,déménagement devis, express, devis en ligne";

            include("express.header.php");
            include("express.actualites.php");
        }
    }
    else if($path[1]=="cout demenagement.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="cout";
        global $ip;
        global $monip;

        $title = "Coût / Prix / Tarif déménagement, calculer devis prix en ligne déménagement";
        $description = "Calculer du coût / prix de votre demenagement, Demenagement-Officiel devis en ligne";
        $keyword = "Coût demenagement, prix demenagement, Tarif déménagement, Estimation, direct calcul, en ligne";

        include("express.header.php");
        if($ip == $monip)
        {
            include("express.cout-demenagementnew.php");
        }
        else
        {
            include("express.cout-demenagement.php");
        }
    }
    else if($path[1]=="demenageurs")
    {
        include("express.info-demenageurs.php");
    }
    else if($path[1]=="demenagements.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="etreprises";

        $title = "Entreprises Déménagements, Recherche société de déménagement, déménageurs avis";
        $description = "Trouvez les infos avis sociétés déménagements dans votre ville, recherche société, avis déménageurs";
        $keyword = "Déménagement Entreprises, Société de déménagement, demenageurs, recherche entreprisе";

        include("express.header.php");
        include("express.demenageurs.php");
    }
    else if($path[1]=="demenagement piano.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="demenagement piano";

        $title = "Déménagement Piano, transport piano, coût déménagement piano,  devis gratuit";
        $description = "Calculer le prix déménagement piano, coût en ligne, demander devis déménagement piano";
        $keyword = "Déménagement Piano conseils,transport piano, protection, coût déménagement piano en ligne";

        include("express.header.php");
        include("express.piano.php");
    }
    else if($path[1]=="statistiques.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="statistique";

        $title = "Demenagement statistique France, alsace,provence-alpes-côte, Rhon-Alpes, Provence-Alpes-Côte d'Azur ";
        $description = "Demenagement statistiques pour les regions en France, decouvrez où les clients déménagent pendant cet anne.";
        $keyword = "Déménagement statistiques, Déménagement regions , Déménagement  France, Déménagement Alsace , Déménagement Rhon-Alpes";

        include("express.header.php");
        include("express.statistiques.php");
    }
    else if($path[1]=="mention legales.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="devis";

        $title = "Mention Legales";
        $description = "Demenagement Officiel Mention Legales";
        $keyword = "Demenagement Officiel Mention Legales";



        include("express.headernew.php");
        include("express.mention-legales.php");
        include("express.footernew.php");
        exit();
    }
    else if($path[1]=="liens.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="devis";

        $title = "Liens utiles";
        $description = "Demenagement-Liens";
        $keyword = "Liens utiles";

        include("express.header.php");
        include("express.liens.php");
    }
    else if($path[1]=="maison.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="maison";

        $title = "Déménagement Maison Office Déménagement Piano Déménagement Devis";
        $description = "Déménagement-Officiel s’occupe du déménagement maison, déménagement office et déménagement bureau. Déménagement-Officiel garantissent un déménagement qualitatif pour un prix correct.";
        $keyword = "Devis Déménagement,Déménagement maison, Déménagement  bureau, Déménagement office, Déménagement Calcul";

        include("express.header.php");
        include("express.maison.php");
    }
    else if($path[1]=="questions.html" || $path[1] == "questions")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;

        if(strlen($path[2]) > 2 && $path[1] == "questions")
        {
            include("express.questionsshow.php");
        }
        else
        {
            $title = "Déménagement Questions fréquentes pratique réponses";
            $description = "Demenagement Questions fréquentes réponses à vos questions, conseils et réponses";
            $keyword = "Déménagement, Questions, Réponses, conseils, Tarif, Cout, Garde Meuble";
        }


        $expresspage ="question";



        include("express.header.php");
        include("express.questions.php");
    }
    else if($path[1]=="seturlannonce.html")
    {
        global $ip;
        global $monip;
        if($ip == $monip)
        {
            if(isset($_POST["seturlanonnce"])||isset($_POST["personID"])|| isset($_POST["SuppersonID"]) )
            {
                include("express.seturlannonce.php");
            }
            include("express.headernew.php");
            include("express.seturlannonce.php");
            include("express.footernew.php");
            exit();
        }
    }
    else if($path[1]=="demenagement annonces.html" || substr($path[1],0,26) == "demenagement annonces.html")
    {

        if(isset($_POST["GetPanelBox"]))
        {
            include("express.GepPanelAnonnce.php");
            exit();
        }
        else if(isset($_GET["annonce"]))
        {
            include("express.annonces-affish.php");
        }
        else
        {
            global $title;
            global $description;
            global $keyword;
            global $path;
            global $expresspage;
            $expresspage ="annonces";

            $title = "Déménagement annonces gratuite, déménagement particulier et entreprise";
            $description = "Demenagement annonces gratuites, propose, publier annonce déménagement gratuit";
            $keyword = "déménagement, annonces, publier annonce, annonce gratuite, déménagement devis, annonce déménagement";

            include("express.headernew.php");
            include("express.annonces.php");
            include("express.footernew.php");
            exit();
        }
    }
    else if( ($path[1] == "accepttextpropose") && ($ip == $monip) )
    {

        $title = "Accept Propose";
        $description = "";
        $keyword = "";
        $expresspage ="devis";

        include("express.header.php");
        include("express.accepttextpropose.php");
    }
    else if($path[1]=="plaininig francemap.html" && $ip == $monip )
    {

        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="contact";

        $title = "Plaining Routier";
        $description = "";
        $keyword = "";

        include("express.header.php");
        include("express.franceplain.php");
    }
    else if($path[1]=="contact.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="contact";

        $title = "Demenagement-Officiel Contact, Devis gratuit";
        $description = "Demenagement-Officiel repondra à tous vous questions. Nous occupons pour organiser avec vous votre déménagement. Pour contacter avec nous il faut faire remplir le formulaire";
        $keyword = "Déménagement-Officiel Contact, Déménagements poser une question, Déménagement Devis gratuit, Déménagement Transport Cartons";

        global $ip;
        global $monip;


        include("express.headernew.php");
        include("express.contact.php");
        include("express.footernew.php");
        exit();
    }
    else if($path[1]=="test.html")
    {
        if(isset($_POST["fname"]))
        {
            include("express.testfunc.php");
            exit();
        }
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="test";

        $title = "Test pour déménager, Question Déménagement, Prêt à déménager?";
        $description = "Découvriez si vous êtes prêt pour un déménagement, demenagement-officiel vous propose passer le test pour déménagement composant 12 questions";
        $keyword = "Test déménagement, Prêt à déménager, Déménagements Conseils, passer le test déménagement, test 12 questions";

        include("express.headernew.php");
        include("express.test.php");
        include("express.footernew.php");
        exit();
    }
    else if($path[1]=="avis.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="avis";

        $title = "Déménagement avis demenagement-officiel, Déménagement service";
        $description = "Les avis des clients déménagement-Officiel, avis (opinions) sur notre service";
        $keyword = "Avis societes déménagement, avis service Déménagement";


        include("express.headernew.php");
        include("express.avisnew.php");
        include("express.footernew.php");
        exit();

    }
    else if($path[1]=="conseil.html")
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;
        $expresspage ="conseil";

        $title = "Déménagement Conseils Déménagement Devis gratuite Cartons";
        $description = "Déménagement Devis gratuit. Déménagement-Officiel Conseils votre déménagement, livraison votre Meubles, Cartons,préparer déménagement, Calcul";
        $keyword = "Déménagement-Officiel, Déménagements Conseils, Déménagement Devis gratuit, Déménagement Transport Cartons";

        include("express.headernew.php");
        include("express.conseils.php");
        include("express.footernew.php");
        exit();

    }
    else if(strlen($path[1])>1)
    {
        notfound404();
    }
    else
    {
        global $title;
        global $description;
        global $keyword;
        global $path;
        global $expresspage;

        $expresspage ="index";

        $title = "Déménagement Devis Garde Meuble Coût Déménagement";
        $description = "Déménagement-Officiel vous propose les services suivantes, Déménagement national, Déménagements de bureaux, Devis gratuit, Transport Piano et meubles";
        $keyword = "Déménagement-Officiel,Déménagement Bureau, Déménagement Piano,Déménagements national,Déménagements bureaux,Entreprise  déménagement,Devis gratuit,Devis Déménagement";




        include("express.headernew.php");
        include("express.index.php");
        include("express.footernew.php");
        exit();


    }


    $secure = 100;

    include("express.footer.php");




}
else
{
    $secure =100;
    include ("express.maintenance.php");
}


if($notcompress == 0)
{
    ob_end_flush();
}


?>