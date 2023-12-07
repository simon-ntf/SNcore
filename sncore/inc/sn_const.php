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

function sn_global_objet_editable(){
	return [ 'article','auteur','mot','rubrique', ];
}
function sn_global_objet_positionnable(){
	return [ 'article','auteur','groupemot','mot','rubrique', ];
}

function sn_global_options(){
	return [
		'A' => [

		],
		'E' => [
			'sn_position' => [ 'tete','cold','colg','corps' ],
		],
		'S' => [

		],
	];
}

/* Renvoie une liste d options ou si ref est vide toute une categorie de listes d options ou si cat est vide toutes les listes d options */
function sn_const_options_liste($cat=null,$ref=null){
	$d = sn_global_options();
	if($cat != null){
		if(isset($d[$cat])){
			if($ref != null){
				if(isset($d[$cat][$ref])){
					return $d[$cat][$ref];
				}
				return null;
			}
			return $d[$cat];
		}
		return null;
	} else {
		return $d;
	}
	return null;
}
