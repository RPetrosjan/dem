<?if($secure!=100)exit();

$header = '<html>
<body>
<div style="background-color: #d13a3f;color: White;height: 41px;padding-left: 5px;"><span style="
    color: #d13a3f;
    background-color: white;
    padding-right: 15px;
    padding-left: 15px;
    font-weight: bold;
    display: inline-block;
    font-size: 36px;
">DQPG</span>
<span style="
    display: inline-block;
    line-height: 16px;
    font-weight: bold;
    letter-spacing: 0.5px;
">
Déménagement Qualité <br>
Professionnelle Garantie
</span>

</div>
<div>
<div style="padding-top: 3px;">
<span style="
    font-family: monospace;
    font-weight: bold;
    font-size: 15px;
    padding-right: 5px;
">Tel : 09 86 37 69 03</span> | <span style="
    font-family: monospace;
    font-weight: bold;
    font-size: 15px;
    padding-left: 5px;
">06 65 12 84 30</span>
</div>
<div style="
    font-family: verdana;
    font-size: 13px;
    padding-top: 20px;
">';

$footer = '<br /><br /><br />
Vous pouvez visiter notre web site : <a href="http://déménagement-devis.fr"><b>déménagement-devis.fr</b></a>
<br /><br />
<b>Votre Equipe</b><br />
DQPG
</div>
</body>
</html>';



function GetSocieteImageLoad($row)
{
    global $header;
	  global $footer;
   $message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle Image Societe.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Societe</b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["SocieteName"].'</span><br />
            
        <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Départ</b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp1"].'</span><br />
      
         <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Arrivée</b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp2"].'</span><br />  
            
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Image Real </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["RealImage"].'</span><br />

      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Image Web Url</b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;"><a href="http://déménagement-devis.fr/'.$row["WebImage"].'"> '.$row["WebImage"].'</a></span><br />

      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Description</b> 
      <br/>
      '.$row["commentaire1"];
      
      return  $header.$message.$footer;
}



function GetVisiteEmploiMessage($row)
{
    global $header;
	  global $footer;
   
   
  $portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}
  
 
 
   
   $message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle demande de Emploi.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
      <span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
      '.$portablemessage.'
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-mail </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />

      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">CP Ville </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp1"].'</span><br />

      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Message ou CV</b> 
      <br/>
      '.$row["commentaire1"];
      
      return  $header.$message.$footer;
      
}



function GetDemandeCartonsMessage($row)
{
    global $header;
	  global $footer;
   
   
  $portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}
  
  
  $LocationArray = array("catronstandard"=>"Cartons Standards", "cartonlivres"=>"Cartons Livres", "cartonverres"=>"Cartons Verres", "cartonpenderie"=>"Cartons Penderies");
  $messgelocationlist = "";
  $locationarrayliste= explode(",",$row["listecartons"]);
  
  foreach($locationarrayliste as $key => $value)
  {
    $messgelocationlist .= $LocationArray[$value]."<br />";
  }

$message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle demande de cartons.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
      <span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
      '.$portablemessage.'
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-mail </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />

      '.$datemessage.'
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Location</b> 
      <br/>
      '.$messgelocationlist;
      
      return  $header.$message.$footer;
      
}


function GetLocationMessage($row)
{
    global $header;
	  global $footer;
   
   
  $portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}
  
  
  $LocationArray = array("camion10"=>"Camion 20m³ + Chauffeur", "camion20"=>"Camion 10m³ + Chauffeur", "monte-meuble-location"=>"Monte meuble", "service-demenageur"=>"Service du déménageur");
  $messgelocationlist = "";
  $locationarrayliste= explode(",",$row["listelocation"]);
  
  foreach($locationarrayliste as $key => $value)
  {
    $messgelocationlist .= $LocationArray[$value]."<br />";
  }

$message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle demande de Visite Technique.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
      <span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
      '.$portablemessage.'
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-mail </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />

      '.$datemessage.'
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Location</b> 
      <br/>
      '.$messgelocationlist;
      
      return  $header.$message.$footer;
      
}

function GetVisiteTechniqueMessage($row)
{
    global $header;
	  global $footer;
   
   
  $portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}
  
   $datemessage = "";
	if($row[date1])
	{
		$datemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Date </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["date1"].'</span><br />
		';
	}
  
   $adresse1message = "";
	if($row["adresse"])
	{
		$adresse1message = '
    	<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Adresse</b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["adresse"].'</span><br />
    ';
	}
 
   
   $message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle demande de Visite Technique.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
      <span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
      '.$portablemessage.'
      
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-mail </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />

      '.$adresse1message.'
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">CP Ville </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp1"].' '.$row["ville1"].'</span><br />

      
      '.$datemessage.'
      
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Commentaire </b> 
      <br/>
      '.$row["commentaire"];
      
      return  $header.$message.$footer;
      
}

function GetContactMessage($row)
{
    global $header;
	  global $footer;
   
   
  $portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}
   
   $message  = '
	
      Bonjour,
      <br /><br />
      vous avez nouvelle contact.<br /><br />
      
      <b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
      <b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
      <span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
      '.$portablemessage.'
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-Mail </b> 
      <span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />
      <br />
      <b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Commentaire </b> 
      <br/>
      '.$row["commentaire"];
      
      return  $header.$message.$footer;
      
}
function GetSendClientDevisMessage($nom,$prenom)
{

	global $header;
	global $footer;

	$message  = '
	Bonjour <i>'.$nom.' '.$prenom.'</i>,	
	<br /><br />
	nous vous confirmons de demande vote devis demenagement.<br />
	Notre consiller vous contactera prochainement sous 24h.<br /><br />
	Pour les questions supplementaires n\'heitez pas a nous contacter.
	';

	return  $header.$message.$footer;
}
 function GetSendAdminDevisMessage($row)
 {

	global $header;
	global $footer;
	

	$portablemessage = "";
	if($row[portable])
	{
		$portablemessage= '
			<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Portable </b> 
			<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["portable"].'</span><br />
		';
	}

	$adresse1message = "";
	if($row["adresse1"])
	{
		$adresse1message = '
		<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Adresse </b> 
		<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["adresse1"].'</span><br />
		';
	}
	$adresse2message = "";
	if($row["adresse2"])
	{
		$adresse2message = '
		<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Adresse </b> 
		<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["adresse2"].'</span><br />
		';
	}

	$message  = '
	
	Bonjour,
<br /><br />
vous avez nouvelle demande de devis.<br /><br />

<b style="color: #D13A3F;font-size: 16px;">Coordonnées</b><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Nom Prenom </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["nom"].' '.$row["prenom"].'</span><br />
<b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Téléphone </b> 
<span style=" border-bottom: 4px solid white; display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["telephone"].'</span><br />
'.$portablemessage.'
<b style="width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">E-Mail </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["email"].'</span><br />
<br />
<span  style="
    border-right: 1px #AEAEAE solid;
    display: inline-block;
    padding-right: 20px;
">
<b style="color: #D13A3F;font-size: 16px;">Départ</b><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Date </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["date1"].'</span><br />
'.$adresse1message.'
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">CP Ville </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp1"].' '.$row["ville1"].'</span><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Etage </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["etage1"].'</span>
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Ascenseur </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["ascenseur1"].'</span><br />
<br /></span>
<span  style="
    display: inline-block;
    padding-left: 20px;
">
<br />
<b style="color: #D13A3F;font-size: 16px;">Arrivée</b><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Date </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["date2"].'</span><br />
'.$adresse2message.'
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">CP Ville </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["cp2"].' '.$row["ville2"].'</span><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Etage </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["etage2"].'</span>
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Ascenseur </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["ascenseur2"].'</span><br />
<br />
</span>
<br /><br />
<b style="color: #D13A3F;font-size: 16px;">Info</b><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Prestation </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["prestation"].'</span><br />
<b style="border-bottom: 4px solid white; width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Volume </b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["volume"].' m&sup3;</span><br />
<b style=" border-bottom: 4px solid white;width: 109px;display: inline-block;padding-top: 2px;padding-bottom: 3px;background-color: #EAEAEA;margin-top: 5px;padding-left: 5px;">Ppix Souhaite</b> 
<span style="display: inline-block;padding-top: 2px; padding-bottom: 3px;background-color: #EAEAEA; margin-top: 5px;padding-left: 5px; padding-right: 10px;">'.$row["prix"].' &euro;</span><br />


	';

	
	return  $header.$message.$footer;
 }

 
?>