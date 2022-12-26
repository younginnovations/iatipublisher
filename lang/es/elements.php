<?php
return array (
  'activities' =>
  array (
    'activity_identifier' =>
    array (
      'help_text' => 'Introduzca una secuencia única de letras o números, o ambas, para identificar su actividad. Por ejemplo, “PROJECT-00120467” o “AFG-COVAX”.</br></br>Debe asegurarse de que:</br></br>cada identificador de la IATI que usted publique sea único;</br></br>ningún identificador comience o finalice con un espacio en blanco;</br></br>solo se utilicen números, letras y guiones para crear sus identificadores;</br></br>una vez que haya publicado una actividad no se cambie su identificador de la IATI. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>Orientación adicional aquí</a>.',
      'shorter_help_text' => 'Introduzca su propio identificador único de actividad; por ejemplo, una abreviatura o simplemente un número. Asegúrese de que todas las actividades tienen un identificador único. IATI Publisher enlazará el identificador de la organización y el identificador de la actividad para generar automáticamente un identificador de la IATI.',
    ),
    'iati_identifier' =>
    array (
      'hover_text' => 'Identificador único de la actividad a nivel mundial.</br></br>DEBE llevar como prefijo YA SEA el identificador actual de la organización notificadora de la IATI (organización-notificadora/@ref) O un identificador anterior comunicado en otro identificador, y como sufijo el identificador de actividad de la propia organización. El prefijo y el sufijo deben estar separados por un guion “-”.</br></br>Una vez que la actividad se haya notificado a la IATI, el identificador NO DEBERÁ modificarse en fechas posteriores. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/iati-identifier/\'>Más información aquí</a>.',
      'help_text' => 'Se genera automáticamente añadiendo su identificador de actividad a la parte final del identificador de su organización (el identificador único que se generó para su organización cuando se registró). <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>Más orientación al respecto aquí</a>.</br></br>Una vez que la actividad se haya notificado a la IATI, el identificador NO DEBERÁ modificarse en fechas posteriores. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/iati-identifier/\'>Más información aquí</a>.',
    ),
    'reporting_org' =>
    array (
      'hover_text' => 'Este es su identificador de organización de la IATI (identificador único que se generó para su organización cuando se registró). <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/registering-and-managing-your-organisation-account/how-to-create-your-iati-organisation-identifier/\'>Más información aquí</a>.',
      'help_text' => 'Organización que presenta el informe. Puede ser la fuente principal (que informa sobre sus propias actividades como donante, organismo de ejecución, etc.) o una fuente secundaria (que informa sobre las actividades de otra organización).</br></br>Especificar el atributo @ref es obligatorio. Puede incluir el nombre de la organización como contenido. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
      'narrative' =>
      array (
        'help_text' => 'Es el nombre que facilitó para su organización cuando completó el registro.',
        'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/narrative/\'>Más información aquí</a>.',
      ),
      'type' =>
      array (
        'hover_text' => 'Tipo de organización que emite el informe. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org',
      ),
    ),
    'title' =>
    array (
      'hover_text' => 'Título conciso, legible para los seres humanos, que contiene un resumen representativo de la actividad. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/\'>Más información aquí</a>.',
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Indique el título de esta actividad. Por ejemplo: “Agua en beneficio de las mujeres de Malawi”.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'description' =>
    array (
      'hover_text' => 'Descripción más amplia, legible para los seres humanos, en la que se explica lo más representativo de la actividad. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/description/\'>Más información aquí</a>.',
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/description/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Facilite una descripción de su actividad. Por ejemplo: “Este proyecto mejorará los comportamientos que favorecen la salud materna e infantil de 800 mujeres embarazadas y 6.500 cuidadoras y cuidadores de niños y niñas menores de cinco años en [ubicación], lo que contribuirá a reducir las elevadas tasas de mortalidad y morbilidad materna y de los niños menores de cinco años en esas comunidades”.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/description/narrative/\'>Más información aquí</a>.',
      ),
      'type' =>
      array (
        'hover_text' => 'Tipos de descripción de las actividades (general, objetivos, etc.). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/descriptiontype/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo de descripción que mejor describa su actividad.</br></br>1. <b>General: </b>descripción amplia y no estructurada de la actividad.<br><br>2. <b>Objetivos: </b>objetivos específicos de la actividad, extraídos —por ejemplo— de un marco lógico.<br><br> 3. <b>Grupos objetivo: </b>detalle de los grupos que se prevé beneficiar con la actividad.<br><br>4. <b>Otra: </b>para usos diversos. La descripción también puede incluir una clasificación o desglose aún mayor</li>',
      ),
    ),
    'participating_org' =>
    array (
      'hover_text' => 'Especifique qué organizaciones participan en la actividad y qué roles individuales desempeñan. Por ejemplo, puede ser un donante, financiador, organismo de ejecución, entre otros.',
      'help_text' => 'Organización que participa en la actividad. Puede ser un donante, financiador, organismo de ejecución, entre otros. Se recomienda indicar el identificador @ref. Puede contener el nombre de la organización como descripción.</br><br>Si la organización notificadora desempeña un rol en la actividad, debe repetirse en este apartado. Una organización puede desempeñar más de un rol (por ejemplo, financiación y ejecución), en cuyo caso deberá informarse de cada rol y deberá repetirse el nombre de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>Más información aquí</a>.',
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Indique el nombre de la organización participante.',
      ),
      'organisation_role' =>
      array (
        'hover_text' => 'Código de la IATI que describe el rol de la organización en la actividad (donante, organismo, etc.). <br></br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione una opción que describa el rol de la organización en la actividad (financiador, organismo de ejecución, etc.):<br></br>1. <b>Financiación:</b> gobierno u organización que aporta los fondos para la actividad.</br><br>2. <b>Responsable:</b> organización encargada de supervisar la actividad y sus resultados.</br><br>3. <b>Encargado de la ampliación:</b> organización que gestiona el presupuesto y la dirección de una actividad en nombre de la organización financiadora.</br><br>4. <b>Ejecución:</b> organización que ejecuta físicamente la actividad o la intervención.</br>',
      ),
      'reference' =>
      array (
        'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. Debe tener el formato {agencia de registro}-{número de registro}. <br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
        'help_text' => 'Indique el identificador de la organización participante de la IATI. La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional.</a>',
      ),
      'type' =>
      array (
        'hover_text' => 'Tipo de organización que presenta el informe. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo que mejor corresponda a la organización participante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organizaciones aquí</a>.',
      ),
      'activity_id' =>
      array (
        'hover_text' => 'Identificador válido de la actividad publicado por la organización participante que hace referencia a la actividad que ha publicado en la IATI y que describe su rol en esta actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>Más información aquí</a>.',
        'help_text' => 'Si la organización participante ha publicado una actividad en la IATI con respecto a esta actividad, indique el identificador para su actividad. Puede consultárselo a la organización participante o buscar la actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.',
      ),
      'crs_channel_code' =>
      array (
        'hover_text' => 'De conformidad con las directivas de presentación de informes CRS++, el código hace referencia al organismo de ejecución. Los códigos que terminan en “00” son genéricos y similares al código de tipo de organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>Más información aquí</a>.',
      ),
    ),
    'other_identifier' =>
    array (
      'hover_text' => 'Otro identificador de la actividad. Puede ser el propio identificador de la entidad que publica y que desea registrar la actividad. Este elemento también se utiliza para hacer seguimiento de los cambios en los identificadores de las actividades, por ejemplo, cuando una organización ha cambiado su identificador de organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>Más información aquí</a> .',
      'reference' =>
      array (
        'hover_text' => 'Identificador que desea proporcionar. Puede utilizarse para comunicar una serie de tipos de identificadores distintos. En la lista de códigos de otros tipos de identificadores podrá ver más detalles y opciones. </br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>Más información aquí</a>.',
        'help_text' => 'Indique el identificador relacionado con esta actividad.',
      ),
      'ref_type' =>
      array (
        'hover_text' => 'Tipo de identificador que se comunica, extraído de la lista de códigos de otros tipos de identificadores. </br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>Más información aquí</a>.',
        'help_text' => 'Si desea registrar otro identificador relacionado con esta actividad, <b>debe</b> seleccionar el tipo de identificador que va a introducir. Las descripciones de todos los tipos posibles figuran en la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/otheridentifiertype/\'>lista de códigos de otros tipos de identificadores.</a>',
      ),
      'owner_org' =>
      array (
        'hover_text' => 'Organización titular del otro identificador que se comunica, en su caso. Cuando se utilice, alguna de las siguientes opciones DEBE estar presente: otro-identificador/organización-propietaria/@ref u otro-identificador/organización-propietaria/descripción/texto(). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/owner-org/\'>Más información aquí</a>.',
        'help_text' => 'Indique el identificador de organización del propietario del otro identificador de la actividad. Si su organización no es la propietaria, puede buscar otras organizaciones en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI.</a> En caso de que no pueda encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/owner-org/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Facilite una descripción del otro identificador de la actividad.',
      ),
    ),
    'activity_status' =>
    array (
      'help_text' => 'Debe indicarse un estado de actividad, en el que se describa el momento del ciclo de vida de la actividad desde su preparación hasta su finalización. Es posible publicar actividades que ya se han completado, se están desarrollando o todavía no han comenzado. A medida que la actividad avanza con el tiempo, debe actualizarse su estado.',
      'hover_text' => 'Estado actual de la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-status/\'>Más información aquí</a>.',
      'code' =>
      array (
        'hover_text' => 'Código de la IATI que establece el estado actual de la actividad.<br></br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-status/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione una opción que defina el estado actual de su actividad.<br></br>1.<b> Fase inicial/identificación</b>: se está planificando la actividad o se está delimitando su alcance.<br></br>2.<b> Ejecución</b>: la actividad está actualmente en proceso de ejecución.<br></br>3.<b> Finalización</b>: se ha completado la actividad física o se ha realizado el desembolso final, pero la actividad sigue abierta pendiente de aprobación financiera o seguimiento y evaluación.<br></br>4.<b> Cerrada</b>: se ha completado la actividad física o se ha realizado el desembolso final.<br></br>5.<b> Cancelada</b>: la actividad se ha cancelado.</br><br>6.<b> Suspendida</b>: la actividad se ha suspendido temporalmente.</li>',
      ),
      'activity_date' =>
      array (
        'hover_text' => 'Fechas de inicio y finalización reales y previstas de la actividad. Las fechas de inicio pueden recoger la puesta en marcha de la financiación, la planificación o la actividad física. En la medida de lo posible, las fechas de finalización recogen la conclusión de la actividad física. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-dates-status/\'>Más información aquí</a>.',
        'type' =>
        array (
          'hover_text' => 'Código de la IATI que establece el tipo de fecha de actividad que se comunica.<br></br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/activitydatetype/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo de fecha de actividad que va a comunicar.<br></br>1. <b>Inicio previsto</b>: fecha en la que se prevé que la actividad se ponga en marcha, por ejemplo, la fecha del primer desembolso previsto o en que se inicia la actividad física.<br></br>2. <b>Inicio real</b>: fecha real de inicio de la actividad, por ejemplo, la fecha del primer desembolso o en la que se pone en marcha la actividad física.<br></br>3. <b>Finalización prevista</b>: fecha en que se prevé finalizar la actividad, por ejemplo, la fecha prevista para el último desembolso o para completar la actividad física.<br></br>4. <b>Finalización real</b>: fecha real en la que finaliza la actividad, por ejemplo, la fecha del último desembolso o en que la actividad física se completa.',
        ),
      ),
      'date' =>
      array (
        'hover_text' => 'Este atributo es necesario.</br>El valor debe ser del tipo xsd:date.</br>1: La fecha de inicio prevista de la actividad debe ser anterior a la fecha de finalización prevista.</br>2: La fecha de inicio real de la actividad debe ser anterior la fecha de finalización real.</br>3: La fecha de inicio real de la actividad no debe ser una fecha futura.</br>4: La fecha de finalización real de la actividad no debe ser una fecha futura. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/\'>Más información aquí</a>.',
        'help_text' => 'Indicar la fecha de su actividad.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Aportar cualquier información complementaria o explicación para la situación de actividad seleccionada.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'contact_info' =>
    array (
      'hover_text' => 'Información de contacto para la actividad. Indique la información disponible. Puede introducir varias personas de contacto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/\'>Más información aquí</a>.',
      'type' =>
      array (
        'hover_text' => 'Tipo de contacto. En la lista de códigos de la IATI podrá encontrar los valores. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/contacttype/\'>Más información aquí</a>.',
        'organisation' =>
        array (
          'hover_text' => 'Nombre de la organización con la que ponerse en contacto para obtener información adicional sobre la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/narrative/\'>Más información aquí</a>.',
            'help_text' => 'Indique el nombre de la organización con la que ponerse en contacto para obtener información adicional sobre la actividad.',
          ),
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/narrative/\'>Más información aquí</a>.',
          ),
        ),
        'department' =>
        array (
          'hover_text' => 'Departamento de la organización con el que ponerse en contacto para obtener información adicional sobre la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/department/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'help_text' => 'Indique el nombre del departamento de la organización con el que ponerse en contacto para obtener información adicional sobre la actividad.',
          ),
        ),
        'person_name' =>
        array (
          'hover_text' => 'Nombre de la persona de contacto de la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/person-name/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'help_text' => 'Indique el nombre de la persona de contacto para obtener información adicional sobre la actividad.',
          ),
        ),
        'job_title' =>
        array (
          'hover_text' => 'Denominación del cargo de la persona de contacto en la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/job-title/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'help_text' => 'Indique la denominación del cargo de la persona de contacto en la organización.',
          ),
        ),
        'telephone' =>
        array (
          'hover_text' => 'Número de teléfono de contacto. Puede introducir varios números. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/telephone/\'>Más información aquí</a>.',
        ),
        'email' =>
        array (
          'hover_text' => 'Correo electrónico de contacto. Pueden introducirse varias direcciones de correo electrónico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/email/\'>Más información aquí</a>.',
        ),
        'website' =>
        array (
          'hover_text' => 'Dirección web de contacto. Pueden introducirse varios sitios web. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/website/\'>Más información aquí</a>.',
        ),
        'mailing_address' =>
        array (
          'hover_text' => 'Dirección postal de contacto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/narrative/\'>Más información aquí</a>.',
            'help_text' => 'Facilite cualquier información adicional sobre este contacto.',
          ),
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/narrative/\'>Más información aquí</a>.',
          ),
        ),
      ),
    ),
    'activity_scope' =>
    array (
      'hover_text' => 'Ámbito geográfico de la actividad: regional, nacional, subnacional, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-scope/\'>Más información aquí</a>.',
      'activity_code' =>
      array (
        'hover_text' => 'Ámbito geográfico. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/activityscope/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione la opción que mejor describa el alcance de esta actividad.<br><br>1. <b>Mundial:</b> la actividad tiene un alcance mundial. Por ejemplo, algunas actividades, como la investigación, no se basan en un país o región concretos, ni buscan beneficiar a un lugar concreto.<br><br>2. <b>Regional:</b> la actividad se enmarca en una región supranacional.<br><br>3. <b>Plurinacional:</b> la actividad engloba varios países que no constituyen una región.<br><br>4. <b>Nacional:</b> el alcance de la actividad es un solo país.<br><br>5.<b>Subnacional (varias demarcaciones administrativas de primer nivel)</b>. La actividad engloba más de una demarcación administrativa subnacional de primer nivel (p. ej., países, provincias, estados).<br><br>6. <b>Subnacional (una sola demarcación administrativa de primer nivel):</b> La actividad se enmarca en una sola demarcación administrativa subnacional de primer nivel.<br><br>7. <b>Subnacional (una sola demarcación administrativa de segundo nivel):</b> La actividad se centra en una sola demarcación administrativa subnacional de segundo nivel (por ejemplo, un municipio o un distrito).<br><br>8. <b>Ubicación única:</b> la actividad se centra en una ubicación única (localidad, población, explotación agrícola). <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Orientación adicional aquí</a>.',
      ),
    ),
    'recipient_country' =>
    array (
      'help_text' => 'En todas las actividades de la IATI se debe especificar el país (por ejemplo, China) en que la actividad se desarrolla o los lugares que se verán beneficiados con la actividad. Si no se conoce el país, se debe especificar la región o regiones supranacionales (por ejemplo, Asia Oriental).<br></br> La información sobre los países o regiones que se beneficiarán con esta actividad puede publicar de distintas maneras.<br></br>Si la región o el país que se beneficia con la actividad es solo uno, debe simplemente seleccionarlo. Esto significa que el 100% de la financiación que publica para esta actividad beneficiará solamente a un país o una región.<br></br>No obstante, en caso de que sean varios los países o las regiones que se van a beneficiar con la actividad, puede:<br></br><b>1.</b> Publicar el país o la región receptores de cada transacción individual de la que informa en relación con esta actividad. Deberá, como mínimo, publicar datos sobre una transacción en cada actividad (publicar datos sobre transacciones). Cada transacción representa dinero que entra o sale de la actividad. Puede seleccionar un país o región diferentes para cada transacción que publica.<br></br>Si desea indicar el país o la región receptores de sus transacciones individuales, no deberá seleccionar un país o una región para la totalidad de la actividad más abajo.<br></br><b>2.</b> Puede seleccionar varios países o regiones para la totalidad de la actividad más abajo. Si opta por esta última opción, es necesario que asigne un porcentaje de financiación de la actividad para cada país o región.<br></br><b>3.</b> Puede elegir crear una actividad separada para cada país que se beneficia con la financiación de esta actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Orientación adicional aquí</a>.',
      'hover_text' => 'País que se beneficiará con la actividad. Si no se conoce el país concreto, debe utilizarse un elemento de región receptora en su lugar. Para la ubicación geográfica, utilice el elemento de ubicación.<br></br>Se pueden comunicar varios países o regiones, en cuyo caso SE DEBE utilizar el atributo de porcentaje para especificar la proporción del compromiso total en todos los países y las regiones sobre las que se informa.<br></br>El país puede también especificarse a nivel de la transacción, en lugar de a nivel de actividad. Si se comunica un elemento país-receptor O región-receptora a nivel de transacción, TODAS las transacciones DEBEN contener un elemento país-receptor o región-receptora y NO DEBEN utilizarse los elementos actividad-iati/país-receptor y actividad-iati/región-receptora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-country/\'>Más información aquí</a>.',
      'country_code' =>
      array (
        'hover_text' => 'Código de dos letras del país según la norma ISO 3166-1. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/country/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione un país que se beneficia con la actividad. Sin embargo, si desea indicar el país receptor que se beneficia con la transacción individual de la actividad <b><u>no</u></b> seleccione el país en este apartado.',
      ),
      'percentage' =>
      array (
        'hover_text' => 'Porcentaje del compromiso total o presupuesto total de la actividad correspondiente a este elemento. Debe ser un número decimal entre 0 y 100 sin el símbolo de porcentaje. Los porcentajes de todos los países y las regiones indicados en un vocabulario DEBEN sumar 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-country/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el porcentaje de la financiación que beneficia a este país. Los porcentajes de todos los países y las regiones indicados DEBEN sumar 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Orientación adicional aquí</a>.',
      ),
      'narrative' =>
      array (
        'help_text' => 'Añada el nombre y/o la descripción libre para el país beneficiario de la actividad.',
      ),
    ),
    'recipient_region' =>
    array (
      'help_text' => 'Si no puede identificar el país o los países específicos beneficiarios de esta actividad, debe indicar la región en su lugar.<br><br>Si se incluye una región, debe ser adicional a cualquier país o países especificados. Si se conocen el país o los países receptores, no se debe añadir la región receptora correspondiente. Por ejemplo, si el 100% de la financiación se destina a Uganda, debería registrar Uganda como país receptor y no debería añadirse que la financiación va dirigida a la región de África.<br></br>No obstante, si sabe que por lo menos el 80% de la financiación prevista se dirige a Uganda, puede especificar que el 20% restante que se desconoce se destina a la región de África. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Más información aquí</a>.',
      'hover_text' => 'Región geopolítica supranacional que se beneficiará con esta actividad. Para la ubicación geográfica subnacional, utilice el elemento de ubicación. Se puede informar de varios países y regiones, en cuyo caso el atributo de porcentaje DEBE utilizarse para especificar la proporción del total del compromiso para cada uno de los países y las regiones indicados. El elemento región-receptora no debe utilizarse solamente para describir la región de un país indicado en país-receptor, SALVO que la región TAMBIÉN figure como receptor. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
      'region_vocabulary' =>
      array (
        'hover_text' => 'Código de la IATI para el vocabulario del que se extrae el código de la región. Si no está presente, se asume 1 - “CAD de la OCDE”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
        'help_text' => 'Se dispone de dos listas de regiones: la lista de códigos del <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/region/\'>CAD de la OCDE</a> y la lista de códigos de <a target=\'_blank\' href=\'https://unstats.un.org/unsd/methodology/m49/\'>regiones de las Naciones Unidas</a>. Seleccione una opción. La IATI le recomienda utilizar la lista de códigos del CAD de la OCDE. De lo contrario, puede utilizar otra lista de regiones seleccionando la opción “organización notificadora” y proporcionando el URI donde se define esta lista interna.<br></br>Si no elige una opción, se asume la lista de códigos del CAD de la OCDE.',
      ),
      'region_code' =>
      array (
        'hover_text' => 'Código de región de las Naciones Unidas o del CAD de la OCDE. La lista de códigos se determina a través del atributo de vocabulario. Este atributo es necesario. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
      ),
      'custom_code' =>
      array (
        'hover_text' => 'Código de región de las Naciones Unidas o del CAD de la OCDE. La lista de códigos se determina a través del atributo de vocabulario. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define ese vocabulario interno. Si bien este campo es opcional, se RECOMIENDA ENCARECIDAMENTE a todas las entidades que publican datos que lo utilicen para garantizar que los usuarios de datos comprendan plenamente el significado de sus códigos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
      ),
      'percentage' =>
      array (
        'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define ese vocabulario interno. Si bien este campo es opcional, se RECOMIENDA ENCARECIDAMENTE a todas las entidades que publican datos que lo utilicen para garantizar que los usuarios de datos comprendan plenamente el significado de sus códigos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
        'help_text' => 'Porcentaje del compromiso total o presupuesto total de la actividad correspondiente a este elemento. Debe ser un número decimal entre 0 y 100 sin el símbolo de porcentaje. Los porcentajes de todos los países y las regiones indicados en un vocabulario DEBEN sumar 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>Más información aquí</a>.',
      ),
      'narrative' =>
      array (
        'help_text' => 'Añada el nombre en texto libre del país beneficiario de la actividad.',
      ),
      'language' =>
      array (
        'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
      ),
    ),
    'sector' =>
    array (
      'hover_text' => 'Código reconocido, de un vocabulario reconocido, que clasifique el propósito de la actividad. El elemento sector DEBE YA SEA indicarse en este apartado O a nivel de transacción para TODAS las transacciones. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>Más información aquí</a>.',
      'help_text' => 'Facilite información sobre el sector al que la actividad se dirige o que recibe su apoyo. Por ejemplo, educación primaria o agricultura. Puede seleccionar más de un sector, pero debe indicar <b>uno como mínimo</b>.',
      'sector_vocabulary' =>
      array (
        'hover_text' => 'Código de la IATI para el vocabulario (véase la lista de códigos) utilizado para las clasificaciones de los sectores. En caso de omitirse, se asumen los códigos de finalidad de cinco dígitos del CAD de la OCDE. En la medida de lo posible, se recomienda utilizar los códigos de finalidad de cinco dígitos del CAD de la OCDE. Asimismo, se recomienda a aquellas entidades que publican datos y cuentan con sus propios sistemas de clasificación el uso de los vocabularios 99 o 98 (vocabularios de la propia organización notificadora), además de los códigos del CAD. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione la lista de sectores a partir de la cual elegirá los sectores a los que se dirige su actividad. La IATI recomienda elegir la lista de códigos de sectores de cinco dígitos del CAD de la OCDE, en la que puede realizar su selección de entre más de 300 sectores.<br></br>Además de la lista de códigos de cinco dígitos del CAD de la OCDE, también puede optar por una lista diferente (ver el siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sectorvocabulary/\'>información sobre todas las opciones posibles</a>). Si desea utilizar una lista propia de su organización de clasificaciones internas de sectores, seleccione la opción “organización notificadora”.<br></br>Puede optar por utilizar varias listas. Si utiliza más de una clasificación de sectores interna, seleccione “organización notificadora 2” (código 98) para la lista adicional. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>Orientación adicional aquí</a>.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 o 98 (organización notificadora), el URI donde se define ese vocabulario interno. Si bien este campo es opcional, se RECOMIENDA ENCARECIDAMENTE a todas las entidades que publican datos que lo utilicen para garantizar que los usuarios de datos comprendan plenamente el significado de sus códigos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>Más información aquí</a>.',
        'help_text' => 'Si ha optado por una lista de códigos de clasificación de sectores interna, adjunte un enlace a dicha lista.',
      ),
      'percentage' =>
      array (
        'hover_text' => 'Porcentaje del compromiso total o presupuesto total de la actividad correspondiente a este elemento. Debe ser un número decimal entre 0 y 100 sin el símbolo de porcentaje. Todos los sectores indicados del mismo vocabulario DEBEN sumar 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'> Más información aquí</a>.',
        'help_text' => 'Si ha seleccionado más de un sector (de la misma lista), se debe asignar un porcentaje a cada uno de estos. Estos porcentajes pueden aplicarse posteriormente a los montos de financiación para calcular los recursos asignados a cada sector. Por ejemplo, al utilizar la lista de códigos de sectores de cinco dígitos del CAD de la OCDE, podría asignar un 50% de la financiación de la actividad al código de sector “formación de docentes” (11130) y un 50% a “educación primaria” (11220).',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Descripción de un sector definido por la organización notificadora (ha de usarse únicamente cuando se aplique el propio vocabulario de la organización notificadora). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Si ha elegido el sector de una lista de códigos de clasificación de sectores interna, presente una descripción de este.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'tag' =>
    array (
      'hover_text' => 'Categorizaciones de taxonomías establecidas que mejoran la clasificación de la actividad, pero que, a diferencia de aquellas indicadas en el elemento de sector, no pueden vincularse a repartos porcentuales de la financiación. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>Más información aquí</a>.',
      'help_text' => 'Puede aportar información adicional de utilidad sobre su actividad añadiendo una etiqueta de categorizaciones de taxonomías establecidas.<br></br>Por ejemplo, la IATI recomienda que, en la medida de lo posible, añada una etiqueta a su actividad del Objetivo o los Objetivos de Desarrollo Sostenible de las Naciones Unidas a los que contribuye. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sdg-guidance/\'>Consulte la orientación relativa a la presentación de datos sobre los Objetivos de Desarrollo Sostenible de las Naciones Unidas.</a>',
      'tag_vocabulary' =>
      array (
        'hover_text' => 'Código de la IATI para el vocabulario o la taxonomía (ver la lista de códigos no integrados) que se utiliza para la clasificación de las etiquetas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione una lista. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tagvocabulary/\'>Ver información sobre todas las opciones</a>. Es posible elegir una etiqueta de actividad siguiendo una lista interna de categorías, para ello, seleccione la opción “organización notificadora”.',
      ),
      'targets_tag_code' =>
      array (
        'hover_text' => 'Código de la etiqueta establecido en el vocabulario indicado.<br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>Más información aquí</a>.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'El URI donde se define este vocabulario. <br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>Más información aquí</a>.',
        'help_text' => 'Proporcione un enlace a su lista seleccionada.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Puede aportar información adicional sobre la opción seleccionada.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'policy_marker' =>
    array (
      'hover_text' => 'Se trata de una política o tema que se aborda con la actividad. Este elemento se concibió para informar los marcadores de políticas del CRS del CAD de la OCDE (columnas 20 a 23 y 28 a 31 del formato de presentación de informes CRS++), pero el atributo de vocabulario permite su uso por parte de otros sistemas (incluidos los locales). Este elemento puede repetirse para cada marcador de políticas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
      'help_text' => 'Facilite información sobre la política o el tema que se aborda con la actividad, por ejemplo, la mitigación del cambio climático o la discapacidad. Una actividad puede tener varios marcadores de políticas y <b>no</b> necesariamente deben añadirse porcentajes a cada marcador de políticas.',
      'policy_marker_vocabulary' =>
      array (
        'hover_text' => 'Código de la IATI para el vocabulario que se utiliza para definir los marcadores de políticas. Si se omite, se asume el vocabulario del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione una lista que incluya el marcador o los marcadores de políticas relacionados con su actividad.<br></br><b>1 (CRS del CAD de la OCDE):</b> la IATI recomienda seleccionar esta lista que cuenta con <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/policymarker/\'>12 opciones</a> para elegir.<br></br><b>99 (organización notificadora)</b>: opte por esta opción si desea indicar un código para un marcador de políticas que ha definido su organización y al que hace seguimiento.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'Si el vocabulario es 99 (organización notificadora), el URI donde se define este vocabulario interno. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
        'help_text' => 'Si ha seleccionado la opción 99 (organización notificadora) antes mencionada, proporcione un enlace al recurso donde figura el marcador de políticas seleccionado.',
      ),
      'significance' =>
      array (
        'hover_text' => 'Código del CRS del CAD de la OCDE que indica la importancia del marcador de políticas para esta actividad. Este atributo DEBE utilizarse para todos los vocabularios del CRS del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
        'help_text' => 'Si ha seleccionado una política o un tema de la lista de marcadores de políticas del CRS del CAD de la OCDE, deberá indicar el nivel de importancia de este para su actividad. Por ejemplo, podría ser el objetivo principal o un objetivo importante de su actividad. Consulte la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/policysignificance/\'>información sobre todas las opciones antes de decantarse por una de ellas</a>.',
      ),
      'policy_marker' =>
      array (
        'hover_text' => 'Código del marcador de políticas de la lista de códigos especificada en el vocabulario. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
      ),
      'policy_marker_text' =>
      array (
        'hover_text' => 'Código del marcador de políticas de la lista de códigos especificada en el vocabulario. Este atributo es necesario. <br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>Más información aquí</a>.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Descripción del marcador de políticas. Esta opción DEBE UTILIZARSE ÚNICAMENTE cuando el vocabulario sea 99 (vocabulario de marcadores de la propia organización notificadora) Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Si ha seleccionado la opción 99 (organización notificadora) antes mencionada, proporcione una descripción del marcador o los marcadores de políticas que ha elegido.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado.<br>Este valor debe figurar en la lista de códigos de idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'collaboration_type' =>
    array (
      'hover_text' => 'Tipo de colaboración utilizada en los desembolsos de la actividad, por ejemplo “bilateral” o “multilateral”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/collaboration-type/\'>Más información aquí</a>.',
      'help_text' => 'Puede describir el flujo de los fondos entre organizaciones para esta actividad. Por ejemplo, los fondos podrían fluir bilateralmente, es decir, entre dos gobiernos. Esto se aplica en gran medida en las organizaciones bilaterales y multilaterales.',
      'collaboration_type' =>
      array (
        'hover_text' => 'Código de la lista de códigos “Bi_Multi” del CRS del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/collaboration-type/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo de colaboración, si una de las opciones es aplicable a su actividad. Puede obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/collaborationtype/\'>información sobre todas las opciones en este enlace</a>. De lo contrario, deje este apartado en blanco.',
      ),
    ),
    'default_flow_type' =>
    array (
      'hover_text' => 'Si la actividad se financia con asistencia oficial para el desarrollo, otros aportes del sector público, u otros medios. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>Más información aquí</a>.',
      'help_text' => 'El tipo de flujo constituye otra forma de clasificar los flujos financieros. Los flujos se clasifican como sigue: asistencia oficial para el desarrollo, otros aportes del sector público, o varios tipos de flujos privados, incluidas las subvenciones privadas que por lo general proporcionan las ONG y otras organizaciones de la sociedad civil.',
      'default_flow_type' =>
      array (
        'hover_text' => 'Código de la lista de códigos para tipos de flujos del CRS del CAD de la OCDE. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>Más información aquí</a>.',
        'help_text' => 'Si los fondos de la actividad pueden clasificarse conforme a las <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>siguientes opciones</a>, elija la opción que corresponda. De lo contrario, deje este apartado en blanco.',
      ),
    ),
    'default_finance_type' =>
    array (
      'hover_text' => 'Tipo de financiación (p. ej., subvención, préstamo, alivio de la deuda, etc.). Se trata del valor predeterminado para todas las transacciones en el informe de la actividad y puede modificarse para cada transacción individual. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/\'>Más información aquí</a>.',
      'help_text' => 'En el tipo de financiación se especifica el instrumento financiero que se utiliza para la actividad. Por ejemplo, lo más habitual es que la financiación se entregue como subvención o préstamo.',
      'default_finance_type' =>
      array (
        'hover_text' => 'Código de la lista de códigos para tipos de financiación del CRS del CAD de la OCDE. Este atributo es necesario.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione un tipo de financiación para esta actividad a partir de las <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/financetype/\'>siguientes opciones</a>.',
      ),
    ),
    'default_aid_type' =>
    array (
      'default_aid_type_vocabulary' =>
      array (
        'hover_text' => 'Código para las clasificaciones del vocabulario del elemento tipo-ayuda. De omitirse, se asume la lista de códigos de tipos de ayuda (CAD de la OCDE). El código debe ser un valor válido de la lista de códigos del vocabulario de tipo de ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione una lista que incluya el elemento tipo-ayuda relacionado con su actividad (en su caso). De lo contrario, deje este apartado en blanco. Tiene la posibilidad de seleccionar el elemento tipo-ayuda de más de una lista.<br></br><b>1. CAD de la OCDE</b>: la IATI le recomienda que opte por esta lista, en la que figuran <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>más de 20 opciones</a>. Posteriormente, podrá, además, seleccionar una opción de otra lista.<br></br><b>2. Categoría de asignación de fondos:</b> seleccione <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/earmarkingcategory/\'>esta lista</a> para clasificar el nivel de flexibilidad de la financiación humanitaria. Existen cuatro categorías de asignación de fondos. Puede conocer más sobre las categorías en el <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>Anexo 1.</a><br></br><b>3. Modalidad de asignación de fondos:</b> utilice esta lista para elegir la modalidad de asignación específica que explica la financiación humanitaria de su actividad. Todas las opciones de modalidades de asignación de fondos se <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>enumeran en el Anexo 1.</a><br></br><b>4. Modalidades de asistencia en efectivo y mediante vales:</b> seleccione esta lista para especificar si su actividad da respuesta a un evento humanitario prestando asistencia en efectivo y mediante vales. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/CashandVoucherModalities/\'>Más información aquí</a>.</br>',
      ),
      'default_aid_type' =>
      array (
        'hover_text' => 'Código del vocabulario especificado. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/\'>Más información aquí</a>.',
      ),
    ),
    'default_tied_status' =>
    array (
      'hover_text' => 'Si la ayuda es condicionada, no condicionada o parcialmente condicionada. Este elemento establece un valor predeterminado para todas las transacciones financieras de la actividad que puede modificarse para cada transacción individual. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/\'>Más información aquí</a>.',
      'help_text' => 'Puede indicar el estado de condicionamiento de esta transacción. En este apartado puede indicar si los fondos están condicionados, es decir, si deben destinarse a la adquisición de bienes o servicios de un país concreto (país donante) o un grupo de países; o si los fondos no están condicionados, que es el caso en que la organización receptora puede adquirirlos de cualquier país.',
      'default_tied_status' =>
      array (
        'hover_text' => 'Código de la IATI que explica el uso de las columnas 36 a 38 del formato de presentación de informes CRS++. (Monto condicionado, monto parcialmente condicionado, monto no condicionado). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione un estado de condicionamiento predeterminado si se aplica a su actividad. En el siguiente enlace puede acceder a las <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tiedstatus/\'>descripciones de todas las opciones</a>. De lo contrario, deje este apartado en blanco.',
      ),
    ),
    'country_budget_items' =>
    array (
      'hover_text' => 'Este elemento codifica qué tan ajustadas están las actividades a las clasificaciones funcionales y administrativas que se utilizan en el plan de cuentas del país receptor. Se aplica a las actividades presupuestarias y extrapresupuestarias. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/\'>Más información aquí</a>.',
      'country_budget_vocabulary' =>
      array (
        'hover_text' => 'Código de la IATI para la clasificación funcional común o el sistema del país, que posibilita el uso de códigos comunes, clasificaciones específicas de los países o cualquier otro tipo de clasificación que hubieran acordado los países y los donantes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/\'>Más información aquí</a>.',
      ),
      'budget_item' =>
      array (
        'hover_text' => 'Identificador de un elemento único en el presupuesto del país receptor. En caso de que se indique más de un identificador, se ha de especificar el reparto porcentual y la suma de los porcentajes debe ser 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>Más información aquí</a>.',
        'code' =>
        array (
          'hover_text' => 'Código para el elemento asignación-presupuestaria del vocabulario facilitado. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>Más información aquí</a>.',
        ),
        'percentage' =>
        array (
          'hover_text' => 'Cuando se indiquen varios elementos de asignación-presupuestaria en un único elemento de asignaciones-presupuestarias-país, para cada vocabulario utilizado los valores porcentuales deben sumar un 100%. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>Más información aquí</a>.',
          'help_text' => 'En caso de que no se seleccione ningún valor, se asume el valor predeterminado.',
        ),
        'description' =>
        array (
          'hover_text' => 'Descripción más amplia y legible para los seres humanos del elemento asignación-presupuestaria. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/\'>Más información aquí</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/narrative/\'>Más información aquí</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/narrative/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'humanitarian_scope' =>
    array (
      'hover_text' => 'Clasificación de emergencias, llamamientos y otros eventos y acciones de índole humanitaria. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
      'help_text' => 'El elemento “alcance-humanitario” puede utilizarse para especificar la emergencia o el llamamiento al que la actividad da respuesta.',
      'type' =>
      array (
        'hover_text' => 'Código del tipo de evento o acción que se clasifica. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo de información que puede suministrar:<br></br><li><b>Emergencias (tipo 1)</b><br>Seleccione esta opción si puede facilitar el número GLIDE de la emergencia humanitaria específica a la que su actividad da respuesta. Como alternativa, seleccione esta opción si puede indicar un código para la emergencia a partir de una lista pública distinta.<br><br></li><li><b>Llamamientos (tipo 2)</b><br>Seleccione esta opción si su actividad contribuye a un <a target=\'_blank\' href=\'https://fts.unocha.org/plan-code-list-iati\'>plan de respuesta humanitaria o un llamamiento urgente</a> de la Oficina de Coordinación de Asuntos Humanitarios de las Naciones Unidas (OCHA). La OCHA crea estos códigos a fin de que se utilicen en su Servicio de Seguimiento Financiero. De lo contrario, seleccione esta opción si puede indicar un código de llamamiento de una lista pública diferente.</li></ul>',
      ),
      'vocabulary' =>
      array (
        'hover_text' => 'Código de un vocabulario reconocido de los términos que clasifican el evento o la acción.<br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione la lista que utilizará para identificar la emergencia o el llamamiento a los que la actividad da respuesta:</br><br><b>1-2 <a target=\'_blank\' href=\'http://glidenumber.net/glide/public/search/search.jsp\'>GLIDE</a></b></br><b>2-1 <a target=\'_blank\' href=\'https://fts.unocha.org/plan-code-list-iati\'>Plan humanitario</a></b></br><b>99 Organización notificadora</b>: seleccione esta opción si puede indicar un código para la emergencia o el llamamiento de una lista pública distinta.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'URI para el vocabulario especificado que brinda acceso a la lista de códigos y descripciones. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
        'help_text' => 'Proporcione un enlace a la lista de emergencias o llamamientos que utilizará, en donde se incluyan los códigos y descripciones respectivos.',
      ),
      'code' =>
      array (
        'hover_text' => 'Código para el evento o la acción del vocabulario indicado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
        'help_text' => 'Indique el código de la emergencia o el llamamiento en cuestión a los que su actividad da respuesta.<br></br>Por ejemplo, si proporciona un código para una emergencia que tiene asociado un <a target=\'_blank\' href=\'https://glidenumber.net/glide/public/search/search.jsp\'>número GLIDE</a>, el formato del código sería: [tipo de emergencia] + [año] + [número] + [país].',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Descripción del código indicado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Si el código para la emergencia o el llamamiento que ha utilizado procede de una lista pública distinta (por ejemplo, ha seleccionado la opción “99 [organización notificadora]”), facilite una descripción del código indicado.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'capital_spend' =>
    array (
      'hover_text' => 'Porcentaje del compromiso total que se destina a gastos de capital. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/capital-spend/\'>Más información aquí</a>.',
      'help_text' => 'Especifique el monto de la financiación total de la actividad que se destinará al capital. “Capital” describe los activos físicos con una vida útil superior a un año. Por ejemplo, una carretera.',
      'capital_spend' =>
      array (
        'hover_text' => 'Porcentaje del compromiso total asignado o previsto para los gastos de capital. Debe ser un número decimal entre 0 y 100, sin símbolo de porcentaje. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/capital-spend/\'>Más información aquí</a>.',
        'help_text' => 'El porcentaje no debe ser superior a 100.',
      ),
    ),
    'related_activity' =>
    array (
      'hover_text' => 'Actividad distinta de la IATI sobre la que se informa por separado y que guarda relación con la actividad en cuestión. El atributo “tipo” explica el tipo de relación: (por ejemplo, actividad principal, actividad secundaria, financiación múltiple). Se recomienda especialmente que el vínculo entre las actividades de un grupo jerárquico se gestione siempre utilizando este elemento con @type 1 (principal) o 2 (secundaria). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/related-activity/\'>Más información aquí</a>.',
      'help_text' => 'Si la actividad forma parte de un programa con diferentes actividades en el marco de una organización, deben incluirse los detalles de todas las actividades relacionadas. En el siguiente enlace puede leer más información sobre los <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/relatedactivitytype/\'>tipos de actividades relacionadas</a> sobre las que puede informar.</br></br>Haga referencia exclusivamente a <b>sus <u>propias</u></b> actividades en este apartado.',
      'activity_identifier' =>
      array (
        'hover_text' => 'Identificador de actividad válido (como se define en actividad-iati/identificador-iati).',
        'help_text' => 'En caso de que desee informar sobre una actividad relacionada, indique el identificador-actividad completo (incluida la parte del identificador-organización). En el siguiente enlace podrá obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>más información sobre los identificadores de actividad</a>. Puede consultar el identificador a la persona o las personas que informan de la actividad o buscar la actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.',
      ),
      'relationship_type' =>
      array (
        'hover_text' => 'Código de la IATI para el tipo de relación.',
        'help_text' => 'Seleccione el tipo de relación entre la actividad sobre la que se informa y la actividad relacionada utilizando <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/relatedactivitytype/\'>esta lista</a>.',
      ),
    ),
    'conditions' =>
    array (
      'hover_text' => 'Condiciones específicas anexas a la actividad que, de no satisfacerse, pueden tener una incidencia en el cumplimiento de los compromisos de las organizaciones participantes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/conditions/\'>Más información aquí</a>.',
      'help_text' => 'Indique las condiciones específicas anexas a la actividad. Por ejemplo, requisitos establecidos por el financiador o un examen tras un período de seis meses para evaluar si merece la pena continuar con la actividad o no.<br></br>Si una condición hace referencia a toda la organización, como las condiciones aplicables a la organización en su conjunto, no debe indicarse en esta actividad. En su lugar, debería indicarlo en el elemento enlace-documento que puede encontrar en el archivo de su organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/conditions/\'>Orientación adicional aquí</a>.',
      'condition_attached' =>
      array (
        'hover_text' => 'Valor Sí/No (1/0) que indica si la actividad tiene condiciones anexas. Se recomienda indicar este atributo, incluso si no hay condiciones anexas (en cuyo caso sería anexo=“0”)',
        'help_text' => 'Seleccione “Sí” si su actividad tiene condiciones anexas o “No” si no es el caso.',
      ),
      'condition' =>
      array (
        'hover_text' => 'Texto de la condición específica anexa a la actividad. Las condiciones que hacen referencia a toda la organización y se aplican a todas las actividades no deben indicarse aquí, sino en organización-iati/enlace-documento o en actividad-iati-enlace-documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/conditions/condition/\'> Más información aquí</a>.',
      ),
      'condition_type' =>
      array (
        'hover_text' => 'Código de la IATI que establece el tipo de condición.',
        'help_text' => 'Seleccione el tipo de condición del que desea informar. Puede indicar tres tipos de condiciones:<br></br><b>Condiciones normativas</b>: por ejemplo, la organización que recibe los fondos debe aplicar una política concreta.<br></br><b>Condiciones de desempeño</b>: por ejemplo, deben alcanzarse determinados productos o resultados.<br></br><b>Condiciones fiduciarias</b>: por ejemplo, la organización receptora debe adoptar determinadas medidas en materia de gestión de las finanzas públicas o rendición pública de cuentas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/conditiontype/\'>Descripción completa de todos los tipos de condiciones</a>.',
      ),
      'narrative' =>
      array (
        'help_text' => 'Describa brevemente la condición aquí.<br></br>Puede proporcionar información adicional adjuntando un enlace a una página web o un documento pertinente en el elemento enlace-documento de la actividad.',
      ),
    ),
    'legacy_data' =>
    array (
      'hover_text' => 'El elemento de datos precedentes permite introducir valores a partir de un campo específico del sistema de la organización notificadora que es similar a un elemento de la IATI, pero no idéntico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/legacy-data/\'>Más información aquí</a>.',
      'help_text' => 'Puede vincular la actividad con los datos internos de su organización e indicar con qué elemento de la Norma IATI está más relacionado.',
      'legacy_name' =>
      array (
        'hover_text' => 'Nombre del campo original en el sistema de la organización notificadora.',
      ),
      'value' =>
      array (
        'hover_text' => 'Valor del campo original en el sistema de la organización notificadora.',
      ),
      'iati_equivalent' =>
      array (
        'hover_text' => 'Nombre del elemento de la IATI equivalente.',
      ),
    ),
    'document_link' =>
    array (
      'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>Más información aquí</a>.',
      'help_text' => 'Puede proporcionar información adicional sobre esta actividad adjuntando un enlace de acceso público a un documento o a una página web.<br></br>Si los documentos estuvieran disponibles en otros idiomas y se almacenaran por separado, facilítelos creando elementos de documento adicionales. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/related-documents/\'>Orientación adicional aquí</a>.',
      'url' =>
      array (
        'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>Más información aquí</a>.',
      ),
      'format' =>
      array (
        'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>Más información aquí</a>.',
        'help_text' => 'Si conoce el formato del archivo del documento, introdúzcalo <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/fileformat/\'>utilizando una opción de la lista</a>.',
      ),
      'title' =>
      array (
        'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/title/\'>Más información aquí</a>.',
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/description/\'>Más información aquí</a>.',
      ),
      'category' =>
      array (
        'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/category/\'>Más información aquí</a>.',
        'code' =>
        array (
          'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/category/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione una categoría para el documento o la página web que ha facilitado de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/documentcategory/\'>lista</a>.',
        ),
      ),
      'language' =>
      array (
        'code' =>
        array (
          'help_text' => 'Seleccione el idioma del documento o de la página web.',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Fecha de publicación del documento al que se vincula (@iso-date). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/document-date/\'>Más información aquí</a>.',
      ),
    ),
    'location' =>
    array (
      'hover_text' => 'Identificación geográfica subnacional de las ubicaciones a las que una actividad está dirigida. Se pueden describir mediante referencias de un nomenclátor, coordenadas, áreas administrativas o una descripción textual. Puede introducir tantas ubicaciones como se desee. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/\'>Más información aquí</a>.',
      'help_text' => 'Si las conoce, indique también la ubicación o ubicaciones subnacionales de la actividad. No obstante, <b>los datos sobre la ubicación solo deben añadirse cuando sea seguro hacerlo.</b> Corresponde a la organización que publica garantizar que los datos no representan ningún peligro.<br></br>Puede indicar las coordenadas geográficas de una ubicación, el nombre y la descripción de la ubicación, la zona administrativa u otras características de la ubicación, por ejemplo, un centro de salud, un pueblo, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Orientación adicional aquí</a>.',
      'reference' =>
      array (
        'hover_text' => 'Referencia interna que define la ubicación en el sistema de la organización notificadora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar una referencia interna que su organización utilice para definir la ubicación, por ejemplo, AF-KAN.',
      ),
      'location_id' =>
      array (
        'hover_text' => 'Código único que define la ubicación según un nomenclátor o un repositorio de límites administrativos reconocido. Las demarcaciones administrativas solo deben indicarse aquí si la ubicación que se describe es la propia demarcación. Para definir una demarcación administrativa dentro de la cual existe una localización más circunscrita, utilice el elemento de ubicación/demarcación administrativa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar un código único que defina la ubicación según un nomenclátor o un repositorio de límites administrativos reconocido. Puede seleccionar una opción de nomenclátor o repositorio de límites administrativos de la lista de abajo.',
        'vocabulary' =>
        array (
          'hover_text' => 'Código de la IATI de un nomenclátor o un repositorio de límites administrativos reconocido.</br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el nomenclátor o el repositorio de límites administrativos del que procede el código que va a introducir. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicvocabulary/\'>Puede consultar más información sobre cada opción aquí</a>.',
        ),
        'code' =>
        array (
          'hover_text' => 'Código del nomenclátor o del repositorio de límites administrativos que establece el vocabulario.</br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>Más información aquí</a>.',
          'help_text' => 'Indique el código único que define la ubicación según un nomenclátor o un repositorio de límites administrativos reconocido <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicvocabulary/\'>Puede consultar más información sobre cada opción aquí</a>.',
        ),
      ),
      'location_reach' =>
      array (
        'hover_text' => '¿La ubicación define el lugar en el que transcurrirá la actividad o el lugar de residencia de los beneficiarios previstos? <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-reach/\'>Más información aquí</a>.',
        'help_text' => 'Especifique si la ubicación define el lugar en el que transcurrirá la actividad o el lugar de residencia de los beneficiarios previstos.',
        'code' =>
        array (
          'hover_text' => 'Código de la IATI para el alcance geográfico de la actividad. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-reach/\'>Más información aquí</a>.',
          'help_text' => 'Elija una opción para describir el alcance de la ubicación.<br><br>1) <b>Actividad</b>: la ubicación especifica el lugar en que la actividad se llevará a cabo.<br><br>2) <b>Beneficiarios previstos</b>: la ubicación específica el lugar en el que residen los beneficiarios previstos de la actividad</li></ol>.',
        ),
      ),
      'name' =>
      array (
        'hover_text' => 'Nombre de la ubicación legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Indique el nombre en texto libre de la ubicación de la actividad.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción que permite definir la ubicación, mas no la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Facilite una descripción de la ubicación de la actividad.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'activity_description' =>
      array (
        'hover_text' => 'Descripción que permite clasificar la actividad que tiene lugar en la ubicación. Este elemento no debe repetir información que ya se haya facilitado en la descripción principal de la actividad, sino que debe utilizarse para diferenciar las actividades realizadas en distintos lugares dentro del mismo registro de actividad-iati. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/narrative/\'>Más información aquí</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'administrative' =>
      array (
        'hover_text' => 'Códigos de identificación de las divisiones nacionales y subnacionales establecidas por repositorios de límites administrativos reconocidos. Pueden indicarse varios niveles. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar un código único que defina la ubicación de la actividad según un repositorio de límites administrativos.',
        'vocabulary' =>
        array (
          'hover_text' => 'Código de la IATI para un repositorio de límites administrativos reconocido. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione una <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>lista de límites administrativos</a> que incluya un código para representar la ubicación en la que tiene lugar su actividad.',
        ),
        'code' =>
        array (
          'hover_text' => 'Código para la demarcación administrativa establecido en el vocabulario indicado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>Más información aquí</a>.',
          'help_text' => 'Indique un código para representar la ubicación en la que tiene lugar su actividad (de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>lista de límites administrativos seleccionada</a>).',
        ),
        'level' =>
        array (
          'hover_text' => 'Número que define una subdivisión en un sistema jerárquico de demarcaciones administrativas. El @vocabulary que se utiliza determina el sistema para asignar un significado específico a cada valor de @level. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>Más información aquí</a>.',
          'help_text' => 'En la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>lista de límites administrativos</a> que haya seleccionado, puede añadir un número para definir una subdivisión en un sistema jerárquico de demarcaciones administrativas.',
        ),
      ),
      'point' =>
      array (
        'hover_text' => 'El elemento “punto” se basa en un subconjunto del elemento “punto” de GML 3.3 <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar las coordenadas geográficas de la ubicación en forma de coordenadas de latitud y longitud<br></br>Las coordenadas se publican utilizando los elementos “punto” y “posición”. El elemento “punto” siempre adopta la forma: <point srsName=\'http://www.opengis.net/def/crs/EPSG/0/4326\'><br></br>Por su parte, el elemento “posición” indica las coordenadas de latitud (el primer número), seguidas de las coordenadas de longitud (el segundo número), por ejemplo, -46.7733 167.6321.<br></br>Tenga en cuenta que las coordinadas pueden remitir a una ubicación “exacta” o “aproximada”. Debe especificarse mediante el elemento para determinar la exactitud de la ubicación. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sub-national-locations/\'>Más información aquí</a>.',
        'srs_name' =>
        array (
          'hover_text' => 'Nombre del sistema de referencia espacial que utilizan las coordenadas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/\'>Más información aquí</a>.',
          'help_text' => 'Este valor nunca cambia.',
        ),
        'pos' =>
        array (
          'hover_text' => 'Coordenadas de latitud y longitud en el formato “lat lng”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/pos/\'>Más información aquí</a>.',
          'help_text' => 'Introduzca las coordenadas de latitud y longitud separadas por un espacio, por ejemplo “31.616944 65.716944”<br></br>Si aún no dispone de una herramienta para encontrar las coordenadas de una actividad, puede ayudarse de plataformas en línea como <a target=\'_blank\' href=\'https://www.google.com/maps/\'>Google Maps</a> o <a target=\'_blank\' href=\'https://www.latlong.net/\'>LatLong.net</a>. Para encontrar las coordenadas de una actividad en Google Maps, haga clic con el botón derecho del ratón en la ubicación de la actividad y seleccione “¿Qué hay aquí?”, a continuación, se mostrarán las coordenadas. Otra opción consiste en introducir las coordenadas y la ubicación de la actividad aparecerá en el mapa. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sub-national-locations/\'>Más información aquí</a>.',
        ),
        'exactness' =>
        array (
          'hover_text' => 'Define si la ubicación representa el punto más identificable que podría asociarse a este tipo de actividad o si se trata de una aproximación debido a la falta de información suficientemente detallada. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/exactness/\'>Más información aquí</a>.',
          'code' =>
          array (
            'hover_text' => 'Código de la lista códigos de exactitud geográfica. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/exactness/\'>Más información aquí</a>.',
            'help_text' => 'Si ya ha indicado las coordinadas geográficas de la ubicación de la actividad, elija una opción de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicexactness/\'>lista de exactitud geográfica</a> para especificar si la ubicación es exacta o aproximada.',
          ),
        ),
        'location_class' =>
        array (
          'hover_text' => 'Tipo de ubicación, ya sea una estructura, un lugar habitado (p. ej., una ciudad o un pueblo), una división administrativa u otra categoría topográfica (p. ej., un río o una reserva natural). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-class/\'>Más información aquí</a>.',
          'code' =>
          array (
            'hover_text' => 'Código de la lista de códigos de clases de ubicaciones. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-class/\'>Más información aquí</a>.',
            'help_text' => 'Especifique el tipo de ubicación de la actividad de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicLocationClass/\'>lista de clases de ubicaciones geográficas</a>. Por ejemplo, si se trata de un lugar habitado (un pueblo, una granja, etc.) o de una categoría topográfica (un río, una montaña, etc.).',
          ),
        ),
        'feature_designation' =>
        array (
          'hover_text' => 'Clasificación codificada más precisa del tipo de característica que define a esta ubicación. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/feature-designation/\'>Más información aquí</a>.',
          'code' =>
          array (
            'hover_text' => 'Código de designación de características de la lista autorizada (mantenida por la Agencia Nacional de Inteligencia Geoespacial de EE.UU.). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/feature-designation/\'>Más información aquí</a>.',
            'help_text' => 'Puede añadir información adicional sobre el tipo de ubicación en el que se desarrolla su actividad (por ejemplo, una playa, un pozo o una universidad). Elija una opción de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/LocationType/\'>lista de tipos de ubicación</a>.',
          ),
        ),
      ),
    ),
    'planned_disbursement' =>
    array (
      'hover_text' => 'El elemento de desembolso previsto solo debería utilizarse para informar sobre transferencias específicas en efectivo previstas. Deben comunicarse para una fecha específica o un período significativamente predecible. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/\'>Más información aquí</a>.',
      'help_text' => 'En esta actividad, puede publicar datos sobre las transferencias en efectivo que tiene previsto efectuar a distintas organizaciones (o que van a producirse entre otras dos organizaciones).<br></br>El objeto de la sección de desembolsos previstos es publicar programas de pagos predefinidos. Deben comunicarse los desembolsos previstos para una fecha concreta o un período significativamente predecible. Los desembolsos previstos deben indicarse además del presupuesto de la actividad, y no en lugar de este.',
      'period_start' =>
      array (
        'hover_text' => 'Fecha exacta del desembolso previsto O fecha de inicio del período en el que se efectuará este desembolso específico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/period-start/\'>Más información aquí</a>.',
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fecha de finalización del período en el que se efectuará este desembolso específico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>Más información aquí</a>.',
      ),
      'planned_disbursement_type' =>
      array (
        'hover_text' => 'El objetivo del elemento desembolso-previsto es definir programas de pago predefinidos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/\'>Más información aquí</a>.',
        'help_text' =>'Especifique si se trata de un desembolso previsto “original” (preparado cuando se contrajo el compromiso original) o si ha sido “revisado” '
      ),
      'value' =>
      array (
        'hover_text' => 'Monto que se prevé desembolsar, en la moneda especificada. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>Más información aquí</a>.',
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras del estándar ISO 4217 correspondiente a la moneda original del monto. Es necesario para todos los montos salvo que se especifique el atributo organización-iati/@default-currency. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar la moneda en la que se ha expresado el valor. En caso de que no se seleccione ningún valor, se asume el valor predeterminado.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha en que se acordó el desembolso previsto.',
        ),
      ),
      'provider_org' =>
      array (
        'hover_text' => 'La organización que se encargará de efectuar el desembolso previsto. En caso de omitirse, se asume la organización notificadora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>Más información aquí</a>.',
        'help_text' => '¿Su organización se encargará de desembolsar los fondos? En caso afirmativo, su organización es la organización proveedora. En caso negativo, proporcione información sobre la organización que desembolsará los fondos.',
        'reference' =>
        array (
          'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. Debe tener el formato {agencia de registro}-{número de registro}. En este caso, {agencia de registro} es un código válido de la lista de códigos de la agencia de registro y {número de registro} es un identificador válido emitido por la {agencia de registro}. En caso de no estar presente, la descripción DEBE incluir el nombre de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Introduzca el <i>identificador de la IATI de la organización proveedora</i>. La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.',
        ),
        'provider_activity_id' =>
        array (
          'hover_text' => 'Identificador de la actividad en la que se informará del desembolso previsto. En caso de omitirse, se asume la actividad actual. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'La organización proveedora puede haber publicado datos de la IATI sobre estos fondos en su propia actividad. De ser así, indique el identificador para la actividad de esa organización con información sobre tales fondos. Puede consultar el identificador de la actividad a la organización proveedora o buscar la actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.<br></br>Si su organización es la proveedora, deje este apartado en blanco.',
        ),
        'type' =>
        array (
          'hover_text' => 'Tipo de organización que proporciona los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo que mejor corresponda a la organización proveedora (si no se trata de su organización). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organizaciones aquí</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Si la organización proveedora no posee un identificador de organización de la IATI, debe proporcionarse el nombre de la organización.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el idioma del nombre que se haya facilitado. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'receiving_org' =>
      array (
        'reference' =>
        array (
          'hover_text' => 'Organización que recibe el dinero del desembolso previsto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'Proporcione información sobre qué organización recibirá los fondos.',
        ),
        'receiver_activity_id' =>
        array (
          'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. Debe tener el formato {agencia de registro}-{número de registro}. En este caso, {agencia de registro} es un código válido de la lista de códigos de la agencia de registro y {número de registro} es un identificador válido emitido por la {agencia de registro}. En caso de no estar presente, la descripción DEBE incluir el nombre de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'Indique el <i>identificador de organización de la IATI</i> de la organización receptora (org-ID). La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.',
        ),
        'type' =>
        array (
          'hover_text' => 'Si los fondos salientes se destinan a otra actividad que se haya notificado a la IATI, cabe la posibilidad de que se haya registrado el identificador único de la IATI para dicha actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'De ser posible, indique el identificador para la actividad de la organización receptora que recibirá el desembolso. Puede consultar el identificador de la actividad a la organización receptora o buscar la actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Tipo de organización que recibe los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo que mejor corresponda a la organización receptora. <<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organizaciones aquí</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/narrative/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'budget' =>
    array (
      'hover_text' => 'Valor del presupuesto de la actividad para cada trimestre o ejercicio financiero a lo largo de la duración de la actividad. Este elemento tiene por objeto ofrecer previsibilidad para facilitar la planificación anual de los beneficiarios. El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/\'>Más información aquí</a>.',
      'help_text' => 'Indique el monto de la financiación que se desembolsará en el marco de esta actividad. Debe presentar el presupuesto o los presupuestos desglosados por períodos de tiempo de un año o menos, abarcando todo el ciclo de vida de la actividad. Publicar los presupuestos trimestrales puede resultar útil para los usuarios de los datos. Un presupuesto no debe abarcar más de 12 meses.<br></br>Debe presentar el presupuesto o los presupuestos para su actividad lo antes posible. Más adelante, podrá actualizarlo en función de la financiación que reciba, o si cambia el alcance de la actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>Más información aquí</a>.',
      'budget_status' =>
      array (
        'hover_text' => 'El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. El valor debería figurar en la lista de códigos de estados del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione un estado para el presupuesto en cuestión:<br></br><br>1) Indicativo</b>: una estimación no vinculante correspondiente al presupuesto descrito.<br></br><br>2) Comprometido</b>: un acuerdo vinculante correspondiente al presupuesto descrito.<br></br>Si cambia el estado del presupuesto, debe actualizarlo aquí. No debe crear un nuevo presupuesto con un estado diferente para el mismo período de tiempo. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>Más información aquí</a>.',
      ),
      'budget_type' =>
      array (
        'hover_text' =>'Si se trata del presupuesto original (preparado cuando se contrajo el compromiso original) o si ha sido revisado ',
        'help_text' => 'Seleccione el tipo de presupuesto que ha elaborado:<br></br><b>1) Original</b>: el presupuesto original que se asignó a la actividad. Elija esta opción si es la primera vez que publica información sobre este presupuesto.<br></br><b>2) Revisado</b>: el presupuesto actualizado de una actividad. Elija esta opción si está revisando su presupuesto original.<br></br>Por ejemplo, una actividad que tiene una duración de un año. El presupuesto original de dicha actividad era de 10.000 dólares, y más tarde se redujo en 2.000 dólares. Así pues, el presupuesto final para la actividad es de 8.000 dólares. Tendrá que crear dos presupuestos distintos para este período de tiempo. En primer lugar, debería añadir un presupuesto etiquetado como “original”, indicando la fecha de inicio y finalización, por valor de 10.000 dólares. Cuando se le informara de que el presupuesto se ha revisado, debería añadir otro presupuesto para las mismas fechas, denominado como “revisado”, por valor de 8.000 dólares.<br></br>Si se produjeran más cambios en el presupuesto revisado, debería modificar el valor en el presupuesto “revisado”. No debe crear presupuestos “revisados” adicionales para el mismo período de tiempo.<br></br>Por lo tanto, solo debe publicarse un presupuesto original y uno revisado para cada período de tiempo. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>Más información aquí</a>.',
      ),
      'period_start' =>
      array (
        'hover_text' => 'Inicio del período del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario.<br><br>El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-start/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha de inicio del presupuesto.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-end/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha de finalización del presupuesto.',
        ),
      ),
      'budget_value' =>
      array (
        'hover_text' => 'Presupuesto durante el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>Más información aquí</a>.',
        'help_text' => 'Indique el monto total de la financiación de este presupuesto.',
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras del estándar ISO 4217 correspondiente a la moneda original del monto. Es necesario para todos los montos salvo que se especifique el atributo organización-iati/@default-currency. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>Más información aquí</a>.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'result' =>
    array (
      'hover_text' => 'Campo para informar sobre productos, efectos, impactos y otros resultados que se derivan directamente de la actividad. Puede repetirse para cada tipo de resultado sobre el que se informa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>Más información aquí</a>.',
      'help_text' => 'Los resultados describen los beneficios o beneficios previstos de una actividad, y pueden clasificarse en tres tipos: <b>productos</b>, <b>efectos</b> e <b>impactos</b>. Puede presentar varios resultados para su actividad. Al actualizar los resultados de forma periódica, los usuarios de los datos pueden dar seguimiento al progreso de la actividad, por ejemplo, si la actividad fue exitosa o qué desafíos surgieron en el camino. Deben incluirse los resultados tanto positivos como negativos. Consulte las siguientes orientaciones: <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>”Información sobre los resultados”</a> y <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/understanding-results/\'>”Comprender los datos de los resultados”</a>.<br></br>Tenga en cuenta que, por motivos de seguridad, puede que no sea posible publicar determinados datos relativos a los resultados, o que los resultados deban estar agregados. Todas las organizaciones deberían detallar las consideraciones de seguridad en su <a href="https://iatistandard.org/en/guidance/preparing-organisation/organisation-data-publication/information-and-data-you-cant-publish-exclusions/">política de exclusión</a>.',
      'type' =>
      array (
        'hover_text' => 'Código de la IATI para el tipo de resultado que se comunica. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo de resultado que su actividad pretende conseguir o ya ha conseguido.<br></br><b>Producto</b>: resultados de la actividad que se produjeron como efecto directo de su trabajo y, en concreto, qué se ha hecho y a qué comunidades se han alcanzado. Por ejemplo, se ha conseguido capacitar a X número de personas.<br></br><b>Efecto</b>: resultados de la actividad que producen un efecto en el conjunto de las comunidades o cuestiones a las que contribuye la organización. Por ejemplo, una menor tasa de infección tras un programa de vacunación.<br></br><b>Impacto</b>: impacto a largo plazo de los efectos que conduce a resultados más amplios y globales, como una mayor esperanza de vida.<br></br><b>Otro</b>: resultados de otro tipo no especificado anteriormente.',
      ),
      'aggregation_status' =>
      array (
        'hover_text' => 'Registro para marcar si los datos del conjunto de resultados pueden agregarse. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione sí si los datos de resultados que proporciona pueden agregarse (el usuario de los datos debe poder sumarlos para obtener el total).',
      ),
      'title' =>
      array (
        'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/title/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/title/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Facilite un título para el resultado. Por ejemplo: “La población tiene acceso a medios de comunicación independientes que abarcan una amplia gama de efectos”.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción detallada y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Presente una descripción más detallada del resultado.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'document_link' =>
      array (
        'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público que proporcione información adicional sobre el resultado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar información adicional sobre el resultado adjuntando un enlace a una página web o un documento en línea de acceso público.',
        'url' =>
        array (
          'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>Más información aquí</a>.',
          'help_text' => 'Introduzca la URL del documento que proporciona información adicional sobre el resultado. Asegúrese de incluir “https://”',
        ),
        'format' =>
        array (
          'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>Más información aquí</a>.',
          'language' =>
          array (
            'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
          ),
        ),
        'description' =>
        array (
          'language' =>
          array (
            'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/category/\'>Más información aquí</a>.',
          'help_text' => 'Si ha proporcionado un enlace a un documento, seleccione la categoría que mejor describa el documento.',
          'code' =>
          array (
            'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/category/\'>Más información aquí</a>.',
            'help_text' => 'Seleccione una categoría de <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/documentcategory/\'>esta lista</a>.',
          ),
        ),
        'language' =>
        array (
          'code' =>
          array (
            'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/language/\'>Más información aquí</a>.',
          ),
        ),
      ),
      'reference' =>
      array (
        'hover_text' => 'Elemento de referencia para identificar el código que determina un marco de resultados. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>Más información aquí</a>.',
        'help_text' => 'Si este resultado está incluido en un marco de resultados, puede facilitar información al respecto. Puede aportar una referencia a un marco de resultados de dos maneras:<br></br><b>1)</b> Puede incluir una referencia a un marco de resultados aquí; O<br></br><b>2)</b> Puede incluir una referencia a un marco de resultados para cada indicador individual que mida el resultado en cuestión. Deberá presentar un indicador para cada resultado que publique (el indicador mide el resultado).<br></br><b>Se recomienda escoger la opción 2</b>. Para llevarla a la práctica, deje en blanco los tres campos siguientes: código, vocabulario, vocabulario URI.<br></br>Tenga en cuenta que no puede añadir una referencia a un marco de resultados <b>tanto para</b> el resultado como para el indicador. Para obtener más información, consulte la orientación adicional: <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>información sobre los resultados</a>.',
        'vocabulary' =>
        array (
          'hover_text' => 'Código para el vocabulario del marco de resultados. El código debe ser un valor válido de la lista de códigos de resultados del vocabulario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>Más información aquí</a>.',
        ),
        'vocabulary_uri' =>
        array (
          'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define ese vocabulario interno. Si bien este campo es opcional, se RECOMIENDA ENCARECIDAMENTE a todas las entidades que publican datos que lo utilicen para garantizar que los usuarios de datos comprendan plenamente el significado de sus códigos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'indicator' =>
    array (
      'hover_text' => 'Indicador o indicadores que se miden para cumplir los resultados. Cada resultado puede contar con varios indicadores. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>Más información aquí</a>.',
      'help_text' => '<br></br><b>Ejemplo de uso</b>: una actividad puede consistir en trabajar para la consecución del siguiente resultado: “que la población tenga acceso a medios de comunicación independientes que abarquen una amplia gama de efectos”. Una de las formas de medir los avances al respecto es determinando el “porcentaje de periodistas que sienten que son libres de expresar su opinión” (esta medida es un indicador). Para conseguirlo, se lleva a cabo una encuesta bianual en la que se pide a los periodistas que puntúen si se sienten libres en una escala de 1 a 4.<br></br>Consulte la “<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Información sobre los resultados</a>” para obtener más detalles sobre este ejemplo y “<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/understanding-results/\'>Comprender los datos de resultados</a>” para ver otros ejemplos.',
      'measure' =>
      array (
        'hover_text' => 'Código de la IATI que establece la unidad de medida en la que se presenta el valor. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione la unidad de medida del indicador:<br></br><b>Unidad</b>: el indicador se mide en unidades, por ejemplo, número de talleres llevados a cabo.<br></br><b>Porcentaje</b>: el indicador se mide en puntos porcentuales, por ejemplo, el porcentaje de la población que ha recibido una vacuna.<br></br><b>Nominal</b>: el indicador se mide en una escala nominal cuantitativa, es decir, por género, raza, etc.<br></br><b>Ordinal</b>: el indicador se mide en una escala ordinal cuantitativa, como: “muy satisfecho/a,” “satisfecho/a,” “insatisfecho/a,” y “muy insatisfecho/a”. En una escala ordinal, debemos centrarnos en el orden de las opciones de respuesta; es imposible cuantificar la diferencia exacta entre cada una de las opciones. Por ejemplo, la diferencia entre las respuestas de “muy satisfecho/a” y “satisfecho/a” es relativa, no exacta.<br></br><b>Cualitativa</b>: el indicador es cualitativo y a menudo se trata de una descripción, como detallar actitudes más favorables para fomentar la igualdad de género entre el personal capacitado.',
      ),
      'ascending' =>
      array (
        'hover_text' => 'Marcador que describe el comportamiento observado en el indicador. Se considera “verdadero” si el indicador mejora de un valor más pequeño a uno mayor (por ejemplo, el aumento de centros de salud construidos), y “falso” si mejora en el sentido inverso, de grande a pequeño (por ejemplo, la reducción de la incidencia de una enfermedad). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>Más información aquí</a>.',
        'help_text' => 'Elija una opción aquí si su indicador es una medida numérica (cuantitativa). Si un número elevado ha mejorado, seleccione el 1 (verdadero). Si un número bajo ha mejorado, seleccione el 0 (falso).',
      ),
      'aggregation_status' =>
      array (
        'hover_text' => 'Registro para marcar si los datos del conjunto de resultados pueden agregarse. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione sí si los datos de resultados que proporciona pueden agregarse (el usuario de los datos debería poder sumarlos para obtener el total).',
      ),
      'title' =>
      array (
        'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Facilite un título o una descripción del indicador. A partir del ejemplo anterior, una descripción podría ser: “Porcentaje de periodistas que sienten que son libres de expresar su opinión (puntuación de 3 o 4 en una escala de 1 a 4)”.<br></br>Consulte la <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>información sobre los resultados</a> para obtener más detalles de este ejemplo.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/narrative/\'>Más información aquí</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Fecha de publicación del documento al que se vincula (@iso-date). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/document-date/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Fecha de publicación del documento al que se vincula. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/document-date/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha de publicación del documento.',
        ),
      ),
      'document_link' =>
      array (
        'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público que proporcione información adicional sobre el resultado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar información adicional sobre el indicador del resultado adjuntando un enlace a una página web o un documento en línea de acceso público.',
        'url' =>
        array (
          'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>Más información aquí</a>.',
          'help_text' => 'Facilite el enlace al indicador del resultado concreto que se comunica. Asegúrese de incluir “https://”',
        ),
        'format' =>
        array (
          'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>Más información aquí</a>.',
          'language' =>
          array (
            'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
          ),
        ),
        'title' =>
        array (
          'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/title/\'>Más información aquí</a>.',
        ),
        'description' =>
        array (
          'language' =>
          array (
            'help_text' => 'Seleccione el idioma del texto que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/category/\'>Más información aquí</a>.',
          'help_text' => 'Si ha proporcionado un enlace a un documento, seleccione la categoría que mejor describa el documento.',
          'code' =>
          array (
            'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/category/\'>Más información aquí</a>.',
          ),
        ),
        'language' =>
        array (
          'code' =>
          array (
            'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/language/\'>Más información aquí</a>.',
          ),
        ),
      ),
      'reference' =>
      array (
        'hover_text' => 'Elemento de referencia para identificar el código que determina un marco de resultados. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>Más información aquí</a>.',
        'help_text' => 'Si el indicador que comunica se incluye en un marco de resultados existente, facilite información al respecto aquí.',
        'vocabulary' =>
        array (
          'hover_text' => 'Código para el vocabulario del marco de resultados. El código debe ser un valor válido de la lista de códigos de resultados del vocabulario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el marco de resultados que incluye su indicador. Si el marco de resultados en cuestión no figura en la lista, seleccione la opción 99 (organización notificadora).',
        ),
        'indicator_uri' =>
        array (
          'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define ese vocabulario interno. Si bien este campo es opcional, se RECOMIENDA ENCARECIDAMENTE a todas las entidades que publican datos que lo utilicen para garantizar que los usuarios de datos comprendan plenamente el significado de sus códigos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>Más información aquí</a>.',
          'help_text' => 'Si ha seleccionado un marco de resultados, adjunte un enlace a dicho marco. Si seleccionó la opción 99 (organización notificadora), se recomienda que incluya un enlace a la lista de códigos aquí. Esto ayuda a garantizar que los usuarios comprendan el significado del código.',
        ),
      ),
      'baseline' =>
      array (
        'hover_text' => 'Valor de referencia para el indicador. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>Más información aquí</a>.',
        'help_text' => 'Para cada indicador, facilite un valor de referencia, un objetivo y el resultado real que se alcanzó. El valor de referencia constituye el punto de partida. El objetivo es un resultado que una organización aspira a lograr con una actividad en un período determinado. El resultado real es aquello que se ha logrado al finalizar dicho período.<br><br>Por ejemplo: Según el valor inicial (valor de referencia) el 15% de los periodistas sentían que tenían la libertad de expresar sus opiniones. El objetivo que se fijó para el final del período en cuestión era del 50%. La actividad logró su objetivo, puesto que para el final del período (real) el 53% de los periodistas sentían que tenían la libertad de expresar sus opiniones.<br><br>Véanse las páginas “<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Información sobre los resultados</a>” para conocer más detalles sobre este ejemplo y “<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/understanding-results/\'>Comprender los datos de los resultados</a>” para obtener ejemplos adicionales.',
        'year' =>
        array (
          'hover_text' => 'Año en que se obtuvo el valor de referencia (aaaa). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>Más información aquí</a>.',
          'help_text' => 'Indique el año en que se midió el valor de referencia del indicador.',
        ),
        'date' =>
        array (
          'hover_text' => 'Fecha en que se obtuvo el valor de referencia. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha en que se midió el valor de referencia del indicador.',
        ),
        'value' =>
        array (
          'hover_text' => 'Valor de referencia. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>Más información aquí</a>.',
          'help_text' => 'Facilite el valor de referencia. Por ejemplo, si el valor de referencia es “15%”, simplemente introduzca “15” (puesto que ya ha indicado la unidad de medida anteriormente).<br></br>Deje este apartado en blanco si este indicador utiliza una medida cualitativa (y añada su valor de referencia en el campo de comentarios que aparece a continuación).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Comentario legible para los seres humanos en relación con información sobre la ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/202/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/\'>Más información aquí</a>.',
          'narrative' =>
          array (
            'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/comment/narrative/\'>Más información aquí</a>.',
            'help_text' => 'Si el indicador es una medida cualitativa, puede describir el valor de referencia aquí.<br></br>También puede añadir información descriptiva sobre dicho valor aquí. Por ejemplo: “Valor de referencia extraído de una encuesta en la que participaron 1083 periodistas en el país X”',
          ),
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/comment/narrative/\'>Más información aquí</a>.',
          ),
        ),
        'dimension' =>
        array (
          'hover_text' => 'Categoría utilizada para desglosar el resultado por género, edad, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>Más información aquí</a>.',
          'help_text' => 'Recuerde: Un valor de referencia puede tener múltiples dimensiones.',
          'name' =>
          array (
            'hover_text' => 'Descripción libre de la categoría que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>Más información aquí</a>.',
            'help_text' => 'Por ejemplo, podría asignarse como nombre de la dimensión “sexo” con un valor “femenino”.',
          ),
          'value' =>
          array (
            'hover_text' => 'Descripción del valor que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>Más información aquí</a>.',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público que proporcione información adicional sobre el resultado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>Más información aquí</a>.',
          'help_text' => 'Puede proporcionar información adicional sobre el valor de referencia del indicador adjuntando un enlace a una página web o un documento en línea de acceso público.',
          'url' =>
          array (
            'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>Más información aquí</a>.',
            'help_text' => 'Introduzca la URL del documento que proporciona información adicional sobre el valor de referencia del indicador. Asegúrese de incluir “https://”',
          ),
          'format' =>
          array (
            'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>Más información aquí</a>.',
          ),
          'title' =>
          array (
            'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/narrative/\'>Más información aquí</a>.',
            ),
            'language' =>
            array (
              'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/narrative/\'>Más información aquí</a>.',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/narrative/\'>Más información aquí</a>.',
            ),
            'language' =>
            array (
              'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/narrative/\'>Más información aquí</a>.',
            ),
          ),
          'category' =>
          array (
            'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/category/\'>Más información aquí</a>.',
            'code' =>
            array (
              'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/category/\'>Más información aquí</a>.',
            ),
          ),
          'language' =>
          array (
            'code' =>
            array (
              'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/language/\'>Más información aquí</a>.',
            ),
          ),
        ),
        'location' =>
        array (
          'hover_text' => 'Ubicación que ya se ha definido y descrito en el elemento actividad-iati/ubicación. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/location/\'>Más información aquí</a>.',
          'reference' =>
          array (
            'hover_text' => 'Mención de la referencia interna asignada a una ubicación definida: actividad-iati/ubicación/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/location/\'>Más información aquí</a>.',
          ),
        ),
      ),
    ),
    'period' =>
    array (
      'hover_text' => 'Período que abarcan los resultados proporcionados. Se pueden indicar varios períodos para un mismo indicador. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/\'>Más información aquí</a>.',
      'help_text' => 'Cada indicador puede tener un período determinado con fechas de inicio y finalización. Corresponde al período en que se mide el indicador, por ejemplo, la temporada agrícola o el curso escolar.',
      'target' =>
      array (
        'hover_text' => 'Hito del objetivo para este período. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/\'>Más información aquí</a>.',
        'help_text' => 'El objetivo es un resultado que una organización aspira a lograr con una actividad en un período determinado.',
        'value' =>
        array (
          'hover_text' => 'Valor del objetivo. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/\'>Más información aquí</a>.',
          'help_text' => 'Indique el valor del objetivo si su indicador es una medida numérica (cuantitativa), por ejemplo, si se mide en unidades o porcentajes.<br></br>Deje este apartado en blanco si este indicador utiliza una medida cualitativa (y añada su objetivo en el campo de comentarios que aparece a continuación).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Comentario legible para los seres humanos en relación con información sobre la ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/\'>Más información aquí</a>.',
          'help_text' => 'Si el indicador es una medida cualitativa, puede describir el objetivo aquí.<br></br>También puede añadir información descriptiva sobre dicho objetivo aquí.',
          'narrative' =>
          array (
            'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/narrative/\'>Más información aquí</a>.',
          ),
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/narrative/\'>Más información aquí</a>.',
          ),
        ),
        'dimension' =>
        array (
          'name' =>
          array (
            'hover_text' => 'Descripción libre de la categoría que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/dimension/\'>Más información aquí</a>.',
          ),
          'value' =>
          array (
            'hover_text' => 'Descripción del valor que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/dimension/\'>Más información aquí</a>.',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público que proporcione información adicional sobre el resultado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>Más información aquí</a>.',
          'help_text' => 'Puede proporcionar información adicional sobre el objetivo del indicador adjuntando un enlace a una página web o un documento en línea de acceso público.',
          'url' =>
          array (
            'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>Más información aquí</a>.',
            'help_text' => 'Introduzca la URL del documento que proporciona información adicional sobre el objetivo del indicador. Asegúrese de incluir “https://”',
          ),
          'format' =>
          array (
            'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>Más información aquí</a>.',
          ),
          'title' =>
          array (
            'hover_text' => 'Título conciso, legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/narrative/\'>Más información aquí</a>.',
            ),
            'language' =>
            array (
              'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/narrative/\'>Más información aquí</a>.',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/narrative/\'>Más información aquí</a>.',
            ),
            'language' =>
            array (
              'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/narrative/\'>Más información aquí</a>.',
            ),
          ),
          'category' =>
          array (
            'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/category/\'>Más información aquí</a>.',
            'code' =>
            array (
              'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/category/\'>Más información aquí</a>.',
            ),
          ),
          'language' =>
          array (
            'hover_text' => 'Código del idioma en que se redactó el documento de destino según la norma ISO 639-1, por ejemplo, “en”. Puede repetirse para describir documentos multilingües. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/language/\'>Más información aquí</a>.',
            'language' =>
            array (
              'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/language/\'>Más información aquí</a>.',
            ),
          ),
          'location' =>
          array (
            'reference' =>
            array (
              'hover_text' => 'Mención de la referencia interna asignada a una ubicación definida: actividad-iati/ubicación/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/location/\'>Más información aquí</a>.',
            ),
          ),
        ),
      ),
      'actual' =>
      array (
        'hover_text' => 'Registro del resultado logrado durante el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/\'>Más información aquí</a>.',
        'help_text' => 'La medida real representa el resultado logrado al finalizar dicho período.',
        'value' =>
        array (
          'hover_text' => 'Medida real. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/\'>Más información aquí</a>.',
          'help_text' => 'Indique el valor real obtenido si su indicador es una medida numérica (cuantitativa), por ejemplo, si se mide en unidades o porcentajes.<br></br>Deje este apartado en blanco si este indicador utiliza una medida cualitativa (y añada su valor real en el campo de comentarios que aparece a continuación).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Comentario legible para los seres humanos en relación con información sobre la ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/\'>Más información aquí</a>.',
          'help_text' => 'Si el indicador es una medida cualitativa, puede describir el resultado real aquí.<br></br>También puede añadir información descriptiva sobre el resultado real aquí.',
          'narrative' =>
          array (
            'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/narrative/\'>Más información aquí</a>.',
          ),
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/narrative/\'>Más información aquí</a>.',
          ),
        ),
        'dimension' =>
        array (
          'hover_text' => 'Categoría utilizada para desglosar el resultado por género, edad, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>Más información aquí</a>.',
          'name' =>
          array (
            'hover_text' => 'Descripción libre de la categoría que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>Más información aquí</a>.',
          ),
          'value' =>
          array (
            'hover_text' => 'Descripción del valor que se desglosa. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>Más información aquí</a>.',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Enlace a una página web o a un documento en línea de acceso público que proporcione información adicional sobre el resultado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>Más información aquí</a>.',
          'help_text' => 'Puede proporcionar información adicional sobre el valor o resultado real adjuntando un enlace a una página web o un documento en línea de acceso público.',
          'url' =>
          array (
            'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>Más información aquí</a>.',
            'help_text' => 'Introduzca la URL del documento que proporciona información adicional sobre el valor o resultado real. Asegúrese de incluir “https://”',
          ),
          'format' =>
          array (
            'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>Más información aquí</a>.',
          ),
          'title' =>
          array (
            'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/narrative/\'>Más información aquí</a>.',
              'help_text' => 'En caso de proporcionar un enlace a un documento, aporte el título del documento',
            ),
            'language' =>
            array (
              'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/narrative/\'>Más información aquí</a>.',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/\'>Más información aquí</a>.',
            'narrative' =>
            array (
              'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/narrative/\'>Más información aquí</a>.',
            ),
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/category/\'>Más información aquí</a>.',
          'code' =>
          array (
            'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/category/\'>Más información aquí</a>.',
          ),
        ),
        'language' =>
        array (
          'hover_text' => 'Código del idioma en que se redactó el documento de destino según la norma ISO 639-1, por ejemplo, “en”. Puede repetirse para describir documentos multilingües. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/language/\'>Más información aquí</a>.',
          'language' =>
          array (
            'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/language/\'>Más información aquí</a>.',
          ),
        ),
        'document_date' =>
        array (
          'hover_text' => 'Fecha de publicación del documento al que se vincula. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/document-date/\'>Más información aquí</a>.',
          'date' =>
          array (
            'hover_text' => 'Fecha de publicación del documento al que se vincula. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/document-date/\'>Más información aquí</a>.',
          ),
        ),
      ),
      'location' =>
      array (
        'reference' =>
        array (
          'hover_text' => 'Mención de la referencia interna asignada a una ubicación definida: actividad-iati/ubicación/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/location/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'transactions' =>
    array (
      'hover_text' => 'Transacciones que indican los fondos comprometidos o recibidos que entran o salen de una actividad de ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>Más información aquí</a>.',
      'help_text' => 'Facilite un registro sobre cómo se financia la actividad y cómo se utiliza la financiación. Cada uno de los fondos entrantes y salientes debería publicarse como transacción.<br></br> Si una organización efectúa un gran número de pequeñas transacciones, puede agruparlas. Por ejemplo, todos los costos de viaje correspondientes a un mes pueden publicarse como una única transacción de gastos. A la hora de decidir si agregar transacciones (o cómo hacerlo), se recomienda que las entidades que publican tengan en cuenta las necesidades de los usuarios de los datos, ya que agregar en exceso puede dificultar el uso de los datos.<br></br>Tenga presente que no debe agrupar flujos de fondos dirigidos a varias organizaciones externas o que provengan de ellas (por ejemplo, un desembolso a CARE no debe combinarse con un desembolso a IRC). <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/financial-transactions/\'>Orientaciones sobre la publicación de transacciones financieras</a>.',
      'reference' =>
      array (
        'hover_text' => 'Referencia interna que vincula esta transacción con el sistema de gestión financiera de la entidad que publica. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>Más información aquí</a>.',
        'help_text' => 'Puede aportar una referencia que utilice para identificar esta transacción en el sistema interno de gestión financiera de su organización.',
      ),
      'humanitarian' =>
      array (
        'hover_text' => 'Atributo para señalizar que esta transacción está relacionada total o parcialmente con la ayuda humanitaria. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>Más información aquí</a>.',
        'help_text' => '<p>Puede marcar que la transacción está relacionada con la ayuda humanitaria seleccionando “sí”.</p><p>Si la totalidad de la actividad está relacionada con la ayuda humanitaria, debería seleccionar sí mediante el atributo de actividad humanitaria de la IATI, en lugar de hacerlo para cada transacción.</p><p>Ver <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/humanitarian/\'>las orientaciones sobre todas las formas de publicar datos humanitarios</a></p>.',
      ),
      'transaction_type' =>
      array (
        'hover_text' => 'Tipo de transacción (por ejemplo, compromiso, desembolso, gasto, etc.). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-type/\'>Más información aquí</a>.',
        'help_text' => 'Elija el tipo de transacción que mejor refleja el flujo de dinero entrante y saliente de la actividad. Los distintos tipos de transacciones incluyen los fondos recibidos, los compromisos salientes, los desembolsos o los gastos.',
        'transaction_type_code' =>
        array (
          'hover_text' => 'Código del vocabulario específico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-type/\'>Más información aquí</a>.',
          'help_text' => 'Indique el tipo de transacción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/transactiontype/\'>Consulte descripciones de todas las opciones.</a>',
        ),
      ),
      'transaction_date' =>
      array (
        'hover_text' => 'Fecha en que la actividad se completó o (para compromisos) se acordó. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-date/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-date/\'>Más información aquí</a>.',
          'help_text' => 'Indicar la fecha en que la actividad se completó o (para compromisos) se acordó.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Monto de la contribución. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/value/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda.',
          'help_text' => 'Esta fecha no debe ser una fecha futura.',
        ),
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/value/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar la moneda de esta transacción.</br>El valor debe figurar en la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/Currency/\'>lista de códigos de moneda</a>.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción de la transacción legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/\'>Más información aquí</a>.',
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Describir brevemente la transacción, por ejemplo, por qué se llevó a cabo.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'provider_organization' =>
      array (
        'hover_text' => 'En el caso de los fondos recibidos, se refiere a la organización que efectuó el desembolso. En caso de omitirse los fondos salientes, se asume la organización notificadora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
        'help_text' => 'Para cada transacción, se recomienda especialmente publicar información tanto sobre la organización proveedora de los fondos como sobre la organización receptora. Ello incluye los casos en los que su organización ha sido la proveedora o la receptora.<br></br>Si no proporciona información sobre la organización proveedora de las transacciones entrantes, se asume que su organización es la proveedora de los fondos.',
        'organization_identifer_code' =>
        array (
          'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Introduzca el identificador de la IATI de la organización proveedora. La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.<br></br>Si su organización es la proveedora, introduzca su identificador de organización de la IATI. Su organización creó su identificador de organización cuando se registró como entidad que publica de conformidad con la IATI. Puede consultarlo aquí.',
        ),
        'provider_activity_id' =>
        array (
          'hover_text' => 'Si los fondos entrantes provienen del presupuesto de otra actividad que se haya notificado a la IATI, se RECOMIENDA ENCARECIDAMENTE registrar el identificador único de la IATI para esa actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'La organización proveedora puede haber publicado datos de la IATI sobre estos fondos en su propia actividad. De ser así, indique el identificador para la actividad de esa organización con información sobre tales fondos. Puede consultar el identificador de la actividad a la organización proveedora o buscar la actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.<br></br>Si su organización es la proveedora, deje este apartado en blanco.',
        ),
        'type' =>
        array (
          'hover_text' => 'Tipo de organización que proporciona los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo que mejor describa la organización proveedora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organización</a>. <br><br>Si su organización es la proveedora, seleccione el tipo de organización que se indicó cuando fue registrada. Puede consultarlo aquí.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Si la organización proveedora no posee un identificador de organización de la IATI, debe proporcionar el nombre en texto de la organización.<br></br><b>No indique un código para la organización proveedora.</b>',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <br></br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'receiver_organization' =>
      array (
        'hover_text' => 'Organización que recibe el dinero de la transacción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>Más información aquí</a>.',
        'help_text' => 'Indique la organización que recibirá/ha recibido los fondos como parte de esta transacción. Si su organización es la receptora, proporcione los datos de esta.',
        'organization_identifier_code' =>
        array (
          'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'Indique el identificador de organización de la IATI de la organización receptora (org-ID). La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.<br></br>Si su organización es la receptora, introduzca su identificador de organización de la IATI (org-ID). Su organización creó su identificador de organización cuando se registró como entidad que publica de conformidad con la IATI. Puede consultarlo aquí.',
        ),
        'receiver_activity_id' =>
        array (
          'hover_text' => 'Si los fondos salientes se destinan a otra actividad que se haya notificado a la IATI, cabe la posibilidad de que se haya registrado el identificador único de la IATI para dicha actividad. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'La organización receptora puede haber publicado datos de la IATI sobre los fondos entrantes en su propia actividad. De ser así, indique el identificador para la actividad de esa organización con información sobre tales fondos. Puede consultar el identificador de la actividad a la organización receptora o buscar su actividad en d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Orientación adicional aquí</a>.<br></br>Si su organización es la proveedora, deje este apartado en blanco.',
        ),
        'type' =>
        array (
          'hover_text' => 'Tipo de organización que recibe los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo que mejor describa la organización receptora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organización<br></a>.</br>Si su organización es la receptora, seleccione el tipo de organización que esta indicó cuando se registró. Puede consultarlo aquí.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Si la organización receptora no posee un identificador de organización de la IATI, debe proporcionar el nombre de la organización.<br></br><b>No indique un código para la organización receptora.</b>',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'disbursement_channel' =>
      array (
        'hover_text' => 'Canal a través del cual se distribuirán los fondos para esta transacción, a partir de una lista de códigos de la IATI. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/disbursement-channel/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione la mejor opción para canalizar los desembolsos (p. ej., a través del gobierno receptor o sin contar con el gobierno receptor).',
        'disbursement_channel_code' =>
        array (
          'hover_text' => 'Código de la IATI que define los canales de desembolso. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/disbursement-channel/\'>Más información aquí</a>.',
          'help_text' => 'En la lista de <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/disbursementchannel/\'>canales de desembolso</a> puede elegir la opción que mejor se ajuste a esta transacción (en su caso).',
        ),
        'sector' =>
        array (
          'hover_text' => 'Código reconocido, de un vocabulario reconocido, que clasifique el propósito de esta transacción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
          'help_text' => 'Puede especificar <b>un</b> sector que se apoye con esta transacción. Por ejemplo, educación primaria o agricultura. En ese caso, debe especificar un sector para <b><u>cada</u></b> transacción que publique.</br>No <b><u>debería</u></b> especificar un sector para ninguna de sus transacciones si desea proporcionar datos sobre el sector o los sectores para la totalidad de la actividad (que puede publicar aquí). <b>Solo deben proporcionarse los sectores a nivel de la actividad o de la transacción, pero <u>no ambos</u></b>.</br>Cuando su organización decida dónde publicar la información sobre los sectores en los que trabaja, debe ser coherente en todas las actividades durante la publicación. Por lo tanto, debería publicar toda la información sobre los sectores a nivel de actividad o para todas las transacciones. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>Más información aquí</a>.',
          'sector_vocabulary' =>
          array (
            'hover_text' => 'Código de la IATI para el vocabulario (véase la lista de códigos) utilizado para las clasificaciones de los sectores. En caso de omitirse, se asumen los códigos de finalidad de cinco dígitos del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Si decide publicar el sector que se apoya con esta operación, deberá elegir una lista de sectores. La IATI recomienda elegir la lista de códigos de sectores de cinco dígitos del CAD de la OCDE, en la que puede realizar su selección de entre <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sector/\'>más de 300 sectores</a>.<br></br>Puede optar por una lista diferente (ver el siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sectorvocabulary/\'>información sobre todas las opciones posibles</a>). Si desea utilizar una lista propia de su organización de clasificaciones internas de sectores, seleccione la opción “organización notificadora”.<br></br>Puede optar por utilizar varias listas. Si utiliza más de una clasificación de sectores interna, seleccione “organización notificadora 2” (código 98) para la lista adicional. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>Orientación adicional aquí</a>.<br></br><b>No seleccione una lista si ha elegido/elegirá una lista de sectores para la totalidad de la actividad.</b>',
          ),
          'vocabulary_uri' =>
          array (
            'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 o 98 (organización notificadora), el URI donde se define este vocabulario interno. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Si ha optado por una lista de códigos de clasificación de sectores interna, adjunte un enlace a dicha lista.',
          ),
          'code' =>
          array (
            'hover_text' => 'Código del sector. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el sector que se apoya con los fondos de la transacción. Elija únicamente <b>un sector</b> de cada lista que utilice.',
          ),
          'text' =>
          array (
            'hover_text' => 'Código del sector. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el sector que se apoya con los fondos de la transacción. Elija únicamente <b>un sector</b> de cada lista que utilice.',
          ),
          'category_code' =>
          array (
            'hover_text' => 'Código del sector. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el sector que se apoya con los fondos de la transacción. Elija únicamente <b>un sector</b> de cada lista que utilice.',
          ),
          'sdg_goal' =>
          array (
            'hover_text' => 'Código del sector. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el sector que se apoya con los fondos de la transacción. Elija únicamente <b>un sector</b> de cada lista que utilice.',
          ),
          'sdg_target' =>
          array (
            'hover_text' => 'Código del sector. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el sector que se apoya con los fondos de la transacción. Elija únicamente <b>un sector</b> de cada lista que utilice.',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Descripción de un sector definido por la organización notificadora (ha de usarse únicamente cuando se aplique el propio vocabulario de la organización notificadora). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Si ha elegido el sector de una lista de códigos de clasificación de sectores interna, presente una descripción de este.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'País que se beneficiará con la transacción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/\'>Más información aquí</a>.',
        'help_text' => 'Puede especificar <b>un</b> país o una región donde se lleve a cabo una transacción individual, o la ubicación que se beneficiará con ello.<br></br>No <b><u>debería</u></b> especificar un país o una región para ninguna de sus transacciones si desea indicar el país o la región receptores de la totalidad de la actividad (que puede publicar aquí). <b>Solo deben indicarse los países o las regiones receptores a nivel de la actividad o de la transacción, pero no ambos.</b><br></br>Cuando su organización decida dónde publicar la información sobre sus países (o regiones) receptores, debe ser coherente en todas las actividades durante la publicación. Por lo tanto, debería publicar toda la información sobre el país o la región receptores a nivel de actividad o para todas las transacciones. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Más información aquí</a>.',
        'country_code' =>
        array (
          'hover_text' => 'Código de dos letras del país según la norma ISO 3166-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar <b>un</b> país en el que se lleve a cabo esta transacción o que se beneficiará con los fondos de la transacción.<br></br><b>No seleccione un país si ha elegido/elegirá un país receptor para la totalidad de la actividad.</b>',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Añada el nombre o la descripción libre del país beneficiario de la actividad.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'recipient_region' =>
      array (
        'hover_text' => 'Región geopolítica supranacional que se beneficiará con esta transacción. Si no se conoce el país concreto, DEBE utilizarse este elemento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>Más información aquí</a>.',
        'help_text' => 'Si no puede identificar el país específico beneficiario de esta transacción, puede indicar la región receptora en su lugar. <b>No indique un país receptor y una región receptora.</b><br></br><br><br>Por ejemplo, si la financiación se destina a Uganda, debería registrar Uganda como país receptor, y no debería añadirse que la financiación va dirigida a la región de África.',
        'region_vocabulary' =>
        array (
          'hover_text' => 'Código de la IATI para el vocabulario del que se extrae el código de la región. Si no está presente, se asume 1 - “CAD de la OCDE”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>Más información aquí</a>.',
          'help_text' => 'Existen dos listas de regiones; la lista de códigos del CAD de la OCDE y la lista de códigos de regiones de las Naciones Unidas. Seleccione una opción. La IATI recomienda utilizar <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/region/\'>la lista de códigos del CAD de la OCDE</a>. De lo contrario, puede utilizar otra lista de regiones seleccionando la opción “organización notificadora” e indicando el URI en el que se define esta lista interna. Si no elige ninguna opción, se asume la lista de códigos “CAD de la OCDE”.',
        ),
        'region_code' =>
        array (
          'hover_text' => 'Código de región de las Naciones Unidas o del CAD de la OCDE. La lista de códigos se determina a través del atributo de vocabulario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione la región que se beneficia con esta transacción.',
        ),
        'custom_code' =>
        array (
          'hover_text' => 'Código de región de las Naciones Unidas o del CAD de la OCDE. La lista de códigos se determina a través del atributo de vocabulario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione la región que se beneficia con esta transacción.',
        ),
        'vocabulary_uri' =>
        array (
          'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define este vocabulario interno. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>Más información aquí</a>.',
          'help_text' => 'Si ha seleccionado la opción “organización notificadora” indique el URI en el que se define esta lista interna.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Descripción de un sector definido por la organización notificadora (ha de usarse únicamente cuando se aplique el propio vocabulario de la organización notificadora). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Si ha seleccionado la opción “organización notificadora” añada el nombre y/o la descripción libre para la región beneficiaria de la actividad.',
          'language' =>
          array (
            'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>Más información aquí</a>.',
            'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
          ),
        ),
      ),
      'flow_type' =>
      array (
        'hover_text' => 'Elemento opcional para modificar el elemento de nivel superior del tipo de flujo predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/flow-type/\'>Más información aquí</a>.',
        'help_text' => 'El tipo de flujo constituye otra forma de clasificar los flujos financieros. Los flujos se clasifican como sigue: asistencia oficial para el desarrollo, otros aportes del sector público, o varios tipos de flujos privados, incluidas las subvenciones privadas que por lo general proporcionan las ONG y otras organizaciones de la sociedad civil.',
        'flow_type' =>
        array (
          'hover_text' => 'Código de la lista de códigos para tipos de flujos del CRS del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/flow-type/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione un tipo de flujo para esta transacción de entre <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/FlowType/\'>las siguientes opciones</a>.<br></br>Tenga en cuenta que si selecciona un tipo de flujo para esta transacción se modificará el <b>tipo de flujo por defecto</b> para la totalidad de la actividad (que se establece aquí), lo que le permite elegir un tipo de flujo para cada transacción, de ser necesario.',
        ),
      ),
      'finance_type' =>
      array (
        'hover_text' => 'Elemento opcional para modificar el elemento de nivel superior del tipo de financiación predeterminado para cada transacción, de ser necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/finance-type/\'>Más información aquí</a>.',
        'help_text' => 'En el tipo de financiación se establece el instrumento financiero que se utiliza. Por ejemplo, lo más habitual es que la financiación se entregue como subvención o préstamo.',
        'finance_type' =>
        array (
          'hover_text' => 'Código de la lista de códigos para tipos de financiación del CRS del CAD de la OCDE. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/finance-type/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione un tipo de financiación para esta transacción de entre <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/financetype/\'>las siguientes opciones</a>.<br></br>Tenga en cuenta que, si selecciona un tipo de financiación para esta transacción, se modificará el <b>tipo de financiación por defecto</b> para la totalidad de la actividad (que se establece aquí), lo que le permite elegir un tipo de financiación para cada transacción, de ser necesario.',
        ),
      ),
      'aid_type' =>
      array (
        'hover_text' => 'Elemento opcional para modificar el elemento de nivel superior del tipo de ayuda predeterminado (alivio de la deuda, etc.) para cada transacción, de ser necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
        'help_text' => 'Puede proporcionar información sobre el tipo de ayuda que se entrega. Por lo general, a esto se le conoce como la modalidad de la ayuda. La IATI recomienda seleccionar un tipo de ayuda de la lista de códigos del CAD de la OCDE para todas las actividades. Entre algunos ejemplos de esta lista de códigos cabe destacar: intervenciones a nivel de los proyectos que respaldan un proyecto particular, o el apoyo presupuestario, que es una contribución financiera al presupuesto de un gobierno receptor. Las intervenciones a nivel de los proyectos son el tipo de ayuda más común para las ONG y las OSC, pero existen muchas otras opciones <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>aquí</a>.<br></br>Si su transacción se dirige a un evento humanitario, puede facilitar información específica sobre el tipo de fondos con este fin. Lo anterior implica presentar información sobre el nivel de especificidad de los fondos de la transacción y especificar si la transacción está proporcionando fondos mediante efectivo o vales. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/humanitarian/\'> <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/humanitarian/\'>Más información sobre la publicación de los tipos de ayuda relacionados con las actividades humanitarias aquí</a>.<br></br>Tenga en cuenta que, si selecciona un tipo de ayuda para esta transacción, se modificará el tipo de ayuda por defecto para la totalidad de la actividad (que se establece aquí), lo que le permite elegir un tipo de ayuda para cada transacción, de ser necesario.',
        'aid_type_vocabulary' =>
        array (
          'hover_text' => 'Código para las clasificaciones del vocabulario del elemento tipo-ayuda. De omitirse, se asume la lista de códigos de tipos de ayuda (CAD de la OCDE). El código debe ser un valor válido de la lista de códigos del vocabulario de tipo de ayuda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione una lista que incluya el elemento tipo-ayuda relacionado con su transacción. Tiene la posibilidad de seleccionar el elemento tipo-ayuda de más de una lista.<br></br><b>1. CAD de la OCDE</b>: la IATI le recomienda que opte por esta lista en la que figuran <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>más de 20 opciones</a>. Posteriormente, podrá, además, seleccionar una opción de otra lista.<br></br><b>2. Categoría de asignación de fondos:</b> seleccione <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/earmarkingcategory/\'>esta lista</a> para clasificar el nivel de flexibilidad de la financiación humanitaria. Existen cuatro categorías de asignación de fondos. Puede conocer más sobre las categorías en el <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>Anexo 1.</a><br></br><b>3. Modalidad de asignación de fondos:</b> utilice esta lista para elegir la modalidad de asignación específica que explica la financiación humanitaria de su actividad. Todas las opciones de modalidades de asignación de fondos se <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>enumeran en el Anexo 1.<br><br></a><b>4. Modalidades de asistencia en efectivo y mediante vales:</b> seleccione esta lista para especificar si su transacción da respuesta a un evento humanitario prestando asistencia en efectivo y mediante vales. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/CashandVoucherModalities/\'>Más información aquí</a>.',
        ),
        'aid_type_code' =>
        array (
          'hover_text' => 'Código del vocabulario específico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el tipo de ayuda relacionado con su transacción.',
        ),
        'earmarking_category' =>
        array (
          'hover_text' => 'Código del vocabulario específico. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Descripción de un sector definido por la organización notificadora (ha de usarse únicamente cuando se aplique el propio vocabulario de la organización notificadora). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Si ha seleccionado la opción “organización notificadora” añada el nombre y/o la descripción libre para la región beneficiaria de la actividad.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el idioma del texto de la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
        ),
      ),
      'earmarking_modality' =>
      array (
        'hover_text' => 'Código del vocabulario específico. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
      ),
      'cash_and_voucher_modalities' =>
      array (
        'hover_text' => 'Código del vocabulario específico. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>Más información aquí</a>.',
      ),
      'tied_status' =>
      array (
        'hover_text' => 'Elemento opcional para modificar el elemento de nivel superior del estado de condicionamiento predeterminado para cada transacción, de ser necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/\'>Más información aquí</a>.',
        'help_text' => 'Puede indicar el estado de condicionamiento de esta transacción. En este apartado puede indicar si los fondos están condicionados, es decir, si deben destinarse a la adquisición de bienes o servicios de un país concreto (país donante) o un grupo de países; o si los fondos no están condicionados, que es el caso en que la organización receptora puede adquirirlos de cualquier país.<br></br>Tenga en cuenta que si selecciona un estado de condicionamiento para esta transacción, se modificará <b>el estado de condicionamiento predeterminado</b> para la totalidad de la actividad (que se establece aquí), lo que le permite elegir un estado de condicionamiento para cada transacción, de ser necesario.',
      ),
      'tied_status_code' =>
      array (
        'hover_text' => 'Código de la IATI que explica el uso de las columnas 36 a 38 del formato de presentación de informes CRS++. (Monto condicionado, monto parcialmente condicionado, monto no condicionado). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/tied-status/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione un estado de condicionamiento predeterminado si se aplica a su transacción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tiedstatus/\'>Descripciones de todas las opciones</a>. De lo contrario, deje este apartado en blanco.',
      ),
    ),
  ),
  'organisation' =>
  array (
    'organisation_identifier' =>
    array (
      'hover_text' => 'El identificador de la organización es un código único correspondiente a su organización. Se genera a partir de la agencia de registro y el número de registro de la organización. Para obtener más información, consulte cómo crear su identificador de organización de la IATI. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/organisation-identifier/\'>Más información aquí</a>.',
      'organization_country' =>
      array (
        'hover_text' => 'Seleccione la ubicación de su organización.',
        'help_text' => 'Indique el país en el que se ubica su organización.',
      ),
      'organization_registration_agency' =>
      array (
        'hover_text' => 'Seleccione la agencia de su país en la que está registrada su organización. Si no conoce esta información, escriba a la siguiente dirección de correo electrónico: support@iatistandard.org.',
        'help_text' => 'Proporcione el nombre de la agencia de su país en la que está registrada su organización. Si no conoce esta información, escriba a la siguiente dirección de correo electrónico: support@iatistandard.org.',
      ),
      'registration_number' =>
      array (
        'hover_text' => 'Indique el número de registro de su organización facilitado por la agencia de registro. Si no lo conoce, escriba a la siguiente dirección de correo electrónico: support@iatistandard.org.',
        'help_text' => 'Indique el número de registro de su organización facilitado por la agencia de registro seleccionada en el campo anterior. Si no conoce esta información, escriba a la siguiente dirección de correo electrónico: support@iatistandard.org.',
      ),
      'iati-activity-identifier' =>
      array (
        'hover_text' => 'El identificador de la organización es un código único correspondiente a su organización. Se genera a partir de la agencia de registro y el número de registro de la organización. Para obtener más información, consulte cómo crear su identificador de organización de la IATI. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/organisation-identifier/\'>Más información aquí</a>.',
        'help_text' => 'El identificador de la organización (org-ID) es un código único correspondiente a su organización. Se genera a partir de la agencia de registro y el número de registro de la organización. Para más información, consulte aquí <a target=\'_blank\' href=\'http://iatistandard.org/en/guidance/preparing-organisation/organisation-account/how-to-create-your-iati-organisation-identifier/\'>cómo crear su identificador de organización de la IATI</a>.',
      ),
    ),
    'name' =>
    array (
      'hover_text' => 'Nombre de la organización legible para los seres humanos.',
      'narrative' =>
      array (
        'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/name/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Indique el nombre de su organización.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/name/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el idioma que facilitó en la descripción. Si no se selecciona ningún idioma, se asume el idioma predeterminado.',
      ),
    ),
    'reporting_org' =>
    array (
      'hover_text' => 'Organización que presenta el informe. Puede ser la fuente principal (que informa sobre sus propias actividades como donante, organismo de ejecución, etc.) o una fuente secundaria (que informa sobre las actividades de otra organización). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
      'help_text' => 'Debe especificar la organización que publica el archivo y la organización de la que tratan los datos. En la mayoría de los casos, la organización encargada de la publicación publica datos sobre sí misma. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-participants/\'>Orientación adicional aquí</a>.',
      'reference' =>
      array (
        'hover_text' => 'Cadena de identificación legible por computadora para la organización que presenta el informe. Debe tener el formato {agencia de registro}-{número de registro}. <br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
        'help_text' => 'Indique el identificador de organización de la IATI de la organización que publica los datos. La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.',
      ),
      'type' =>
      array (
        'hover_text' => 'Tipo de organización que presenta el informe. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el tipo que mejor corresponda a la organización que publica los datos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>Información sobre todos los tipos de organizaciones aquí</a>.',
      ),
      'secondary_reporter' =>
      array (
        'hover_text' => 'Marcador de que la organización notificadora de esta actividad actúa en calidad de informador secundario. Un informador secundario es aquel que reproduce datos sobre las actividades de una organización de la que no es responsable directo. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>Más información aquí</a>.',
        'help_text' => '¿Reproduce datos presentados por otra organización? En caso afirmativo, su organización es un informador secundario y debería seleccionar “<b>Sí</b>”. Si presenta datos de su propia organización, seleccione “<b>No</b>”.<br><br>Tenga presente que <b>no</b> es un informador secundario si su organización está oficialmente designada como apoderada (proxy) para publicar datos de la IATI en nombre de otra organización.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'El texto en este elemento debe ser del siguiente tipo: xsd:string. Este elemento debe ocurrir al menos una vez (para cada elemento principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/narrative/\'>Más información aquí</a>.',
        'help_text' => 'Si presenta datos de otra organización, indique su nombre.',
      ),
      'language' =>
      array (
        'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/narrative/\'>Más información aquí</a>.',
      ),
    ),
    'total_budget' =>
    array (
      'hover_text' => 'El elemento de presupuesto-total permite informar sobre el presupuesto de la organización propia. La recomendación es que, siempre que sea posible, se indique el presupuesto anual previsto total de la organización correspondiente a cada uno de los próximos tres próximos años. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/\'>Más información aquí</a>.',
      'help_text' => 'Indique el gasto total previsto de su organización en desarrollo y ayuda humanitaria correspondiente al año en curso y (si es posible) a los tres próximos años. El presupuesto total que indique debe abarcar un período no superior a 12 meses, y de ser posible coincidir con el ejercicio económico de su organización. <br><br>Los presupuestos también pueden publicarse para períodos inferiores a un año, por ejemplo, por trimestres. Los períodos de los presupuestos no deberían solaparse. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Orientación adicional aquí</a>.',
      'status' =>
      array (
        'hover_text' => 'El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. El valor debería figurar en la lista de códigos de estados del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el estado que mejor describa el presupuesto en cuestión:<br><br>1) <b>Indicativo</b>: una estimación no vinculante correspondiente al presupuesto descrito.<br><br>2) <b>Comprometido</b>: un acuerdo vinculante correspondiente al presupuesto descrito.<br><br>Si no se selecciona un estado, se asume que el presupuesto es indicativo.',
      ),
      'period_start' =>
      array (
        'hover_text' => 'Inicio del período del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-start/\'>Más información aquí</a>.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-end/\'>Más información aquí</a>.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Valor total del presupuesto para ayuda de la organización durante el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>Más información aquí</a>.',
        'help_text' => 'Indicar el monto total de la financiación de este presupuesto.',
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras del estándar ISO 4217 correspondiente a la moneda original del monto. Es necesario para todos los montos salvo que se especifique el atributo organización-iati/@default-currency. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>Más información aquí</a>.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>Más información aquí</a>.',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Desglose del presupuesto total en subtotales. La organización notificadora determina el desglose, que se explica en la descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/\'>Más información aquí</a>.',
        'help_text' => 'Puede facilitar información adicional sobre el presupuesto en las partidas presupuestarias. Las partidas presupuestarias permiten desglosar el presupuesto total, por ejemplo en diferentes programas que se llevan a cabo en un mismo año.<br><br>Tenga en cuenta que la suma de todas las partidas presupuestarias <b><u>no</u></b> necesariamente debe ser igual al valor total del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Orientación adicional aquí</a>.',
        'reference' =>
        array (
          'help_text' => 'Puede proporcionar una referencia que utilice para identificar esta partida presupuestaria en el sistema interno de presentación de informes financieros de su organización.',
        ),
        'value' =>
        array (
          'hover_text' => 'Subtotal del presupuesto. La definición de la subdivisión se determina en los elementos organización-iati/presupuesto-total/partida-presupuestaria/descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'>Más información aquí</a>.',
          'help_text' => 'Indicar el monto total de la financiación de esta partida presupuestaria.',
          'currency' =>
          array (
            'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'>Más información aquí</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
        ),
      ),
    ),
    'recipient_org_budget' =>
    array (
      'hover_text' => 'El elemento presupuesto-organización-receptora permite informar sobre presupuestos prospectivos para cada institución que reciba financiación básica de la organización notificadora. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/\'>Más información aquí</a>.',
      'help_text' => 'Si su organización proporcionará financiación básica a una organización u organizaciones receptoras, publique la información sobre el presupuesto en cuestión aquí. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Orientación adicional aquí</a>.<br><br>En la medida de lo posible, debería facilitar los presupuestos anuales previstos para cada organización receptora correspondientes a cada uno de los tres siguientes ejercicios financieros.',
      'status' =>
      array (
        'hover_text' => 'El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. El valor debería figurar en la lista de códigos de estados del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el estado que mejor describa el presupuesto de la organización receptora en cuestión:<br><br>1) <b>Indicativo</b>: una estimación no vinculante correspondiente al presupuesto descrito.<br><br>2) <b>Comprometido</b>: un acuerdo vinculante correspondiente al presupuesto descrito.<br><br>Si no se selecciona un estado, se asume que el presupuesto es indicativo.',
      ),
      'recipient_org' =>
      array (
        'hover_text' => 'Organización que recibirá los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/\'>Más información aquí</a>.',
        'help_text' => 'Proporcione información sobre la organización que recibirá los fondos.',
        'reference' =>
        array (
          'hover_text' => 'Organización que recibirá los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/\'>Más información aquí</a>.',
          'help_text' => 'Introduzca el <i>identificador de la organización</i> receptora de la IATI. La forma más rápida de encontrarlo es hacer una búsqueda de la organización en la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>lista de entidades que publican conforme a la IATI</a>. Si no puede encontrar la organización, acceda al siguiente enlace para obtener <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>orientación adicional</a>.<br></br>Si no puede facilitar el identificador de la organización, DEBE indicar el nombre de la organización a continuación.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre de la organización. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Indique el nombre de la organización receptora.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Este elemento debe ocurrir solo una vez (para cada elemento principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-start/\'>Más información aquí</a>.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-end/\'>Más información aquí</a>.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Valor total del dinero presupuestado que se desembolsará a la organización receptora específica para el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/value/\'>Más información aquí</a>.',
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras del estándar ISO 4217 correspondiente a la moneda original del monto. Es necesario para todos los montos salvo que se especifique el atributo organización-iati/@default-currency. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>Más información aquí</a>.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/value/\'>Más información aquí</a>.',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Desglose del presupuesto total en subtotales. La organización notificadora determina el desglose, que se explica en la descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/\'>Más información aquí</a>.',
        'help_text' => 'Puede ofrecer un desglose del presupuesto de la organización receptora en partidas presupuestarias.<br><br>Tenga en cuenta que la suma de todas las partidas presupuestarias <b><u>no</u></b> necesariamente debe ser igual al valor total del presupuesto de la organización receptora. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Orientación adicional aquí</a>.',
        'value' =>
        array (
          'hover_text' => 'Subtotal del presupuesto. La definición de la subdivisión se determina en los elementos organización-iati/presupuesto-total/partida-presupuestaria/descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>Más información aquí</a>.',
          'currency' =>
          array (
            'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
        ),
      ),
    ),
    'recipient_region_budget' =>
    array (
      'hover_text' => 'El elemento presupuesto-región-receptora permite informar sobre presupuestos prospectivos para los casos en que la organización mantiene presencia en toda la región, en vez o además de en presupuestos específicos de los países. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/\'>Más información aquí</a>.',
      'help_text' => 'La IATI exhorta a las organizaciones a desglosar su presupuesto total en presupuestos más pequeños para los países receptores o las regiones receptoras donde operan.<br><br>Si indica un presupuesto de una región receptora o un país receptor, no es necesario que utilice los mismos períodos, y <b>no</b> es necesario sumar estos presupuestos al presupuesto total de su organización.<br><br>Si desea indicar el presupuesto de una región receptora, NO debe tratarse de una suma de los presupuestos de los países receptores. Por ejemplo, si publica un presupuesto del país receptor para Uganda por valor de 100.000 USD y un presupuesto para Kenya por valor de 100.000 USD para el año siguiente, NO debería publicar un presupuesto de la región receptora para África por un valor de 200.000 USD correspondiente al año siguiente.',
      'status' =>
      array (
        'hover_text' => 'El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. El valor debería figurar en la lista de códigos de estados del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/\'>Más información aquí</a>.',
        'help_text' => 'Seleccione el estado que mejor describa el presupuesto de la región receptora:<br><br>1) <b>Indicativo</b>: una estimación no vinculante correspondiente al presupuesto descrito.<br><br>2) <b>Comprometido</b>: un acuerdo vinculante correspondiente al presupuesto descrito.<br><br>Si no se selecciona un estado, se asume que el presupuesto es indicativo.',
      ),
      'recipient_region' =>
      array (
        'hover_text' => 'La región supranacional a la que se han asignado los fondos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>Más información aquí</a>.',
        'vocabulary' =>
        array (
          'hover_text' => 'Código de la IATI para el vocabulario del que se extrae el código de la región. En caso de no estar presente, se asume el código 1 (DAC de la OCDE). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>Más información aquí</a>.',
          'help_text' => 'Se dispone de dos listas de regiones: la lista de códigos del <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/codelists/region/’>CAD de la OCDE</a> y la lista de códigos de <a target=’_blank’ href=’https://unstats.un.org/unsd/methodology/m49/’>regiones de las Naciones Unidas</a>. Seleccione una opción. La IATI le recomienda utilizar la lista de códigos del CAD de la OCDE. De lo contrario, puede utilizar otra lista de regiones seleccionando la opción “organización notificadora” y proporcionando el URI donde se define esta lista interna.<br><br>Si no elige una opción, se asume la lista de códigos del CAD de la OCDE.',
        ),
        'vocabulary-uri' =>
        array (
          'hover_text' => 'El URI donde se define este vocabulario. Si el vocabulario es 99 (organización notificadora), el URI donde se define este vocabulario interno. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>Más información aquí</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Indique el nombre de la región que se beneficia con el presupuesto.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Inicio del período presupuestario. Este elemento debe ocurrir solo una vez (para cada elemento principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-start/\'>Más información aquí</a>.',
          'help_text' => 'Indicar la fecha de inicio del período del presupuesto de la región receptora.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-end/\'>Más información aquí</a>.',
          'help_text' => 'Indicar la fecha de finalización del período del presupuesto de la región receptora.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Valor total del dinero presupuestado que se desembolsará al país receptor específico para el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>Más información aquí</a>.',
        'help_text' => 'Indicar el monto de la financiación del presupuesto de la región receptora',
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>Más información aquí</a>.',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Desglose del presupuesto del país receptor en subtotales. La organización notificadora determina el desglose, que se explica en la descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/\'>Más información aquí</a>.',
        'help_text' => 'Puede facilitar información adicional sobre este presupuesto de la región receptora en las partidas presupuestarias. Las partidas presupuestarias permiten desglosar el presupuesto de la región receptora, por ejemplo en diferentes proyectos que se llevan a cabo en un mismo año.<br><br>Tenga en cuenta que la suma de todas las partidas presupuestarias <b>no</b> necesariamente debe ser igual al valor total del presupuesto de la región receptora.',
        'reference' =>
        array (
          'hover_text' => 'Referencia interna de esta partida presupuestaria extraída del sistema de presentación de informes propio de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/\'>Más información aquí</a>.',
        ),
        'value' =>
        array (
          'hover_text' => 'Subtotal del presupuesto. La definición de la subdivisión se determina en los elementos organización-iati/presupuesto-total/partida-presupuestaria/descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>Más información aquí</a>.',
          'currency' =>
          array (
            'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
        ),
      ),
    ),
    'recipient_country_budget' =>
    array (
      'hover_text' => 'El elemento presupuesto-país-receptor permite informar sobre presupuestos prospectivos para cada país con presencia de la organización notificadora. <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/’>Más información aquí</a>.',
      'help_text' => 'Puede proporcionar el presupuesto o los presupuestos de su organización en función del país receptor. No es necesario que utilice los mismos períodos, y <b>la</b> suma de estos presupuestos no tiene que ser equivalente al presupuesto total de su organización.<br><br>Si su organización mantiene presupuestos a escala nacional, indíquelos aquí.',
      'status' =>
      array (
        'hover_text' => 'El estado detalla si el presupuesto que se comunica es indicativo o si se ha comprometido formalmente. El valor debería figurar en la lista de códigos de estados del presupuesto. <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/’>Más información aquí</a>.',
        'help_text' => 'Seleccione el estado que mejor describa el presupuesto del país receptor:<br><br>1) <b>Indicativo</b>: una estimación no vinculante correspondiente al presupuesto descrito.<br><br>2) <b>Comprometido</b>: un acuerdo vinculante correspondiente al presupuesto descrito.<br><br>Si no se selecciona un estado, se asume que el presupuesto es indicativo.',
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'País receptor. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/\'>Más información aquí</a>.',
        'code' =>
        array (
          'hover_text' => 'Código de dos letras del país según la norma ISO 3166-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/\'>Más información aquí</a>.',
          'help_text' => 'Seleccionar el país receptor de este presupuesto.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Indique el nombre del país receptor.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda en la medida de lo posible utilizar únicamente los códigos de la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/narrative/\'>Más información aquí</a>.',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Inicio del período presupuestario. Este elemento debe ocurrir solo una vez (para cada elemento principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-start/\'>Más información aquí</a>.',
          'help_text' => 'Indicar la fecha de inicio del período del presupuesto del país receptor.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-end/\'>Más información aquí</a>.',
          'help_text' => 'Indicar la fecha de finalización del período del presupuesto del país receptor.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Valor total del dinero presupuestado que se desembolsará a la organización receptora especificada para el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>Más información aquí</a>.',
        'help_text' => 'Indicar el monto de la financiación de este presupuesto.',
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <br><br>Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>Más información aquí</a>.',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Desglose del presupuesto total en subtotales. La organización notificadora determina el desglose, que se explica en la descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/\'>Más información aquí</a>.',
        'help_text' => 'Puede facilitar información adicional sobre este presupuesto del país receptor en las partidas presupuestarias. Las partidas presupuestarias permiten desglosar los presupuestos de los países receptores, por ejemplo, en diferentes proyectos que se llevan a cabo en un año determinado.<br><br>Tenga en cuenta que la suma de todas las partidas presupuestarias <b>no</b> necesariamente debe ser igual al valor total del presupuesto del país receptor.',
        'reference' =>
        array (
          'hover_text' => 'Referencia interna de esta partida presupuestaria extraída del sistema de presentación de informes propio de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/\'>Más información aquí</a>.',
        ),
        'value' =>
        array (
          'hover_text' => 'Subtotal del presupuesto. La definición de la subdivisión se determina en los elementos organización-iati/presupuesto-total/partida-presupuestaria/descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>Más información aquí</a>.',
          'currency' =>
          array (
            'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>Más información aquí</a>.',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/narrative/\'>Más información aquí</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/narrative/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'total_expenditure' =>
    array (
      'hover_text' => 'El elemento del gasto total permite informar sobre los gastos de desarrollo internacional de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/\'>Más información aquí</a>.',
      'help_text' => 'La IATI recomienda que su organización informe del gasto anterior en su labor humanitaria y de desarrollo. Esto se conoce como “gasto total” y la IATI recomienda que, en la medida de lo posible, la organización comunique su gasto total durante cada uno de los últimos tres años. <br><br>Un período de gasto <b>no</b> debe ser superior a un año.',
      'period_start' =>
      array (
        'hover_text' => 'Inicio del período del presupuesto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-start/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-start/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha de inicio del período de gasto.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Fin del período (no debe ser superior a un año). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-end/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-end/\'>Más información aquí</a>.',
          'help_text' => 'Indique la fecha de finalización del período de gasto.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Valor total del gasto de la organización en ayuda durante el período en cuestión. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>Más información aquí</a>.',
        'help_text' => 'Indique el monto de la financiación de este gasto.',
        'currency' =>
        array (
          'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>Más información aquí</a>.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>Más información aquí</a>.',
        ),
      ),
      'expense_line' =>
      array (
        'hover_text' => 'Desglose del gasto total en subtotales. La organización notificadora determina el desglose, que se explica en la descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/\'>Más información aquí</a>.',
        'help_text' => 'Puede facilitar información adicional del gasto de su organización por partida o partidas de gastos. Las partidas de gastos permiten desglosar el gasto en gastos de menor valor.<br><br>Tenga en cuenta que la suma de todas las partidas de gastos <b>no</b> necesariamente debe ser igual al valor total del gasto.',
        'reference' =>
        array (
          'hover_text' => 'Referencia interna de esta partida de gastos extraída del sistema de presentación de informes propio de la organización. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/\'>Más información aquí</a>.',
          'help_text' => 'Puede aportar una referencia que utilice para identificar esta partida de gastos en el sistema interno de gestión financiera de su organización.',
        ),
        'value' =>
        array (
          'hover_text' => 'Subtotal de gastos. La definición de la subdivisión se determina en los elementos organización-iati/gasto-total/partida-gastos/descripción. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>Más información aquí</a>.',
          'help_text' => 'Indique el monto de la financiación de esta partida de gastos.',
          'currency' =>
          array (
            'hover_text' => 'Código de tres letras de la norma ISO 4217 para la moneda original del monto. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>Más información aquí</a>.',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Fecha que se empleará para determinar el tipo de cambio de las conversiones de moneda. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>Más información aquí</a>.',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nombre o descripción libre del elemento que se describe. Puede repetirse en varios idiomas. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/narrative/\'>Más información aquí</a>.',
          'help_text' => 'Presente una descripción de esta partida de gastos.',
        ),
        'language' =>
        array (
          'hover_text' => 'Código que especifica el idioma del texto en este elemento. Se recomienda, en la medida de lo posible, utilizar únicamente los códigos de la norma ISO 639-1. En caso de no estar presente, se asume el idioma predeterminado. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/narrative/\'>Más información aquí</a>.',
        ),
      ),
    ),
    'document_link' =>
    array (
      'hover_text' => 'Enlace a una página web o un documento en línea de acceso público. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>Más información aquí</a>.',
      'help_text' => 'Puede proporcionar información adicional sobre el desarrollo de programas humanitarios de su organización adjuntando un enlace de acceso público a un documento o una página web. Por ejemplo, puede adjuntar un enlace al informe anual de su organización o a un plan de trabajo de un país concreto.<br><br>Si los documentos estuvieran disponibles en otros idiomas y se almacenaran por separado, facilítelos creando elementos de documento adicionales. <a target=’_blank’ href=’https://iatistandard.org/en/guidance/standard-guidance/related-documents/’>Orientación adicional aquí</a>.',
      'url' =>
      array (
        'hover_text' => 'URL de destino del documento externo, por ejemplo, “http://www.example.org/doc.odt”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>Más información aquí</a>.',
      ),
      'format' =>
      array (
        'hover_text' => 'Código de la IANA para el tipo de MIME del documento que se describe, por ejemplo, “aplicación/pdf”. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>Más información aquí</a>.',
        'help_text' => 'Si conoce el formato del archivo del documento, introdúzcalo <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/codelists/fileformat/’>utilizando una opción de la lista</a>.',
      ),
      'title' =>
      array (
        'hover_text' => 'Título conciso y legible para los seres humanos. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/title/\'>Más información aquí</a>.',
      ),
      'description' =>
      array (
        'hover_text' => 'Descripción del contenido del documento u orientación sobre dónde encontrar la información más importante del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/description/\'>Más información aquí</a>.',
      ),
      'category' =>
      array (
        'hover_text' => 'Código de la IATI de categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/category/\'>Más información aquí</a>.',
        'code' =>
        array (
          'hover_text' => 'Código de la IATI que establece la categoría del documento. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/category/\'>Más información aquí</a>.',
        ),
      ),
      'language' =>
      array (
        'hover_text' => 'Código del idioma en que se redactó el documento de destino según la norma ISO 639-1, por ejemplo, “en”. Puede repetirse para designar documentos plurilingües. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/language/\'>Más información aquí</a>.',
        'code' =>
        array (
          'hover_text' => 'Código del idioma según la norma ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/language/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el idioma del documento o de la página web.',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Fecha de publicación del documento al que se vincula. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/document-date/\'>Más información aquí</a>.',
        'date' =>
        array (
          'hover_text' => 'Este atributo es necesario. El valor debe ser del siguiente tipo: xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/document-date/\'>Más información aquí</a>.',
        ),
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'El país receptor en que el documento centra la atención. Puede repetirse para varios países. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/recipient-country/\'>Más información aquí</a>.',
        'help_text' => 'Si el documento o la página web centran su atención en un país receptor, especifíquelo en este apartado. Puede indicar más de un país.',
        'code' =>
        array (
          'hover_text' => 'Código de dos letras del país según la norma ISO 3166-1. Este atributo es necesario. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/recipient-country/\'>Más información aquí</a>.',
          'help_text' => 'Seleccione el país receptor en el que el documento o la página web centran la atención.',
        ),
        'narrative' =>
        array (
          'help_text' => 'Introduzca el nombre del país receptor en el que el documento o la página web centran la atención.',
        ),
      ),
    ),
  ),
);
