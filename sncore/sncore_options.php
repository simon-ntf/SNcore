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

/* Renvoie une liste de cles valeurs (traduites) d options de liste
*  - si la trad est conforme dans un fichier de langue spip au nom du plugin et sous la forme "opt_ref_item"
*  - si la liste d options est presente dans la fonction sn_const_OPTIONS du fichier inc/sn_const
*
* @param string $ref Libelle reference de la liste d options
* @param string $cat Libelle categorie de la liste d options : A (auteur) | E (edition) | S (structure)
* @param string $plugin Libelle du plugin si la trad est dans un plugin | laisser vide si hors plugin
*
* ATTENTION cette fonctions DOIT rester dans un fichier d options
*/
function sn_const_options_trads($ref,$cat,$plugin=null){
	include_spip('inc/sn_const');
	$liste_trads = null;
	$pre = 'opt_';
	if($plugin != null){
		$pre = $plugin . ':opt_';
	}
	$liste_options = sn_const_options_liste($cat,$ref);
	if(is_array($liste_options)){
		$liste_trads = [];
	    foreach($liste_options as $cle => $valeur){
	        $liste_trads[$valeur] = _T($pre . $ref . '_' . $valeur);
	    }
	}
	return $liste_trads;
}

/**
 * Cree une chaine de caracteres alphanumeriques aleatoire
 *
 * @param int $nb_car Nombre de caracteres de la chaine attendue
 * @param int $poids_num Multiplicateur de poids des numeriques dans l'aleatoire
 * @param string $numer Chaine de caracteres représentant les numeriques
 * @param string $numer Chaine de caracteres représentant les alphabetiques
 * @return string Chaine aleatoire

 * ATTENTION cette fonction DOIT rester dans un fichier d'options
 * ATTENTION fonction utilisee lors de la maj du plugin SN Abonnements
 * tester obligatoirement l'install ok en cas de modification
*/
function sn_crea_alphanum_str($nb_car,$poids_num=1,$numer='0123456789',$alpha='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz') {
    $str = '';
    $str_source = $numer;
    for($i=1;$i<$poids_num;$i++){
    	$str_source .= $numer;
    }
    $str_source .= $alpha;
    $str = substr(str_shuffle($str_source), 0, $nb_car);
    return $str;
}
