<?	
require_once('../../../../wp-load.php');
include 'class_sessie.php';
$ses->tr_log('module >>>> '.'ua_smup update som sommen');
$ses->tr_log($_POST,'post bij aanroep smaj');
if (isset($_POST['pasjs'])) 	{ 	
	echo 'pasjs '.$_POST['pasjs'].'<br>';												// opgestart met resultaten
	echo 'oeky '.$ses->oeky.'<br>';														// opgestart met resultaten
	echo 'oecojs'.$_POST['oecojs'].'<br>';												// opgestart met resultaten
	$pas 		= json_decode(stripslashes($_POST['pasjs']));
	$oeco_upd 	= json_decode(stripslashes($_POST['oecojs']));

	$wpdb->insert( 'm_an', array( 'smid' => $pas->id, 'oeky' => $ses->oeky, 'ok' => $pas->ok, 'pas' => stripslashes($_POST['pasjs']) ), array('%s', '%s', '%s', '%s' ));
	// totaal	
	$rwoe	= $wpdb->get_row("select * from m_oe where oeky = '".$ses->oeky."'");
	$oepa 	= json_decode($rwoe->oepa);
	$oeco 	= json_decode($rwoe->oeco);
	foreach ($oeco_upd as $par => $val) {
		echo 'par'.$par.'<br>';
		$oeco->{$par}	= $val;
	}
	echo 'oepa : '.$rwoe->oepa.'<br>';
	if ($pas->ok == 'a') {
		$oepa->{'ok'.$pas->id} = $oepa->{'ok'.$pas->id} + 1;
	} else {
		$oepa->{'no'.$pas->id} = $oepa->{'no'.$pas->id} + 1;
	}
	$oepa->{'lt'.$pas->id}	= substr($pas->ok.$oepa->{'lt'.$pas->id},0,30);				// de laatste 30 antwoorden
	$aant_ant	= $oepa->{'ok'.$pas->id} + $oepa->{'no'.$pas->id};						// aantal gegeven antwoorden
	$aant_vr	= ( $pas->as * $oeco->om ) / 100;										// gekozen omvang (om = %)
	if ( $oeco->kl == 0) {																// toets
		if ($aant_ant == $pas->as ) {
			$oepa->{'fi'.$pas->id}	= 'kl';												// fin
		} else {
			$oepa->{'fi'.$pas->id}	= 'vd';												// verder
		}
		$oepa->{'pc'.$pas->id} 		= round(($oepa->{'ok'.$pas->id} * 100) / $aant_ant).' % )';
	} elseif ( $aant_ant >= ( $pas->as * $oeco->mx ) / 100) {								// genoeg geoefend meer dan mx dus
		$oepa->{'fi'.$pas->id}		= 'go';	
		$oepa->{'pc'.$pas->id} 		= round(($oepa->{'ok'.$pas->id} * 100) / $aant_ant).' % )';
	} else {	
		$norm		= round(( $pas->as * $oeco->kl ) / 100);							// hoeveel moeten er goed zijn (kl = %)
		$ant	= substr($pas->ok.$oepa->{'lt'.$pas->id},0,$pas->as);					// alleen het aantal vragen
		$tel	= substr_count($ant,'a');												// bepalen aantal goed 
		$oepa->{'pc'.$pas->id} 		= round(($tel * 100) / $norm).' % van de norm )';
		if ($tel >= $norm )  {
			$oepa->{'fi'.$pas->id}	= 'ok';												// voldaan
		} else {
			$oepa->{'fi'.$pas->id}	= 'vd';												// verder
		}
	}
	$wpdb->update( 'm_oe', array( 'oepa' => json_encode($oepa), 'oeco' => json_encode($oeco)), array( 'oeky' => $ses->oeky ), array( '%s') );
} 
echo 'oeco goed ? : '.json_encode($oeco);
?>	