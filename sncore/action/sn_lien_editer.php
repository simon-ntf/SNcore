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

// Si un bouton d'edition de lien SN est activé : lance l'édition de lien avec en paramètre la commande passée
if(_request('sn_lien_editer') !== null){
	$commande_txt = array_search('sn_lien_editer', _request('sn_lien_editer'));
	$res = null;
	$retour = '';
	if(is_string($commande_txt)){
		$res = sn_lien_editer($commande_txt);
		if($res[0] === true){
			// Si besoin d'afficher un message ok activer cette ligne
			// $retour = '<div class="reponse_formulaire reponse_formulaire_ok"><p>Ok</p></div>';
		} else{
			$retour = '<div class="reponse_formulaire reponse_formulaire_erreur">';
			foreach($res[1] as $c => $e){
				$retour .= '<p>' . $e  . '</p>';
			}
			$retour .= '</div>';
		}
		echo $retour;
	}
	return null;
}

// Décoder la commande d'action et lancer l'action
function sn_lien_editer($commande_txt){
	include_spip('inc/sn_regexr');
	$erreurs = [];
	$objet_cible = '';
	$id_cible = '';
	$objet = '';
	$id_objet = '';
	$sn_liens_actions = [ 'prioriser','deprioriser','positionner' ];
	include_spip('inc/sn_const');
	$sn_liens_objets = sn_global_objet_positionnable();
	$liste_positions = sn_const_options_trads('sn_position','E','sncore');
	$commande = explode("-", $commande_txt);
	if(!is_array($commande)){
		$erreurs[] = _T('sncore:edit_lien_erreur_commande');
	} else {
		if(isset($commande[0])){
			if(!in_array($commande[0],$sn_liens_objets)){
				$erreurs[] = _T('sncore:edit_lien_erreur_objet') . ' : '. $commande[0];
			}
		} else {
			$erreurs[] = _T('sncore:edit_lien_erreur_manquant');
		}
		if(isset($commande[1])){
			if (!preg_match(sn_regex_numid(),$commande[1])){
				$erreurs[] = _T('sncore:edit_lien_erreur_id');
			}
		} else {
			$erreurs[] = _T('sncore:edit_lien_erreur_manquant');
		}
		if(isset($commande[2])){
			if(!in_array($commande[2],$sn_liens_objets)){
				$erreurs[] = _T('sncore:edit_lien_erreur_objet') . ' : '. $commande[2];
			}
		} else {
			$erreurs[] = _T('sncore:edit_lien_erreur_manquant');
		}
		if(isset($commande[3])){
			if (!preg_match(sn_regex_numid(),$commande[3])){
				$erreurs[] = _T('sncore:edit_lien_erreur_id');
			}
		} else {
			$erreurs[] = _T('sncore:edit_lien_erreur_manquant');
		}
		if(isset($commande[4])){
			if(!in_array($commande[4],$sn_liens_actions)){
				$erreurs[] = _T('sncore:edit_lien_erreur_action');
			}
		} else {
			$erreurs[] = _T('sncore:edit_lien_erreur_manquant');
		}
		if(isset($commande[5])){
			if(!isset($liste_positions[$commande[5]])){
				$erreurs[] = _T('sncore:edit_lien_erreur_position').' : '.$commande[5];
			}
		}
	}
	if(count($erreurs) === 0){
		$objet_cible = $commande[0];
		$id_cible = $commande[1];
		$objet = $commande[2];
		$id_objet = $commande[3];
		$action = $commande[4];
		$position = '';
		if($action === 'positionner'){
			$position = $commande[5];
		}
		if($action === 'prioriser'){
			$erreurs = sn_lien_editer_prioriser($objet_cible,$id_cible,$objet,$id_objet);
		} elseif($action === 'deprioriser'){
			$erreurs = sn_lien_editer_prioriser($objet_cible,$id_cible,$objet,$id_objet,true);
		} elseif($action === 'positionner'){
			$erreurs = sn_lien_editer_positionner($objet_cible,$id_cible,$objet,$id_objet,$position);
		}
		return [ true, $erreurs ];
	}
	return [ false, $erreurs ];
}

// Action de faire monter ou descendre (si $inverse = vrai) l'ordre de priorité
function sn_lien_editer_prioriser($objet_source,$id_objet_source,$objet,$id_objet,$inverse=false) {

	$erreurs = [];
	$lien_cible_data = null;
	$lien_cible2_data = null;
	$liens_datas = [];
	$table_source_liens = 'spip_'.$objet_source.'s_liens';
	$nom_public_objet_source = _T($objet_source.':'.$objet_source);
	$id_objet_source = intval($id_objet_source);
	$id_objet = intval($id_objet);
	$req_liens = sql_select('*',$table_source_liens,'objet='.sql_quote($objet).' AND id_objet='.sql_quote($id_objet));
	
	// Reclasse par ordre de priorite et identifie l'objet source
	$iter = 0;
	while($res_liens = sql_fetch($req_liens)){
		$liens_datas[$res_liens['sn_priorite']] = $res_liens;
		if(intval($res_liens['id_'.$objet_source]) === $id_objet_source){ $lien_cible_data = $res_liens; }
		$iter++;
	}

	if($lien_cible_data == null){
		$erreurs[] = _T('sncore:edit_lien_erreur_source');

	} else{
		$pos_source = intval($lien_cible_data['sn_priorite']);

		// Dé-prioriser
		if($inverse === true){
			$pos_cible = $pos_source + 1;
			if($pos_cible >= count($liens_datas)){
				// ne rien faire
				$erreurs[] = _T('sncore:edit_lien_erreur_prioriser_limite_min');
			}
		}
		// Prioriser
		else{
			$pos_cible = $pos_source - 1;
			if($pos_cible < 0){
				// ne rien faire
				$erreurs[] = _T('sncore:edit_lien_erreur_prioriser_limite_max');
			}
		}

		if(count($erreurs) === 0){
			if( isset($liens_datas[ $pos_cible ]) ){
				$lien_cible2_data = $liens_datas[ $pos_cible ];
			} else {
				$erreurs[] = _T('sncore:edit_lien_erreur_priorite_cible');
			}
		}
	}

	if(count($erreurs) === 0){
		$where = 'id_'.$objet_source.' = '.sql_quote($lien_cible_data['id_'.$objet_source]).' AND objet='.sql_quote($objet).' AND id_objet = '.sql_quote($id_objet);
		$where2 = 'id_'.$objet_source.' = '.sql_quote($lien_cible2_data['id_'.$objet_source]).' AND objet='.sql_quote($objet).' AND id_objet = '.sql_quote($id_objet);
		$req_p1 = sql_updateq($table_source_liens, ['sn_priorite' => $pos_cible], $where);
		$req_p2 = sql_updateq($table_source_liens, ['sn_priorite' => $pos_source], $where2);
		if(($req_p1 === true)&&($req_p2 === true)){
			return [ true, [$req_p1,$req_p2]];
		} else {
			$erreurs[] = _T('sncore:edit_erreur_enregistrement');
		}
	}
	
	return [ false, $erreurs ];
	
}

// Action d'attribuer ou désattribuer (si elle était attribuée) une valeur de position à un objet lié
function sn_lien_editer_positionner($objet_source,$id_objet_source,$objet,$id_objet,$position) {
	$erreurs = [];
	$lien_data;
	$explosion;
	$attr_position;
	$lien_modif;
	$suppression = false;
	$positions_avant = [];
	$positions_apres = [];
	$liste_positions = sn_const_options_trads('sn_position','E','sncore');
	$table_source_liens = 'spip_'.$objet_source.'s_liens';
	$where = 'objet='.sql_quote($objet).' AND id_objet='.sql_quote($id_objet).' AND id_' . $objet_source . '='.sql_quote($id_objet_source);
	$lien_data = sql_fetsel('*', $table_source_liens, $where);
	if($lien_data == null){
		$erreurs[] = _T('sncore:edit_lien_erreur_source');
	} else {
		$positions_avant = explode(',', stripslashes(trim($lien_data['sn_position'])));
		foreach($positions_avant as $k => $p){
			if(isset($liste_positions[$p])){
				if($p == $position){
					$suppression = true;
				} else {
					$positions_apres[] = $p;
				}
			}
		}
		if($suppression == true){

		} else {
			$positions_apres[] = $position;
		}
		$attr_position = implode(',',$positions_apres);

		$lien_modif = sql_updateq($table_source_liens, ['sn_position' => $attr_position], $where);
		if(!is_array($lien_modif)){
			$erreurs[] = _T('sncore:erreur_ecriture');
		}
		return [ true, $lien_modif];
	}
	return [ false, $erreurs ];
}
