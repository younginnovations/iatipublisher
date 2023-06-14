<?php
return array (
  'settings_label' => 'Ajustes',
  'publishing_settings_label' => 'Ajustes de publicación',
  'default_values_label' => 'Valores predeterminados',
  'registry_information' => 
  array (
    'label' => 'Información del registro',
    'hover_text' => 'Los datos de su organización deben transferirse de IATI Publisher al Registro de la IATI (iatiregistry.org). Es por ello que hemos de acceder a la cuenta de entidad que publica de su organización en el Registro de la IATI. Proporcione los datos de su organización en el Registro de la IATI.',
  ),
  'publisher_id' => 
  array (
    'label' => 'Identificador de entidad que publica',
    'hover_text' => 'Consiste en una identificación única de su organización que creó cuando configuró su cuenta de entidad que publica en el Registro de la IATI. Es una versión abreviada del nombre de su organización que incluirá letras en minúscula y puede incluir números y también guiones (-) o guiones bajos (_). Por ejemplo, nef_mali para la Near East Foundation Malí.',
    'placeholder' => 'Introduzca aquí el identificador de entidad que publica',
  ),
  'api_token' => 
  array (
    'label' => 'Token de API',
    'hover_text' => 'El token de API es una clave única que se genera a partir de la cuenta de su organización en el Registro de la IATI. Es necesario para otorgar permisos a IATI Publisher, de manera que pueda añadir datos al Registro de la IATI en su nombre. Genere un token en la pestaña de su cuenta (“My account”) <a href=\'https://www.iatiregistry.org/user/login\' target=\'_blank\' target=\'_blank\'>iniciando sesión</a> en el Registro de la IATI.',
    'placeholder' => 'Introduzca el token de API aquí',
  ),
  'correct_label' => 'Correcto',
  'incorrect_label' => 'Incorrecto',
  'uc_verify' => 'VERIFICAR',
  'uc_cancel' => 'CANCELAR',
  'uc_save_publishing' => 'GUARDAR AJUSTES DE PUBLICACIÓN',
  'default_values' => 
  array (
    'label' => 'Valores predeterminados',
    'hover_text' => 'Estos valores se añadirán de forma automática a sus archivos de datos.',
  ),
  'default_currency' => 
  array (
    'label' => 'Moneda predeterminada',
    'hover_text' => 'Moneda en que se presentan sus transacciones financieras. Posteriormente, puede cambiar manualmente la moneda para los presupuestos y las transacciones individuales, cuando corresponda.',
    'placeholder' => 'Seleccionar una opción del menú desplegable',
    'help_text' => 'Si no establece una moneda predeterminada, deberá seleccionar una moneda manualmente para todas las transacciones financieras.',
  ),
  'default_language' => 
  array (
    'label' => 'Valores predeterminados',
    'hover_text' => 'Idioma en el que facilita los datos sobre sus actividades. Posteriormente, puede cambiar manualmente el idioma en el texto concreto, cuando corresponda.',
    'placeholder' => 'Seleccione un idioma del menú desplegable',
    'help_text' => 'Si no establece su idioma predeterminado, deberá seleccionar un idioma para todas las descripciones de las actividades y la organización.',
  ),
  'default_hierarchy' => 
  array (
    'label' => 'Jerarquía predeterminada',
    'hover_text' => 'Si presenta informes tanto sobre programas (actividades principales) como sobre proyectos (actividades secundarias), seleccione el nivel jerárquico que tengan la mayoría de sus actividades, es decir, actividad principal = 1; actividad secundaria = 2.<br>En el caso de que todas sus actividades tengan el mismo nivel, es decir, que no existan actividades secundarias, seleccione “1”.',
    'placeholder' => 'Introducir la jerarquía predeterminada',
    'help_text' => 'Si no se establece una jerarquía, se asume la opción “1”. Para evitar la doble contabilización en los casos que se presente información en múltiples niveles, las transacciones financieras deberían notificarse solamente en el nivel jerárquico más inferior.',
  ),
  'budget_not_provided' => 
  array (
    'label' => 'Presupuesto no facilitado',
    'hover_text' => 'Marcar como humanitarias todas las actividades sobre las que su organización publique datos. Esto significa que su organización reconoce que todas sus actividades abordan crisis humanitarias o crisis múltiples ya sea parcial o totalmente. Posteriormente, puede marcar manualmente como humanitarias las actividades individuales, o desmarcarlas, si procediera.',
    'placeholder' => 'Seleccione la razón por la cual no se facilita el presupuesto',
    'help_text' => 'Si no se selecciona, se aplicará la opción “Sí” a todas las actividades.',
  ),
  'humanitarian' => 
  array (
    'label' => 'Atributo humanitario',
    'hover_text' => 'Marcar como humanitarias todas las actividades sobre las que su organización publique datos. Esto significa que su organización reconoce que todas sus actividades abordan crisis humanitarias o crisis múltiples ya sea parcial o totalmente. Posteriormente, puede marcar manualmente como humanitarias las actividades individuales, o desmarcarlas, si procediera.',
    'placeholder' => 'Seleccionar si es humanitario',
    'help_text' => 'Si no se selecciona, se aplicará la opción “Sí” a todas las actividades.',
  ),
  'default_for_all_data_label' => 'Valor predeterminado para todos los datos',
  'default_for_activity_label' => 'Valor predeterminado para los datos de la actividad',
  'uc_save_default_values_label' => 'GUARDAR VALORES PREDETERMINADOS',
);
