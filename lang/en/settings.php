<?php
return array (
  'settings_label' => 'Settings',
  'publishing_settings_label' => 'Publishing Settings',
  'default_values_label' => 'Default Values',
  'registry_information' => 
  array (
    'label' => 'Registry Information',
    'hover_text' => 'IATI Publisher needs to add your organisation\'s data to the IATI Registry (iatiregistry.org). To do this, we need to access your organisation\'s IATI Registry Publisher Account. Please provide your organisation\'s credentials from the IATI Registry.',
  ),
  'publisher_id' => 
  array (
    'label' => 'Publisher ID',
    'hover_text' => 'This is the unique ID for your organisation that you created when you set up your IATI Registry Publisher Account. It is a shortened version of your organisation\'s name, which will include lowercase letters and may include numbers and also - (dash) and _ (underscore). For example nef_mali\' for Near East Foundation Mali.',
    'placeholder' => 'Type Publisher ID here',
  ),
  'api_token' => 
  array (
    'label' => 'API Token',
    'hover_text' => 'The API token is a unique key that is generated from your organisation\'s IATI Registry Publisher Account. It is required to give IATI Publisher permission to add data to the IATI Registry on your behalf. Generate a Token in the \'My Account\' tab by <a href=\'https://www.iatiregistry.org/user/login\' target=\'_blank\' target=\'_blank\'>logging</a> into to the IATI Registry.',
    'placeholder' => 'Type API Token here',
  ),
  'correct_label' => 'Correct',
  'incorrect_label' => 'Incorrect',
  'uc_verify' => 'VERIFY',
  'uc_cancel' => 'CANCEL',
  'uc_save_publishing' => 'SAVE PUBLISHING SETTING',
  'default_values' => 
  array (
    'label' => 'Default Values',
    'hover_text' => 'These values will be automatically added to your data files.',
  ),
  'default_currency' => 
  array (
    'label' => 'Default Currency',
    'hover_text' => 'The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required.',
    'placeholder' => 'Select from dropdown',
    'help_text' => 'If you do not set your default currency, you have to choose and select currency manually for all the financial transactions.',
  ),
  'default_language' => 
  array (
    'label' => 'Default Values',
    'hover_text' => 'The language in which you provide data on your activities. You can later manually change the language on individual text if required.',
    'placeholder' => 'Select language from dropdown',
    'help_text' => 'If you do not set your default language, you have to choose and select language for all the narrative text in activity and organisation.',
  ),
  'default_hierarchy' => 
  array (
    'label' => 'Default Hierarchy',
    'hover_text' => 'If you are reporting both programmes (parent activities) and projects (child activities), choose the hierarchical level that most of your activities are at. e.g. parent activity = 1; child activity = 2.<br>If all your activities are at the same level i.e. you have no child activities, then choose 1.',
    'placeholder' => 'Type default hierarchy here',
    'help_text' => 'If hierarchy is not reported then 1 is assumed. If multiple levels are reported then, to avoid double counting, financial transactions should only be reported at the lowest hierarchical level.',
  ),
  'budget_not_provided' => 
  array (
    'label' => 'Budget Not Provided',
    'hover_text' => 'Add a \'Humanitarian Flag\' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required.',
    'placeholder' => 'Select budget not provided type here',
    'help_text' => 'If not selected, it will be set to \'Yes\' in all the activities.',
  ),
  'humanitarian' => 
  array (
    'label' => 'Humanitarian',
    'hover_text' => 'Add a \'Humanitarian Flag\' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required.',
    'placeholder' => 'Select Humanitarian here',
    'help_text' => 'If not selected, it will be set to \'Yes\' in all the activities.',
  ),
  'default_for_all_data_label' => 'Default for all data',
  'default_for_activity_label' => 'Default for activity data',
  'uc_save_default_values_label' => 'SAVE DEFAULT VAlUES',
);
