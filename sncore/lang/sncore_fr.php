<?php
// This is a SPIP langague file -- Ceci est un fichier de langue de SPIP

if (!defined('_ECRIRE_INC_VERSION')) { return; }

$GLOBALS[$GLOBALS['idx_lang']] = [
	'edit_erreur_enregistrement' => 'Erreur : un incident a eu lieu lors de l\'enregistrement en base de données.',
	'edit_lien_erreur_action' => 'Erreur : action non reconnue',
	'edit_lien_erreur_id' => 'Erreur : id non conforme',
	'edit_lien_erreur_objet' => 'Erreur : objet non reconnu',
	'edit_lien_erreur_position' => 'Erreur : paramètre de position non reconnu',
	'edit_lien_erreur_position_cible' => 'Erreur : pas d\'objet à échanger',
	'edit_lien_erreur_prioriser_cible' => 'Erreur : cible introuvable',
	'edit_lien_erreur_prioriser_limite_max' => 'Erreur : priorité déjà au max',
	'edit_lien_erreur_prioriser_limite_min' => 'Erreur : priorité déjà au min',
	'edit_lien_erreur_manquant' => 'Erreur : paramètre d\'action manquant',
	'edit_lien_erreur_source' => 'Erreur : source introuvable.',
	'erreur_acces_donnees' => 'Erreur : une requête a échoué.',
	'erreur_autorisation_refusee' => 'Autorisation refusée.',
	'erreur_auth_motdepasse' => 'L\'authentification a échoué. Veuillez saisir votre mot de passe actuel.',
	'erreur_comparaison' => 'Les données saisies ne correspondent pas.',
	'erreur_comparaison_email' => 'Les données saisies ne correspondent pas. Veuillez confirmer votre adresse email.',
	'erreur_doublon' => 'Un objet existe déjà à cette adresse.',
	'erreur_doublon_email' => 'L\'adresse proposée n\'est pas disponible.',
	'erreur_doublon_login' => 'L\'identifiant proposé n\'est pas disponible.',
	'erreur_ecriture' => 'Une erreur s\'est produite lors de l\'écriture des données. Veuillez réessayer.',
	'erreur_longueur_email' => 'L\'adresse proposée est trop longue pour être recevable.',
	'erreur_motdepasse_conformite' => 'Le mot de passe n\'est pas conforme.',
	'erreur_objet_inexistant' => 'Aucun objet ne correspond à cet identifiant.',
	'erreur_objet_inexistant_article' => 'Aucun article ne correspond à cet identifiant.',
	'erreur_objet_inexistant_auteur' => 'Aucun auteur ne correspond à cet identifiant.',
	'erreur_objet_inexistant_rubrique' => 'Aucune rubrique ne correspond à cet identifiant.',
	'erreur_technique' => 'Une erreur technique s\'est produite : @err@',
	'info_longueur_motdepasse' => 'Le mot de passe doit comprendre entre @min@ et @max@ caractères.',
	'info_positionnement' => 'Flux',
	'message_champ_obligatoire' => 'Ce champ est obligatoire.',
	'message_erreur_defaut' => 'Une erreur inconnue s\'est produite. Veuillez réessayer.',
	'message_erreur_regex_incoherente' => 'Une erreur est survenue lors de la vérification de ce champ. Veuillez entrer une saisie valide.',
	'message_erreur_regex_inverifiable' => 'Une erreur de configuration empêche la vérification de ce champ.',
	'message_login_non_modifiable' => 'Veuillez définir une adresse de connexion pour pouvoir modifier votre identifiant.',
	'message_reconnexion_necessaire' => 'Veuillez vous déconnecter et vous reconnecter pour prendre en compte ces modifications.',
	'opt_sn_position_cold' => 'Contexte (D)',
	'opt_sn_position_colg' => 'Contexte (G)',
	'opt_sn_position_corps' => 'Principal (bas)',
	'opt_sn_position_tete' => 'Contexte (haut)',
	'regex_awesome_icons_cle' => 'Veuillez entrer une clé de compte Awesom Icons valide (un compte gratuit est suffisant).',
	'regex_date_spip' => 'Veuillez entrer une date au format JJ/MM/AAAA.',
	'regex_dom_class' => 'Classe CSS (texte brut sauf - et _) (128 caractères max)',
	'regex_dom_classes' => 'Classes CSS (texte brut sauf - et _) séparées par des espaces (256 caractères max)',
	'regex_gen' => 'La valeur saisie ne correspond pas aux valeurs escomptées recevables.',
	'regex_liste_numids' => 'Listes d\'identifiants uniques (ID).',
	'regex_liste_virgules' => 'Listes de mots clef séparés par une virgule.',
	'regex_latlon' => 'Latitude et longitude séparées par une virgule.',
	'regex_lat' => 'Latitude au format GPS.',
	'regex_lon' => 'Longitude au format GPS.',
	'regex_email' => 'Adresse courriel au format adresse@fournisseur.domaine.',
	'regex_id_article' => 'Identifiant d\'article invalide.',
	'regex_id_auteur' => 'Identifiant de profil membre invalide.',
	'regex_id_objet' => 'Identifiant numérique unique d\'un objet SPIP.',
	'regex_id_rubrique' => 'Identifiant de rubrique invalide.',
	'regex_int_nb' => 'Nombre de @nb@ chiffres maximum.',
	'regex_nom_humain' => 'Veuillez entrer un nom valide (128 caractères maximum, sans ponctuation à part "-", ",", "\'" et des espaces).',
	'regex_numid' => 'Identifiant unique (ID) de l\'objet.',
	'regex_spip_id' => 'Veuillez entrer un identifiant numérique unique (ID) correspondant à l\'objet éditorial de votre choix.',
	'regex_tel' => 'Numéro de téléphone au format international.',
	'regex_txt_etendu_nb' => 'Texte limité à @nb@ caractères maximum (ponctuation limitée à ()?!:.@-%,\' et espace).',
	'regex_txt_limite_nb' => 'Texte limité à @nb@ caractères maximum (ponctuation limitée à \' - et espace).',
	'regex_txt_limite_nb_ajouts' => 'Texte limité à @nb@ caractères maximum (ponctuation limitée à @ajouts@ et espace).',
	'regex_txt_longueur_nb' => 'Trop long : ce champ est limité à @nb@ caractères.',
	'regex_txt_brut_nb_ajouts' => 'Texte brut de @nb@ caractères maximum (sans ponctuation sauf @ajouts@).',
	'regex_txt_brut_nb' => 'Texte brut de @nb@ caractères maximum.',
	'regex_txt_nb' => 'Texte de @nb@ caractères maximum (ponctuation limitée).',
	'regex_trop_long' => 'La longueur est limitée à @nb@ caractères maximum.',
	'regex_tinyint_jours' => 'Nombre de jours (255 max).',
	'regex_url' => 'Veuillez entrer une URL valide (256 caractères maximum).',
];
