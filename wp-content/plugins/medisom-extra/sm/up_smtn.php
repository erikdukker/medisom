<?	
/* up_smtn som tonen*/
include 'class_sessie.php';
$oe			= $_SESSION['oe'];
$rwoe			= $ses->get_row($wpdb->prepare("select * from oe where oeky = '".$oe."'","oe");
$oett			= $ses->toar($rwoe['oett']);
$oepa			= $ses->toar($rwoe['oepa']);
foreach ($_POST as $vld => $val) { 
		$pastx	= str_getcsv($_POST['p|'.substr($vld,2)],';');
		foreach ($pastx as $par1 ) { $par2 = str_getcsv($par1,'=');if (isset($par2[1])){$pas[$par2[0]] = $par2[1];}}
//		$_SESSION['ver'] = substr($oktl.$_SESSION['ver'],0,50);	
		$sel = array("mi", "pl", "ke", "de", "ma", "br");
		if (in_array($sr,$sel)){
			$uq		= str_replace(' ', '', $som['tn']);
		} else {
			$uq		= ''; 																			// of zou dit $som['tn'] moeten zijn
		}
		// detail
		$ses->exsql("insert an SET ken = '".$ken."', uq = '".$uq."', oeky = '".$oe."', ok = '".$som['ok']."', 
					som = '".$ses->totx($som)."', pas = '".$ses->totx($pas)."'","detail");
		// totaal	
		if (!isset($oett['au|'.$ken])) { $oett['au|'.$ken] = '';}									// wat zou het zijn ??
		if (!isset($oett['ve'])) { $oett['ve'] = '';} else { $oett['ve'] =  substr($oett['ve'],0,49); }
		$oett['ve']				= $som['ok'].$oett['ve'];
		if (!isset($oett['to'])) {	$oett['to'] = 0;}												// aantal ok 
		if (!isset($oett['ta'])) {	$oett['ta'] = 0;}												// aantal antwoorden 
		$oett['ta']++;
		if ($som['ok'] 				== 'a') { 
			$oett['to']++;
			if (isset($oett['ok|'.$ken])) {																// ok = goed
				$oett['ok|'.$ken]	= $oett['ok|'.$ken] + 1; 	
			} else {
				$oett['ok|'.$ken]	= 1; 
			} 	
			$oett['au|'.$ken] 		= 'a'.$oett['au|'.$ken];
		} else {
			if (isset($oett['no|'.$ken])) {																// no = fout
				$oett['no|'.$ken]	= $oett['no|'.$ken] + 1; 	
			} else {
				$oett['no|'.$ken]	= 1; 
			} 	
			$oett['au|'.$ken] 		= 'u'.$oett['au|'.$ken];		
		}
		//val($oepa['ni']);
		switch ($oepa['ni']) {																			// ni in oepa = ni in uspa
			case 1: $dlOk=40; $mlNo=2;	break;															// brons, snel oefenen
			case 2: $dlOk=60; $mlNo=4;	break;															// zilver, normaal (6)
			case 3: $dlOk=80; $mlNo=6;	break;															// goud, meer (8)
		}
		$tel						= substr_count(substr($oett['au|'.$ken],0,$pas['ao']),'a');			// bepalen aantal goed
		$oett['ct|'.$ken]			=  round((100 * $tel) / $pas['ao'],0);								// bereken score
		if (!isset($oett['ni|'.$ken])) { $oett['ni|'.$ken] = 0;	}										// ster nivo init
		if ($oett['ct|'.$ken] 		>= $dlOk ) {														// beter dan norm
			if ($oett['ni|'.$ken] 	<= $oepa['ni']) {													// verbetering?
				$oett['ni|'.$ken] 	= $oepa['ni'];														// ster nivo
				$oett['ns|'.$ken] 	= $oepa['ni'];														// nieuwe ster indicator
			}
		}
		if ($oett['no|'.$ken] > ($pas['ao'] * $mlNo)) {													// door begrenzing
			$oett['ni|'.$ken] 		= $oepa['ni'] + 10;													//
	//		val($oepa['ni'] );																			//
	//		val($oett['ni|'.$ken] );																	//
		} else {
			if ($oett['ni|'.$ken] > 10) {																// andere sterren gekozen
				$oett['ni|'.$ken] 	= 0;			
			}
		}
	//	if (substr($vld,2) == $_POST['ansom']){															// alleen laatste som hoeft eigenlijk niet
			$_SESSION['vopas']	= totx($pas);
	//	}
	}
}

$ses->tr_log($oett,"oett voor update");
$ses->exsql("update oe set oepa = '".$ses->totx($oepa)."', oett = '".$ses->totx($oett)."' where oeky = '".$oe."'","oe");
$ses->tr_log($oepa,"oepa na update");
$ses->tr_log($oett,"oett na update")s->tr_log($_SESSION,"SESSION");
?>