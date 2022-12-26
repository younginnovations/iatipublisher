<?php
return array (
  'override_default_values' => 
  array (
    'label' => 'Override default values',
    'text' => 'Use the following form to change the default values such as currency, language etc for this specific activity. Changing the values here will not change the default values in the setting page.',
  ),
  'currency' => 
  array (
    'label' => 'Currency',
    'placeholder' => 'Select from dropdown',
    'hover_header' => 'Default Currency',
    'hover_text' => 'The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required.',
    'help_text' => 'The currency in which you are reporting your financial transactions for this activity. Select from dropdown',
  ),
  'language' => 
  array (
    'label' => 'Language',
    'placeholder' => 'Select from dropdown',
    'hover_header' => 'Default Language',
    'hover_text' => 'The language in which you provide data on your activities. You can later manually change the language on individual text if required.',
    'help_text' => 'The language in which you are reporting this activity. Select from dropdown.',
  ),
  'hierarchy' => 
  array (
    'label' => 'Hierarchy',
    'placeholder' => 'Type default hierarchy here',
    'hover_header' => 'Default Hierarchy',
    'hover_text' => 'If you are reporting both programmes (parent activities) and projects (child activities), choose the hierarchical level that most of your activities are at. e.g. parent activity = 1; child activity = 2.<br>If all your activities are at the same level i.e. you have no child activities, then choose 1.',
    'help_text' => 'IATI allows for activities to be reported hierarchically (eg. parent - child ; programme - project - sub-project, etc). For activities at lower levels, their hierarchy can be edited as you are entering them.',
  ),
  'budget_not_provided' => 
  array (
    'label' => 'Budget not provided',
    'placeholder' => 'select budget not provided type here',
    'hover_header' => 'Budget not provided',
    'hover_text' => 'A code indicating the reason why this activity does not contain any iati-activity/budget elements. The attribute MUST only be used when no budget elements are present.',
  ),
  'humanitarian' => 
  array (
    'label' => 'Humanitarian',
    'placeholder' => 'Select Humanitarian here',
    'hover_header' => 'Humanitarian',
    'hover_text' => 'Add a \'Humanitarian Flag\' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required.',
  ),
  'cancel_label' => 'Cancel',
  'save_default_values_label' => 'Save default values',
);
