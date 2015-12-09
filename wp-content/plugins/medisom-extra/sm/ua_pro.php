<?
require_once('../../../../wp-load.php');
include 'class_sessie.php';
$ses->tr_log('module >>>> ' . 'ua_pro update som + nieuwe som');
$ses->tr_log('post bij aanroep ua_pro :');
$ses->tr_log($_POST);
if (isset($_POST['pasjs'])) {                                                        // eerst een resultaat verwerken
    $pas = json_decode(stripslashes($_POST['pasjs']));
    $pasjs = json_encode($pas);
    $wpdb->insert('m_an', array('smid' => $pas->id, 'oeky' => $ses->oeky, 'ok' => $pas->ok, 'ip' => $ses->ip, 'anpa' => $pasjs), array('%s', '%s', '%s', '%s', '%s'));
    // totaal
    $rwoe = $wpdb->get_row("select * from m_oe where oeky = '" . $ses->oeky . "'");
    $oepa = json_decode($rwoe->oepa);
    $oeco = json_decode($rwoe->oeco);
    if ($pas->ok == 'a') {                                                              // resultaat tellen
        $oepa->{'ok' . $pas->id} = $oepa->{'ok' . $pas->id} + 1;
    } else {
        $oepa->{'no' . $pas->id} = $oepa->{'no' . $pas->id} + 1;
    }
    $oepa->{'ov' . $pas->id} = $oepa->{'ov' . $pas->id} - 1;
    $oepa->{'lt' . $pas->id} = substr($pas->ok . $oepa->{'lt' . $pas->id}, 0, 30);      // de laatste 30 antwoorden
    switch ($oeco->kz) {
        case 't':                                                                        // toets
            $kl = 0;                                                                    // klaar als % goed als 0 dan toets
            $om = 100;                                                                    // omvang in %
            $mx = 0;                                                                    // maximale aantal sommen als niet klaar  %																		// maximale aantal sommen als niet klaar  %
            break;
        case 'o':                                                                        // gewoon
            $kl = 70;                                                                    // klaar als % goed als 0 dan toets
            $om = 100;                                                                    // omvang in %
            $mx = 150;                                                                    // maximale aantal sommen als niet klaar  %
            break;
        case 'k':                                                                        // korter
            $kl = 60;                                                                    // klaar als % goed als 0 dan toets
            $om = 50;                                                                    // omvang in %
            $mx = 75;                                                                    // maximale aantal sommen als niet klaar  %
            break;
        case 'l':                                                                        // langer
            $kl = 80;                                                                    // klaar als % goed als 0 dan toets
            $om = 150;                                                                    // omvang in %
            $mx = 200;
            break;
        case 'i':                                                                        // uitleg
            $ses->mode = 'i';
            break;
    }
    if ($ses->mode != 'i') {																// not info
        $aant_ant 	= $oepa->{'ok' . $pas->id} + $oepa->{'no' . $pas->id};                  // aantal gegeven antwoorden
        $aant_vr 	= ($pas->as * $om) / 100;                                               // gekozen omvang (om = %)
        if ($oeco->kz == 't') {                                                                // toets
            if ($aant_ant == $pas->as) {
                $oepa->{'fi' . $pas->id} = 'kl';                                                // fin
            } else {
                $oepa->{'fi' . $pas->id} = 'vd';                                                // verder
            }
            $oepa->{'pc' . $pas->id} = round(($oepa->{'ok' . $pas->id} * 100) / $aant_ant) . ' % )';
        } elseif ($aant_ant >= ($pas->as * $mx) / 100) {                                // genoeg geoefend meer dan mx dus
            $oepa->{'fi' . $pas->id} = 'go';
            $oepa->{'pc' . $pas->id} = round(($oepa->{'ok' . $pas->id} * 100) / $aant_ant) . ' % )';
        } else {
            $norm = round(($pas->as * $kl) / 100);                                    // hoeveel moeten er goed zijn (kl = %)
            $ant = substr($pas->ok . $oepa->{'lt' . $pas->id}, 0, $pas->as);                    // alleen het aantal vragen
            $tel = substr_count($ant, 'a');                                                // bepalen aantal goed
            $oepa->{'pc' . $pas->id} = ' )';
            //	$oepa->{'pc'.$pas->id} 		= round(($tel * 100) / $norm).' % van de norm )';
            if ($tel >= $norm) {
                $oepa->{'fi' . $pas->id} = 'ok';                                                // voldaan
            } else {
                $oepa->{'fi' . $pas->id} = 'vd';                                                // verder
            }
        }
        $wpdb->update('m_oe', array('oepa' => json_encode($oepa)), array('oeky' => $ses->oeky), array('%s'));
    }
} else {
    switch ($ses->kz) {
        case 'i':                                                                        // uitleg
            $ses->mode = 'i';
            break;
    }
}
// nieuw som opbouwen ------------------------------------------------------------------------------------------------------------------------------------
$ses->tr_log('opbouwen som');
if ($ses->mode == 'i') {                                                                        		// geen som
    // uitleg
	
    // info
    $rwco = $wpdb->get_row("select * from m_sy where syid = '" . $ses->coid . "' and sytp = 'co'");    // het ophalen van de info
    $copa = json_decode($rwco->sypa);
    if (isset($copa->ui)) {
        $rwal = $wpdb->get_row("select * from m_sy where syid = '" . $copa->ui . "' and sytp = 'ui'");    // het ophalen van de info
        echo "<fieldset><legend><h5>uitleg</h5></legend>" . PHP_EOL;
        echo $rwal->sypa . PHP_EOL;
        echo "</fieldset>" . PHP_EOL;
    } else {
        echo "<fieldset><legend><h5>uitleg</h5></legend>" . PHP_EOL;
        echo "<h4><br>Helaas (nog) geen uitleg beschikbaar<br></h4>". PHP_EOL;
        echo "</fieldset>" . PHP_EOL;
    }
    $brs = str_getcsv($copa->br, '|}');
    foreach ($brs as $br) {
        if ($rwbr = $wpdb->get_row("SELECT * FROM m_sy where syid = '" . $br . "' and sytp = 'br'")) {
            $oef[$br] = '<td>' . $rwbr->syds . '</td>';
        }
    }
    $tel = 0;
    $rsoe = $wpdb->get_results($wpdb->prepare("SELECT * FROM m_oe where coid = %s and seid = %s order by oeky desc", $ses->coid, $ses->seid));
	$to_all = 0;
    foreach ($rsoe as $rwoe) {
        $tel++;
        if ($tel <= 5) {
            //		echo $tel;
            $oepa = json_decode($rwoe->oepa);
            $oeco = json_decode($rwoe->oeco);
            foreach ($oepa as $par => $val) {
                if (substr($par, 0, 2) == 'ok') {
                    $ok = $val;
                    $to = $val + $oepa->{'no' . substr($par, 2)} + $oepa->{'ov' . substr($par, 2)};
					if ($to > 0) {
					   	$to_all = $to_all + $to; 
						$sc		= ($ok * 10)/ $to;
						if ($oeco->kz != 'k') {
							if ($sc < 5) { $cl = 'rgba(255,0,0,0.4)';}
							elseif ($sc < 8) { $cl = 'rgba(255,255,0,0.4)';}
							else { $cl = 'rgba(0,255,0,0.4)';}
						} else {
							if ($sc > 8) { $cl = 'rgba(0,0,255,0.18)';}
							$score	= "(".round($sc * 10 ).' %)';
						}	
						$scorevk	= " style='background:".$cl."'";
                        $oef[substr($par, 2)] .= '<td'.$scorevk.'>' . $ok . ' van ' . $to . '</td>';
                    } else {
                        $oef[substr($par, 2)] .= '<td> </td>';
                    }
                }
            }
        }
    }
	if ($to_all > 0) {
		echo "<fieldset><legend><h5>de 5 laatste scores per oefening</h5></legend>" . PHP_EOL;
		echo '<table>';
		foreach ($oef as $oefnr => $reg) {
			echo '<tr>' . $reg . '</tr>';
		}
		echo '</table>';
		echo 'laatste oefening staat vooraan en als vakje leeg dan zijn er geen antwoorden gegeven';
		echo "</fieldset>" . PHP_EOL;
	}
} 

if ($ses->mode == 'b') {                                                            // alleen berekening dus geen oefening
	$id = $ses->bt;
}
if ($ses->mode == 'c') {
	if ($rwoe = $wpdb->get_row($wpdb->prepare("select * from m_oe where oeky = %s", $ses->oeky))) {
        $oepa = json_decode($rwoe->oepa);
        $oeco = json_decode($rwoe->oeco);
        $coid = $rwoe->coid;
        $pas = json_decode($rwoe->oepa);
        $ses->tr_log('conf ');
        $ses->tr_log($pas);
        $wd_laagste = 1000;
        unset($id);
        foreach ($pas as $par => $val) {
            if (substr($par, 0, 2) == 'wd') {
                if ($oepa->{'fi' . substr($par, 2)} == 'vd') {                            // nog niet voldaan
                    $sw = rand(-3, 3);                                            // swing voor variatie
                    $wd_cor = $val + $sw;                                            // de waardering + swing voor variatie
                    $ses->tr_log('wd_id : ' . substr($par, 2) . ' wd : ' . $val . ' wd_co : ' . $wd_cor . ' wd_laagste : ' . $wd_laagste . ' fi : ' . $oepa->{'fi' . substr($par, 2)} . '<br>');
                    if ($wd_cor < $wd_laagste) {                                        // zoek id met de laagste sore
                        $id = substr($par, 2);
                        $wd_laagste = $wd_cor;
                    }
                }
            }
        }
    } else {
        ?><img src="../wp-content/plugins/medisom-extra/sm/zimg/no17.png"
               onload="document.location.href ='http://medisom.nl/onof/';"/> <?
    }
}
if ($ses->mode == 'b' or $ses->mode == 'c') {
	$ses->tr_log('id '.$id);
	if (isset($id)) {                                                                             	// we hebben een id van een br berekening
		$rwbr = $wpdb->get_row("SELECT * FROM m_sy where syid = '" . $id . "' and sytp = 'br'");    // het ophalen van de berekening
		$pas = json_decode($rwbr->sypa);
		$ses->tr_log('pas uit br');
		$ses->tr_log($pas);
		$pas->id = $id;
		echo "<div><b style='margin-right:15px'>› " . $oeco->ds . "</b>";     					   // titel
		if (isset($oepa) and $oepa->{'ok' . $id} > 3) {
			echo '( ' . $oepa->{'ok' . $id} . ' goed van ' . ($oepa->{'ok' . $id} + $oepa->{'no' . $id}) . ' ' . $oepa->{'pc' . $id};
		}
		echo '</div>';
	} else {
		?><img src="../wp-content/plugins/medisom-extra/sm/zimg/ok17.png"
					 onload="document.location.href ='http://medisom.nl/ofkl/';"/> <?
	}

	// we hebben een berekening
	$ok = false;                                                                        // goede som ?
	$tl = 20;                                                                                     // 20 pogingen om een goede som te maken
	while (!$ok and $tl > 0) {                                                            // zoek
		for ($i = 1; $i <= 9; $i++) {                                                                // de variabelen berekenen
			if (isset($pas->{'t' . $i})) {                                                    // variabele t$i
				$tvars = str_getcsv($pas->{'t' . $i}, '|}');
				foreach ($tvars as $tvar) {                                                // de parameters opsplitsen
					$pas->{'t' . $i . substr($tvar, 0, 1)} = substr($tvar, 1);
				}
				// v van, t tot, d decimalen, s special
				if (!isset($pas->{'t' . $i . 's'})) {                                            // niet speciaal
					if (isset($pas->{'t' . $i . 'v'}) and isset($pas->{'t' . $i . 't'})) {            // maar wel een t specificatie
						if (isset($pas->{'t' . $i . 'd'})) {                                    // decimalen na komma
							if ($pas->{'t' . $i . 'd'} < 0) {                                    // nullen voor komma
								$dec = 1;
								$dec_dl = pow(10, $pas->{'t' . $i . 'd'});
							} else {
								$dec = pow(10, $pas->{'t' . $i . 'd'});
								$dec_dl = $dec;
							}
						} else {
							$dec = 1;
							$dec_dl = 1;
						}
						if ($pas->{'t' . $i . 'v'} == $pas->{'t' . $i . 't'}) {
							$pas->{'r' . $i} = $pas->{'t' . $i . 'v'};
						} else {
							$pas->{'r' . $i} = rand(($dec * $pas->{'t' . $i . 'v'}), ($dec * $pas->{'t' . $i . 't'})) / $dec_dl;
						}
					}
			   }
			}
		}
		$ok = true;                                                                        // een goede som
	 //   $ses->tr_log(' pas r1 > '.$pas->r1.' pas r2 > '.$pas->r2.' pas r3 > '.$pas->r3);
		$in_basis = false;
		switch ($pas->sm) {                                                                    // reken routine
			case 'ba':
				$calfo = $pas->fo;                                                // calculatie formule samenstellen
				$pas->tn = $pas->fo;                                                // toon som samenstellen
				for ($j = 1; $j <= 9; $j++) {                                                // t1 tm t9 vervangen
					if (isset($pas->{'r' . $j})) {
						$calfo = str_replace('t' . $j, $pas->{'r' . $j}, $calfo);
						$pas->tn = str_replace('t' . $j, $pas->{'r' . $j}, $pas->tn);
					}
				}
				$calfo = str_replace('x', '*', $calfo);                                    // keer
				$pas->rs = eval('return ' . $calfo . ';');
				$ses->tr_log($calfo . ' res ' . $pas->rs);
				$in_basis = true;
				break;
			case 'sc':                                                                    // delen
				$rwsc = $wpdb->get_row("select * from m_sy where sytp = 'sc' and syid ='" . $pas->sc . "'");
				$stappen = str_getcsv($rwsc->sypa, ';');
				if ($pas->r2 == $pas->r3) {
					$ok = false;
				}
				unset($e2, $e3);
				for ($i = 0; $i <= 20; $i++) {
					if (isset($stappen[$i])) {
						$pars = str_getcsv($stappen[$i], '|');
						if ($pars[0] == $pas->r2) {
							$e2 = $pars[1];                                            // eenheid
							$m2 = $pars[2];                                            // metrische stap
							$f2 = $pars[3];                                            // factor naar metrisch
						}
						if ($pars[0] == $pas->r3) {
							$e3 = $pars[1];                                            // eenheid
							$m3 = $pars[2];                                            // metrische stap
							$f3 = $pars[3];                                            // factor naar metrisch
						}
						if ($pars[0] == 'di') {
							$di = $pars[1];                                            // dimensie 1,2,3,
						}
					}
				}
				if (isset($e2) and isset($e3)) {
					$pas->tn = $pas->r1 . ' ' . $e2;
					$pas->tn2 = $e3;
					$r1 = $pas->r1;
					if ($f2 != 1) {                                                        // factor naar metrisch
						$r1 = $r1 / $f2;
					}
					if ($f3 != 1) {                                                        // factor naar metrisch
						$r1 = $r1 * $f3;
					}
					$div = $m2 - $m3;
					//				echo 'minuut '.$div.'<br>';
					$pas->rs = $r1 * pow(10, $div * $di);
				} else {
					$ok = false;
				}
				$ses->tr_log('minuut ' . $pas->sm . ' ok = ' . (int)$ok);
				break;
		}
		if (!$in_basis) {
			include 'lb_id' . substr($id, 0, 2) . '.php';
		}
		if ($ok) {                                                                 	           // alleen als ok range controle
			if (isset($pas->{'rg'})) {
				$tvars = str_getcsv($pas->{'rg'}, '|}');                             		   // range toegestaan antwoord
				foreach ($tvars as $tvar) {                                          	      // de parameters opsplitsen
					$pas->{'r' . substr($tvar, 0, 1)} = substr($tvar, 1);
				}
				// v van, t tot
				if (isset($pas->rv) and isset($pas->rt)) {
					if ($pas->rs < $pas->rv or $pas->rs > $pas->rt) {
						$ok = false;
					}        // antwoord niet in range
				} elseif (isset($pas->rv) and $pas->rs < $pas->rv) {
					$ok = false;
				} elseif (isset($pas->rt) and $pas->rs > $pas->rt) {
					$ok = false;
				}
			}
		}
		$tl--;
	}
	if ($ok) {
		//  scherm opbouwen
		// oefening
		echo "<div id='oe' style='display:inline'>" . PHP_EOL;
		$pas->tn = str_replace(".", ",", $pas->tn);                                                // de toon formule
		$pas->rs = str_replace(".", ",", $pas->rs);                                                // van punt naar komma het resultaat
		if ($pas->vr == 'mk') {
			for ($i = 1; $i <= $pas->aa; $i++) {
				if (isset($pas->{'a' . $i}) and $pas->{'a' . $i} == $pas->rs) {
					$pas->ko = $i;
				}
			}        // wat is de goede keuze
		}
		echo "<div id='pasjs' style='font-size:10px;' class='nd'>" . json_encode($pas) . "</div>" . PHP_EOL;
		echo "<fieldset id=o style='display:inline'><legend><h5>opdracht</h5></legend>" . PHP_EOL;
		$rwbd = $wpdb->get_row("select * from m_sy where sytp = 'bd' and syid ='" . $pas->vr . $pas->bd . "'");
		$pas->inst = $rwbd->syds;
		echo $pas->inst . "" . PHP_EOL;
		echo "</fieldset>" . PHP_EOL;
		echo "<div id=d style='display:inline; margin-bottom:15px;'>" . PHP_EOL; // cover som
		if (isset($pas->im)) {
			echo "<div><img id=i src='../wp-content/plugins/medisom-extra/sm/zimg/" . $pas->im . ".png' alt='OK' ></div>";
		}
		if (isset($pas->to)) {
			echo "<div>" . $pas->to . "</div>";
		}
		echo "<div>" . PHP_EOL;                                                                        // na opdracht
		echo "<div class='ib' id=v style='padding-right:10px; font-size:10px;display:none'>vorige ></div>" . PHP_EOL;     //vorige
		// de som
		echo "<fieldset id=o style='display:inline'><legend id=okd ><h5>som</h5></legend>" . PHP_EOL;
		echo "<div class='ib'>" . $pas->tn . "</div>" . PHP_EOL;                                            // som tekst
		echo "<div class='ib'>=</div>" . PHP_EOL;                                                        // =
		if ($pas->vr == 'mk') {
			for ($i = 1; $i <= $pas->aa; $i++) {
				if (isset($pas->kb)) {
					$kb = "style='width: " . $pas->kb . "px'";
				} else {
					$kb = "";
				}    // afwijkende breedte
				echo "<div class='ib kn' " . $kb . " id=k" . '|' . $i . " onclick='pro(" . $i . ")'>";
				echo $pas->{'a' . $i} . "</div>";                                                        // een knop
			}
		} elseif ($pas->vr == 'ov') {
			$pasrs = str_getcsv($pas->rs, '|');                                                // splits antwoorden
			$antwoord = '';
			foreach ($pasrs as $ant) {
				if ($antwoord == '') {
					$antwoord = $ant;
				} else {
					$antwoord .= ' of ' . $ant;
				}
			}
			echo "<div class='ib'>";                                                                // open antwoord
			if (isset($pas->sc)) {
				$sc = $pas->sc;
			} else {
				$sc = '';
			}       														                         // sc is het in gegeven antwoord
			echo "<input type='text' class='md' id='t' onchange='pro(99)'  style='display:inline; width:100px; margin:0px; padding:3px' autofocus>" . PHP_EOL;
			echo "<script>document.getElementById('t').focus();</script>" . PHP_EOL;
			if (isset($pas->tn2)) {
				echo $pas->tn2;
				$tn2 = $pas->tn2;
			} else {
				$tn2 = '';
			}
			echo "<input class='md'	disabled type='text' id='oa' value='" . $antwoord . " " . $tn2 . "' style='background:#41fa10; display:none; width:100px; margin:0px; padding:3px' )'>" . PHP_EOL;
			echo "</div>";
			// als je een som afbreekt en verder gaat dan krijg	 je een andere som. Doordat bij moeilijke sommen te doen kun je de score beïnvloeden
			// daarom wordt een vraag meteen als onbeantwoord (=fout) geturfd. Als de vraag dan beantwoord dan wordt dat gecorrigeerd.
			$oepa->{'ov'.$id} = $oepa->{'ov'.$id} + 1;	
			$wpdb->update('m_oe', array('oepa' => json_encode($oepa)), array('oeky' => $ses->oeky), array('%s'));
			?><img src="../wp-content/plugins/medisom-extra/sm/zimg/no17.png" onload="document.getElementById('t').focus();"
				   style='display:none;'/> <?
		}
		echo "<div class='ib' style='padding: 0px 10px 0px 10px;'>";                                                    // teken
		echo "<img id=ok class='nd' src='../wp-content/plugins/medisom-extra/sm/zimg/ok17.png' alt='OK' width='17' height='17' >";
		echo "<img id=no class='nd' src='../wp-content/plugins/medisom-extra//sm/zimg/no17.png' alt='NO' width='17' height='17' >";
		echo "</div>" . PHP_EOL;                                                                                            // einde teken
		echo "</div>" . PHP_EOL;                                                                                            // de som
		echo "</div>" . PHP_EOL;
		echo "</fieldset>" . PHP_EOL;

		if (isset($pas->ku) and $oeco->kz != 't') {                                                                                            // uitleg
			$rwui = $wpdb->get_row("select * from m_sy where syid = '" . $pas->ku . "' and sytp = 'ui'");                    // het ophalen van de  korte uitleg
			echo "<fieldset><legend><h5>korte uitleg / tips</h5></legend>" . PHP_EOL;
			echo $rwui->sypa . PHP_EOL;
			echo "</fieldset>" . PHP_EOL;
		}
		// cover som
		echo "</div><!--einde -->" . PHP_EOL;
		unset($pas);
		$ses->tr_log('module >>>> in_smex.php toon extra ');
		if (isset($evq)) {
			$ev = str_getcsv($evq, ';');
			$rwts = $wpdb->get_row($wpdb->prepare("SELECT * FROM ts where sytp = 'ev' and id = '%s"));
			$tspa = json_decode($rwts->tspa);
			unset($ev[0]);
			$evq = '';
			if (isset($ev)) {
				foreach ($ev as $evp) {
					if ($evp != '') {
						$evq = $evq . ';' . $evp;
					}
				}
			}
			$come = $rwts->tx;
			if (isset($tspa->vv)) {
				if (isset($evq)) {
					$evq = $tspa->vv . ';' . $evq;
				} else {
					$evq = $tspa->vv;
				}
			}
			$_SESSION->evq = $evq;
		} else {
			unset($come);
		}
		if (isset($come)) {                                                                                                    // advies
			echo "<fieldset><legend><h5>advies</h5></legend>" . PHP_EOL;
			echo $come . PHP_EOL;
			echo "</fieldset>" . PHP_EOL;
		}
		$ver = '';
		$ct = 0;
		$at = 0;
		$gr = '';
		while (strlen($ver) > 0) {
			$ct++;
			if (substr($ver, 0, 1) == 'a') {
				$gr = $gr . "<td class=bl1></td>";
				$at++;
			} else {
				$gr = $gr . "<td class=bl2></td>";
			}
			$ver = substr($ver, 1);
		}
		if ($ct > 0) {
			echo "<fieldset><legend><h5>scores</h5></legend>" . PHP_EOL;
			echo "<table class='sm'><tr>" . PHP_EOL;
			echo "<td id='at'>" . $at . "</td><td style='padding:3px'>  goed van </td><td td id='ct'>" . $ct . "</td><td style='padding:3px'><table class='sm'><tr>" . $gr . "</tr></table></td>" . PHP_EOL;
			echo "<td style='padding:3px'>(laatste vooraan)</td></tr></table >" . PHP_EOL;
			foreach ($oett as $par => $wrd) {
				$pael = str_getcsv($par, '|');                                                        // splits par
				if ($pael[0] == 'ni') {                                                                        // tellen sterren
					$st->$wrd++;                                                                                    // per soort ster
				}
			}
			if (isset($st[1]) or isset($st[2]) or isset($st[3])) {
				if (isset($st[1]) and $st[1] != 0) {
					for ($i = 1; $i <= $st[1]; $i++) {
						echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sb 18.png'>";
					}
					echo " (" . $st[1] . " brons) " . PHP_EOL;
				}
				if (isset($st[2]) and $st[2] != 0) {
					for ($i = 1; $i <= $st[2]; $i++) {
						echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sz 18.png'>";
					}
					echo " (" . $st[2] . " zilver) " . PHP_EOL;
				}
				if (isset($st[3]) and $st[3] != 0) {
					for ($i = 1; $i <= $st[3]; $i++) {
						echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/sg 18.png'>";
					}
					echo " (" . $st[3] . " goud)" . PHP_EOL;
				}
				echo "van " . $oepa->st . " sterren" . PHP_EOL;
			}
			if (isset($st[11]) or isset($st[12]) or isset($st[13])) {
				if (isset($st[11]) and $st[11] != 0) {
					echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vb 18.png'>";
					echo " (" . $st[11] . " brons) " . PHP_EOL;
				}
				if (isset($st[12]) and $st[12] != 0) {
					echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vz 18.png'>";
					echo " (" . $st[12] . " zilver) " . PHP_EOL;
				}
				if (isset($st[13]) and $st[13] != 0) {
					echo "<img src='../wp-content/plugins/medisom-extra/sm/zimg/vg 18.png'>";
					echo " (" . $st[13] . " goud)" . PHP_EOL;
				}
			}
			echo "</fieldset>" . PHP_EOL;
		}
		echo "</div >" . PHP_EOL;
	} else {
			?><img src="../wp-content/plugins/medisom-extra/sm/zimg/ok17.png"
					 onload="document.location.href ='http://medisom.nl/ofkl/';"/> <?
	}
}
?>