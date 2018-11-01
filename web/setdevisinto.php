<?
function SetTdevisDemenagements($row)
{

    echo "ko ko";
    // Pour Demenagements.fr
	?><b>TROUVER RR!</b><?
	$inStartMySql = 1;
	global $ConMySql1;
	$mysql_host = "localhost";
	$mysql_database = "rafdemfr_dem-demenagements";
	$mysql_user = "rafdemfr_dem";
	$mysql_password = "1AQW2ZSX3EDCde,";
	$ConMySql1 = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	mysqli_set_charset($ConMySql1, "utf8");


    echo '<br/>ADDED IN Demenagement-exprees<br/>';

	if(strlen($row["pays1"])<2)
	{
		$row["pays1"] = "France";
	}
	if(strlen($row["pays2"])<2)
	{
		$row["pays2"] = "France";
	}

	$dateperiod = DateTime::createFromFormat('d/m/Y', $row["date1"]);
	if($dateperiod != false)
    {
        $dateperiod->format('Y-m-d');
    }
    else{
        $dateperiod = DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('Y-m-d');
    }

    var_dump($dateperiod);

    if($dateperiod instanceof DateTime) {
        $dateperiod = $dateperiod->format('Y-m-d');
    }
    echo $dateperiod;


    echo '<br/>ADDED IN Demenagement-exprees 000<br/>';

    echo DateTime::createFromFormat('Y-m-d');

    $querydevis =  "INSERT INTO Devis (nom, prenom, telephone, email, date1, date2, cp1, cp2, ville1, ville2, prestation, prix, etage1, etage2, ascenseur1, ascenseur2, volume, IP, commentaire1, commentaire2, portable, adresse1, adresse2, pays1, pays2, today, period) VALUES ('".clean_input($row[nome])."', '".clean_input($row["prenome"])."','".clean_input($row["tel"])."', '".clean_input($row["email"])."', '".clean_input($row["date1"])."', '".clean_input($row["date1"])."', '".clean_input($row["cp1"])."', '".clean_input($row["cp2"])."', '".clean_input($row["ville1"])."', '".clean_input($row["ville2"])."','".clean_input($row["cond"])."','".clean_input($row["entreprise"])."', '".clean_input($row["etage1"])."', '".clean_input($row["etage2"])."', '".clean_input($row["ascenseur1"])."', '".clean_input($row["ascenseur2"])."', '".clean_input($row["volume"])."', '".clean_input($row["IP"])."', '".clean_input($row["comment1"])."', '".clean_input($row["comment2"])."', '".clean_input($row["telpor"])."' ,'".clean_input($row["adresse1"])."','".clean_input($row["adresse2"])."', '".clean_input($row["pays1"])."', '".clean_input($row["pays2"])."', '".date("d/m/Y")."', '".$dateperiod."')";

    mysqli_query($ConMySql1,$querydevis) or die (mysqli_error($ConMySql1));

    $mysql_host = "localhost";
    $mysql_database = "rafdemfr_sdemenagement";
    $mysql_user = "rafdemfr_sdemenagement_user";
    $mysql_password = "Av{Iw71$5D)l";

    $ConMySql1 = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
    mysqli_set_charset($ConMySql1, "utf8");


    if(strlen($row["pays1"])<2)
    {
        $row["pays1"] = "France";
    }
    if(strlen($row["pays2"])<2)
    {
        $row["pays2"] = "France";
    }

    echo 'lin ONK';

    $querydevis =  "INSERT INTO demande_devis (nom, prenom, telephone, email, date1, date2, cp1, cp2, ville1, ville2, prestation, etage1, etage2, ascenseur1, ascenseur2, volume, comment1, comment2, portable, adresse1, adresse2, pays1, pays2, Created) VALUES ('".clean_input($row[nome])."', '".clean_input($row["prenome"])."','".clean_input($row["tel"])."', '".clean_input($row["email"])."', '".clean_input($row["date1"])."', '".clean_input($row["date2"])."', '".clean_input($row["cp1"])." ".clean_input($row["ville1"])."', '".clean_input($row["cp2"])." ".clean_input($row["ville2"])."', '".clean_input($row["ville1"])."', '".clean_input($row["ville2"])."','".clean_input($row["cond"])."', '".clean_input($row["etage1"])."', '".clean_input($row["etage2"])."', '".clean_input($row["ascenseur1"])."', '".clean_input($row["ascenseur2"])."', '".clean_input($row["volume"])."', '".clean_input($row["comment1"])."', '".clean_input($row["comment2"])."', '".clean_input($row["telpor"])."' ,'".clean_input($row["adresse1"])."','".clean_input($row["adresse2"])."', '".clean_input($row["pays1"])."', '".clean_input($row["pays2"])."', '".(new DateTime('NOW'))->format('Y-m-d')."')";
    mysqli_query($ConMySql1,$querydevis) or die (mysqli_error($ConMySql1));

    echo '<br/>ADDED IN Déménagements.fr<br/>';


}
?>