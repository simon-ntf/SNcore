<?php
/***************************************************************************\
 *  SN Suite, suite de plugins pour SPIP                                   *
 *  Copyright © depuis 2014                                                *
 *  Simon N                                                            *
 *                                                                         *
 *  Ce programme est un logiciel libre distribué sous licence GNU/GPL.     *
 *  Pour plus de détails voir l'aide en ligne.                             *
 *  https://www.snsuite.net                                                *
\**************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function sn_si_echeance_passee_heures($date,$heures=0){
	$echeance = sn_echeance_heures($date,$heures);
	if($echeance < time()){
		return true;
	}
	return false;
}
function sn_echeance_heures($date,$heures=0){
	return strtotime($date) + (60*60*$heures);
}
function sn_si_echeance_passee_jours($date,$jours=0){
	$echeance = sn_echeance_jours($date,$jours);
	if($echeance < time()){
		return true;
	}
	return false;
}
function sn_echeance_jours($date,$jours=0){
	return strtotime($date) + (60*60*24*$jours);
}
