<?php
return array (
  'settings_label' => 'Paramètres',
  'publishing_settings_label' => 'Paramètres de publication',
  'default_values_label' => 'Valeurs par défaut',
  'registry_information' =>
  array (
    'label' => 'Information du registre',
    'hover_text' => 'IATI Publisher doit consigner les données de votre organisation dans le registre de l’IITA (iatiregistry.org). Pour ce faire, nous devons accéder au compte de signataire de votre organisation dans IATI Publisher. Veuillez fournir les informations d’identification de votre organisation figurant dans le registre de l’IITA.',
  ),
  'publisher_id' =>
  array (
    'label' => 'Identifiant du signataire',
    'hover_text' => 'Il s’agit de l’identifiant unique de votre organisation. Vous l’avez créé lors de la configuration de votre compte de signataire dans le registre de l’IITA. Il s’agit d’une version abrégée du nom de votre organisation, qui peut comprendre des lettres minuscules, des chiffres et les symboles - (tiret) et _ (tiret bas). Par exemple, « nef_mali » pour Near East Foundation Mali.',
    'placeholder' => 'Saisissez l’identifiant du signataire',
  ),
  'api_token' =>
  array (
    'label' => 'Jeton d’API',
    'hover_text' => 'Le jeton d’API est une clé unique générée à partir du compte de signataire de votre organisation dans le registre de l’IITA. Vous devez autoriser IATI Publisher de façon à ce qu’il puisse ajouter des données dans le registre de l’IITA en votre nom. Générez un jeton dans l’onglet « Mon compte » en <a href=\'https://www.iatiregistry.org/user/login\' target=\'_blank\' target=\'_blank\'>vous connectant</a> au registre de l’IITA.',
    'placeholder' => 'Saisissez le jeton d’API',
  ),
  'correct_label' => 'Correct',
  'incorrect_label' => 'Incorrect',
  'uc_verify' => 'VÉRIFIER',
  'uc_cancel' => 'ANNULER',
  'uc_save_publishing' => 'SAUVEGARDER LES PARAMÈTRES DE PUBLICATION',
  'default_values' =>
  array (
    'label' => 'Valeurs par défaut',
    'hover_text' => 'Ces valeurs rejoindront automatiquement vos fichiers de données.',
  ),
  'default_currency' =>
  array (
    'label' => 'Devise par défaut',
    'hover_text' => 'La devise dans laquelle vous déclarez vos transactions financières. Le cas échéant, vous pourrez modifier manuellement la devise de chaque transaction ou budget.',
    'placeholder' => 'Sélectionnez une entrée du menu déroulant',
    'help_text' => 'Si vous ne choisissez pas de devise par défaut, vous devrez sélectionner manuellement la devise de chaque transaction financière.',
  ),
  'default_language' =>
  array (
    'label' => 'Valeurs par défaut',
    'hover_text' => 'La langue dans laquelle vous fournissez des données sur vos activités. Le cas échéant, vous pourrez modifier manuellement la langue de chaque texte.',
    'placeholder' => 'Sélectionnez une langue dans le menu déroulant',
    'help_text' => 'Si vous ne choisissez pas de langue par défaut, vous devrez sélectionner manuellement la langue des exposés relatifs aux activités et à l’organisation.',
  ),
  'default_hierarchy' =>
  array (
    'label' => 'Hiérarchie par défaut',
    'hover_text' => 'Si vous signalez à la fois des programmes (activités principales) et des projets (activités secondaires), choisissez le niveau hiérarchique auquel se situent la plupart de vos activités. Par exemple, activité principale = 1 ; activité secondaire = 2.<br>Si toutes vos activités sont au même niveau, c’est-à-dire en l’absence d’activités secondaires, indiquez 1.',
    'placeholder' => 'Indiquez une hiérarchie par défaut',
    'help_text' => 'En l’absence d’indication, la valeur par défaut est 1. Si plusieurs niveaux hiérarchiques sont déclarés, les transactions financières ne doivent être déclarées qu’au niveau le plus bas afin d’éviter un double comptage.',
  ),
  'budget_not_provided' =>
  array (
    'label' => 'Budget non fourni',
    'hover_text' => 'Marquer comme « humanitaires » toutes les activités sur lesquelles votre organisation publie des données. Cela signifie que votre organisation estime que toutes ses activités répondent entièrement ou partiellement à une crise humanitaire ou à des crises multiples. Le cas échéant, vous pourrez par la suite marquer manuellement comme humanitaire chaque activité.',
    'placeholder' => 'Sélectionnez le type de budget non fourni',
    'help_text' => 'S’il n’est pas sélectionné, l’option « Oui » sera appliquée par défaut dans toutes les activités.',
  ),
  'humanitarian' =>
  array (
    'label' => 'Aide humanitaire',
    'hover_text' => 'Marquer comme « humanitaires » toutes les activités sur lesquelles votre organisation publie des données. Cela signifie que votre organisation estime que toutes ses activités répondent entièrement ou partiellement à une crise humanitaire ou à des crises multiples. Le cas échéant, vous pourrez par la suite marquer manuellement comme humanitaire chaque activité.',
    'placeholder' => 'Sélectionner un type d’aide humanitaire',
    'help_text' => 'S’il n’est pas sélectionné, l’option « Oui » sera appliquée par défaut dans toutes les activités.',
  ),
  'default_for_all_data_label' => 'Valeurs par défaut pour toutes les données',
  'default_for_activity_label' => 'Valeurs par défaut pour les données d’activité',
  'uc_save_default_values_label' => 'SAUVEGARDER LES VALEURS PAR DÉFAUT',
);
