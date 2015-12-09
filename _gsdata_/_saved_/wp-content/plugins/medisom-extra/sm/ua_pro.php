<?	
require_once('../../../../wp-load.php');
include 'class_sessie.php';
$ses->tr_log('module >>>> '.'ua_pro update som + nieuwe som');
$ses->tr_log('post bij aanroep ua_pro :');
$ses->tr_log($_POST);
if (isset($_POST['pasjs'])) 	{ 														// eerst een resultaat verwerken
	$pas 		= json_decode(stripslashes($_POST['pasjs']));
	$oeco_upd 	= json_decode(stripslashes($_POST['oecojs']));
	$wpdb->insert( 'm_an', array( 'smid' => $pas->id, 'oeky' => $ses->oeky, 'ok' => $pas->ok, 'pas' => stripslashes($_POST['pasjs']) ), array('%s', '%s', '%s', '%s' ));
	// totaal	
	$rwoe	= $wpdb->get_row("select * from m_oe where oeky = '".$ses->oeky."'");
	$oepa 	= json_decode($rwoe->oepa);
	$oeco 	= json_decode($rwoe->oeco);
	foreach ($oeco_upd as $par => $val) { $oeco->{$par}	= $val; }						// oeco updaten: de toetsen
	if ($pas->ok == 'a') {																// resultaat tellen
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
	$ses->tr_log($oeco);
	$wpdb->update( 'm_oe', array( 'oepa' => json_encode($oepa), 'oeco' => json_encode($oeco)), array( 'oeky' => $ses->oeky ), array( '%s') );
	$ses->tr_log($_POST,'post bij aanroep smaj');
} 
// nieuw som opbouwen ------------------------------------------------------------------------------------------------------------------------------------
if ($ses->mode 	== 'b') {															// alleen berekening dus geen oefening
	$id 		= $ses->bt;
} elseif ($rwoe	= $wpdb->get_row($wpdb->prepare("select * from m_oe where oeky = %s",$ses->oeky))) { 
	$oepa		= json_decode($rwoe->oepa);	
	$coid		= $rwoe->coid;
	$pas		= json_decode($rwoe->oepa);
	$ses->tr_log('conf ');$ses->tr_log($pas);
	$wd_laagste	= 1000;
	unset($id);
	foreach ( $pas as $par => $val) {
		if (substr($par,0,2) == 'wd'){
			if (($oepa->{'fi'.substr($par,2)}	== 'vd')) {							// nog niet voldaan
				$sw			= rand(-3,3); 											// swing voor variatie
				$wd_cor		= $val + $sw;										 	// de waardering + swing voor variatie
				$ses->tr_log('wd_id : '.substr($par,2).' wd : '.$val.' wd_co : '.$wd_cor.' wd_laagste : '.$wd_laagste.' fi : '.$oepa->{'fi'.substr($par,2)}.'<br>');
				if ( $wd_cor < $wd_laagste) {										// zoek id met de laagste sore
					$id			= substr($par,2);
					$wd_laagste = $wd_cor;		
				}	
			}	
		}
	}
} else {	
	?><img src="../wp-content/plugins/medisom-extra/sm/zimg/no17.png" onload="document.location.href ='http://medisom.nl/onof/';" /> <?
}
// we hebben een id van een br berekening
if (isset($id)) {
	$rwbr 		= $wpdb->get_row("SELECT * FROM m_sy where syid = '".$id."' and sytp = 'br'");	// het ophalen van de berekening												
	$pas		= json_decode($rwbr->sypa);
	$pas->id	= $id;
	echo "<div><b style='margin-right:15px'>".$oepa->ds." › ".$rwbr->syds."</b>";		// titel
	if (isset($oepa) and $oepa->{'ok'.$id} > 1) {
		echo '( '.$oepa->{'ok'.$id}.' goed van '.($oepa->{'ok'.$id} + $oepa->{'no'.$id}).', '.$oepa->{'pc'.$id};
	}
	echo '</div>';										
} else {
//	?><img src="../wp-content/plugins/medisom-extra/sm/zimg/ok17.png" onload="document.location.href ='http://medisom.nl/ofkl/';" /> <?
}
// we hebben een berekening
$ok		= false;																		// goede som ?
$tl		= 20;																			// 20 pogingen om een goede som te maken
while ( !$ok and $tl	> 0 ) {															// zoek  
	for ($i=1;$i<=9;$i++) {																// de variabelen berekenen
		if (isset($pas->{'t'.$i})) { 													// variabele t$i
			$tvars		= str_getcsv($pas->{'t'.$i},'|}');
			foreach ( $tvars as $tvar) {												// de parameters opsplitsen
				$pas->{'t'.$i.substr($tvar,0,1)} = substr($tvar,1);
			}
			// v van, t tot, d decimalen, s special
			if (!isset($pas->{'t'.$i.'s'})) { 											// niet speciaal
				if (isset($pas->{'t'.$i.'v'}) and isset($pas->{'t'.$i.'t'})) { 			// maar wel een t specificatie
					if (isset($pas->{'t'.$i.'d'}) ) { 									// decimalen na komma
						if ($pas->{'t'.$i.'d'} < 0 ) { 									// nullen voor komma
							$dec	= 1;
							$dec_dl	= pow(10,$pas->{'t'.$i.'d'});
						} else {
							$dec	= pow(10,$pas->{'t'.$i.'d'});		
							$dec_dl	= $dec;							
						}
					} else {
						$dec	= 1;
						$dec_dl	= 1;
					}			
					$pas->{'r'.$i}		= rand(($dec * $pas->{'t'.$i.'v'}),($dec * $pas->{'t'.$i.'t'})) / $dec_dl;
				}
			}	
		}
	}
	$ok							= true;																		// een goede som
//	$ses->tr_log(' t1 > '.$pas->r1.' t2 > '.$pas->r2.' t3 > '.$pas->r3);
	$in_basis					= false;
	switch ($pas->sm) {																	// reken routine
		case 'ba': 
			$calfo				= $pas->fo;												// calculatie formule samenstellen
			$pas->tn			= $pas->fo;												// toon som samenstellen
			for ($j = 1; $j <= 9; $j++){												// t1 tm t9 vervangen
				if (isset($pas->{'r'.$j})) {
					$calfo 		= str_replace('t'.$j,$pas->{'r'.$j},$calfo);
					$pas->tn 	= str_replace('t'.$j,$pas->{'r'.$j},$pas->tn);
				}
			}
			$calfo 		= str_replace('x','*',$calfo);									// keer	
			$pas->rs 	= eval('return '.$calfo.';');
			$ses->tr_log($calfo.' res '.$pas->rs);
			$in_basis			= true;
		break;
		case 'sc': 																	// delen
			$rwsc 		= $wpdb->get_row("select * from m_sy where sytp = 'sc' and syid ='".$pas->sc."'");
			$stappen	= str_getcsv($rwsc->sypa,';');
			if ($pas->r2 	== $pas->r3) {
				$ok		= false;
			}
			unset($e2,$e3);
			for ( $i	= 0; $i <= 20; $i++) {
				if (isset($stappen[$i])) {
					$pars	= str_getcsv($stappen[$i],'|');	
					if ($pars[0] 	== $pas->r2) {
						$e2			= $pars[1];											// eenheid
						$m2			= $pars[2];											// metrische stap
						$f2			= $pars[3];											// factor naar metrisch
					}	
					if ($pars[0] 	== $pas->r3) {
						$e3			= $pars[1];											// eenheid
						$m3			= $pars[2];											// metrische stap
						$f3			= $pars[3];											// factor naar metrisch
					}	
					if ($pars[0] 	== 'di') {
						$di			= $pars[1];											// dimensie 1,2,3, 
					}
				}
			}
			if (isset($e2) and isset($e3)) {
				$pas->tn	= $pas->r1.' '.$e2;
				$pas->tn2	= $e3;
				$r1			= $pas->r1;
				if ($f2		!= 1) {														// factor naar metrisch
					$r1		=	$r1 / $f2;
				}	
				if ($f3		!= 1) {														// factor naar metrisch
					$r1		=	$r1 * $f3;
				}
				$div		= $m2 - $m3;
				echo 'lb30 '.$div.'<br>';
				$pas->rs	= $r1 *  pow(10,$div*$di);
			} else {
				$ok		= false;
			}
			$ses->tr_log ('lb30 '.$pas->sm.' ok = '.(int)$ok);
		break;		
	}
	if (! $in_basis) {
		include  'lb_id'.substr($id,0,2).'.php';
	}
	if ($ok) {																			// alleen als ok range controle
		if (isset($pas->{'rg'})) { 								
			$tvars		= str_getcsv($pas->{'rg'},'|}');								// range toegestaan antwoord
			foreach ( $tvars as $tvar) {												// de parameters opsplitsen
				$pas->{'r'.substr($tvar,0,1)} = substr($tvar,1);
			}
			// v van, t tot
			if (isset($pas->rv) and isset($pas->rt)) { 
				if  ($pas->rs < $pas->rv or $pas->rs > $pas->rt) 	{ $ok = false;}		// antwoord niet in range
			}
			elseif (isset($pas->rv) and $pas->rs < $pas->rv ) 	{ $ok = false;}		
			elseif (isset($pas->rt) and $pas->rs > $pas->rt ) 	{ $ok = false;}	
		}
	}	
	$tl--;
}
if ($ok) {
//  scherm opbouwen
// oefening	
	echo "<div id='oe' style='display:inline'>".PHP_EOL;	 																			
	$pas->tn	=	str_replace(".",",",$pas->tn); 												// de toon formule
	$pas->rs	=	str_replace(".",",",$pas->rs); 												// van punt naar komma het resultaat
	if ($pas->vr == 'mk') {	
		for ( $i	= 1; $i <= $pas->aa; $i++) { if (isset($pas->{'a'.$i}) and $pas->{'a'.$i} == $pas->rs) {$pas->ko = $i;}}  		// wat is de goede keuze
	}
	echo "<div id='pasjs' style='font-size:10px;' class='nd'>".json_encode($pas)."</div>".PHP_EOL;	
	echo "<fieldset id=o style='display:inline'><legend><h5>opdracht</h5></legend>".PHP_EOL; 
	$rwbd 	= $wpdb->get_row("select * from m_sy where sytp = 'bd' and syid ='".$pas->vr.$pas->bd."'");
	$pas->inst	= $rwbd->syds;
	echo $pas->inst."".PHP_EOL;
	echo "</fieldset>".PHP_EOL;
	echo "<div id=d style='display:inline; margin-bottom:15px;'>".PHP_EOL; // cover som
	if (isset($pas->im)) {
		echo "<div><img id=i src='../wp-content/plugins/medisom-extra/sm/zimg/".$pas->im.".png' alt='OK' ></div>";
	}
	if (isset($pas->to)) {
		echo "<div>".$pas->to."</div>";
	}
	echo "<div>".PHP_EOL;																		// na opdracht
	if (isset($pas->tl)) {
		echo "<div class='ib' id=v".$pas->tl."' style='padding-right:10px; font-size:10px;display:none'>vorige ></div>".PHP_EOL;	 //vorige	
	}
	// de som	
	echo "<fieldset id=o style='display:inline'><legend id=okd ><h5>som</h5></legend>".PHP_EOL; 
	echo "<div class='ib'>".$pas->tn."</div>".PHP_EOL;											// som tekst
	echo "<div class='ib'>=</div>".PHP_EOL;														// =
	if ($pas->vr 	== 'mk') {	
		for ( $i	= 1; $i <= $pas->aa; $i++) {
			if (isset($pas->kb)) {$kb = "style='width: ".$pas->kb."px'"; } else { $kb = "";} 	// afwijkende breedte
			echo "<div class='ib kn' ".$kb." id=k".'|'.$i." onclick='pro(".$i.")'>";
			echo $pas->{'a'.$i}."</div>";														// een knop
		}
	 } elseif ($pas->vr	== 'ov') {
		$pasrs		= str_getcsv($pas->rs,'|'); 												// splits antwoorden 
		$antwoord 	= '';
		foreach ( $pasrs as $ant) {
			if ($antwoord 	== '' ) {
				$antwoord 	= $ant;
			} else {
				$antwoord 	.= ' of '.$ant;
			}
		}
//		echo 'pas tn 1'.$pas->tn.' pas tn2 '.$pas->tn2,'<br>';
		echo "<div class='ib'>";																	// open antwoord
		if ($pas->tl			== 0 and isset($pas->sc)) {$sc = $pas->sc;} else { $sc = '';} 		// sc is het in gegeven antwoord
//		echo "<input type='text' class='md' id='t' onchange='pro(99)' onkeyup='evhand(event)' style='display:inline; width:100px; margin:0px; padding:3px' autofocus>".PHP_EOL;
		echo "<input type='text' class='md' id='t' onchange='pro(99)'  style='display:inline; width:100px; margin:0px; padding:3px' autofocus>".PHP_EOL;
//		echo 'pas tn 2'.$pas->tn.' pas tn2 '.$pas->tn2,'<br>';
		echo "<script>document.getElementById('t').focus();</script>".PHP_EOL;
//		echo 'pas tn 3'.$pas->tn.' pas tn2 '.$pas->tn2,'<br>';
		if (isset($pas->tn2)) {
			echo $pas->tn2;
			$tn2			= $pas->tn2;
		} else {
			$tn2			= '';
		}
		echo "<input class='md'	disabled type='text' id='oa' value='".$antwoord." ".$tn2."' style='background:#41fa10; display:none; width:100px; margin:0px; padding:3px' )'>".PHP_EOL;
		echo "</div>";				
		?><img src="../wp-content/plugins/medisom-extra/sm/zimg/no17.png"  onload="document.getElementById('t').focus();" style='display:none;' /> <?
	}
	echo "<div class='ib' style='padding: 0px 10px 0px 10px;'>";													// teken
	echo "<img id=ok class='nd' src='../wp-content/plugins/medisom-extra/sm/zimg/ok17.png' alt='OK' width='17' height='17' >";
	echo "<img id=no class='nd' src='../wp-content/plugins/medisom-extra//sm/zimg/no17.png' alt='NO' width='17' height='17' >";
	echo "</div>".PHP_EOL;																							// einde teken
	echo "</div>".PHP_EOL;																							// de som
	echo "</div>".PHP_EOL;	
	echo "</fieldset>".PHP_EOL;

	if (isset($pas->ui)){																							// uitleg
		$rwui	= $wpdb->get_row("select * from m_sy where syid = '".$pas->ui."' and sytp = 'ui'");					// het ophalen van de uitleg		
		echo "<fieldset><legend><h5>uitleg / tips</h5></legend>".PHP_EOL; 
		echo $rwui->sypa.PHP_EOL;
		echo "</fieldset>".PHP_EOL; 	
	}
	// cover som
	echo "</div><!--einde -->".PHP_EOL; 	
	unset($pas);
	$ses->tr_log('module >>>> in_smex.php toon extra ');
	if (isset($evq)) {
		$ev 		= str_getcsv($evq,';');	
		$rwts 		= $wpdb->get_row($wpdb->prepare("SELECT * FROM ts where sytp = 'ev' and id = '%s"));
		$tspa		= json_decode($rwts->tspa);
		unset($ev[0]);
		$evq		= '';
		if (isset($ev)) {
			foreach ($ev as $evp) { if ($evp != '') {$evq = $evq.';'.$evp;}}
		}
		$come = $rwts->tx;
		if (isset($tspa->vv)) {
			if (isset($evq)) {
				$evq 	= $tspa->vv.';'.$evq;
			} else {
				$evq 	= $tspa->vv;
			}	
		}	
		$_SESSION->evq = $evq;
	} else {
		unset($come);
	}	
	if (isset($come)){																									// advies
		echo "<fieldset><legend><h5>advies</h5></legend>".PHP_EOL; 
		echo $come.PHP_EOL;
		echo "</fieldset>".PHP_EOL; 	
	}																				
	$ver						= '';
	$ct							= 0;
	$at							= 0;
	$gr							= '';
	while( strlen($ver) > 0 ) {	
		$ct++;
		if (substr($ver,0,1) == 'a') {	
			$gr					= $gr."<td class=bl1></td>";
			$at++;
		} else {	
			$gr					= $gr."<td class=bl2></td>";
		}
		$ver= substr($ver,1);
	} 
	if ( $ct > 0) {
		echo "<fieldset><legend><h5>scores</h5></legend>".PHP_EOL; 
		echo "<table class='sm'><tr>".PHP_EOL; 
		echo "<td id='at'>".$at."</td><td style='padding:3px'>  goed van </td><td td id='ct'>".$ct."</td><td style='padding:3px'><table class='sm'><tr>".$gr."</tr></table></td>".PHP_EOL; 
		echo "<td style='padding:3px'>(laatste vooraan)</td></tr></table >".PHP_EOL; 
		foreach ( $oett as $par => $wrd) {
			$pael				= str_getcsv($par,'|'); 														// splits par
			if ($pael[0] 		== 'ni') {																		// tellen sterren
				$st->$wrd++;																					// per soort ster
			}
		}
		if (isset($st[1]) or isset($st[2]) or isset($st[3])) {
			if (isset($st[1]) and $st[1] != 0) {																		
				for($i = 1; $i <= $st[1]; $i++) { echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sb 18.png'>"; }
				echo " (".$st[1]." brons) ".PHP_EOL;
			}
			if (isset($st[2]) and $st[2] != 0) {
				for($i = 1; $i <= $st[2]; $i++) { echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sz 18.png'>"; }
				echo " (".$st[2]." zilver) ".PHP_EOL;
			}
			if (isset($st[3]) and $st[3] != 0) {
				for($i = 1; $i <= $st[3]; $i++) { echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sg 18.png'>"; } 
				echo " (".$st[3]." goud)".PHP_EOL;
			}
			echo "van ".$oepa->st." sterren".PHP_EOL;
		}	
		if (isset($st[11]) or isset($st[12]) or isset($st[13])) {
			if (isset($st[11]) and $st[11] != 0) {																		
				echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vb 18.png'>"; 
				echo " (".$st[11]." brons) ".PHP_EOL;
			}
			if (isset($st[12]) and $st[12] != 0) {
				echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vz 18.png'>"; 
				echo " (".$st[12]." zilver) ".PHP_EOL;
			}
			if (isset($st[13]) and $st[13] != 0) {
				echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vg 18.png'>"; 
				echo " (".$st[13]." goud)".PHP_EOL;
			}
		}
		echo "</fieldset>".PHP_EOL; 
	}	
	echo "</div >".PHP_EOL;	
// stap voor stap	
	echo "<div id='stap' style='display:none'>".PHP_EOL;	 																			
	echo "</div >".PHP_EOL;	 					
	
} else {
//	?><img src="../wp-content/plugins/medisom-extra/sm/zimg/ok17.png" onload="document.location.href ='http://medisom.nl/ofkl/';" /> <?
}
?>	