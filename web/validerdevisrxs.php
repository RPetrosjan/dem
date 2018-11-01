<?if($secure == 100){

global $ConMySql;

function SendClientInfo($nom,$prenom,$clientmail)
{
	$messageMD = NotificationDevisClient($nom,$prenom);


	$nomsociete = "Demenagement Express";
	$emailsociete =  "contact@demenagement-express.fr";


	$emailto = $clientmail;
	$fromname = "Demenagement Express";
	$fromemail = "contact@xn--dmnagements-bbbb.fr";
	$subject = "Info Devis";
	$htmlmessage = $messageMD;
	$adminemail = "contact@demenagement-express.fr";
	$bbcemail = "contact@demenagement-express.fr";
	$filename = "20_conseils_demenagement.pdf"; 


	include("newlibmail.php");
	if(SendExpressMail($emailto,$fromname,$fromemail,$subject,$htmlmessage,$filename,$adminemail,$bbcemail))
	{
		///echo "Envoyee!!!";
	}
}
function GetNumberRandom()
{
      $characters = '123456789'; 
	  $random_string_length = 5;
	  $string = ''; 
      
      for ($i = 0; $i <$random_string_length; $i++)
	  { 
					  $string.= $characters[rand(0, strlen($characters) - 1)]; 
	  }
      return $string; 
	
}
function AddSessionDevis($email,$KeySsi,$DevisNum)
{
	 global $ConMySql;
	 $query = "SELECT * FROM express_entreprise WHERE email='".$email."'  ";
     $addsession = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));
	 if ($rowaddsession = mysqli_fetch_assoc($addsession))
	 {
			$queryadd ="INSERT INTO express_sessions_devis (NomSociete,KeySsi,DevisNum) VALUE ('".$rowaddsession['nom_societe']."','".$KeySsi."','".$DevisNum."' )";
			mysqli_query($ConMySql,$queryadd) or die(mysqli_error($ConMySql));
	 }	
}
function SendUserInfo($personID,$cp1,$cp2,$date1,$date2,$ville1,$ville2,$cond,$volume)
{
	$mails="";
	$dep1=substr($cp1,0,2);
	$dep2=substr($cp2,0,2);

	echo $dep1." | ".$dep2;

	$subject = "Devis ".$cp1." -> ".$cp2;
	$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
	$headers .= "From: demenagement-express.fr <contact@demenagement-Express.fr>\r\n"; 

	global $ConMySql;
	$resultMD = mysqli_query($ConMySql,"SELECT * FROM express_mails_devis WHERE departament LIKE '%$dep1%' OR departament LIKE '%$dep2%' ORDER BY RAND() LIMIT 20 ");

	

	   
	global $adminemail;
	      
    while($rowMD = mysqli_fetch_array($resultMD))
    {
	   $keyssi = md5(GetNumberRandom());
	   $messageMD = NotificationDevis($date1,$date2,$cp1,$cp2,$ville1,$ville2,$volume,$cond,$keyssi);
	   AddSessionDevis($rowMD['mail'],$keyssi ,$personID);
       mail($rowMD['mail'],$subject,$messageMD,$headers);
	   $mails=$mails.$rowMD['mail']." | ";
    }

	mail($adminemail,$subject,$messageMD."<br/><br/>".$mails."<br/><br/>",$headers);
}

if(isset($_GET['ipch']) && isset($_GET['emailch']))
{

	$ip=substr($_GET['ipch'],0,30);
	$ip=htmlspecialchars($ip);

	$email=substr($_GET['emailch'],0,50);
	$email=htmlspecialchars($email);

	global $ConMySql;


	echo 'setdevisinto.php';
	include("setdevisinto.php");

	$query = "SELECT * FROM express_users WHERE  ip = '".$ip."' AND email = '".$email."' AND type = '133' ";
	$query = "SELECT * FROM express_users WHERE  ip = '".$ip."' AND email = '".$email."' ";
    $res = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));
    if($row = mysqli_fetch_assoc($res))	
	{
			SetTdevisDemenagements($row);
			$query = "UPDATE express_users SET type='33' WHERE ip = '".$ip."' AND email = '".$email."'";
			$result = mysqli_query($ConMySql,$query)  or die (mysqli_error($ConMySql));

			if($result)
			{
				echo $email." ";
				?>
				   accept;
				<?
			}
			else
			{
				?>
				   no mutch;
				<?
			}

		SendUserInfo($row['personID'],$row['cp1'],$row['cp2'],$row['date1'],$row['date2'],$row['ville1'],$row['ville2'],$row['cond'],$row['volume']);
		SendClientInfo($row['nome'],$row['prenome'],$row['email']);	
	}
	else
	{
			
			?>
			    <script type="text/javascript">
                    function alertexpress()
                    {
                        ShowMessage("error", "Error", "Devis a deja accepté.", "", "", "OK");
                    }
                    setTimeout("alertexpress()",1000);
                </script>
              <? 
	}
	
}


if(isset($_GET['ip']) && isset($_GET['email']))
{
	$ip=substr($_GET['ip'],0,30);
	$ip=htmlspecialchars($ip);

	$email=substr($_GET['email'],0,50);
	$email=htmlspecialchars($email);

	global $ConMySql;

	echo "ku ku";
	include("setdevisinto.php");


	$query = "SELECT * FROM express_users WHERE  ip = '".$ip."' AND email = '".$email."'";
    $res = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));
	$row = mysqli_fetch_assoc($res);
	SetTdevisDemenagements($row);

	$query = "SELECT * FROM express_users WHERE  ip = '".$ip."' AND email = '".$email."' AND type = '1' ";
    $res = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));

    if($row = mysqli_fetch_assoc($res))	
	{
		
		$query = "UPDATE express_users SET type='3' WHERE ip = '".$ip."' AND email = '".$email."'";

			$result = mysqli_query($ConMySql,$query)  or die (mysqli_error($ConMySql));

			if($result)
			{
				echo $email." ";
				?>
				   accept;
				<?
			}
			else
			{
				?>
				   no mutch;
				<?
			}

		SendUserInfo($row['personID'],$row['cp1'],$row['cp2'],$row['date1'],$row['date2'],$row['ville1'],$row['ville2'],$row['cond'],$row['volume']);
		SendClientInfo($row['nome'],$row['prenome'],$row['email']);
	}
	else
	{
			?>
			    <script type="text/javascript">
                    function alertexpress()
                    {
                        ShowMessage("error", "Error", "Devis a deja accepté.", "", "", "OK");
                    }
                    setTimeout("alertexpress()",1000);
                </script>
              <? 
	}
	
}


class backlink
{
	var $errors = '';
	var $backlink = '';
	var $backlink_parse = array();
	var $backlink_path = '';
	var $backlink_path_ar = array();

	function backlink($backlink)
	{
		$this->backlink				= $backlink;
		$this->backlink_parse	= parse_url($backlink);

		$this->backlink_path	= $this->backlink_parse['path'];
		if ( substr($this->backlink_path,0,1)=='/' )	$this->backlink_path = substr($this->backlink_path,1);
		if ( substr($this->backlink_path,-1)=='/' )		$this->backlink_path = substr($this->backlink_path,0,strlen($this->backlink_path)-1);

		$backlink_path_ar			= split("[/]",$this->backlink_path);
		if ( count($backlink_path_ar)>0 )
		{
			foreach ( $backlink_path_ar as $k=>$v )
			{
				$v = trim($v);
				if ( empty($v) ) unset($backlink_path_ar[$k]);
			}
		}
		if ( count($backlink_path_ar)>0 ) $this->backlink_path_ar = $backlink_path_ar;
	}

	function subpath_check($rule)
	{
		if ( count($this->backlink_path_ar)>0 )
		{
			$path = '';
			foreach ( $this->backlink_path_ar as $k=>$v )
			{
				$path.= empty($path) ? $v : "\/".$v;
				if ( preg_match('/Disallow:\s*[\/]?'.$path.'[\/\*]?\s*$/i',$rule) ) return true;
			}
		}
		$this->errors = "False 1";
		return false;
	}

	function check($url)
	{
		$parse_url			= parse_url($url);

		/* robotos.txt */

		$robots_url			= 'http://'.$this->backlink_parse['host'].'/robots.txt';
		$robots_data_ar	= @file($robots_url);

		if ( $robots_data_ar!==false )
		{
			if ( count($robots_data_ar)>0 )
			{
				foreach ( $robots_data_ar as $k=>$v )
				{
					$v = trim($v);
					if ( !empty($v) )
					{
						if ( preg_match('/Disallow:\s*\/\s*$/i',$v) )  // запрет индексации всего сайта
						{
							$this->errors = 'Sur '.$robots_url.' il ya une règle interdisant l\'indexation de la page.';
                            return false;
						}
						if (
							preg_match('/Disallow:\s*[\/]?'.str_replace("/","\/",$this->backlink_path).'[\/\$]\s*$/i',$v) || // запрет индексации страницы с ссылкой
							$this->subpath_check($v)  // запрет индексации пути к странице с ссылкой
						) {
							 $this->errors = 'Sur '.$robots_url.' il ya une règle interdisant l\'indexation de la page.';
							 ///.$this->backlink;
                            return false;
						}
					}
				}
			}
		}

		/* META */

		$meta = @get_meta_tags($this->backlink);
		if (
			eregi('noindex',$meta['robots']) ||
			eregi('nofollow',$meta['robots'])
		) {
			$this->errors = 'Sur la page il ya META tag interdire l\'indexation.';
			//'.$this->backlink.'
			return false;
		}

		/* Link */

		$data = '';
		$fp = @fopen($this->backlink,"r");
		if ( $fp )
		{
			while (!feof($fp)) $data.= fgets ($fp,4096);
			fclose ($fp);

			$pattern = array (
				"'<script[^>]*?>.*?</script>'si", // Вырезается javascript
				"'<noscript[^>]*?>.*?</noscript>'si", // noscript
				"'<noindex[^>]*?>.*?</noindex>'si", // noindex
				"'<a[^>]*?rel=[\"\']nofollow[\"\'].*?>'si", //nofollow
				"'<\!--.*?-->'si", // remarka
			);
			$replace = array(" "," "," "," "," ");
			$data = preg_replace($pattern, $replace, $data);

			if ( preg_match_all('/<a.*?href=["\']http:\/\/(.*?)["\']/i', $data, $m) ) {
				if ( count($m[1])>0 )
				{
					foreach ( $m[1] as $k=>$v ) if ( eregi($parse_url['host'],$v) ) return true;
				}
			}

			 $this->errors = 'Sur la page le lien est introuvable ou n\'est pas accessible.<br />Evidez noindex, nofolow etc...';
			 /// '.$this->backlink.'  <noindex></noindex>  rel="nofolow" и другие...';
        }
        else $this->errors = 'La page '.$this->backlink.' ne peut pas être ouvert.';
		// 

		return false;
	}
}


function DesactiveLien($lien)
{
	global $ConMySql;
	$query = "SELECT * FROM express_societe_liens WHERE Lien = '".$lien."'";
    $res = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));
    if ($row = mysqli_fetch_assoc($res))
	{
		$queryi = "UPDATE  express_societe_liens SET Date='".date("d/m/Y")."', admin='no' WHERE  Lien='".$lien."'";
		mysqli_query($ConMySql,$queryi) or die (mysqli_error($ConMySql));
	}
}

/*
   $webexpress = "http://www.demenagement-express.fr";
   $query = "SELECT * FROM express_societe_liens";
   $res = mysqli_query($ConMySql,$query) or die(mysqli_error($ConMySql));
   while($row = mysqli_fetch_array($res))
   {
		?>
			<div style="text-align: center;">
			<b><? echo $row['Societe']; ?></b>
		<?
		$bl = new backlink($row['Lien']);
		if ( !$bl->check($webexpress) )
		{
			DesactiveLien($row['Lien']);
			?>
			
			<a target="_blank"  style="padding: 10px; font-size: 16px; color: red;" href="<? echo $row['Lien']; ?>"><? echo $row['Lien']; ?></a>
			</div>
			<?
		}
		else
		{
			?>
			<div style="text-align: center;">
			<a  target="_blank" style="padding: 10px;  font-size: 16px; color: green;" href="<? echo $row['Lien']; ?>"><? echo $row['Lien']; ?></a>
			<span class="submit">
				<input type="button" value="Disable" onclick="SetDisableLien('<? echo $row['Lien']; ?>')" />
			</span>
			<?
				if($row['admin']=="no")
				{?>
					<span class="submit">
						<input type="button" value="Accepter" onclick="AcceptWithMail('<? echo $row['Lien']; ?>',this)" />
					</span>
				<?}
			?>

			</div>
			<?
		}

   }
   */

?>
<script type="text/javascript">
	function SetDisableLien(lien)
	{ 
		$.post(urlw, { Disablelien: lien },
		function (data) {
			if(data == "ok")
			{
				ShowMessage("success", "Succès", "Lien est Desactive.", "", "", "OK");	
			}
			else
			{
				ShowMessage("error", "erreur", data, "", "", "OK");	
			}
		

        });
	}
	function AcceptWithMail(lien,obj)
	{ 
		$.post(urlw, { Acceptlien: lien },
		function (data) {
			if(data == "ok")
			{
				obj.style.visibility = "hidden";
				ShowMessage("success", "Succès", "Lien est Active.", "", "", "OK");	
			}
			else
			{
				ShowMessage("error", "erreur", data, "", "", "OK");	
			}
			
		});
	}
</script>
<?




}?>

