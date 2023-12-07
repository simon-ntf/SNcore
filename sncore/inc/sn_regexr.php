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

/* Verifications regex */

function sn_regex_date_spip(){
	return '#^[0-9]{2}/[0-9]{2}/[1|2]{1}[0-9]{3}$#';
}
function sn_regex_domid(){
	return '#^[a-z0-9_-]{0,32}$#';
}
function sn_regex_domclasse(){
	return '#^[a-z0-9_\-]{0,128}$#';
}
function sn_regex_domclasses(){
	return '#^[a-z0-9_\-\s]{0,256}$#';
}
function sn_regex_geoloc_lat(){
	return '#^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$#';
}
function sn_regex_geoloc_lon(){
	return '#^[-+]?(180(\.0+)?|((1[0-7]\d)|[1-9]?\d)(\.\d+)?)$#';
}
function sn_regex_liste_numids(){
	return '#^(\d+)(,\s*\d+)*$#';
}
function sn_regex_liste_numids_req(){
	return '#^[(i[0-9]{0,21}]{0,999}$#';
}
function sn_regex_liste_virgules(){
	return '#^(\d+)(,\s*\d+)*$#';
}
function sn_regex_numid_ex(){
	return '#^[\d]{1,21}$#';
}
function sn_regex_numid(){
	return '#^[1-9]{1}[\d]{0,20}$#';
}
function sn_regex_int($max=1,$min=1){
	$rgx = "#^[0-9]{" . $min . "," . $max . "}$#"; return $rgx;
}
function sn_regex_tel(){
	return '#^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$#';
}
function sn_regex_txt($max=1024,$min=1){
	$rgx = "#^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\(\)\?\!\:\.\s\#\@\-\+\=°%;,']{" . $min . "," . $max . "}$#";
	return $rgx;
}
function sn_regex_txt_brut($max=1024,$min=1,$ajout=''){
	$rgx = "#^[a-zA-Z0-9" . $ajout . "]{" . $min . "," . $max . "}$#"; return $rgx;
}
function sn_regex_txt_limite($max=1024,$min=1,$ajout=''){
	$rgx = "#^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s\-'" . $ajout . "]{" . $min . "," . $max . "}$#";
	return $rgx;
}
function sn_regex_txt_etendu($max=1024,$min=1,$ajout=''){
	$rgx = "#^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\(\)\?\!\:\.\s\@\-%;,'" . $ajout . "]{" . $min . "," . $max . "}$#";
	return $rgx;
}

/* Verifications booleens */

function sn_verif_bool_on($str){
	return ($str === '' || $str === 'on');
}
function sn_verif_bool_oui($str){
	return ($str === 'non' || $str === 'oui');
}

/* Verification multiple automatisee */

function sn_saisies_verifier($verif_config){

	$erreurs = [];

	foreach($verif_config as $ref => $v){

		if ((isset($v['obl'])) && (!_request($ref))){
			$erreurs[$ref] = _T('sncore:message_champ_obligatoire');
		}

		if(count($erreurs)==0){
			if($v['ctrl'] === 'txt'){
				$rgx_func = 'sn_regex_' . $v['rgx'];
				$rgx_txt = 'sncore:regex_' . $v['rgx'];
				$rgx_arg_max = 1024;
				$rgx_arg_min = 1;
				$rgx_arg_ajout = '';
				if(isset($v['max'])){
					$rgx_arg_max = $v['max'];
				}
				if(isset($v['min'])){
					$rgx_arg_min = $v['min'];
				}
				if(isset($v['ajout'])){
					$rgx_arg_ajout = $v['ajout'];
				}
				if (_request($ref)){
					if(!preg_match($rgx_func($rgx_arg_max,$rgx_arg_min,$rgx_arg_ajout),_request($ref))){
						if(isset($v['ajout'])){
							$erreurs[$ref] = _T($rgx_txt . '_nb_ajouts',['nb'=>$rgx_arg_max,'ajouts'=>$rgx_arg_ajout]);
						}
						else if($v['max']){
							$erreurs[$ref] = _T($rgx_txt . '_nb', ['nb'=>$rgx_arg_max]);
						}
						else{
							$erreurs[$ref] = _T($rgx_txt);
						}
					}
				}
			}
			elseif($v['ctrl'] === 'liste'){
				if(isset($fdata['saisies'][$ref]['options']['datas'])){
					$liste_ctrl = $fdata['saisies'][$ref]['options']['datas'];
					if(!isset($liste_ctrl[_request($ref)])){
						$erreurs[$ref] = 'erreur de valeur de liste...';
					}
				}
			}
			elseif($v['ctrl'] === 'on_off') {
				if(sn_verif_bool_on(_request($ref))){
					$erreurs[$ref] = _T('sncore:message_erreur_regex_incoherente');
				}
			}
			elseif($v['ctrl'] === 'oui_non') {
				if(sn_verif_bool_oui(_request($ref))){
					$erreurs[$ref] = _T('sncore:message_erreur_regex_incoherente');
				}
			}
			elseif($v['ctrl'] === 'date'){
				$rgx_func = 'sn_regex_' . $v['rgx'];
				$rgx_txt = 'sncore:regex_' . $v['rgx'];
				if(is_array(_request($ref))){
					$date_sql = sn_conv_dateheure_saisie_sql(_request($ref));
					// SN VERIF
					/*if(!preg_match($rgx_func(),$date_sql)){
						$erreurs[$ref] = _T($rgx_txt);
					}*/
					set_request($ref,$date_sql);
				}
			}
			elseif($v['ctrl'] === 'email') {
				if(!filter_var(_request($ref), FILTER_VALIDATE_EMAIL)){
					$erreurs[$ref] = _T('sncore:regex_email');
				}
			}
			elseif($v['ctrl'] === 'url_externe') {
				$lien = filter_var(_request($ref), FILTER_SANITIZE_URL);
				if(strlen(_request($ref)) > 512){
					$erreurs[$ref] = _T('sncore:regex_txt_longueur_nb',[nb=>512]);
				} elseif (!filter_var(_request($ref), FILTER_VALIDATE_URL)){
					$erreurs[$ref] = _T('sncore:regex_url');
				}
			}
			elseif($v['ctrl'] === 'rgx'){
				$rgx_func = 'sn_regex_' . $v['rgx'];
				$rgx_txt = 'sncore:regex_' . $v['rgx'];
				if (_request($ref)){
					if(!preg_match($rgx_func(),_request($ref))){
						$erreurs[$ref] = _T($rgx_txt);
					}
				}
			}
			else{
				$erreurs[$ref] = _T('sncore:message_erreur_regex_inverifiable');
			}
		}
	}

	return $erreurs;

}
