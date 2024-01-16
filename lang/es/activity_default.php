<?php
return array (
  'override_default_values' => 
  array (
    'label' => 'Modificación de los valores predeterminados',
    'text' => 'Utilice el formulario que consta a continuación para cambiar los valores predeterminados como la moneda, el idioma y otros valores de esta actividad específica. Cambiar los valores en este apartado no cambiará valores predeterminados de la página de ajustes.',
  ),
  'currency' => 
  array (
    'label' => 'Moneda',
    'placeholder' => 'Seleccionar una opción del menú desplegable',
    'hover_header' => 'Moneda predeterminada',
    'hover_text' => 'Moneda en que se presentan sus transacciones financieras. Posteriormente, puede cambiar manualmente la moneda para los presupuestos y las transacciones individuales, cuando corresponda.',
    'help_text' => 'Moneda en la que presenta las transacciones financieras de esta actividad. Seleccionar una opción del menú desplegable',
  ),
  'language' => 
  array (
    'label' => 'Idioma',
    'placeholder' => 'Seleccionar una opción del menú desplegable',
    'hover_header' => 'Idioma predeterminado',
    'hover_text' => 'Idioma en el que facilita los datos sobre sus actividades. Posteriormente, puede cambiar manualmente el idioma en el texto concreto, cuando corresponda.',
    'help_text' => 'Idioma en el que presenta esta actividad. Seleccionar una opción del menú desplegable',
  ),
  'hierarchy' => 
  array (
    'label' => 'Jerarquía',
    'placeholder' => 'Introducir la jerarquía predeterminada',
    'hover_header' => 'Jerarquía predeterminada',
    'hover_text' => 'Si presenta informes tanto sobre programas (actividades principales) como sobre proyectos (actividades secundarias), seleccione el nivel jerárquico que tengan la mayoría de sus actividades, es decir, actividad principal = 1; actividad secundaria = 2.<br>En el caso de que todas sus actividades tengan el mismo nivel, es decir, que no existan actividades secundarias, seleccione “1”.',
    'help_text' => 'La IATI permite que se presenten informes sobre actividades en orden jerárquico (es decir, principales-secundarias; programas-proyectos-subproyectos, etc.). La jerarquía de las actividades de nivel inferior puede editarse a medida que las introduce.',
  ),
  'budget_not_provided' => 
  array (
    'label' => 'Presupuesto no facilitado',
    'placeholder' => 'Seleccionar el tipo de presupuesto que no se facilita',
    'hover_header' => 'Presupuesto no facilitado',
    'hover_text' => 'Código que indica el motivo por el que esta actividad no contiene elementos relacionados con el presupuesto de actividad conforme a la IATI. El atributo DEBE utilizarse únicamente cuando no existan elementos de presupuesto.',
  ),
  'humanitarian' => 
  array (
    'label' => 'Atributo humanitario',
    'placeholder' => 'Seleccionar si es humanitario',
    'hover_header' => 'Atributo humanitario',
    'hover_text' => 'Marcar como humanitarias todas las actividades sobre las que su organización publique datos. Esto significa que su organización reconoce que todas sus actividades abordan crisis humanitarias o crisis múltiples ya sea parcial o totalmente. Posteriormente, puede marcar manualmente como humanitarias las actividades individuales, o desmarcarlas, si procediera.',
  ),
  'cancel_label' => 'Cancelar',
  'save_default_values_label' => 'Guardar los valores predeterminados',
);
