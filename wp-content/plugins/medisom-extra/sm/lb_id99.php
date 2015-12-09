<?
switch ($pas->sm) {																	// reken routine
		case 'pc3':  															// gegeven perc totaal en bereken part
			$r2			= $pas->r1 * $pas->r2;										// part
			$pas->rs	= $pas->r2 * 100;
			$pas->tn	=  $r2." is ".$pas->r1."% van ";
		break;

	}