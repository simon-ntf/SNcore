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

if (!defined('_ECRIRE_INC_VERSION')) { return; }

/* FONCTIONS ARRAY
*******************/

/* Renvoie la valeur correspondant a une cle dans un array. Ou une valeur par defaut. */
function sn_trouver($arr,$cle,$sinon='!') {
	if(isset($arr[$cle])){
		return $arr[$cle];
	}
	return $sinon;
}

/* Renvoie si une valeur est dans un array. Ou une valeur par defaut. */
function sn_estula($arr,$val) {
	if(in_array($val,$arr)){
		return true;
	}
	return false;
}

/* Renvoie si une valeur est dans un array. Ou une valeur par defaut. */
function sn_trouver_val($arr,$val) {
	if(sn_estula($arr,$val) === true){
		return array_search($val,$arr);
	}
	return false;
}

/* Conversion txt (termes séparés par des virgules) > array */
function sn_explose($texte) {
	return explode(',',$texte);
}

/* Conversion array > txt (termes séparés par des virgules) */
function sn_implose($tableau) {
	return implode(',',$tableau);
}

/* Conversion txt (cle,val,cle,val) > [cle=>val,cle=>val] */
function sn_conv_liste_array($str) {
	$arrb = explode(',',$str);
	$arr = [];
	$v_is_k = true;
	$nb = count($arrb); for($i=0; $i<$nb; $i++){
		if($v_is_k == true){
			$arr[$arrb[$i]] = $arrb[$i+1];
			$v_is_k = false;
		} else {
			$v_is_k = true;
		}
	}
	return $arr;
}

/* Conversion array(cle=>val,cle=>val) > txt (cle,val,cle,val) */
function sn_conv_array_liste($arr) {
	$str = ''; $i = 0;
	foreach($arr as $k=>$d){
		if($i>0){
			$str .= ',';
		} $str .= $k . ',' . $d; $i++;
	}
	return $str;
}

/* FONCTIONS TEXTE DOM HTML
*******************/

/* Ajouter un code numérique au hasard à la fin d'une chaîne de caractères (pour forcer le rafraichissement d'une image en cache par ex) */
function sn_hasardiser($str) {
	$hasardeuse = rand(0,99999);
	$retour = $str . $hasardeuse;
	return $retour;
}

/* FONCTIONS DATES
*******************/

/* Conversion date issue de saisie (via plugin saisies) > date SQL */
function sn_conv_date_saisie_sql($str_date) {
	$journee = '0000-00-00';
	$heure = '00:00:00';
	$sql_date = $journee.' '.$heure;
	if( is_string($str_date) ){
		if(affdate($str_date) == '') {
		} else {
			$journee = affdate($str_date,'Y-m-d');
		}
		$sql_date = $journee.' '.$heure;
	}
	return $sql_date;
}

/* Conversion date+heure issue de saisie (via plugin saisies) > date SQL */
function sn_conv_dateheure_saisie_sql($date_saisie) {
	$journee = '0000-00-00';
	$heure = '00:00:00';
	$sql_date = $journee.' '.$heure;
	if( isset($date_saisie['date']) ) {
		if(affdate($date_saisie['date']) == '') {
		} else {
			$journee = affdate($date_saisie['date'],'Y-m-d');
		}
		if(isset($date_saisie['heure'])){
			if(strlen($date_saisie['heure'])>0){
				$heure = $date_saisie['heure'].':00';
			}
		}
		$sql_date = $journee.' '.$heure;
	}
	return $sql_date;
}

/* FONCTIONS UTILISATEURS
*******************/
function sn_session_ip() {
	return $_SERVER['REMOTE_ADDR'];
}
