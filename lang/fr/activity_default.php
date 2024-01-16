<?php
return array (
  'override_default_values' =>
  array (
    'label' => 'Modifier les valeurs par défaut',
    'text' => 'Utilisez le formulaire suivant pour modifier les valeurs par défaut telles que la devise, la langue, etc. pour l’activité en question. Cette modification ne se répercute pas sur les valeurs par défaut de la page des paramètres.',
  ),
  'currency' =>
  array (
    'label' => 'Devise',
    'placeholder' => 'Sélectionnez une entrée du menu déroulant',
    'hover_header' => 'Devise par défaut',
    'hover_text' => 'La devise dans laquelle vous déclarez vos transactions financières. Le cas échéant, vous pourrez modifier manuellement la devise de chaque transaction ou budget.',
    'help_text' => 'La devise dans laquelle vous déclarez vos transactions financières pour cette activité. Sélectionnez une entrée du menu déroulant',
  ),
  'language' =>
  array (
    'label' => 'Langue',
    'placeholder' => 'Sélectionnez une entrée du menu déroulant',
    'hover_header' => 'Langue par défaut',
    'hover_text' => 'La langue dans laquelle vous fournissez des données sur vos activités. Le cas échéant, vous pourrez modifier manuellement la langue de chaque texte.',
    'help_text' => 'La langue dans laquelle vous rendez compte de cette activité. Sélectionnez une entrée du menu déroulant.',
  ),
  'hierarchy' =>
  array (
    'label' => 'Hiérarchie',
    'placeholder' => 'Indiquez une hiérarchie par défaut',
    'hover_header' => 'Hiérarchie par défaut',
    'hover_text' => 'Si vous signalez à la fois des programmes (activités principales) et des projets (activités secondaires), choisissez le niveau hiérarchique auquel se situent la plupart de vos activités. Par exemple, activité principale = 1 ; activité secondaire = 2.<br>Si toutes vos activités sont au même niveau, c’est-à-dire en l’absence d’activités secondaires, indiquez 1.',
    'help_text' => 'L’IITA permet de rendre compte des activités de manière hiérarchique (principales-secondaires ; programmes-projets-sous-projets, etc.). Vous pouvez modifier la hiérarchie des activités de niveau inférieur lors de la saisie.',
  ),
  'budget_not_provided' =>
  array (
    'label' => 'Budget non fourni',
    'placeholder' => 'sélectionnez le type de budget non fourni',
    'hover_header' => 'Budget non fourni',
    'hover_text' => 'Code indiquant pourquoi cette activité ne contient aucun élément sur les activités/budgets de l’IITA. L’attribut DOIT être utilisé uniquement lorsqu’aucun élément de budget n’est présent.',
  ),
  'humanitarian' =>
  array (
    'label' => 'Aide humanitaire',
    'placeholder' => 'Sélectionner un type d’aide humanitaire',
    'hover_header' => 'Aide humanitaire',
    'hover_text' => 'Marquer comme « humanitaires » toutes les activités sur lesquelles votre organisation publie des données. Cela signifie que votre organisation estime que toutes ses activités répondent entièrement ou partiellement à une crise humanitaire ou à des crises multiples. Le cas échéant, vous pourrez par la suite marquer manuellement comme humanitaire chaque activité.',
  ),
  'cancel_label' => 'Annuler',
  'save_default_values_label' => 'Sauvegarder les valeurs par défaut',
);
