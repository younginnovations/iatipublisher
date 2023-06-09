<?php
return array (
  'activities' =>
  array (
    'activity_identifier' =>
    array (
      'help_text' => 'Saisissez une série unique de lettres et/ou de chiffres qui permettra d’identifier votre activité. Par exemple : PROJECT-00120467 ou AFG-COVAX. </br></br>Assurez-vous que :</br></br>Chaque identifiant IITA publié est unique.</br></br>Vos identifiants IITA ne sont pas précédés ou suivis d’une espace.</br></br>Vos identifiants IITA sont exclusivement composés de chiffres, de lettres et de tirets.</br></br>L’identifiant IITA ne subit aucune modification après publication de l’activité correspondante.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>Instructions complémentaires.</a>',
      'shorter_help_text' => 'Saisissez votre propre identifiant d’activité unique, par exemple une abréviation ou un simple numéro. Assurez-vous que cet identifiant ne correspond à aucune autre activité. IATI Publisher générera automatiquement un identifiant IITA en combinant l’identifiant de l’organisation et l’identifiant d’activité.',
    ),
    'iati_identifier' =>
    array (
      'hover_text' => 'Identifiant d’activité universel unique.</br></br>Cet identifiant DOIT IMPÉRATIVEMENT avoir pour préfixe l’identifiant IITA actuel de l’organisation déclarante (organisation-déclarante/@ref) OU un identifiant préalablement renseigné en tant qu’identifiant alternatif, et pour suffixe l’identifiant d’activité propre à l’organisation. Le préfixe et le suffixe doivent être séparés de l’identifiant par un trait d’union (« - »).</br></br>Une fois qu’une activité est déclarée auprès de l’IITA, son identifiant NE DOIT PLUS être modifié lors des mises à jour ultérieures.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/iati-identifier/\'>En savoir plus</a>',
      'help_text' => 'Cet identifiant est généré automatiquement en ajoutant l’identifiant d’activité à la fin de votre identifiant d’organisation (l’identifiant unique généré pour votre organisation au moment de votre inscription). <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>Instructions complémentaires</a>.</br></br>Une fois qu’une activité est déclarée auprès de l’IITA, son identifiant NE DOIT PLUS être modifié lors des mises à jour ultérieures. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/iati-identifier/\'>En savoir plus.</a>',
    ),
    'reporting_org' =>
    array (
      'hover_text' => 'Il s’agit de l’identifiant IITA de votre organisation (l’identifiant unique généré pour votre organisation au moment de votre inscription).<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/registering-and-managing-your-organisation-account/how-to-create-your-iati-organisation-identifier/\'>En savoir plus.</a>',
      'help_text' => 'Organisation déclarante. Il peut s’agir d’une source primaire (organisation déclarant ses propres activités d’organisme donateur, d’organisme de mise en œuvre, etc.) ou d’une source secondaire (organisation déclarant les activités d’une autre organisation).</br></br>L’attribut @ref doit obligatoirement être spécifié. Le nom de l’organisation peut être utilisé comme contenu. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
      'narrative' =>
      array (
        'help_text' => 'Il s’agit du nom de votre organisation tel que vous l’avez renseigné au moment de votre inscription.',
        'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/narrative/\'>En savoir plus</a>',
      ),
      'type' =>
      array (
        'hover_text' => 'Type d’organisation déclarante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org',
      ),
    ),
    'title' =>
    array (
      'hover_text' => 'Titre concis, lisible par l’être humain et offrant une présentation plus claire des activités de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/\'>En savoir plus</a>',
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/\'>En savoir plus</a>',
        'help_text' => 'Attribuez un titre à l’activité concernée. Par exemple : « De l’eau pour les femmes au Malawi ».',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/\'>En savoir plus</a>',
      ),
    ),
    'description' =>
    array (
      'hover_text' => 'Description plus complète, lisible par l’être humain et offrant une présentation claire des activités de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/description/\'>En savoir plus</a>',
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/description/narrative/\'>En savoir plus</a>.',
        'help_text' => 'Fournissez une description de votre activité. Par exemple : « Ce projet permettra d’améliorer la fréquentation des services de santé maternelle et infantile parmi les 800 femmes enceintes et les 6 500 personnes s’occupant d’enfants de moins de 5 ans à/en [nom du lieu], ce qui contribuera à réduire les taux de mortalité et de morbidité, particulièrement élevés chez les mères et les enfants de moins de 5 ans issus de ces communautés. »',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/description/narrative/\'>En savoir plus</a>',
      ),
      'type' =>
      array (
        'hover_text' => 'Modalités de description de l’activité. (Présentation générale, objectifs, etc.). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/descriptiontype/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez la modalité de description la mieux adaptée à la présentation de votre activité.</br></br>1. <b>Présentation générale </b>- Présentation détaillée et non structurée de l’activité.<br><br>2. <b>Objectifs</b> - Objectifs spécifiques de l’activité, par exemple les objectifs présents dans le cadre logique.<br><br> 3. <b>Groupes cibles</b> - Description des groupes cibles auxquels l’activité est censée bénéficier.<br><br>4. <b>Autres</b> - Éléments de présentation divers. Une classification ou une ventilation plus précise peut être intégrée à l’exposé</li>',
      ),
    ),
    'participating_org' =>
    array (
      'hover_text' => 'Précisez quelles sont les organisations impliquées dans cette activité et quelles sont leurs fonctions respectives. Par exemple : donateur, bailleur de fonds, organisme de mise en œuvre, etc.',
      'help_text' => 'Organisation impliquée dans l’activité concernée. Il peut s’agir d’un donateur, d’un bailleur de fonds, d’un organisme de mise en œuvre, etc. Il est fortement recommandé de spécifier l’identifiant @ref. Le nom de l’organisation peut être utilisé comme exposé.</br><br>Si l’organisation déclarante est impliquée dans l’activité concernée, son nom doit être répété ici. Une même organisation peut assumer plusieurs fonctions (par exemple, bailleur de fonds et organisme de mise en œuvre) : le cas échéant, chaque fonction doit être indiquée et le nom de l’organisation doit être répété.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>En savoir plus</a>',
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/narrative/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le nom de l’organisation participante.',
      ),
      'organisation_role' =>
      array (
        'hover_text' => 'Code IITA permettant de connaître le rôle que joue l’organisation dans l’activité concernée (donateur, organisme de mise en œuvre, etc.).<br></br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez l’option correspondant au rôle de l’organisation dans l’activité concernée (bailleur de fonds, organisme de mise en œuvre, etc.) :<br></br>1. <b>Bailleur de fonds</b> - Le gouvernement ou l’organisation finance l’activité</br><br>2. <b>Organisme responsable</b> - L’organisation supervise l’activité et les résultats obtenus</br><br>3. <b>Organisme administrateur</b> - L’organisation gère le budget et l’activité au nom du bailleur de fonds</br><br>4. <b>Organisme de mise en œuvre</b> - L’organisation prend en charge la mise en œuvre physique de l’activité ou de l’intervention.</br>',
      ),
      'reference' =>
      array (
        'hover_text' => 'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. Doit respecter le format {OrganismeD’enregistrement}-{NuméroD’enregistrement}.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
        'help_text' => 'Veuillez saisir l’identifiant IITA de l’organisation participante. Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas l’organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires.</a>',
      ),
      'type' =>
      array (
        'hover_text' => 'Type d’organisation déclarante.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation participante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation.</a>',
      ),
      'activity_id' =>
      array (
        'hover_text' => 'Identifiant d’activité valide, publié par l’organisation participante et correspondant à l’activité renseignée à l’IITA pour présenter son rôle dans l’activité concernée.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>En savoir plus</a>',
        'help_text' => 'Si l’organisation participante a renseigné une activité à l’IITA pour l’activité concernée, veuillez saisir l’identifiant d’activité correspondant. Vous pouvez obtenir ces informations auprès de l’organisation participante ou trouver les activités correspondantes sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires.</a>',
      ),
      'crs_channel_code' =>
      array (
        'hover_text' => 'Conformément aux directives de publication du SNPC++, ce code permet d’identifier l’organisme de mise en œuvre. Les codes se terminant par « 00 » sont génériques et correspondent aux codes permettant d’identifier les types d’organisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/participating-org/\'>En savoir plus</a>',
      ),
    ),
    'other_identifier' =>
    array (
      'hover_text' => 'Autre identifiant pour l’activité concernée. Il peut s’agir d’un identifiant choisi par le signataire pour enregistrer son activité. Cet élément permet également de suivre l’évolution des identifiants d’activité, par exemple lorsqu’une organisation modifie son identifiant.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>En savoir plus</a>',
      'reference' =>
      array (
        'hover_text' => 'Identifiant que vous souhaitez renseigner. Différents types d’identifiants peuvent être utilisés. Pour plus de précisions et d’options, veuillez consulter la liste de codes pour les autres types d’identifiants.<br></br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>En savoir plus</a>',
        'help_text' => 'Veuillez saisir l’identifiant correspondant à l’activité concernée.',
      ),
      'ref_type' =>
      array (
        'hover_text' => 'Type d’identifiant renseigné, issu de la liste de codes pour les autres types d’identifiants.<br></br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/\'>En savoir plus</a>',
        'help_text' => 'Si vous souhaitez renseigner un autre identifiant pour cette activité, vous <b>devez</b> sélectionner le type d’identifiant utilisé. Pour obtenir la description de tous les types d’identifiants possibles, veuillez consulter la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/otheridentifiertype/\'>liste de codes pour les autres types d’identifiants.</a>',
      ),
      'owner_org' =>
      array (
        'hover_text' => 'Le cas échéant, nom de l’organisation titulaire de l’autre identifiant renseigné. Si ce champ est renseigné, il DOIT contenir l’information autre-identifiant/organisation-titulaire/@ref ou autre-identifiant/organisation-titulaire/exposé/texte().<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/owner-org/\'>En savoir plus</a>',
        'help_text' => 'Veuillez indiquer l’identifiant de l’organisation titulaire de l’autre identifiant renseigné pour l’activité. Si votre organisation n’est pas titulaire de l’autre identifiant, vous pouvez trouver d’autres organisations dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA.</a> Si vous ne trouvez pas l’organisation recherchée, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires.</a>',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/other-identifier/owner-org/narrative/\'>En savoir plus</a>',
        'help_text' => 'Indiquez l’autre identifiant utilisé pour l’activité.',
      ),
    ),
    'activity_status' =>
    array (
      'help_text' => 'Vous devez fournir un statut d’activité. Ce dernier permet de rendre compte du cycle de vie de l’activité, depuis la phase de planification jusqu’à la phase de mise en œuvre. Vous pouvez publier des activités déjà achevées, en cours de mise en œuvre ou encore en développement. Au fur et à mesure des progrès accomplis, le statut d’activité doit être mis à jour.',
      'hover_text' => 'Statut actuel de l’activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-status/\'>En savoir plus</a>',
      'code' =>
      array (
        'hover_text' => 'Code IITA indiquant le statut actuel de l’activité.<br></br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-status/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez l’option correspondant au statut actuel de votre activité.<br></br>1.<b> Planification/repérage</b> : L’activité fait l’objet d’un travail de cadrage ou de planification<br></br>2.<b> Mise en œuvre</b> : L’activité est en cours de mise en œuvre<br></br>3.<b> Finalisation</b> : L’activité est physiquement achevée ou le dernier décaissement a été effectué, mais elle reste ouverte en attendant le processus d’approbation financière ou de suivi et d’évaluation<br></br>4.<b> Achevée</b> : L’activité est physiquement achevée ou le dernier décaissement a été effectué<br></br>5.<b> Annulée</b> : L’activité a été annulée</br><br>6.<b> Suspendue</b> : L’activité a été temporairement suspendue</li>',
      ),
      'activity_date' =>
      array (
        'hover_text' => 'Dates de début et d’achèvement prévisionnelles et effectives de l’activité. Les dates de début peuvent correspondre au déclenchement du processus de financement, de planification ou de mise en œuvre physique de l’activité. Dans la mesure du possible, les dates d’achèvement doivent correspondre à la fin de la mise en œuvre physique de l’activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-dates-status/\'>En savoir plus</a>',
        'type' =>
        array (
          'hover_text' => 'Code IITA indiquant le type de date renseigné pour l’activité.<br></br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/activitydatetype/\'>En savoir plus</a>',
          'help_text' => 'Veuillez sélectionner le type de date que vous allez renseigner pour l’activité.<br></br>1. <b>Date de début prévisionnelle</b> : La date à laquelle il est prévu que l’activité commence, par exemple la date prévue pour le premier décaissement ou pour le déclenchement du processus de mise en œuvre physique.<br></br>2. <b>Date de début effective</b> : La date à laquelle l’activité commence effectivement, par exemple la date du premier décaissement ou du déclenchement du processus de mise en œuvre physique.<br></br>3. <b>Date d’achèvement prévisionnelle</b> : La date à laquelle il est prévu que l’activité s’achève, par exemple la date prévue pour le dernier décaissement ou pour la fin du processus de mise en œuvre physique.<br></br>4. <b>Date d’achèvement effective</b> : La date à laquelle l’activité s’achève effectivement, par exemple la date du dernier décaissement ou de la fin du processus de mise en œuvre physique.',
        ),
      ),
      'date' =>
      array (
        'hover_text' => 'Cet attribut est obligatoire.</br>Cette valeur doit être de type xsd:date.</br>1 : La date de début prévisionnelle de l’activité doit être antérieure à sa date d’achèvement prévisionnelle.</br>2 : La date de début effective de l’activité doit être antérieure à sa date d’achèvement effective.</br>3 : La date de début effective de l’activité ne doit pas être située dans le futur.</br>4 : La date d’achèvement effective de l’activité ne doit pas être située dans le futur.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/\'>En savoir plus</a>',
        'help_text' => 'Veuillez saisir la date de votre activité.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/narrative/\'>En savoir plus</a>',
        'help_text' => 'Saisissez toute information ou explication complémentaire relative au statut d’activité renseigné.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-date/narrative/\'>En savoir plus</a>',
      ),
    ),
    'contact_info' =>
    array (
      'hover_text' => 'Coordonnées de la personne à contacter au sujet de cette activité. Saisissez toutes les informations dont vous disposez. Vous pouvez répéter cet élément pour chaque personne à contacter.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/\'>En savoir plus</a>',
      'type' =>
      array (
        'hover_text' => 'Type de contact. Pour accéder aux valeurs, veuillez consulter la liste de codes IITA.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/contacttype/\'>En savoir plus</a>',
        'organisation' =>
        array (
          'hover_text' => 'Nom de l’organisation à contacter pour en savoir plus sur l’activité. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/narrative/\'>En savoir plus</a>',
            'help_text' => 'Saisissez le nom de l’organisation à contacter pour en savoir plus sur l’activité.',
          ),
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/organisation/narrative/\'>En savoir plus</a>',
          ),
        ),
        'department' =>
        array (
          'hover_text' => 'Service à contacter, au sein de l’organisation, pour en savoir plus sur l’activité. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/department/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'help_text' => 'Saisissez le nom du service à contacter, au sein de l’organisation, pour en savoir plus sur l’activité.',
          ),
        ),
        'person_name' =>
        array (
          'hover_text' => 'Nom de la personne à contacter au sujet de cette activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/person-name/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'help_text' => 'Saisissez le nom de la personne à contacter pour en savoir plus sur l’activité.',
          ),
        ),
        'job_title' =>
        array (
          'hover_text' => 'Intitulé du poste de la personne à contacter au sein de l’organisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/job-title/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'help_text' => 'Saisissez l’intitulé du poste de la personne à contacter au sein de l’organisation.',
          ),
        ),
        'telephone' =>
        array (
          'hover_text' => 'Numéro de téléphone de la personne à contacter. Vous pouvez répéter cet élément pour saisir plusieurs numéros de téléphone.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/telephone/\'>En savoir plus</a>',
        ),
        'email' =>
        array (
          'hover_text' => 'Adresse e-mail de la personne à contacter. Vous pouvez répéter cet élément pour saisir plusieurs adresses e-mail.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/email/\'>En savoir plus</a>',
        ),
        'website' =>
        array (
          'hover_text' => 'Adresse du site Internet de la personne à contacter. Vous pouvez répéter cet élément pour saisir plusieurs sites Internet.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/website/\'>En savoir plus</a>',
        ),
        'mailing_address' =>
        array (
          'hover_text' => 'Adresse postale de la personne à contacter.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/narrative/\'>En savoir plus</a>',
            'help_text' => 'Saisissez toute information complémentaire relative à la personne à contacter.',
          ),
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/contact-info/mailing-address/narrative/\'>En savoir plus</a>',
          ),
        ),
      ),
    ),
    'activity_scope' =>
    array (
      'hover_text' => 'Portée géographique de l’activité : régionale, nationale, infranationale, etc.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/activity-scope/\'>En savoir plus</a>',
      'activity_code' =>
      array (
        'hover_text' => 'Portée géographique. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/activityscope/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez l’option correspondant le mieux à la portée de cette activité.<br><br>1. <b>Mondiale</b> - L’activité a une portée mondiale. Certaines activités de recherche, par exemple, n’ont pas de zone d’ancrage ou de couverture spécifique <br><br>2. <b>Régionale</b> - L’activité a une portée régionale (échelle supranationale)<br><br>3. <b>Multinationale</b> - L’activité couvre plusieurs pays, qui ne constituent pas pour autant une région<br><br>4. <b>Nationale</b> - L’activité couvre un seul pays<br><br>5. <b>Infranationale : plusieurs zones administratives de premier niveau</b> - L’activité couvre au moins deux zones administratives infranationales de premier niveau (comtés, provinces, États, etc.)<br><br>6. <b>Infranationale : une seule zone administrative de premier niveau</b> - L’activité couvre une seule zone administrative infranationale de premier niveau (comté, province, État, etc.)<br><br>7. <b>Infranationale : une seule zone administrative de deuxième niveau</b> - L’activité couvre une seule zone administrative infranationale de deuxième niveau (municipalité, district, etc.)<br><br>8. <b>Lieu unique</b> - L’activité couvre un lieu unique (ville, village, ferme, etc.)<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'> Instructions complémentaires.</a>',
      ),
    ),
    'recipient_country' =>
    array (
      'help_text' => 'Pour chaque activité saisie dans IATI Publisher, il convient de préciser le pays de mise en œuvre (p. ex. la Chine) ou les différents lieux qui bénéficieront de cette mise en œuvre. Si le pays de mise en œuvre n’est pas connu, il convient de saisir une ou plusieurs régions supranationales (p. ex. l’Asie de l’Est).<br></br>Il existe plusieurs façons de publier des informations concernant le pays et/ou la région qui bénéficiera de cette activité.<br></br>Si l’activité ne bénéficie qu’à un seul pays ou région, il suffit de sélectionner ce pays ou cette région ci-dessous. Cela signifie que 100 % des financements publiés pour cette activité bénéficieront à un seul pays ou région.<br></br>À l’inverse, si plusieurs régions et/ou pays bénéficient de votre activité, vous pouvez :<br></br><b>1.</b> Saisir le pays ou la région bénéficiaire pour chaque transaction que vous publiez pour l’activité concernée. Pour chaque activité que vous publiez, il vous sera demandé de saisir des données sur au moins une transaction (publication de données relatives aux transactions). Chaque transaction correspond à un flux financier entrant ou sortant, ayant trait à l’activité. Vous pouvez sélectionner un pays ou une région différente pour chaque transaction publiée.<br></br>Si vous souhaitez indiquer le comté ou la région bénéficiaire pour chaque transaction, ne remplissez pas le champ ci-dessous réservé au pays ou à la région bénéficiaire de l’ensemble de l’activité.<br></br><b>2.</b>Ci-dessous, vous pouvez sélectionnez plusieurs pays ou régions pour l’ensemble de l’activité. Si vous choisissez cette option, il vous faudra attribuer un pourcentage du financement total de l’activité à chaque pays et/ou région.<br></br><b>3.</b> Vous pouvez choisir de créer une activité distincte pour chaque pays bénéficiaire des fonds affectés à l’ensemble de l’activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Instructions complémentaires.</a>',
      'hover_text' => 'Pays bénéficiaire de cette activité. Si aucun pays précis ne peut être renseigné, il convient d’indiquer la région bénéficiaire. Pour sélectionner un lieu géographique, utilisez l’élément de localisation.<br></br>Plusieurs pays et régions peuvent être renseignés, auquel cas l’attribut de pourcentage DOIT être utilisé pour indiquer la part associée à chaque pays et région, sur l’ensemble des engagements.<br></br>Le pays peut également être renseigné au niveau des transactions, plutôt qu’au niveau des activités. Si le nom du pays-bénéficiaire OU de la région-bénéficiaire est renseigné au niveau des transactions, TOUTES les transactions DOIVENT contenir un élément « pays-bénéficiaire » ou « région-bénéficiaire », et les éléments activité-IITA/pays-bénéficiaire et activité-IITA/région-bénéficiaire NE DOIVENT PAS être utilisés.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-country/\'>En savoir plus</a>',
      'country_code' =>
      array (
        'hover_text' => 'Code ISO 3166-1 alpha-2 du pays. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/country/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez un pays bénéficiaire pour l’activité concernée. Cependant, vous <b><u>ne devez pas</u></b> renseigner de pays dans ce champ si vous souhaitez indiquer un pays bénéficiaire pour chaque transaction individuelle associée à l’activité.',
      ),
      'percentage' =>
      array (
        'hover_text' => 'Pourcentage de l’ensemble des engagements ou du budget total de l’activité correspondant à cet élément. Le contenu de ce champ doit être un nombre décimal compris entre 0 et 100, sans signe de pourcentage. La somme des pourcentages renseignés pour l’ensemble des pays et régions et pour un même vocabulaire doit être égale à 100.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-country/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez le pourcentage des fonds qui bénéficient à ce pays. La somme des pourcentages renseignés pour l’ensemble des pays et régions doit être égale à 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Instructions complémentaires.</a>',
      ),
      'narrative' =>
      array (
        'help_text' => 'Ajoutez le nom et/ou une description en texte libre du pays bénéficiaire de l’activité.',
      ),
    ),
    'recipient_region' =>
    array (
      'help_text' => 'Si vous n’êtes pas en mesure d’identifier le ou les pays bénéficiaires de cette activité, veuillez renseigner la région bénéficiaire.<br><br>Si une région est indiquée, elle doit s’ajouter aux pays renseignés. Si vous êtes en mesure d’identifier le ou les pays bénéficiaires, la région bénéficiaire correspondante ne doit pas être indiquée. Par exemple, si 100 % des fonds sont affectés à l’Ouganda, vous devez renseigner l’Ouganda en tant que pays bénéficiaire, sans ajouter l’Afrique comme région bénéficiaire.<br></br>Toutefois, si vous savez qu’au moins 80 % des fonds prévisionnels seront affectés à l’Ouganda, vous pouvez préciser que les 20 % restants seront affectés à la région Afrique.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>En savoir plus</a>',
      'hover_text' => 'Région géopolitique supranationale qui bénéficiera de cette activité. Pour sélectionner un lieu géographique infranational, utilisez l’élément de localisation. Plusieurs pays et régions peuvent être renseignés, auquel cas l’attribut de pourcentage DOIT être utilisé pour indiquer la part associée à chaque pays et région, sur l’ensemble des engagements. L’élément « région-bénéficiaire » ne doit pas être utilisé pour indiquer la région correspondant au pays renseigné en tant que « pays-bénéficiaire », mais UNIQUEMENT si la région en question est bénéficiaire EN PLUS du pays.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
      'region_vocabulary' =>
      array (
        'hover_text' => 'Code IITA pour le vocabulaire dont le code de région est issu. Si aucun code n’est renseigné, le vocabulaire 1 - « CAD-OCDE » s’applique par défaut.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
        'help_text' => 'Il existe deux listes de régions ; la liste du <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/region/\'>CAD de l’OCDE</a> et les listes de codes de <a target=\'_blank\' href=\'https://unstats.un.org/unsd/methodology/m49/\'>région des Nations Unies</a>. Veuillez sélectionner une option. L’IITA recommande l’usage de la liste de codes du CAD de l’OCDE. Vous pouvez également faire appel à une autre liste de régions, en sélectionnant l’option : « Organisation déclarante » et en indiquant l’URI correspondant à cette liste interne.<br></br>Si aucune option n’est sélectionnée, la liste de codes du CAD de l’OCDE s’applique par défaut.',
      ),
      'region_code' =>
      array (
        'hover_text' => 'Code du CAD de l’OCDE ou code de région des Nations Unies. La liste de codes est déterminée par l’attribut de vocabulaire. Cet attribut est obligatoire.</br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
      ),
      'custom_code' =>
      array (
        'hover_text' => 'Code du CAD de l’OCDE ou code de région des Nations Unies. La liste de codes est déterminée par l’attribut de vocabulaire. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. Bien qu’il s’agisse d’un champ facultatif, l’ensemble des signataires sont FORTEMENT ENCOURAGÉS à l’utiliser, afin de garantir la pleine compréhension de leurs codes par les utilisateurs des données.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
      ),
      'percentage' =>
      array (
        'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. Bien qu’il s’agisse d’un champ facultatif, l’ensemble des signataires sont FORTEMENT ENCOURAGÉS à l’utiliser, afin de garantir la pleine compréhension de leurs codes par les utilisateurs des données. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
        'help_text' => 'Pourcentage de l’ensemble des engagements ou du budget total de l’activité correspondant à cet élément. Le contenu de ce champ doit être un nombre décimal compris entre 0 et 100, sans signe de pourcentage. La somme des pourcentages renseignés pour l’ensemble des pays et régions et pour un même vocabulaire doit être égale à 100.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/recipient-region/\'>En savoir plus</a>',
      ),
      'narrative' =>
      array (
        'help_text' => 'Ajoutez le nom et/ou une description en texte libre de la région bénéficiaire de l’activité.',
      ),
      'language' =>
      array (
        'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
      ),
    ),
    'sector' =>
    array (
      'hover_text' => 'Code reconnu, issu d’un vocabulaire reconnu et permettant de catégoriser l’objectif de l’activité. Le secteur DOIT être renseigné ici OU au niveau des transactions pour TOUTES les transactions. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>En savoir plus</a>',
      'help_text' => 'Saisissez des informations concernant le secteur que l’activité cible ou soutient. Par exemple, l’éducation primaire ou l’agriculture. Vous pouvez sélectionner plusieurs secteurs, mais il est obligatoire d’en indiquer <b>au moins un</b>.',
      'sector_vocabulary' =>
      array (
        'hover_text' => 'Code IITA pour le vocabulaire (voir la liste de codes) utilisé à des fins de catégorisation sectorielle. Si aucun code n’est renseigné, les codes-objet à cinq caractères du CAD de l’OCDE s’appliquent par défaut. Dans la mesure du possible, il est conseillé d’avoir recours aux codes-objet à cinq caractères du CAD de l’OCDE. Si un signataire fait appel à son propre système ou à ses propres systèmes, il est également recommandé qu’il utilise le vocabulaire 99 ou 98 (vocabulaire propre à l’organisation déclarante) en plus des codes du CAD.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>En savoir plus</a>',
        'help_text' => 'Veuillez choisir la liste de secteurs que vous utiliserez pour sélectionner les secteurs ciblés par votre activité. L’IITA recommande l’usage de la liste de codes sectoriels à cinq caractères du CAD de l’OCDE, qui permet de choisir parmi plus de 300 secteurs différents.<br></br>En plus de la liste de codes à cinq caractères du CAD de l’OCDE, vous pouvez également faire appel à une autre liste (voir les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sectorvocabulary/\'>informations relatives aux différentes options disponibles</a>). Si vous souhaitez faire appel à la liste utilisée par votre organisation pour la classification interne des différents secteurs, choisissez l’option : « Organisation déclarante ».<br></br>Vous pouvez choisir plusieurs listes. Si vous faites appel à plusieurs outils de classification sectorielle interne, sélectionnez l’option « Organisation déclarante 2 » (qui correspond au code 98) pour la liste complémentaire.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>Instructions complémentaires.</a>',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 ou 98 (organisation déclarante), URI correspondant à ce vocabulaire interne. Bien qu’il s’agisse d’un champ facultatif, l’ensemble des signataires sont FORTEMENT ENCOURAGÉS à l’utiliser, afin de garantir la pleine compréhension de leurs codes par les utilisateurs des données.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez choisi de faire appel à une liste de codes interne pour la classification sectorielle, veuillez fournir un lien vers cette liste.',
      ),
      'percentage' =>
      array (
        'hover_text' => 'Pourcentage de l’ensemble des engagements ou du budget total de l’activité correspondant à cet élément. Le contenu de ce champ doit être un nombre décimal compris entre 0 et 100, sans signe de pourcentage. La somme des différents secteurs renseignés pour un même vocabulaire doit être égale à 100. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez sélectionné plus d’un secteur (dans la même liste), chaque secteur doit être associé à un pourcentage. Ces pourcentages peuvent ensuite être appliqués aux fonds disponibles pour estimer le montant des ressources affectées à chaque secteur. Par exemple, en utilisant la liste de codes à cinq caractères du CAD de l’OCDE, on peut envisager l’allocation de 50 % des fonds de l’activité au secteur « formation des enseignants » (code 11130) et 50 % au secteur « éducation primaire » (code 11220).',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Description d’un secteur identifié par l’organisation déclarante. (À remplir uniquement si l’organisation déclarante emploie son propre vocabulaire).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/narrative/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez choisi un secteur issu d’une liste interne de classification sectorielle, veuillez fournir une description de ce secteur.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/sector/narrative/\'>En savoir plus</a>',
      ),
    ),
    'tag' =>
    array (
      'hover_text' => 'Classifications fondées sur des taxonomies reconnues qui permettent d’enrichir la catégorisation de l’activité, mais qui, contrairement à celles renseignées dans l’élément de secteur, ne peuvent être associées à un pourcentage des fonds disponibles. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez ajouter d’autres informations utiles concernant votre activité en l’« étiquetant » selon des classifications fondées sur des taxonomies reconnues.<br></br>L’IITA recommande par exemple que, dans la mesure du possible, votre activité soit étiquetée en fonction du ou des objectifs de développement durable auxquels elle contribue. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sdg-guidance/\'>Veuillez prendre connaissance des directives consacrées à la publication des données relatives aux objectifs de développement durable des Nations Unies.</a>',
      'tag_vocabulary' =>
      array (
        'hover_text' => 'Code IITA pour le vocabulaire ou la méthode de classification (voir la liste de codes non intégrée) utilisé pour la catégorisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>En savoir plus</a>',
        'help_text' => 'Choisissez une liste. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tagvocabulary/\'>Voir les informations relatives aux différentes options disponibles</a>. Vous pouvez choisir d’étiqueter votre activité selon une liste de catégories interne en sélectionnant « Organisation déclarante ».',
      ),
      'targets_tag_code' =>
      array (
        'hover_text' => 'Code de l’étiquette tel qu’il est défini dans le vocabulaire spécifique utilisé.<br><br>Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>En savoir plus</a>',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'URI correspondant au vocabulaire sélectionné.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/\'>En savoir plus</a>',
        'help_text' => 'Fournissez un lien vers la liste choisie.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/narrative/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez fournir des informations complémentaires concernant l’option que vous avez choisie.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/tag/narrative/\'>En savoir plus</a>',
      ),
    ),
    'policy_marker' =>
    array (
      'hover_text' => 'Politique ou thème abordé dans le cadre de l’activité. Cet élément a été conçu pour permettre de renseigner les marqueurs politiques du SNPC du CAD de l’OCDE (colonnes 20-23 et 28-31 du format de publication du SNPC++), mais l’attribut de vocabulaire permet son utilisation par d’autres systèmes (y compris locaux). Cet élément peut être répété pour chaque marqueur politique.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
      'help_text' => 'Fournissez des informations concernant la politique ou le thème abordé par votre activité, par exemple : la lutte contre les changements climatiques ou le handicap. Une même activité peut être associée à plusieurs marqueurs politiques et il <b>n’est pas</b> nécessaire d’ajouter un pourcentage à chaque marqueur.',
      'policy_marker_vocabulary' =>
      array (
        'hover_text' => 'Code IITA correspondant au vocabulaire utilisé pour définir les marqueurs politiques. Si aucun code n’est renseigné, le vocabulaire du CAD de l’OCDE s’applique par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez une liste comprenant le ou les marqueurs politiques associés à votre activité.<br></br><b>1 SNPC du CAD de l’OCDE</b> - l’IITA vous recommande de choisir cette liste, qui vous permet de choisir parmi <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/policymarker/\'>12 options</a>.<br></br><b>99 Organisation déclarante</b> - choisissez cette option si vous souhaitez fournir un code de marqueur politique établi et suivi par votre organisation.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez sélectionné l’option « 99 Organisation déclarante » (ci-dessus), veuillez fournir un lien vers la liste comprenant le marqueur politique choisi.',
      ),
      'significance' =>
      array (
        'hover_text' => 'Code du SNPC du CAD de l’OCDE permettant d’expliciter le marqueur politique choisi pour cette activité. Cet attribut DOIT être utilisé pour l’ensemble des vocabulaires du SNPC du CAD de l’OCDE.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez choisi une politique ou un thème issu de la liste du SNPC du CAD de l’OCDE, vous devez préciser sa place au sein de votre activité. Par exemple, il peut s’agir de l’objectif principal de votre activité ou d’un objectif important. Veuillez prendre connaissance des <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/policysignificance/\'>informations relatives aux différentes options disponibles avant de faire votre choix</a>.',
      ),
      'policy_marker' =>
      array (
        'hover_text' => 'Code de marqueur politique issu de la liste de codes indiquée dans le vocabulaire. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
      ),
      'policy_marker_text' =>
      array (
        'hover_text' => 'Code de marqueur politique issu de la liste de codes indiquée dans le vocabulaire. Cet attribut est obligatoire.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/\'>En savoir plus</a>',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Description du marqueur politique. Cet élément doit être utilisé UNIQUEMENT si le vocabulaire sélectionné est 99 (vocabulaire propre à l’organisation déclarante). Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/narrative/\'>En savoir plus</a>',
        'help_text' => 'Si vous avez sélectionné l’option « 99 Organisation déclarante » (ci-dessus), veuillez fournir une description du ou des marqueurs politiques choisis.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <br>This value should be on the Language codelist.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/policy-marker/narrative/\'>En savoir plus</a>',
      ),
    ),
    'collaboration_type' =>
    array (
      'hover_text' => 'Type de collaboration correspondant aux décaissements liés à l’activité, p. ex. « bilatérale » ou « multilatérale ».<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/collaboration-type/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez décrire la manière dont les fonds circulent entre les différentes organisations impliquées dans l’activité. Par exemple, les fonds peuvent circuler de manière bilatérale, c’est-à-dire entre deux gouvernements. Cet élément est particulièrement adapté aux organisations bilatérales et multilatérales.',
      'collaboration_type' =>
      array (
        'hover_text' => 'Code issu de la liste de codes « Bi_Multi » du SNCP du CAD de l’OCDE .<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/collaboration-type/\'>En savoir plus</a>',
        'help_text' => 'Veuillez sélectionner un type de collaboration, si l’une des options proposées correspond à votre activité. Voir les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/collaborationtype/\'>informations relatives aux différentes options disponibles</a>. Sinon, laissez le champ vide.',
      ),
    ),
    'default_flow_type' =>
    array (
      'hover_text' => 'Financement de l’activité par l’aide publique au développement (APD), les autres apports du secteur public (AASP), etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>En savoir plus</a>',
      'help_text' => 'Le type de flux constitue un autre moyen de catégoriser les flux financiers. Il permet de distinguer l’aide publique au développement (APD), les autres apports du secteur public (AASP) et les différents types de flux privés, notamment les subventions privées, généralement octroyées par les ONG ou par d’autres organisations de la société civile.',
      'default_flow_type' =>
      array (
        'hover_text' => 'Code du SNCP du CAD de l’OCDE issu de la liste de codes « Types de flux ». Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>En savoir plus</a>',
        'help_text' => 'Si les fonds de l’activité peuvent être catégorisés selon les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/\'>options suivantes</a>, veuillez sélectionner les catégories correspondantes. Sinon, laissez le champ vide.',
      ),
    ),
    'default_finance_type' =>
    array (
      'hover_text' => 'Type de financement (p. ex. subvention, prêt, allègement de la dette, etc.). Cet élément propose une valeur par défaut pour l’ensemble des transactions mentionnées dans le rapport d’activité ; il peut être remplacé par des valeurs transaction par transaction.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/\'>En savoir plus</a>',
      'help_text' => 'Le type de financement permet de préciser quel est l’instrument financier utilisé pour cette activité. Ainsi, le plus souvent, les financements sont octroyés sous la forme de subventions ou de prêts.',
      'default_finance_type' =>
      array (
        'hover_text' => 'Code du SNPC du CAD de l’OCDE issu de la liste de codes « Types de financement ». Cet attribut est obligatoire.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/\'>En savoir plus</a>',
        'help_text' => 'Veuillez sélectionnez un type de financement pour cette activité en choisissant parmi les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/financetype/\'>options suivantes</a>.',
      ),
    ),
    'default_aid_type' =>
    array (
      'default_aid_type_vocabulary' =>
      array (
        'hover_text' => 'Code du vocabulaire utilisé pour catégoriser le type d’aide. Si aucun code n’est renseigné, la liste de codes de types d’aide (CAD-OCDE) s’applique par défaut. Le code doit correspondre à une valeur valide issue de la liste de codes du vocabulaire d type d’aide. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez une liste comprenant le type d’aide concerné par votre activité (si possible). Sinon, laissez le champ vide. Vous pouvez sélectionnez l’élément type-aide dans plusieurs listes.<br></br>]<b>1 CAD-OCDE</b> - l’IITA recommande l’emploi de cette liste, qui comprend <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>plus de 20 options</a>. Vous pouvez ensuite compléter votre choix en sélectionnant une option issue d’une autre liste<br></br><b>2 Catégorie d’affectation</b> - choisissez <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/earmarkingcategory/\'>cette liste</a> pour caractériser la flexibilité des financements humanitaires. Il existe quatre catégories d’affectation. Pour en savoir plus sur les différentes catégories, consultez l’<a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>annexe 1</a><br></br><b>3. Modalité d’affectation</b> - utilisez cette liste pour choisir une modalité d’affectation spécifique, correspondant au financement humanitaire de votre activité. Toutes les modalités d’affectation sont <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>recensées dans l’annexe 1</a><br></br><b>4. Modalités d’aide en espèces et en coupons</b> - utilisez cette liste pour indiquer si votre activité fournit une aide en espèces ou en coupons, en réaction à une situation humanitaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/CashandVoucherModalities/\'>En savoir plus</a>.</br>',
      ),
      'default_aid_type' =>
      array (
        'hover_text' => 'Code issu du vocabulaire indiqué. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/\'>En savoir plus</a>',
      ),
    ),
    'default_tied_status' =>
    array (
      'hover_text' => 'Aide non conditionnelle, conditionnelle ou semi-conditionnelle. Cet élément propose une valeur par défaut pour l’ensemble des transactions financières liées à l’activité ; il peut être remplacé par des valeurs transaction par transaction.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez indiquer le type de conditionnalité correspondant à cette transaction. Dans cet élément, vous pouvez préciser si les fonds octroyés sont conditionnels – auquel cas ils doivent être dépensés pour l’achat de biens et de services auprès d’un pays (p. ex. le pays donateur) ou d’un groupe de pays spécifique. Ou s’ils sont non conditionnels – auquel cas il est possible d’effectuer des achats auprès de n’importe quel pays.',
      'default_tied_status' =>
      array (
        'hover_text' => 'Code IITA permettant d’interpréter l’usage des colonnes 36-38 du format de publication du SNPC++. (Montant non conditionnel, montant semi-conditionnel, montant conditionnel). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/\'>En savoir plus</a>',
        'help_text' => 'Si votre activité le permet, sélectionnez un type de conditionnalité par défaut. Voir la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tiedstatus/\'>description des différentes options disponibles</a>. Sinon, laissez le champ vide.',
      ),
    ),
    'country_budget_items' =>
    array (
      'hover_text' => 'Cet élément permet d’encoder l’alignement des activités avec les classifications fonctionnelles et administratives employées dans le plan comptable du pays bénéficiaire. Il s’applique à la fois aux activités budgétaires et non budgétaires.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/\'>En savoir plus</a>',
      'country_budget_vocabulary' =>
      array (
        'hover_text' => 'Code IITA pour la classification fonctionnelle commune ou le système utilisé à l’échelle nationale (cet élément permet d’indiquer les codes communs, les codes employés à l’échelle nationale ou toute autre classification adoptée par les pays et les donateurs). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/\'>En savoir plus</a>',
      ),
      'budget_item' =>
      array (
        'hover_text' => 'Identifiant pour un élément unique du budget du pays bénéficiaire. Si plus d’un identifiant est renseigné, un pourcentage devra leur être associé et la somme de tous les pourcentages indiqués devra être égale à 100 %.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>En savoir plus</a>',
        'code' =>
        array (
          'hover_text' => 'Code pour l’élément budgétaire issu du vocabulaire indiqué. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>En savoir plus</a>',
        ),
        'percentage' =>
        array (
          'hover_text' => 'Lorsque plusieurs éléments budgétaires sont associés à un seul élément de budget de pays, la somme des pourcentages correspondants doit être égale à 100 % pour chaque vocabulaire utilisé.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/\'>En savoir plus</a>',
          'help_text' => 'Si aucune valeur n’est renseignée, la valeur par défaut s’applique.',
        ),
        'description' =>
        array (
          'hover_text' => 'Description plus complète, lisible par l’être humain, de l’élément budgétaire. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/\'>En savoir plus</a>',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/narrative/\'>En savoir plus</a>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/country-budget-items/budget-item/description/narrative/\'>En savoir plus</a>',
        ),
      ),
    ),
    'humanitarian_scope' =>
    array (
      'hover_text' => 'Classification des situations d’urgence, des appels et autres événements et interventions humanitaires concernés. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>En savoir plus</a>',
      'help_text' => 'L’élément « portée-humanitaire » peut être utilisé pour indiquer à quelle situation d’urgence et/ou à quel appel votre activité répond.',
      'type' =>
      array (
        'hover_text' => 'Code correspondant au type d’événement ou d’action concerné par la classification. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez le type d’informations que vous êtes en mesure de fournir :<br></br><li><b>Situations d’urgence (type 1)</b><br>Choisissez cette option si vous êtes en mesure de fournir le numéro GLIDE correspondant à la situation d’urgence humanitaire à laquelle répond votre activité. Le cas échéant, choisissez cette option si vous êtes en mesure de fournir un code issu d’une autre liste publique et correspondant à la situation d’urgence en question.<br><br></li><li><b>Appels (type 2)</b><br>Choisissez cette option si votre activité s’inscrit dans un <a target=\'_blank\' href=\'https://fts.unocha.org/plan-code-list-iati\'>plan d’intervention humanitaire ou dans un appel éclair</a> du Bureau de la coordination des affaires humanitaires des Nations Unies (OCHA). Ces codes ont été créés par l’OCHA dans le cadre de leur Service de surveillance financière. Le cas échéant, choisissez cette option si vous êtes en mesure de fournir un code issu d’une autre liste publique et correspondant à l’appel en question.</li></ul>',
      ),
      'vocabulary' =>
      array (
        'hover_text' => 'Code issu d’un vocabulaire reconnu et correspondant à l’événement ou à l’intervention concerné.<br><br>Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez la liste que vous souhaitez utiliser pour identifier la situation d’urgence ou l’appel auquel répond votre activité :</br><br><b>1-2 <a target=\'_blank\' href=\'http://glidenumber.net/glide/public/search/search.jsp\'>Numéro GLIDE</a></b></br><b>2-1 <a target=\'_blank\' href=\'https://fts.unocha.org/plan-code-list-iati\'>Plan d’intervention humanitaire</a></b></br><b>99 Organisation déclarante</b> - choisissez cette option si vous êtes en mesure de fournir un code issu d’une autre liste publique et correspondant à la situation d’urgence ou à l’appel humanitaire concerné.',
      ),
      'vocabulary_uri' =>
      array (
        'hover_text' => 'URI renvoyant au vocabulaire utilisé et donnant accès à la liste des codes et aux descriptions correspondantes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>En savoir plus</a>',
        'help_text' => 'Renseignez un lien vers la liste des situations d’urgence et des appels humanitaires que vous souhaitez utiliser, avec les codes et les descriptions correspondants.',
      ),
      'code' =>
      array (
        'hover_text' => 'Code pour l’événement ou l’intervention concerné dans le vocabulaire sélectionné.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/\'>En savoir plus</a>',
        'help_text' => 'Renseignez le code correspondant à la situation d’urgence ou à l’appel humanitaire auquel votre activité répond.<br></br>Par exemple, si vous saisissez un code pour une situation d’urgence associée à un <a target=\'_blank\' href=\'https://glidenumber.net/glide/public/search/search.jsp\'>numéro GLIDE</a>, ce code aura pour format : [Type d’urgence] + [Année] + [Numéro] + [Pays].',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Description du code indiqué. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/narrative/\'>En savoir plus</a>',
        'help_text' => 'Si le code saisi pour la situation d’urgence ou l’appel humanitaire est issu d’une autre liste publique (c’est-à-dire si vous avez choisi la mention « 99 Organisation déclarante » dans le champ ci-dessus), veuillez fournir une description du code choisi.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/humanitarian-scope/narrative/\'>En savoir plus</a>',
      ),
    ),
    'capital_spend' =>
    array (
      'hover_text' => 'Pourcentage de l’engagement total consacré aux dépenses d’investissement. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/capital-spend/\'>En savoir plus</a>',
      'help_text' => 'Veuillez indiquer quelle sera la part consacrée aux dépenses d’investissement sur le montant total des fonds affectés à l’activité. Les dépenses d’investissement portent sur des biens physiques ayant une durée de vie utile de plus d’un an. Par exemple, une route.',
      'capital_spend' =>
      array (
        'hover_text' => 'Pourcentage effectif ou prévisionnel de l’engagement total réservé aux dépenses d’investissement. Le contenu de ce champ doit être un nombre décimal compris entre 0 et 100, sans signe de pourcentage.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/capital-spend/\'>En savoir plus</a>',
        'help_text' => 'La somme des pourcentages ne doit pas être supérieure à 100.',
      ),
    ),
    'related_activity' =>
    array (
      'hover_text' => 'Autre activité de l’IITA renseignée de manière distincte et ayant un lien avec cette activité. L’attribut « type » décrit le type de relation (p. ex. activité principale, activité secondaire, financements multiples). Au sein d’un groupe d’activités hiérarchisées, il est fortement recommandé d’utiliser systématiquement cet élément en renseignant le @type 1 (activité principale) ou 2 (activité secondaire). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/related-activity/\'>En savoir plus</a>',
      'help_text' => 'Si cette activité fait partie d’un programme composé de plusieurs activités au sein d’une même organisation, vous devez fournir une description de l’ensemble des activités connexes. Pour en savoir plus, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/relatedactivitytype/\'>informations relatives aux différents types d’activités connexes</a> susceptibles d’être renseignées.</br></br>Attention : ce champ est exclusivement réservé à <b>vos <u>propres</u></b> activités.',
      'activity_identifier' =>
      array (
        'hover_text' => 'Identifiant d’activité valide (tel que défini dans l’élément activité-IITA/identifiant-IITA).',
        'help_text' => 'Si vous avez une activité connexe à déclarer, veuillez indiquer son identifiant d’activité complet (y compris la partie correspondant à l’identifiant d’organisation). Voir les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-overview/preparing-your-data/activity-information/creating-iati-identifiers/\'>informations complémentaires concernant les identifiants d’activité</a>. Vous pouvez obtenir ces informations auprès des personnes ayant déclaré l’activité connexe, ou trouver l’activité en question sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires</a>.',
      ),
      'relationship_type' =>
      array (
        'hover_text' => 'Code IITA pour le type de relation.',
        'help_text' => 'Veuillez sélectionner le type de relation entre l’activité déclarée et l’activité connexe en vous appuyant sur <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/relatedactivitytype/\'>cette liste</a>.',
      ),
    ),
    'conditions' =>
    array (
      'hover_text' => 'Conditions générales encadrant la mise en œuvre de l’activité et susceptibles, en cas de manquement, d’avoir une incidence sur les engagements contractés par les organisations participantes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/conditions/\'>En savoir plus</a>',
      'help_text' => 'Veuillez fournir toute information relative aux conditions générales qui encadrent la mise en œuvre de cette activité. Il peut s’agir, par exemple, de conditions imposées par votre bailleur de fonds ou d’un bilan d’étape à six mois destiné à évaluer l’opportunité de prolonger l’activité.<br></br>Si une condition se rapporte à l’ensemble de l’organisation, par exemple les conditions générales de l’organisation, celle-ci ne doit pas être saisie pour cette activité. Elle devra figurer dans l’élément « lien-document » présent dans le fichier de votre organisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/conditions/\'>Instructions complémentaires</a>.',
      'condition_attached' =>
      array (
        'hover_text' => 'Valeur en « oui/non » (1/0) indiquant si cette activité est soumise à une ou plusieurs conditions. Il est fortement recommandé de renseigner cet attribut, même si l’activité n’est soumise à aucune condition (conditionnalité = « 0 »).',
        'help_text' => 'Veuillez choisir la mention « Oui » si votre activité est soumise à une ou plusieurs conditions et « Non » si tel n’est pas le cas.',
      ),
      'condition' =>
      array (
        'hover_text' => 'Texte décrivant la condition spécifiquement associée à l’activité. Les conditions générales de l’organisation, applicables à l’ensemble des activités, ne doivent pas être saisies ici, mais dans l’élément organisation-iita/lien-document ou activité-iita-lien-document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/conditions/condition/\'> En savoir plus</a>',
      ),
      'condition_type' =>
      array (
        'hover_text' => 'Code IITA correspondant au type de condition concerné.',
        'help_text' => 'Sélectionnez le type de condition que vous souhaitez renseigner. Trois catégories de conditions peuvent être renseignées :<br></br><b>Conditions stratégiques</b> : p. ex. un objectif stratégique que l’organisation bénéficiaire des fonds devra mettre en œuvre.<br></br><b>Conditions de performance</b> : p. ex. certains produits ou réalisations à atteindre.<br></br><b>Conditions fiduciaires</b> : p. ex. le bénéficiaire doit mettre en œuvre certaines mesures en matière de gestion des finances publiques ou de responsabilité publique.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/conditiontype/\'>Description complète des différents types de conditions</a>.',
      ),
      'narrative' =>
      array (
        'help_text' => 'Saisissez une brève description de la condition dans le champ suivant.<br></br>Pour fournir plus d’informations, vous pouvez ajouter un lien vers un document ou un site Internet dans l’élément lien-document de l’activité.',
      ),
    ),
    'legacy_data' =>
    array (
      'hover_text' => 'L’élément de données historiques permet de renseigner des valeurs issues d’un champ de saisie propre au système de l’organisation déclarante et présentant des points communs avec un élément de l’IITA, sans pour autant être identique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/legacy-data/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez faire appel à des données internes de votre organisation ayant trait à cette activité et préciser quel élément de la norme de l’IITA se rapproche le plus de ce type d’informations.',
      'legacy_name' =>
      array (
        'hover_text' => 'Dénomination du champ de saisie original au sein du système de l’organisation déclarante.',
      ),
      'value' =>
      array (
        'hover_text' => 'Valeur inscrite dans le champ de saisie original au sein du système de l’organisation déclarante.',
      ),
      'iati_equivalent' =>
      array (
        'hover_text' => 'Nom de l’élément de l’IITA correspondant.',
      ),
    ),
    'document_link' =>
    array (
      'hover_text' => 'Lien vers un site Internet ou un document en ligne, accessible au grand public. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez ajouter des informations complémentaires relatives à cette activité en fournissant un lien vers un site Internet ou un document accessible au grand public.<br></br>S’il existe des documents disponibles dans d’autres langues et stockés séparément, veuillez les ajouter également en créant de nouveaux éléments d’ajout de documents.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/related-documents/\'>Instructions complémentaires</a>',
      'url' =>
      array (
        'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ».<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>En savoir plus</a>',
      ),
      'format' =>
      array (
        'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/\'>En savoir plus</a>',
        'help_text' => 'Si vous connaissez le format du document, veuillez le saisir en choisissant <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/fileformat/\'>une option dans cette liste</a>.',
      ),
      'title' =>
      array (
        'hover_text' => 'Titre court et lisible par un être humain.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/title/\'>En savoir plus.</a>',
      ),
      'description' =>
      array (
        'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/description/\'>En savoir plus</a>',
      ),
      'category' =>
      array (
        'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/category/\'>En savoir plus</a>',
        'code' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/category/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez une catégorie pour le document ou le site Internet que vous avez renseigné, en vous appuyant sur <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/documentcategory/\'>cette liste</a>.',
        ),
      ),
      'language' =>
      array (
        'code' =>
        array (
          'help_text' => 'Sélectionnez la langue du document ou de la page Internet.',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Date de publication du document associé. (@iso-date).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/document-link/document-date/\'>En savoir plus</a>',
        'date'=>
        array(
            'hover_text' => 'Date de publication du document vers lequel renvoie le lien ajouté. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/document-date/\'>En savoir plus</a>',
        )
      ),
    ),
    'location' =>
    array (
      'hover_text' => 'Informations permettant d’identifier les zones infranationales ciblées par l’activité. Ces informations peuvent prendre la forme d’une nomenclature géographique, de coordonnées, de zones administratives ou d’une description textuelle. Vous pouvez renseigner autant de zones géographiques que vous le souhaitez.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/\'>En savoir plus</a>',
      'help_text' => 'Si vous les connaissez, renseignez les zones géographiques ciblées par l’activité. Attention toutefois : <b>les données relatives au lieu géographique ne doivent être saisies que si leur diffusion ne représente aucun danger.</b> Il appartient à l’organisation déclarante de s’assurer que les données qu’elles publient ne représentent aucun danger.<br></br>Vous pouvez saisir les coordonnées géographiques d’un lieu, son nom et sa description, la zone administrative ou toute autre caractéristique permettant de l’identifier (centre de santé, village, etc.).<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>Instructions complémentaires.</a>',
      'reference' =>
      array (
        'hover_text' => 'Code de référence utilisé par l’organisation déclarante pour mentionner le lieu concerné en interne.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez saisir un code de référence interne utilisé par votre organisation pour caractériser le lieu concerné, par exemple : AF-KAN.',
      ),
      'location_id' =>
      array (
        'hover_text' => 'Code unique permettant de caractériser le lieu selon une nomenclature ou un répertoire des frontières administratives reconnu. Les zones administratives ne doivent être renseignées ici que si le lieu concerné est lui-même une zone administrative. Pour caractériser une zone administrative au sein de laquelle se trouve un lieu plus circonscrit, veuillez utilisez l’élément lieu/zone-administrative.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez saisir un code unique permettant de caractériser le lieu selon une nomenclature ou un répertoire des frontières administratives reconnu. Vous pouvez choisir une nomenclature ou un répertoire des frontières administratives dans la liste ci-dessous.',
        'vocabulary' =>
        array (
          'hover_text' => 'Code IITA correspondant à une nomenclature ou à un répertoire des frontières administratives reconnu.</br>Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>En savoir plus</a>',
          'help_text' => 'Veuillez choisir la nomenclature ou le répertoire des frontières administratives dont est issu le code que vous comptez saisir.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicvocabulary/\'>En savoir plus sur les différentes options disponibles.</a>',
        ),
        'code' =>
        array (
          'hover_text' => 'Code issu de la nomenclature ou du répertoire des frontières administratives spécifié par le vocabulaire.</br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-id/\'>En savoir plus</a>',
          'help_text' => 'Saisissez un code unique permettant de caractériser le lieu selon une nomenclature ou un répertoire des frontières administratives reconnu <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicvocabulary/\'>(voir la liste).</a>',
        ),
      ),
      'location_reach' =>
      array (
        'hover_text' => 'Le lieu indiqué correspond-il à la zone de mise en œuvre de l’activité ou à la zone de résidence des bénéficiaires ciblés ? <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-reach/\'>En savoir plus</a>',
        'help_text' => 'Veuillez préciser si le lieu indiqué correspond à la zone de mise en œuvre de l’activité ou à la zone de résidence des bénéficiaires ciblés.',
        'code' =>
        array (
          'hover_text' => 'Code IITA correspondant à la portée géographique de l’activité. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-reach/\'>En savoir plus</a>',
          'help_text' => 'Veuillez sélectionner une option permettant de caractériser la nature du lieu indiqué.<br><br>1. <b>Activité</b> - Le lieu indiqué correspond à la zone de mise en œuvre de l’activité<br><br>2. <b>Bénéficiaires ciblés</b> - Le lieu indiqué correspond à la zone de résidence des bénéficiaires ciblés par l’activité</li></ol>',
        ),
      ),
      'name' =>
      array (
        'hover_text' => 'Nom du lieu, lisible par un être humain.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/\'>En savoir plus</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez le nom en texte libre du lieu de mise en œuvre de l’activité.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/name/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Description permettant de caractériser le lieu, et non l’activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/\'>En savoir plus</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/narrative/\'>En savoir plus</a>',
          'help_text' => 'Fournissez une description du lieu de mise en œuvre de l’activité.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/description/narrative/\'>En savoir plus</a>',
        ),
      ),
      'activity_description' =>
      array (
        'hover_text' => 'Description permettant de caractériser l’activité mise en œuvre dans le lieu renseigné. Cet élément ne doit pas répéter les informations déjà saisies dans la description principale de l’activité, mais permettre de différencier les activités mises en œuvre dans des lieux distincts au sein d’un même fichier d’activité-IITA.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/\'>En savoir plus</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/narrative/\'>En savoir plus</a>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/activity-description/narrative/\'>En savoir plus</a>',
        ),
      ),
      'administrative' =>
      array (
        'hover_text' => 'Codes d’identification des juridictions nationales et infranationales établies par les répertoires des frontières administratives reconnus. Vous pouvez renseigner plusieurs niveaux.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez saisir un code unique permettant de caractériser le lieu de l’activité selon un répertoire des frontières administratives.',
        'vocabulary' =>
        array (
          'hover_text' => 'Code IITA correspondant à un répertoire des frontières administratives reconnu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez une <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>liste des frontières administratives</a> comprenant un code qui permettra de caractériser le lieu de votre activité.',
        ),
        'code' =>
        array (
          'hover_text' => 'Code issu du vocabulaire spécifié et correspondant à la zone administrative renseignée.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez un code permettant de caractériser le lieu de votre activité (et issu de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>liste des frontières administratives</a> que vous avez choisie).',
        ),
        'level' =>
        array (
          'hover_text' => 'Numéro permettant de caractériser une subdivision au sein d’un système hiérarchisé de zones administratives. Le système permettant d’attribuer une signification précise à chaque valeur de @level dépend du @vocabulary utilisé.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/administrative/\'>En savoir plus</a>',
          'help_text' => 'Au sein de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicVocabulary/\'>liste de frontières administratives</a> sélectionnée, vous pouvez choisir un nombre qui permettra de caractériser une subdivision au sein d’un système hiérarchisé de zones administratives.',
        ),
      ),
      'point' =>
      array (
        'hover_text' => 'L’élément « point » est fondé sur un sous-ensemble de l’élément « point » du langage GML 3.3.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez fournir les coordonnées géographiques du lieu sous la forme de coordonnées de latitude et de longitude<br></br>Les coordonnées sont publiées par l’intermédiaire des éléments « point » et « position ». L’élément « point » prend toujours la forme : <point srsName=\'http://www.opengis.net/def/crs/EPSG/0/4326\'><br></br>L’élément « position » indique ensuite les coordonnées de latitude (premier numéro), suivies des coordonnées de longitude (deuxième numéro), p. ex. -46.7733 167.6321.<br></br>Attention : les coordonnées peuvent renvoyer à un lieu précis ou approximatif. Le degré d’exactitude doit être spécifié dans l’élément consacré à l’exactitude du lieu.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sub-national-locations/\'>En savoir plus.</a>',
        'srs_name' =>
        array (
          'hover_text' => 'Nom du système de référence spatiale correspondant aux coordonnées indiquées.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/\'>En savoir plus</a>',
          'help_text' => 'Cette valeur ne change jamais.',
        ),
        'pos' =>
        array (
          'hover_text' => 'Coordonnées de latitude et de longitude au format « lat lng ».<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/point/pos/\'>En savoir plus</a>',
          'help_text' => 'Renseignez les coordonnées de latitude et de longitude séparées par une espace, p. ex. 31.616944 65.716944<br></br>Si vous ne disposez pas encore d’un outil permettant de trouver les coordonnées d’une activité, il existe des plateformes en ligne pour vous aider, p. ex. <a target=\'_blank\' href=\'https://www.google.com/maps/\'>Google Maps</a> et <a target=\'_blank\' href=\'https://www.latlong.net/\'>Latlong.net</a>. Pour trouver les coordonnées d’une activité sur Google Maps, faites un clic droit sur le lieu de l’activité. Ses coordonnées s’afficheront. Vous pouvez également taper les coordonnées et le lieu de l’activité, qui sera alors localisée sur la carte.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/sub-national-locations/\'>En savoir plus.</a>',
        ),
      ),
      'exactness' =>
      array (
          'hover_text' => 'Indiquez si le lieu choisi correspond à l’emplacement le plus précis susceptible d’être associé à ce type d’activité ou s’il s’agit d’une approximation, due à un manque d’informations suffisamment détaillées.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/exactness/\'>En savoir plus</a>',
          'code' =>
              array (
                  'hover_text' => 'Code issu de la liste de codes relative à l’exactitude géographique. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/exactness/\'>En savoir plus</a>',
                  'help_text' => 'Si vous avez renseigné des coordonnées géographiques pour le lieu de l’activité, sélectionnez une option dans la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/geographicexactness/\'>liste de codes relative à l’exactitude géographique</a> afin de préciser si la désignation du lieu est exacte ou approximative.',
              ),
      ),
      'location_class' =>
      array (
          'hover_text' => 'Type de lieu renseigné : structure, zone peuplée (p. ex. ville ou village), division administrative ou autre catégorie topographique (p. ex. cours d’eau, réserve naturelle).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-class/\'>En savoir plus</a>',
          'code' =>
              array (
                  'hover_text' => 'Code issu de la liste de codes relative aux catégories de lieux. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/location-class/\'>En savoir plus</a>',
                  'help_text' => 'Veuillez préciser à quelle catégorie de lieu correspond l’emplacement choisi pour l’activité, à partir de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/GeographicLocationClass/\'>liste de codes relative aux catégories de lieux</a>. Par exemple, une zone peuplée (ville, ferme) ou une catégorie topographique (montagne, cours d’eau).',
              ),
      ),
      'feature_designation' =>
      array (
          'hover_text' => 'Code de classification plus précis permettant d’identifier la catégorie topographique correspondant à ce lieu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/feature-designation/\'>En savoir plus</a>',
          'code' =>
              array (
                  'hover_text' => 'Code d’identification désignant la catégorie topographique et issu de la liste officielle (mise à jour par la National Geospatial-Intelligence Agency des États-Unis).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/location/feature-designation/\'>En savoir plus</a>',
                  'help_text' => 'Vous pouvez ajouter des informations complémentaires concernant la catégorie de lieu correspondant à votre activité (p. ex. plage, puits ou université). Veuillez choisir une option parmi la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/LocationType/\'>liste des catégories de lieux.</a>',
              ),
      ),
    ),
    'planned_disbursement' =>
    array (
      'hover_text' => 'L’élément relatif aux décaissements prévisionnels ne doit être utilisé que pour renseigner des transferts en espèces spécifiques et déjà planifiés. Ces décaissements doivent être associés à une date précise ou à une période suffisamment prévisible.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/\'>En savoir plus</a>',
      'help_text' => 'Dans le cadre des informations publiées pour cette activité, vous pouvez saisir des données relatives aux transferts en espèces déjà planifiés entre votre organisation et une autre organisation, ou entre deux autres organisations.<br></br>Les informations relatives à la planification des décaissements permettent la publication de programmes de paiement préétablis. Les décaissements planifiés doivent être associés à une date précise ou à une période suffisamment prévisible. Les décaissements planifiés doivent être renseignés en complément du budget de l’activité et ne doivent pas le remplacer.',
      'period_start' =>
      array (
        'hover_text' => 'Date exacte prévue pour le décaissement OU date de début de la période au cours de laquelle il doit avoir lieu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/period-start/\'>En savoir plus</a>',
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période au cours de laquelle le décaissement doit avoir lieu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/period-end/\'>En savoir plus</a>',
      ),
      'planned_disbursement_type' =>
      array (
        'hover_text' => 'Les informations relatives à la planification des décaissements permettent la publication de programmes de paiement préétablis.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/\'>En savoir plus</a>',
        'help_text' => 'Précisez s’il s’agit d’un décaissement « initial » (planifié dans le cadre de l’engagement initial) ou s’il a été « révisé » par la suite.',
      ),
      'value' =>
      array (
        'hover_text' => 'Montant prévisionnel du décaissement, dans la devise choisie. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>En savoir plus</a>',
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. Cet élément est obligatoire pour tous les montants exprimés en devise, sauf lorsque l’attribut organisation-iita/@default-currency est indiqué. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la devise dans laquelle vous avez indiqué la valeur. Si aucune valeur n’est renseignée, la valeur par défaut s’applique.',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/value/\'>En savoir plus</a>',
          'help_text' => 'Saisissez la date prévue pour le décaissement.',
        ),
      ),
      'provider_org' =>
      array (
        'hover_text' => 'Organisation à l’origine du décaissement prévu. Si aucune organisation n’est renseignée, l’organisation déclarante s’applique par défaut.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>En savoir plus</a>',
        'help_text' => 'Votre organisation sera-t-elle à l’origine de ce décaissement ? Si oui, vous êtes l’organisation responsable de l’octroi des fonds. Si non, veuillez saisir les informations relatives à l’organisation responsable de ce décaissement.',
        'reference' =>
        array (
          'hover_text' => 'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. Doit respecter le format {OrganismeD’enregistrement}-{NuméroD’enregistrement}, dans lequel {OrganismeD’enregistrement} correspond à un code valide, présent sur la liste des organismes d’enregistrement des organisations, et {NuméroD’enregistrement} à un identifiant valide émis par l’{OrganismeD’enregistrement}. Si cette information n’est pas renseignée, l’exposé DOIT obligatoirement contenir le nom de l’organisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Veuillez saisir l’<i>identifiant IITA de l’organisation</i> responsable de l’octroi des fonds. Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas l’organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.',
        ),
        'provider_activity_id' =>
        array (
          'hover_text' => 'Identifiant correspondant à l’activité dans le cadre de laquelle le décaissement prévu sera renseigné. Si aucun identifiant n’est renseigné, l’activité en cours s’applique par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Il est possible que l’organisation responsable de l’octroi des fonds ait déjà publié des données de l’IITA relatives à ces fonds dans le cadre de ses propres activités. Si tel est le cas, veuillez saisir l’identifiant correspondant à l’activité dans le cadre de laquelle les informations relatives à ces fonds ont été saisies. Vous pouvez obtenir ces informations auprès de l’organisation responsable de l’octroi des fonds ou trouver l’activité correspondante sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires</a>.<br></br>Si votre organisation est responsable de l’octroi des fonds, veuillez laisser ce champ vide.',
        ),
        'type' =>
        array (
          'hover_text' => 'Type d’organisation responsable de l’octroi des fonds.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation responsable de l’octroi des fonds (s’il ne s’agit pas de votre propre organisation). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Si l’organisation responsable de l’octroi des fonds ne dispose pas d’un identifiant IITA, il convient de saisir le nom de l’organisation.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/provider-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du nom que vous avez saisi. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'receiving_org' =>
      array (
        'hover_text' => 'Organisation bénéficiaire du décaissement prévu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>En savoir plus</a>',
        'help_text' => 'Saisissez des informations relatives à l’organisation qui recevra les fonds.',
        'reference' =>
        array (
          'hover_text' =>  'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. Doit respecter le format {OrganismeD’enregistrement}-{NuméroD’enregistrement}, dans lequel {OrganismeD’enregistrement} correspond à un code valide, présent sur la liste des organismes d’enregistrement des organisations, et {NuméroD’enregistrement} à un identifiant valide émis par l’{OrganismeD’enregistrement}. Si cette information n’est pas renseignée, l’exposé DOIT obligatoirement contenir le nom de l’organisation.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>En savoir plus</a>',
          'help_text' => 'Veuillez saisir l’<i>identifiant IITA de l’organisation</i> bénéficiaire des fonds (org-ID). Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas l’organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.',
        ),
        'receiver_activity_id' =>
        array (
          'hover_text' => 'Si les fonds transférés bénéficient à une autre activité publiée sur l’IITA, il convient, dans la mesure du possible, de renseigner l’identifiant IITA unique correspondant à cette activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>En savoir plus</a>',
          'help_text' => 'Dans la mesure du possible, veuillez saisir l’identifiant correspondant à l’activité bénéficiaire du décaissement. Vous pouvez obtenir cet identifiant d’activité auprès de l’organisation bénéficiaire ou trouver cette activité sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires</a>.',
        ),
        'type' =>
        array (
          'hover_text' => 'Type d’organisation bénéficiaire des fonds.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation bénéficiaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation</a>.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/narrative/\'>En savoir plus</a>',
          'help_text'=>'Add the name of the receiver organisation.'
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/planned-disbursement/receiver-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
    ),
    'budget' =>
    array (
      'hover_text' => 'Valeur du budget de l’activité pour chaque trimestre ou exercice financier pendant toute la durée de la mise en œuvre. Cet élément vise à offrir plus de visibilité en matière de planification annuelle des bénéficiaires. Le statut permet d’indiquer si le montant du budget renseigné est donné à titre indicatif ou a fait l’objet d’un engagement formel. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/\'>En savoir plus</a>',
      'help_text' => 'Indiquez le montant des dépenses prévues dans le cadre de cette activité. Les budgets saisis doivent être décomposés en périodes d’un an maximum et couvrir l’ensemble du cycle de vie de l’activité. La publication de budgets trimestriels est particulièrement intéressante pour les utilisateurs de données. Aucun budget ne doit couvrir une période supérieure à 12 mois.<br></br>Les budgets associés à votre activité doivent être saisis aussi rapidement que possible. Vous aurez ensuite la possibilité de les mettre à jour en fonction de l’évolution des fonds reçus et de la portée de l’activité. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>En savoir plus</a>.',
      'budget_status' =>
      array (
        'hover_text' => 'Le statut permet de déterminer si le budget renseigné est indicatif ou officiellement adopté. La valeur saisie doit être issue de la liste de codes relative au statut du budget.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/\'>En savoir plus</a>',
        'help_text' => 'Veuillez choisir le statut qui correspond le mieux à ce budget :<br><br>1 indicatif</b> - estimation du budget concerné, qui n’a fait l’objet d’aucun accord contraignant.<br><br>2 adopté</b> - le budget concerné est soumis à un accord contraignant.<br><br>Si ce budget change de statut, vous devez renseigner ce changement ici. Vous ne devez pas créer un autre budget couvrant la même période et ayant un statut différent. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>En savoir plus</a>.',
      ),
      'budget_type' =>
      array (
        'hover_text' => 'Budget initial (planifié dans le cadre de l’engagement initial) ou révisé par la suite.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/\'>En savoir plus</a>',
        'help_text' => 'Précisez le type de budget saisi :<br></br><b>1 Initial</b> Budget initialement affecté à l’activité. Choisissez cette option si vous saisissez des informations relatives à ce budget pour la première fois.<br></br><b>2 Révisé</b> Le budget de cette activité est issu d’une mise à jour. Choisissez cette option si vous procédez à une révision de votre budget initial.<br></br>Par exemple : une activité couvrant une période d’un an. Le budget initial était de 10 000 dollars É.-U., avant une baisse de 2 000 dollars É.-U. Le budget total de l’activité s’élève finalement à 8 000 dollars É.-U. Vous devez donc créer deux budgets pour cette période. Le premier est un budget « initial », avec une date de début et de fin couvrant une période d’un an et un montant de 10 000 dollars É.-U. Une fois que vous avez eu connaissance de la révision, vous pouvez ajouter un nouveau budget « révisé », couvrant les mêmes dates et d’un montant de 8 000 dollars É.-U.<br></br>Si le budget révisé fait l’objet de nouveaux changements, vous devrez alors modifier le montant associé à ce budget. Ne créez pas d’autres budgets « révisés » pour la même période.<br></br>Pour chaque période, il ne doit exister qu’un seul budget initial et un seul budget révisé. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-budgets/\'>En savoir plus</a>.',
      ),
      'period_start' =>
      array (
        'hover_text' => 'Date de début de la période budgétaire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire.<br><br>Cette valeur doit être de type xsd:date.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-start/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de début de la période budgétaire.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/period-end/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de fin de la période budgétaire.',
        ),
      ),
      'budget_value' =>
      array (
        'hover_text' => 'Budget pour la période considérée.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le montant total de ce budget.',
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. Cet élément est obligatoire pour tous les montants exprimés en devise, sauf lorsque l’attribut organisation-iita/@defaut-currency est indiqué.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>En savoir plus</a>',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>En savoir plus</a>',
        ),
      ),
    ),
    'result' =>
    array (
      'hover_text' => 'Support permettant de renseigner les produits, les réalisations, les impacts et autres résultats directement liés à l’activité. Cet élément peut être répété pour chaque type de résultat renseigné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>En savoir plus.</a>',
      'help_text' => 'Les résultats correspondent aux avantages, effectifs ou escomptés, d’une activité ; on peut les classer en plusieurs catégories : <b>produits</b>, <b>réalisations</b> et <b>impacts</b>. Vous pouvez renseigner plusieurs résultats pour votre activité. La mise à jour régulière des résultats permet aux utilisateurs de données de suivre les progrès de l’activité concernée, d’évaluer sa réussite et de prendre connaissance des difficultés rencontrées. Il convient d’inclure tant les résultats positifs que négatifs. Pour en savoir plus, veuillez consulter les instructions suivantes : <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Informations relatives aux résultats</a> et <a target=\'_blank\' href=\'\'>Comprendre les données relatives aux résultats</a>.<br></br>Attention : pour des raisons de sécurité, il est possible que certaines données de résultats ne puissent pas être ventilées ou publiées. Toutes les considérations relatives à la sécurité doivent figurer dans la <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/preparing-organisation/organisation-data-publication/information-and-data-you-cant-publish-exclusions/\'>politique d’exclusion</a> de l’organisation concernée.',
      'type' =>
      array (
        'hover_text' => 'Code IITA pour le type de résultat renseigné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>En savoir plus.</a>',
        'help_text' => 'Sélectionnez le type de résultats que votre activité se propose d’obtenir ou a déjà obtenu.<br></br><b>Produits</b> - Résultats directement issus du travail fourni et portant plus particulièrement sur le contenu de l’activité et sur les communautés bénéficiaires. Par exemple, le nombre de personnes formées.<br></br><b>Réalisations</b> - Résultats portant sur l’ensemble des communautés ou des problèmes concernés par l’activité. Par exemple, la baisse du taux d’infection à la suite d’un programme de vaccination.<br></br><b>Impacts</b> - Conséquences à long terme des réalisations, aboutissant à des résultats plus généraux tels que l’augmentation de l’espérance de vie.<br></br><b>Autres</b> - Autres types de résultats, n’appartenant à aucune des catégories ci-dessus.',
      ),
      'aggregation_status' =>
      array (
        'hover_text' => 'Mention indiquant si les données de résultats sont susceptibles d’être agrégées.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/\'>En savoir plus.</a>',
        'help_text' => 'Choisissez la mention « Oui » si les données fournies sont susceptibles d’être agrégées (l’utilisateur des données doit être en mesure de les additionner pour obtenir une valeur totale).',
      ),
      'title' =>
      array (
        'hover_text' => 'Titre court et lisible par un être humain.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/title/\'>En savoir plus.</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/title/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez un titre pour le résultat. Par exemple : « la population a accès à des médias indépendants, couvrant un large éventail de réalisations ».',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Description plus complète, lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/\'>En savoir plus.</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez une description plus détaillée du résultat.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/description/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'document_link' =>
      array (
        'hover_text' => 'Lien vers un site Internet ou un document en ligne accessible au grand public et présentant plus en détail le résultat. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez fournir des informations complémentaires relatives au résultat en ajoutant un lien vers un site Internet ou un document accessible au grand public.',
        'url' =>
        array (
          'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>En savoir plus</a>',
          'help_text' => 'Saisissez l’URL du document contenant des informations complémentaires relatives au résultat. Assurez-vous que l’adresse contient les caractères « https:// ».',
        ),
        'format' =>
        array (
          'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/\'>En savoir plus</a>',
          'language' =>
          array (
            'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
          ),
        ),
        'description' =>
        array (
          'language' =>
          array (
            'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/category/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez ajouté un lien vers un document, sélectionnez la catégorie qui lui correspond le mieux.',
          'code' =>
          array (
            'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/category/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez une catégorie pour le document que vous avez fourni, en vous appuyant sur <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/documentcategory/\'>cette liste</a>.',
          ),
        ),
        'language' =>
        array (
          'code' =>
          array (
            'hover_text' => 'Code de langue de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/document-link/language/\'>En savoir plus</a>',
          ),
        ),
      ),
      'reference' =>
      array (
        'hover_text' => 'Élément renvoyant à des informations relatives au cadre de résultats et au code d’identification correspondant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>En savoir plus</a>',
        'help_text' => 'Si ce résultat fait partie d’un cadre de résultats, vous devez fournir des informations relatives à ce dernier. Il existe deux manières de renvoyer à un cadre de résultats :<br></br><b>1.</b> Vous pouvez renvoyer à un cadre de résultats pour l’ensemble du résultat concerné ici OU<br></br><b>2.</b> Vous pouvez renvoyer à un cadre de résultats pour chaque indicateur permettant de mesurer ce résultat. Pour chaque résultat publié, vous devrez renseigner un indicateur (permettant de mesurer le résultat).<br></br><b>Il est recommandé de choisir la deuxième option</b>. Pour choisir cette option, ne remplissez pas les trois champs suivants : code, vocabulaire, URI du vocabulaire.<br></br>Attention : vous ne pouvez pas ajouter une référence à un cadre de résultats <b>à la fois</b> pour l’ensemble du résultat et pour chaque indicateur. Pour en savoir plus, veuillez consulter les instructions suivantes : <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Informations relatives aux résultats</a>',
        'vocabulary' =>
        array (
          'hover_text' => 'Code correspondant au vocabulaire utilisé pour le cadre de résultats. Le code doit correspondre à une valeur valide issue de la liste de codes relative au vocabulaire de résultats. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>En savoir plus</a>',
        ),
        'vocabulary_uri' =>
        array (
          'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. Bien qu’il s’agisse d’un champ facultatif, l’ensemble des signataires sont FORTEMENT ENCOURAGÉS à l’utiliser, afin de garantir la pleine compréhension de leurs codes par les utilisateurs des données.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/reference/\'>En savoir plus</a>',
        ),
      ),
    ),
    'indicator' =>
    array (
      'hover_text' => 'Indicateur(s) mesuré(s) pour évaluer l’obtention des résultats visés. Chaque résultat peut être associé à plusieurs indicateurs.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>En savoir plus</a>',
      'help_text' => '<br></br><b>Exemple concret</b> : Une activité vise la réalisation suivante : « la population a accès à des médias indépendants, couvrant un large éventail de réalisations ». Pour mesurer cette réalisation, on s’appuie notamment sur « le pourcentage de journalistes qui se sentent libres d’exprimer leur opinion » (il s’agit d’un indicateur). Cet indicateur est mesuré dans le cadre d’une enquête semestrielle au cours de laquelle les journalistes sont invités à noter leur sentiment de liberté sur une échelle de 1 à 4.<br></br>Veuillez consulter les instructions suivantes : <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Informations relatives aux résultats</a> pour en savoir plus sur cet exemple et <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/understanding-results/\'>Comprendre les données relatives aux résultats</a> pour découvrir d’autres exemples.',
      'measure' =>
      array (
        'hover_text' => 'Code IITA permettant de caractériser l’unité de mesure utilisée pour renseigner cette valeur. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>En savoir plus</a>',
        'help_text' => 'Choisissez l’unité de mesure correspondant à l’indicateur :<br></br><b>Unité</b> - L’indicateur est mesuré en unités, p. ex. le nombre d’ateliers organisés.<br></br><b>Pourcentage</b> - L’indicateur est mesuré en pourcentages, p. ex. le pourcentage de la population ayant reçu un vaccin.<br></br><b>Catégories nominales</b> - L’indicateur est mesuré selon une échelle de catégories nominales, p. ex. le genre, l’origine ethnique, etc.<br></br><b>Valeurs ordinales</b> - L’indicateur est mesuré sur une échelle de valeurs ordinales, p. ex. « très satisfait », « satisfait », « insatisfait » et « très insatisfait ». Dans une échelle de valeurs ordinales, l’ordre des réponses proposées est essentiel – il est impossible de quantifier la différence exacte entre les différentes réponses. La différence entre « très satisfait » et « satisfait », par exemple, est relative, et non absolue.<br></br><b>Données qualitatives</b> - L’indicateur est qualitatif et il s’agit généralement d’une description, par exemple, dans le cadre d’une formation, des détails concernant l’amélioration du comportement du personnel en matière d’égalité de genre.',
      ),
      'ascending' =>
      array (
        'hover_text' => 'Mention caractérisant le comportement ciblé par l’indicateur. La mention « vrai » s’applique lorsque l’indicateur connaît une évolution à la hausse (p. ex. la construction de cliniques) ; la mention « faux » s’applique lorsque l’indicateur connaît une évolution à la baisse (p. ex. la propagation d’une maladie). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>En savoir plus</a>',
        'help_text' => 'Si votre indicateur correspond à une mesure numérique (quantitative), choisissez une option. Si un chiffre élevé traduit une amélioration, choisissez 1 (vrai). Si un chiffre bas traduit une amélioration, choisissez 0 (faux).',
      ),
      'aggregation_status' =>
      array (
        'hover_text' => 'Mention indiquant si les données de résultats sont susceptibles d’être agrégées. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/\'>En savoir plus.</a>',
        'help_text' => 'Choisissez la mention « Oui » si les données fournies sont susceptibles d’être agrégées (l’utilisateur des données doit être en mesure de les additionner pour obtenir une valeur totale).',
      ),
      'title' =>
      array (
        'hover_text' => 'Titre court et lisible par un être humain.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/\'>En savoir plus</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez un titre ou une brève description pour l’indicateur. En reprenant l’exemple cité plus haut, on peut proposer l’exposé suivant : « Le pourcentage de journalistes qui se sentent libres d’exprimer leur opinion (note de 3 ou 4 sur une échelle de 1 à 4) ».<br></br>Pour en savoir plus sur cet exemple, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Informations relatives aux résultats</a>.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/title/narrative/\'>En savoir plus</a>',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/\'>En savoir plus</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/narrative/\'>En savoir plus</a>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/description/narrative/\'>En savoir plus</a>',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Date de publication du document vers lequel renvoie le lien ajouté. (@iso-date). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/document-date/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Date de publication du document vers lequel renvoie le lien ajouté.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/document-date/\'>En savoir plus</a>',
          'help_text' => 'Saisissez la date de publication du document.',
        ),
      ),
      'document_link' =>
      array (
        'hover_text' => 'Lien vers un site Internet ou un document en ligne accessible au grand public et présentant plus en détail le résultat. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez fournir des informations complémentaires relatives à l’indicateur de résultat en ajoutant un lien vers un site Internet ou un document accessible au grand public.',
        'url' =>
        array (
          'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>En savoir plus</a>',
          'help_text' => 'Ajoutez un lien vers l’un des indicateurs de résultats que vous avez renseignés. Assurez-vous que l’adresse contient les caractères « https:// ».',
        ),
        'format' =>
        array (
          'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/\'>En savoir plus</a>',
          'language' =>
          array (
            'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
          ),
        ),
        'title' =>
        array (
          'hover_text' => 'Titre court et lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/title/\'>En savoir plus</a>',
        ),
        'description' =>
        array (
          'language' =>
          array (
            'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/category/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez ajouté un lien vers un document, sélectionnez la catégorie qui lui correspond le mieux.',
          'code' =>
          array (
            'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/category/\'>En savoir plus</a>',
          ),
        ),
        'language' =>
        array (
          'code' =>
          array (
            'hover_text' => 'Code de langue de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/document-link/language/\'>En savoir plus</a>',
          ),
        ),
      ),
      'reference' =>
      array (
        'hover_text' => 'Élément renvoyant à des informations relatives au cadre de résultats et au code d’identification correspondant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>En savoir plus</a>',
        'help_text' => 'Si l’indicateur que vous avez renseigné fait partie d’un cadre de résultats existant, veuillez saisir ici des informations relatives à ce dernier.',
        'vocabulary' =>
        array (
          'hover_text' => 'Code correspondant au vocabulaire utilisé pour le cadre de résultats. Le code doit correspondre à une valeur valide issue de la liste de codes relative au vocabulaire de résultats. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez le cadre de résultats dont fait partie votre indicateur. Si le cadre de résultats concerné ne fait pas partie de la liste, choisissez « 99 Organisation déclarante ».',
        ),
        'indicator_uri' =>
        array (
          'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. Bien qu’il s’agisse d’un champ facultatif, l’ensemble des signataires sont FORTEMENT ENCOURAGÉS à l’utiliser, afin de garantir la pleine compréhension de leurs codes par les utilisateurs des données. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/reference/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez choisi un cadre de résultats, veuillez ajouter ici un lien vers ce dernier. Si vous avez sélectionné « 99 Organisation déclarante », il est fortement recommandé d’ajouter un lien vers la liste de codes. Cela permet de s’assurer que les utilisateurs de données comprennent la signification du code.',
        ),
      ),
      'baseline' =>
      array (
        'hover_text' => 'Valeur de référence pour l’indicateur. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>En savoir plus</a>',
        'help_text' => 'Pour chaque indicateur, veuillez saisir une valeur de référence, une cible et le résultat obtenu. La valeur de référence correspond au point de départ. La cible correspond au résultat que l’organisation souhaite obtenir, au cours d’une période donnée, grâce à l’activité concernée. Le résultat obtenu correspond à la situation telle qu’elle se présente à l’issue de la période concernée.<br><br>Par exemple : Au départ (valeur de référence), 15 % des journalistes se sentaient libres d’exprimer leur opinion. La cible était fixée à 50 % à la fin de la période concernée. L’activité a permis d’atteindre cette cible, puisque, à la fin de la période (résultat obtenu), 53 % des journalistes se sentaient libres d’exprimer leur opinion.<br></br>Veuillez consulter les instructions suivantes : <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/results/\'>Informations relatives aux résultats</a> pour en savoir plus sur cet exemple et <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/understanding-results/\'>Comprendre les données relatives aux résultats</a> pour découvrir d’autres exemples.',
        'year' =>
        array (
          'hover_text' => 'Année durant laquelle la valeur de référence a été mesurée (aaaa). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>En savoir plus</a>',
          'help_text' => 'Indiquez l’année au cours de laquelle la valeur de référence de l’indicateur a été mesurée.',
        ),
        'date' =>
        array (
          'hover_text' => 'Date à laquelle la valeur de référence a été mesurée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date à laquelle la valeur de référence de l’indicateur a été mesurée.',
        ),
        'value' =>
        array (
          'hover_text' => 'Valeur de référence. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/\'>En savoir plus</a>',
          'help_text' => 'Saisissez la valeur de référence. Par exemple, si la valeur de référence est de 15 %, saisissez « 15 » (l’unité de mesure a déjà été indiquée plus haut).<br></br>Si l’indicateur concerné correspond à une mesure qualitative, laissez ce champ vide (et ajoutez votre valeur de référence dans la section « remarques » ci-dessous).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Commentaire lisible par un être humain concernant une information relative à l’aide. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/202/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/\'>En savoir plus</a>',
          'narrative' =>
          array (
            'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/comment/narrative/\'>En savoir plus</a>',
            'help_text' => 'Si l’indicateur concerné correspond à une mesure qualitative, proposez une description de la valeur de référence ici.<br></br>Vous pouvez ajouter ici des informations complémentaires relatives à cette valeur de référence. Par exemple : « Valeur de référence mesurée dans le cadre d’une enquête menée auprès de 1 083 journalistes dans le pays X ».',
          ),
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/comment/narrative/\'>En savoir plus</a>',
          ),
        ),
        'dimension' =>
        array (
          'hover_text' => 'Catégorie utilisée pour ventiler les données de résultat par genre, âge, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>En savoir plus</a>',
          'help_text' => 'Attention : une valeur de référence peut avoir plusieurs dimensions.',
          'name' =>
          array (
            'hover_text' => 'Description en texte libre d’une catégorie de ventilation. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>En savoir plus</a>',
            'help_text' => 'Par exemple, dans le cadre d’une activité, on peut indiquer « sexe » en dimension et « femme » en valeur.',
          ),
          'value' =>
          array (
            'hover_text' => 'Description de la valeur soumise à une ventilation des données. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/dimension/\'>En savoir plus</a>',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Lien vers un site Internet ou un document en ligne accessible au grand public et présentant plus en détail le résultat. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>En savoir plus</a>',
          'help_text' => 'Vous pouvez fournir des informations complémentaires relatives à l’indicateur de référence en ajoutant un lien vers un site Internet ou un document accessible au grand public.',
          'url' =>
          array (
            'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ».<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>En savoir plus</a>',
            'help_text' => 'Saisissez l’URL du document contenant des informations complémentaires relatives à l’indicateur de référence. Assurez-vous que l’adresse contient les caractères « https:// ».',
          ),
          'format' =>
          array (
            'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/\'>En savoir plus</a>',
          ),
          'title' =>
          array (
            'hover_text' => 'Titre court et lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/narrative/\'>En savoir plus</a>',
            ),
            'language' =>
            array (
              'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/title/narrative/\'>En savoir plus</a>',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/narrative/\'>En savoir plus</a>',
            ),
            'language' =>
            array (
              'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/description/narrative/\'>En savoir plus</a>',
            ),
          ),
          'category' =>
          array (
            'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/category/\'>En savoir plus</a>',
            'code' =>
            array (
              'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/category/\'>En savoir plus</a>',
            ),
          ),
          'language' =>
          array (
            'code' =>
            array (
              'hover_text' => 'Code de langue de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/document-link/language/\'>En savoir plus</a>',
            ),
          ),
        ),
        'location' =>
        array (
          'hover_text' => 'Lieu déjà identifié et caractérisé dans l’élément activité-iita/lieu.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/location/\'>En savoir plus</a>',
          'reference' =>
          array (
            'hover_text' => 'Renvoi à la référence interne utilisée pour un lieu donné : activité-iita/lieu/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/baseline/location/\'>En savoir plus</a>',
          ),
        ),
      ),
    ),
    'period' =>
    array (
      'hover_text' => 'Période concernée par les résultats renseignés. Plusieurs périodes peuvent être renseignées pour chaque indicateur. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/\'>En savoir plus</a>',
      'help_text' => 'Chaque indicateur peut être associé à une période, avec une date de début et une date de fin. Il s’agit de la période au cours de laquelle l’indicateur est mesuré, p. ex. une saison agricole ou un trimestre scolaire.',
      'target' =>
      array (
        'hover_text' => 'Seuil ciblé pour la période. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/\'>En savoir plus</a>',
        'help_text' => 'La cible correspond au résultat que l’organisation souhaite obtenir, au cours d’une période donnée, grâce à l’activité concernée.',
        'value' =>
        array (
          'hover_text' => 'Valeur de la cible. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/\'>En savoir plus</a>',
          'help_text' => 'Si votre indicateur correspond à une mesure numérique (quantitative), p. ex. une valeur mesurée en pourcentages, ajoutez une valeur cible.<br></br>Si votre indicateur correspond à une mesure qualitative, veuillez laisser ce champ vide (et ajoutez votre cible dans la section « remarques » ci-dessous).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Commentaire lisible par un être humain concernant une information relative à l’aide. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/\'>En savoir plus</a>',
          'help_text' => 'Si l’indicateur concerné correspond à une mesure qualitative, proposez une description de la cible ici.<br></br>Vous pouvez ajouter des informations complémentaires relatives à cette cible.',
          'narrative' =>
          array (
            'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/narrative/\'>En savoir plus</a>',
          ),
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/comment/narrative/\'>En savoir plus</a>',
          ),
        ),
        'dimension' =>
        array (
          'name' =>
          array (
            'hover_text' => 'Description en texte libre d’une catégorie de ventilation. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/dimension/\'>En savoir plus</a>',
          ),
          'value' =>
          array (
            'hover_text' => 'Description de la valeur soumise à une ventilation des données. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/dimension/\'>En savoir plus</a>',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Lien vers un site Internet ou un document en ligne accessible au grand public et présentant plus en détail le résultat. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>En savoir plus</a>',
          'help_text' => 'Vous pouvez fournir des informations complémentaires relatives à l’indicateur cible en ajoutant un lien vers un site Internet ou un document accessible au grand public.',
          'url' =>
          array (
            'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>En savoir plus</a>',
            'help_text' => 'Saisissez l’URL du document contenant des informations complémentaires relatives à l’indicateur cible. Assurez-vous que l’adresse contient les caractères « https:// ».',
          ),
          'format' =>
          array (
            'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/\'>En savoir plus</a>',
          ),
          'title' =>
          array (
            'hover_text' => 'Titre court et lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/narrative/\'>En savoir plus</a>',
            ),
            'language' =>
            array (
              'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/title/narrative/\'>En savoir plus</a>',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/narrative/\'>En savoir plus</a>',
            ),
            'language' =>
            array (
              'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/description/narrative/\'>En savoir plus</a>',
            ),
          ),
          'category' =>
          array (
            'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/category/\'>En savoir plus</a>',
            'code' =>
            array (
              'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/category/\'>En savoir plus</a>',
            ),
          ),
          'language' =>
          array (
            'hover_text' => 'Code de la norme ISO 639-1 correspondant à la langue dans laquelle le document cible est écrit, p. ex. « en ». Cet élément peut être répété pour caractériser des documents disponibles en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/language/\'>En savoir plus</a>',
            'language' =>
            array (
              'hover_text' => 'Code de langue de la norme ISO 639-1.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/document-link/language/\'>En savoir plus</a>',
            ),
          ),
          'location' =>
          array (
            'reference' =>
            array (
              'hover_text' => 'Renvoi à la référence interne utilisée pour un lieu donné : activité-iita/lieu/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/target/location/\'>En savoir plus</a>',
            ),
          ),
        ),
      ),
      'actual' =>
      array (
        'hover_text' => 'Données relatives au résultat obtenu au cours de cette période. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/\'>En savoir plus</a>',
        'help_text' => 'Le résultat obtenu correspond à la situation telle qu’elle se présente à l’issue de la période concernée.',
        'value' =>
        array (
          'hover_text' => 'Valeur du résultat obtenu. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/\'>En savoir plus</a>',
          'help_text' => 'Si votre indicateur correspond à une mesure numérique (quantitative), p. ex. une valeur mesurée en unités ou en pourcentages, ajoutez la valeur du résultat obtenu.<br></br>Si votre indicateur correspond à une mesure qualitative, veuillez laisser ce champ vide (et ajoutez le résultat obtenu dans la section « remarques » ci-dessous).',
        ),
        'comment' =>
        array (
          'hover_text' => 'Commentaire lisible par un être humain concernant une information relative à l’aide. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/\'>En savoir plus</a>',
          'help_text' => 'Si l’indicateur concerné correspond à une mesure qualitative, proposez une description du résultat obtenu ici.<br></br>Vous pouvez ajouter des informations complémentaires relatives à ce résultat.',
          'narrative' =>
          array (
            'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/narrative/\'>En savoir plus</a>',
          ),
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/comment/narrative/\'>En savoir plus</a>',
          ),
        ),
        'dimension' =>
        array (
          'hover_text' => 'Catégorie utilisée pour ventiler les données de résultat par genre, âge, etc. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>En savoir plus</a>',
          'name' =>
          array (
            'hover_text' => 'Description en texte libre d’une catégorie de ventilation. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>En savoir plus</a>',
          ),
          'value' =>
          array (
            'hover_text' => 'Description de la valeur soumise à une ventilation des données. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/dimension/\'>En savoir plus</a>',
          ),
        ),
        'document_link' =>
        array (
          'hover_text' => 'Lien vers un site Internet ou un document en ligne accessible au grand public et présentant plus en détail le résultat. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>En savoir plus</a>',
          'help_text' => 'Vous pouvez fournir des informations complémentaires relatives à la valeur ou au résultat effectif en ajoutant un lien vers un site Internet ou un document accessible au grand public.',
          'url' =>
          array (
            'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>En savoir plus</a>',
            'help_text' => 'Saisissez l’URL du document contenant des informations complémentaires relatives à la valeur réelle ou au résultat effectif. Assurez-vous que l’adresse contient les caractères « https:// ».',
          ),
          'format' =>
          array (
            'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/\'>En savoir plus</a>',
          ),
          'title' =>
          array (
            'hover_text' => 'Titre court et lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/narrative/\'>En savoir plus</a>',
              'help_text' => 'Si vous avez ajouté un lien vers un document, donnez un titre à ce document.',
            ),
            'language' =>
            array (
              'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/title/narrative/\'>En savoir plus</a>',
            ),
          ),
          'description' =>
          array (
            'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/\'>En savoir plus</a>',
            'narrative' =>
            array (
              'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/description/narrative/\'>En savoir plus</a>',
            ),
          ),
        ),
        'category' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/category/\'>En savoir plus</a>',
          'code' =>
          array (
            'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/category/\'>En savoir plus</a>',
          ),
        ),
        'language' =>
        array (
          'hover_text' => 'Code de la norme ISO 639-1 correspondant à la langue dans laquelle le document cible est écrit, p. ex. « en ». Cet élément peut être répété pour caractériser des documents disponibles en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/language/\'>En savoir plus</a>',
          'language' =>
          array (
            'hover_text' => 'Code de langue de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/language/\'>En savoir plus</a>',
          ),
        ),
        'document_date' =>
        array (
          'hover_text' => 'Date de publication du document vers lequel renvoie le lien ajouté. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/document-date/\'>En savoir plus</a>',
          'date' =>
          array (
            'hover_text' => 'Date de publication du document vers lequel renvoie le lien ajouté. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/document-link/document-date/\'>En savoir plus</a>',
          ),
        ),
      ),
      'location' =>
      array (
        'reference' =>
        array (
          'hover_text' => 'Renvoi à la référence interne utilisée pour un lieu donné : activité-iita/lieu/@ref. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/result/indicator/period/actual/location/\'>En savoir plus</a>',
        ),
      ),
    ),
    'transactions' =>
    array (
      'hover_text' => 'Transactions correspondant à des fonds entrants ou sortants, engagés ou effectifs, pour une activité d’aide.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>En savoir plus</a>',
      'help_text' => 'Veuillez renseigner les modalités de financement de votre activité et indiquer la façon dont ces financements sont utilisés. Tout flux entrant ou sortant doit être publié comme transaction.<br></br>Si une organisation se livre à un grand nombre de petites transactions, il est possible de regrouper ces dernières. L’ensemble des frais de déplacement pour un mois, par exemple, peuvent être publiés sous la forme d’une transaction unique. Au moment de décider si les transactions seront agrégées (et selon quelles modalités), les organisations déclarantes sont invitées à tenir compte des besoins des utilisateurs de données, car l’agrégation d’un trop grand nombre de données peut rendre leur utilisation plus difficile.<br></br>Attention : vous ne devez pas regrouper des flux ou des fonds entrants ou sortants et impliquant plusieurs organisations externes (p. ex. un décaissement au profit de CARE ne doit pas être associé à un décaissement au profit du Comité international de secours).<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/financial-transactions/\'>Instructions relatives à la publication des transactions financières</a>',
      'reference' =>
      array (
        'hover_text' => 'Référence interne utilisée par le système de gestion financière de l’organisation déclarante pour désigner cette transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez indiquer la référence utilisée par le système de gestion financière interne de votre organisation pour désigner cette transaction.',
      ),
      'humanitarian' =>
      array (
        'hover_text' => 'Mention indiquant que cette transaction est totalement ou en partie liée à l’aide humanitaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/\'>En savoir plus</a>',
        'help_text' => '<p>Vous pouvez indiquer si cette transaction a trait à l’aide humanitaire en sélectionnant la mention « oui ».</p><p>Si l’ensemble de l’activité a trait à l’aide humanitaire, vous devez sélectionner « oui » en utilisant la mention d’activité humanitaire de l’IITA, plutôt que de répéter le processus pour chaque transaction.</p><p>Voir les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/humanitarian/\'>instructions relatives aux différentes façons de publier des données humanitaires</a></p>.',
      ),
      'transaction_type' =>
      array (
        'hover_text' => 'Type de transaction (p. ex. engagement, décaissement, dépense, etc.).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-type/\'>En savoir plus</a>',
        'help_text' => 'Veuillez sélectionner le type de transaction qui correspond le mieux aux flux financiers entrants et sortants pour cette activité. Les différents types de transaction comprennent notamment les transferts de fonds entrants, les engagements sortants, les décaissements et les dépenses.',
        'transaction_type_code' =>
        array (
          'hover_text' => 'Code issu du vocabulaire sélectionné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-type/\'>En savoir plus</a>',
          'help_text' => 'Veuillez préciser le type de transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/transactiontype/\'>Prenez connaissance des différents types de transaction existants et des descriptions correspondantes.</a>',
        ),
      ),
      'transaction_date' =>
      array (
        'hover_text' => 'Date à laquelle la transaction a été effectuée ou (pour les engagements) approuvée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-date/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/transaction-date/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date à laquelle la transaction a été effectuée ou (pour les engagements) approuvée.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant de la contribution. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/value/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises.',
          'help_text' => 'Cette date ne doit pas être située dans le futur.',
        ),
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/value/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la devise de cette transaction.</br>Cette valeur doit être issue de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/Currency/\'>liste de codes relative aux devises</a>.',
        ),
      ),
      'description' =>
      array (
        'hover_text' => 'Description de la transaction lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/\'>En savoir plus.</a>',
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez une brève description de la transaction, p. ex. les objectifs poursuivis.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/description/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'provider_organization' =>
      array (
        'hover_text' => 'Pour les fonds entrants, il s’agit de l’organisation à l’origine de la transaction. Si aucune organisation n’est renseignée pour les fonds sortants, l’organisation déclarante s’applique par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
        'help_text' => 'Pour chaque transaction, il est fortement recommandé de fournir des informations à la fois sur l’organisation responsable de l’octroi des fonds et sur l’organisation bénéficiaire. Cette recommandation s’applique également lorsque votre organisation assume l’une ou l’autre de ces deux fonctions.<br></br>Si vous ne renseignez aucune information concernant l’organisation responsable de l’octroi des fonds pour les transactions entrantes, votre organisation sera considérée comme assumant cette fonction par défaut.',
        'organization_identifer_code' =>
        array (
          'hover_text' => 'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Veuillez saisir l’identifiant IITA de l’organisation responsable de l’octroi des fonds. Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas votre organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.<br></br>Si votre organisation est responsable de l’octroi des fonds, veuillez saisir son identifiant IITA. Votre organisation a créé son identifiant d’organisation au moment de sa première inscription en tant que signataire de l’IITA. Vous trouverez cette information ici.',
        ),
        'provider_activity_id' =>
        array (
          'hover_text' => 'Si les fonds entrants sont issus du budget d’une autre activité publiée sur l’IITA, il est FORTEMENT RECOMMANDÉ de renseigner l’identifiant d’activité unique associé à l’organisation responsable de l’octroi des fonds pour cette activité. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Il est possible que l’organisation responsable de l’octroi des fonds ait déjà publié des données de l’IITA relatives à ces fonds dans le cadre de ses propres activités. Si tel est le cas, veuillez saisir l’identifiant correspondant à l’activité dans le cadre de laquelle les informations relatives à ces fonds ont été saisies. Vous pouvez obtenir ces informations auprès de l’organisation responsable de l’octroi des fonds ou trouver l’activité correspondante sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires</a>.<br></br>Si votre organisation est responsable de l’octroi des fonds, veuillez laisser ce champ vide.',
        ),
        'type' =>
        array (
          'hover_text' => 'Type d’organisation responsable de l’octroi des fonds. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation responsable de l’octroi des fonds. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation</a>. <br><br>Si l’organisme bailleur de fonds est votre propre organisation, veuillez sélectionner le type d’organisation renseigné au moment de sa première inscription. Vous trouverez cette information ici.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Si l’organisation responsable de l’octroi des fonds ne dispose pas d’un identifiant IITA, il convient de saisir le nom de l’organisation.<br></br><b>Merci de ne pas saisir un code dans cet espace réservé au nom de l’organisation responsable de l’octroi des fonds.</b>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <br></br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/provider-org/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'receiver_organization' =>
      array (
        'hover_text' => 'Organisation bénéficiaire de la transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>En savoir plus</a>',
        'help_text' => 'Veuillez indiquer le nom de l’organisation qui recevra ou a déjà reçu les fonds dans le cadre de cette transaction. Si votre organisation est le bénéficiaire, veuillez renseigner les informations la concernant.',
        'organization_identifier_code' =>
        array (
          'hover_text' => 'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>En savoir plus.</a>',
          'help_text' => 'Veuillez saisir l’identifiant IITA de l’organisation bénéficiaire des fonds (org-ID). Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas votre organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.<br></br>Si votre organisation est bénéficiaire des fonds, veuillez saisir son identifiant IITA (org-ID). Votre organisation a créé son identifiant d’organisation au moment de sa première inscription en tant que signataire de l’IITA. Vous trouverez cette information ici.',
        ),
        'receiver_activity_id' =>
        array (
          'hover_text' => 'Si les fonds transférés bénéficient à une autre activité publiée sur l’IITA, il convient, dans la mesure du possible, de renseigner l’identifiant IITA unique correspondant à cette activité.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>En savoir plus</a>',
          'help_text' => 'Il est possible que l’organisation bénéficiaire ait déjà publié des données de l’IITA relatives à ces fonds dans le cadre de ses propres activités. Si tel est le cas, veuillez saisir l’identifiant correspondant à l’activité dans le cadre de laquelle les informations relatives à ces fonds ont été saisies. Vous pouvez obtenir ces informations auprès de l’organisation bénéficiaire ou trouver l’activité correspondante sur d-portal.org. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>Instructions complémentaires</a>.<br></br>Si votre organisation est responsable de l’octroi des fonds, veuillez laisser ce champ vide.',
        ),
        'type' =>
        array (
          'hover_text' => 'Type d’organisation bénéficiaire des fonds. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation bénéficiaire des fonds. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation<br></a>.</br>Si l’organisme bénéficiaire des fonds est votre propre organisation, veuillez sélectionner le type d’organisation renseigné au moment de sa première inscription. Vous trouverez cette information ici.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Si l’organisation bénéficiaire des fonds ne dispose pas d’un identifiant IITA, il convient de saisir le nom de l’organisation.<br></br><b>Merci de ne pas saisir un code dans cet espace réservé au nom de l’organisation bénéficiaire des fonds.</b>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/receiver-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'disbursement_channel' =>
      array (
        'hover_text' => 'Canal par lequel transiteront les fonds dans le cadre de cette transaction (code issu d’une liste de codes IITA). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/disbursement-channel/\'>En savoir plus</a>',
        'help_text' => 'Choisissez l’option qui correspond le mieux aux canaux utilisés pour vos décaissements (p. ex. par l’intermédiaire du gouvernement bénéficiaire ou via un canal extérieur au gouvernement bénéficiaire).',
        'disbursement_channel_code' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser les canaux de décaissement. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/disbursement-channel/\'>En savoir plus</a>',
          'help_text' => 'Veuillez consulter la liste des <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/disbursementchannel/\'>canaux de décaissement</a> et choisir (dans la mesure du possible) l’option qui correspond le mieux à cette transaction.',
        ),
        'sector' =>
        array (
          'hover_text' => 'Code issu d’un vocabulaire reconnu et correspondant à la catégorie d’objectifs associée à cette transaction.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
          'help_text' => 'Vous pouvez indiquer <b>un</b> secteur que cette transaction spécifique permet de soutenir. Par exemple, l’éducation primaire ou l’agriculture. Si vous utilisez cet élément, vous devrez indiquer un secteur pour <b><u>chaque</u></b> transaction publiée.</br>Vous <b><u>ne devez</u></b> renseigner aucun secteur pour vos transactions si vous souhaitez saisir des données relatives aux secteurs pour l’ensemble de cette activité (ce que vous pouvez faire ici). <b>Les informations relatives aux secteurs doivent être renseignées au niveau de l’activité ou des transactions, mais <u>pas les deux</u></b>.</br>Une fois que votre organisation a choisi à quel niveau elle souhaite renseigner les informations relatives aux secteurs concernés par ses activités, vous devez appliquer ce choix à l’ensemble des activités publiées. Autrement dit, l’ensemble des informations relatives aux secteurs doivent être publiées soit au niveau de l’activité soit au niveau de chaque transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>En savoir plus</a>.</br>',
          'sector_vocabulary' =>
          array (
            'hover_text' => 'Code IITA pour le vocabulaire (liste de codes) utilisé pour la classification sectorielle. Si aucun code n’est renseigné, les codes-objet à cinq caractères du CAD de l’OCDE s’appliquent par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Si vous choisissez de publier des informations relatives au secteur soutenu par cette transaction, vous devez choisir une liste de secteurs. L’IITA recommande l’usage de la liste de codes sectoriels à cinq caractères du CAD de l’OCDE, qui permet de choisir parmi <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sector/\'>plus de 300 secteurs différents</a>.<br></br>Vous pouvez également faire appel à une autre liste (voir les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/sectorvocabulary/\'>informations relatives aux différents options disponibles</a>). Si vous souhaitez faire appel à la liste utilisée par votre organisation pour la classification interne des différents secteurs, choisissez l’option : « Organisation déclarante ».<br></br>Vous pouvez choisir plusieurs listes. Si vous faites appel à plusieurs outils de classification sectorielle interne, sélectionnez l’option « Organisation déclarante 2 » (qui correspond au code 98) pour la liste complémentaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-thematic-focus/\'>Instructions complémentaires</a>.<br></br><b>Ne sélectionnez pas de liste si vous avez choisi ou comptez choisir une seule liste de secteurs pour l’ensemble de l’activité.</b>',
          ),
          'vocabulary_uri' =>
          array (
            'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 ou 98 (organisation déclarante), URI correspondant à ce vocabulaire interne. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Si vous avez choisi de faire appel à une liste de codes interne pour la classification sectorielle, veuillez fournir un lien vers cette liste.',
          ),
          'code' =>
          array (
            'hover_text' => 'Code correspondant au secteur concerné.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez le secteur auquel bénéficieront les fonds transférés dans le cadre de la transaction. Vous ne pouvez choisir qu’<b>un seul secteur</b> pour chacune des listes que vous utilisez.',
          ),
          'text' =>
          array (
            'hover_text' => 'Code correspondant au secteur concerné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez le secteur auquel bénéficieront les fonds transférés dans le cadre de la transaction. Vous ne pouvez choisir qu’<b>un seul secteur</b> pour chacune des listes que vous utilisez.',
          ),
          'category_code' =>
          array (
            'hover_text' => 'Code correspondant au secteur concerné. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez le secteur auquel bénéficieront les fonds transférés dans le cadre de la transaction. Vous ne pouvez choisir qu’<b>un seul secteur</b> pour chacune des listes que vous utilisez.',
          ),
          'sdg_goal' =>
          array (
            'hover_text' => 'Code correspondant au secteur concerné. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez le secteur auquel bénéficieront les fonds transférés dans le cadre de la transaction. Vous ne pouvez choisir qu’<b>un seul secteur</b> pour chacune des listes que vous utilisez.',
          ),
          'sdg_target' =>
          array (
            'hover_text' => 'Code correspondant au secteur concerné. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez le secteur auquel bénéficieront les fonds transférés dans le cadre de la transaction. Vous ne pouvez choisir qu’<b>un seul secteur</b> pour chacune des listes que vous utilisez.',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Description d’un secteur identifié par l’organisation déclarante. (À remplir uniquement si l’organisation déclarante emploie son propre vocabulaire).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/narrative/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez choisi un secteur issu d’une liste interne de classification sectorielle, veuillez fournir une description de ce secteur.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/sector/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'Pays bénéficiaire de cette transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez nommer <b>un</b> pays ou une région correspondant au lieu de mise en œuvre d’une transaction précise, ou un lieu qui bénéficiera de cette transaction.<br></br>Vous <b><u>ne devez pas</u></b> nommer un pays ou une région pour les différentes transactions si vous souhaitez ajouter un pays ou une région bénéficiaire pour l’ensemble de l’activité (ce que vous pouvez faire ici). <b>Les pays ou régions bénéficiaires doivent être renseignés au niveau de l’activité ou des transactions, mais pas les deux.</b><br></br>Une fois que votre organisation a choisi à quel niveau elle souhaite renseigner les informations relatives aux pays (ou régions) bénéficiaires, vous devez appliquer ce choix à l’ensemble des activités publiées. Autrement dit, l’ensemble des informations relatives aux pays ou régions bénéficiaires doivent être publiées soit au niveau de l’activité soit au niveau de chaque transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/countries-regions/\'>En savoir plus</a>.',
        'country_code' =>
        array (
          'hover_text' => 'Code ISO 3166-1 alpha-2 du pays. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/\'>En savoir plus</a>',
          'help_text' => 'Choisissez <b>un</b> pays dans lequel cette transaction est mise en œuvre, ou qui bénéficiera des fonds transférés.<br></br><b>Ne renseignez aucun pays si vous avez sélectionné ou comptez sélectionner un pays bénéficiaire pour l’ensemble de l’activité.</b>',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/narrative/\'>En savoir plus</a>',
          'help_text' => 'Ajoutez le nom et/ou une description en texte libre du pays bénéficiaire de la transaction.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-country/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'recipient_region' =>
      array (
        'hover_text' => 'Région géopolitique supranationale qui bénéficiera de cette transaction. Si aucun pays précis ne peut être renseigné, cet élément DOIT être utilisé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>En savoir plus</a>',
        'help_text' => 'Si vous n’êtes pas en mesure d’identifier le pays bénéficiaire de cette transaction, vous pouvez renseigner la région bénéficiaire. <b>Ne renseignez pas à la fois un pays bénéficiaire et une région bénéficiaire.</b><br></br>Par exemple, si les fonds sont affectés à l’Ouganda, vous devez renseigner l’Ouganda en tant que pays bénéficiaire, sans ajouter l’Afrique comme région bénéficiaire.',
        'region_vocabulary' =>
        array (
          'hover_text' => 'Code IITA pour le vocabulaire dont le code de région est issu. Si aucun code n’est renseigné, le vocabulaire 1 - « CAD-OCDE » s’applique par défaut.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>En savoir plus</a>',
          'help_text' => 'Il existe deux listes de régions ; la liste du CAD de l’OCDE et les listes de codes de région des Nations Unies. Veuillez sélectionner une option. L’IITA recommande l’usage de la <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/region/\'>liste de codes du CAD de l’OCDE</a>. Vous pouvez également faire appel à une autre liste de régions, en sélectionnant l’option : « organisation déclarante » et en indiquant l’URI correspondant à cette liste interne. Si aucune option n’est sélectionnée, la liste de codes du CAD de l’OCDE s’applique par défaut.',
        ),
        'region_code' =>
        array (
          'hover_text' => 'Code du CAD de l’OCDE ou code de région des Nations Unies. La liste de codes est déterminée par l’attribut de vocabulaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la région bénéficiant de cette transaction.',
        ),
        'custom_code' =>
        array (
          'hover_text' => 'Code du CAD de l’OCDE ou code de région des Nations Unies. La liste de codes est déterminée par l’attribut de vocabulaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la région bénéficiant de cette transaction.',
        ),
        'vocabulary_uri' =>
        array (
          'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez sélectionné l’option « organisation déclarante », veuillez fournir l’URI lorsque cette liste interne est définie.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Description d’un secteur identifié par l’organisation déclarante. (À remplir uniquement si l’organisation déclarante emploie son propre vocabulaire.) <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez sélectionné l’option « Organisation déclarante », veuillez ajouter le nom et/ou une description en texte libre de la région bénéficiaire de l’activité.',
          'language' =>
          array (
            'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>En savoir plus</a>',
            'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
          ),
        ),
      ),
      'flow_type' =>
      array (
        'hover_text' => 'Élément facultatif permettant de remplacer le type de flux établi par défaut au niveau supérieur. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/flow-type/\'>En savoir plus</a>',
        'help_text' => 'Le type de flux constitue un autre moyen de catégoriser les flux financiers. Il permet de distinguer l’aide publique au développement (APD), les autres apports du secteur public (AASP) et les différents types de flux privés, notamment les subventions privées, généralement octroyées par les ONG ou par d’autres organisations de la société civile.',
        'flow_type' =>
        array (
          'hover_text' => 'Code issu de la liste de codes du SNPC du CAD de l’OCDE pour le « type de flux ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/flow-type/\'>En savoir plus</a>',
          'help_text' => 'Veuillez sélectionner le type de flux correspondant à cette transaction parmi les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/FlowType/\'>options suivantes</a>.<br></br>Attention : si vous sélectionnez un type de flux pour cette transaction, le <b>type de flux par défaut</b> établi pour l’ensemble de l’activité (et sélectionné ici) sera supprimé et vous pourrez choisir un type de flux différent pour chaque transaction si nécessaire.',
        ),
      ),
      'finance_type' =>
      array (
        'hover_text' => 'Élément facultatif permettant de supprimer le type de financement établi par défaut au niveau supérieur et de le remplacer, si nécessaire, par un type de financement différent pour chaque transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/finance-type/\'>En savoir plus</a>',
        'help_text' => 'Le type de financement permet de préciser quel est l’instrument financier utilisé. Ainsi, le plus souvent, les financements sont octroyés sous la forme de subventions ou de prêts.',
        'finance_type' =>
        array (
          'hover_text' => 'Code issu de la liste de codes du SNPC/CAD de l’OCDE pour le « type de financement ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/finance-type/\'>En savoir plus</a>',
          'help_text' => 'Veuillez sélectionner le type de financement correspondant à cette transaction parmi les <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/financetype/\'>options suivantes</a>.<br></br>Attention : si vous sélectionnez un type de financement pour cette transaction, le <b>type de financement par défaut</b> établi pour l’ensemble de l’activité (et sélectionné ici) sera supprimé et vous pourrez choisir un type de flux différent pour chaque transaction si nécessaire.',
        ),
      ),
      'aid_type' =>
      array (
        'hover_text' => 'Élément facultatif permettant de supprimer le type d’aide (allègement de la dette, etc.) établi par défaut au niveau supérieur et de le remplacer, si nécessaire, par un type d’aide différent pour chaque transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez saisir des informations concernant le type d’aide fourni. Cet élément est généralement nommé « modalité d’aide » et l’IITA recommande d’utiliser un type d’aide issu de la liste de codes du CAD de l’OCDE pour l’ensemble des activités. Dans cette liste de codes, on trouve notamment : les interventions de type projet, qui consistent à soutenir un projet particulière, et l’aide budgétaire, qui prend la forme d’une contribution financière au budget d’un gouvernement bénéficiaire. Les interventions de type projet sont les plus courantes pour les ONG et les OSC, mais on peut trouver beaucoup d’autres types d’aides <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>ici</a>.<br></br>Si votre transaction concerne un événement humanitaire, vous pouvez fournir des informations précises concernant le type de fonds correspondant. Vous pouvez notamment préciser le degré de préaffectation des fonds transférés dans le cadre de la transaction et indiquer si les fonds sont transférés en espèces ou en coupons. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/humanitarian/\'>En savoir plus sur la publication du type d’aide associé aux transactions humanitaires</a>.<br></br>Attention : si vous sélectionnez un type d’aide pour cette transaction, le type d’aide par défaut établi pour l’ensemble de l’activité (et sélectionné ici) sera supprimé et vous pourrez choisir un type d’aide différent pour chaque transaction, si nécessaire.',
        'aid_type_vocabulary' =>
        array (
          'hover_text' => 'Code du vocabulaire utilisé pour catégoriser le type d’aide. Si aucun code n’est renseigné, la liste de codes de types d’aide (CAD-OCDE) s’applique par défaut. Le code doit correspondre à une valeur valide issue de la liste de codes du vocabulaire relatif au type d’aide. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez une liste comprenant le type d’aide concerné par votre transaction. Vous pouvez sélectionnez un type d’aide dans plusieurs listes.<br></br><b>1 CAD-OCDE</b> - l’IITA recommande l’emploi de cette liste, qui comprend <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/aidtype/\'>plus de 20 options</a>. Vous pouvez ensuite compléter votre choix en sélectionnant une option issue d’une autre liste<br></br><b>2 Catégorie d’affectation</b> - choisissez <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/earmarkingcategory/\'>cette liste</a> pour caractériser la flexibilité des financements humanitaires. Il existe quatre catégories d’affectation. Pour en savoir plus sur les différentes catégories, consultez l’<a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>annexe 1</a><br></br><b>3. Modalité d’affectation</b> - utilisez cette liste pour choisir une modalité d’affectation spécifique, correspondant au financement humanitaire de votre activité. Toutes les modalités d’affectation sont <a target=\'_blank\' href=\'https://reliefweb.int/sites/reliefweb.int/files/resources/Grand_Bargain_final_22_May_FINAL-2.pdf\'>recensées dans l’annexe 1<br><br></a><b>4 Modalités d’aide en espèces et en coupons</b> - utilisez cette liste pour indiquer si votre activité fournit une aide en espèces ou en coupons, en réaction à une situation humanitaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/CashandVoucherModalities/\'>En savoir plus</a>.</br>',
        ),
        'aid_type_code' =>
        array (
          'hover_text' => 'Code issu du vocabulaire sélectionné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez le type d’aide associé à votre transaction.',
        ),
        'earmarking_category' =>
        array (
          'hover_text' => 'Code issu du vocabulaire sélectionné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Description d’un secteur identifié par l’organisation déclarante. (À remplir uniquement si l’organisation déclarante emploie son propre vocabulaire.) <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>En savoir plus</a>',
          'help_text' => 'Si vous avez sélectionné l’option « Organisation déclarante », veuillez ajouter le nom et/ou une description en texte libre de la région bénéficiaire de l’activité.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/recipient-region/narrative/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du texte de l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
        ),
      ),
      'earmarking_modality' =>
      array (
        'hover_text' => 'Code issu du vocabulaire sélectionné. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
      ),
      'cash_and_voucher_modalities' =>
      array (
        'hover_text' => 'Code issu du vocabulaire sélectionné. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/aid-type/\'>En savoir plus</a>',
      ),
      'tied_status' =>
      array (
        'hover_text' => 'Élément facultatif permettant de supprimer le type de conditionnalité établi par défaut au niveau supérieur et de le remplacer, si nécessaire, par un type de conditionnalité transaction par transaction. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/tied-status/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez indiquer le type de conditionnalité correspondant à cette transaction. Dans cet élément, vous pouvez préciser si les fonds octroyés sont conditionnels – auquel cas ils doivent être dépensés pour l’achat de biens et de services auprès d’un pays (p. ex. le pays donateur) ou d’un groupe de pays spécifique. Ou s’ils sont non conditionnels – auquel cas il est possible d’effectuer des achats auprès de n’importe quel pays.<br></br>Attention : si vous choisissez un type de conditionnalité pour cette transaction, le <b>type de conditionnalité par défaut</b> établi pour l’ensemble de l’activité (et sélectionné ici) sera supprimé et vous pourrez choisir un type de conditionnalité différent pour chaque transaction si nécessaire.',
      ),
      'tied_status_code' =>
      array (
        'hover_text' => 'Code IITA permettant d’interpréter l’usage des colonnes 36-38 du format de publication du SNPC++. (Montant non conditionnel, montant semi-conditionnel, montant conditionnel). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/transaction/tied-status/\'>En savoir plus</a>',
        'help_text' => 'Si votre activité le permet, sélectionnez un type de conditionnalité par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/tiedstatus/\'>Description des différentes options disponibles</a>. Sinon, laissez le champ vide.',
      ),
    ),
  ),
  'organisation' =>
  array (
    'organisation_identifier' =>
    array (
      'hover_text' => 'L’identifiant d’organisation est un code unique associé à votre organisation. Il se compose du nom de l’organisme d’enregistrement et du numéro d’enregistrement de l’organisation. Pour en savoir plus, veuillez consulter la page suivante : Comment créer son identifiant d’organisation IITA. </br><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/organisation-identifier/\'>En savoir plus</a>',
      'organization_country' =>
      array (
        'hover_text' => 'Indiquez le lieu de votre organisation.',
        'help_text' => 'Précisez dans quel pays se trouve votre organisation.',
      ),
      'organization_registration_agency' =>
      array (
        'hover_text' => 'Sélectionnez l’organisme auprès duquel votre organisation est enregistrée au sein de votre pays. Si vous ne connaissez pas cette information, veuillez écrire à l’adresse suivante : support@iatistandard.org.',
        'help_text' => 'Donnez le nom de l’organisme auprès duquel votre organisation est enregistrée au sein de votre pays. Si vous ne connaissez pas cette information, veuillez écrire à l’adresse suivante : support@iatistandard.org.',
      ),
      'registration_number' =>
      array (
        'hover_text' => 'Saisissez le numéro d’enregistrement fourni, pour votre organisation, par l’organisme d’enregistrement. Si vous ne connaissez pas cette information, veuillez écrire à l’adresse suivante : support@iatistandard.org.',
        'help_text' => 'Saisissez le numéro d’enregistrement fourni, pour votre organisation, par l’organisme d’enregistrement mentionné ci-dessus. Si vous ne connaissez pas cette information, veuillez écrire à l’adresse suivante : support@iatistandard.org.',
      ),
      'iati-activity-identifier' =>
      array (
        'hover_text' => 'L’identifiant d’organisation est un code unique associé à votre organisation. Il se compose du nom de l’organisme d’enregistrement et du numéro d’enregistrement de l’organisation. Pour en savoir plus, veuillez consulter la page suivante : Comment créer son identifiant d’organisation IITA. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/organisation-identifier/\'>En savoir plus</a>',
        'help_text' => 'L’identifiant d’organisation (Org-ID) est un code unique associé à votre organisation. Il se compose du nom de l’organisme d’enregistrement et du numéro d’enregistrement de l’organisation. Pour en savoir plus, veuillez consulter la page suivante : <a target=\'_blank\' href=\'http://iatistandard.org/en/guidance/preparing-organisation/organisation-account/how-to-create-your-iati-organisation-identifier/\'>Comment créer l’identifiant IITA de votre organisation.</a>',
      ),
    ),
    'name' =>
    array (
      'hover_text' => 'Nom de l’organisation, lisible par l’être humain.',
      'narrative' =>
      array (
        'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/name/narrative/\'> En savoir plus</a>',
        'help_text' => 'Saisissez le nom de votre organisation.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/name/narrative/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez la langue du texte que vous avez saisi dans l’exposé. Si aucune langue n’est sélectionnée, la langue par défaut s’applique.',
      ),
    ),
    'reporting_org' =>
    array (
      'hover_text' => 'Organisation déclarante. Il peut s’agir d’une source primaire (organisation déclarant ses propres activités d’organisme donateur, d’organisme de mise en œuvre, etc.) ou d’une source secondaire (organisation déclarant les activités d’une autre organisation).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
      'help_text' => 'Vous devez préciser quelle est l’organisation à l’origine de la publication du fichier et quelle est l’organisation concernée par les données correspondantes. Dans la plupart des cas, l’organisation déclarante publie des données qui la concernent elle-même.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/activity-participants/\'>Instructions complémentaires</a>',
      'reference' =>
      array (
        'hover_text' => 'Chaîne d’identification lisible par les systèmes informatiques pour l’organisation déclarante. Doit respecter le format {OrganismeD’enregistrement}-{NuméroD’enregistrement}.<br> <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
        'help_text' => 'Saisissez l’identifiant d’organisation de l’IITA de l’organisation à l’origine de la publication des données. Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas l’organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.',
      ),
      'type' =>
      array (
        'hover_text' => 'Type d’organisation déclarante.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
        'help_text' => 'Sélectionnez la catégorie qui correspond le mieux à l’organisation déclarante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/\'>En savoir plus sur les différents types d’organisation.</a>',
      ),
      'secondary_reporter' =>
      array (
        'hover_text' => 'Symbole indiquant que l’organisation déclarante pour cette activité agit en tant qu’organisme de déclaration secondaire. Un organisme de déclaration secondaire restitue les données d’activité d’une organisation vis-à-vis de laquelle il n’assume aucune responsabilité directe.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/\'>En savoir plus</a>',
        'help_text' => 'Restituez-vous des données déclarées par une autre organisation ? Si oui, votre organisation a le statut d’« organisme de déclaration secondaire » et vous devez sélectionner la réponse « <b>Oui</b> ». Si vous restituez les données de votre propre organisation, choisissez la réponse « <b>No</b> ».<br><br>Attention : vous n’avez <b>pas</b> le statut d’organisme de déclaration secondaire si votre organisation est officiellement désignée comme mandataire (proxy) pour la publication des données IITA au nom d’une autre organisation.',
      ),
      'narrative' =>
      array (
        'hover_text' => 'Le texte de cet élément doit être de type xsd:string. Cet élément doit apparaître au moins une fois (au sein de chaque élément parent). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/narrative/\'>En savoir plus</a>',
        'help_text' => 'Si vous publiez les données d’une autre organisation, indiquez son nom.',
      ),
      'language' =>
      array (
        'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/narrative/\'>En savoir plus</a>',
      ),
    ),
    'total_budget' =>
    array (
      'hover_text' => 'L’élément relatif au budget total permet de renseigner le budget de l’organisation. Dans la mesure du possible, il est recommandé de renseigner le budget annuel prévisionnel total de l’organisation pour les trois années à venir.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/\'>En savoir plus</a>',
      'help_text' => 'Saisissez les dépenses prévisionnelles totales de votre organisation en matière de développement et d’aide humanitaire pour l’année en cours et (dans la mesure du possible) pour les trois années à venir. Chaque budget total saisi doit couvrir une période de 12 mois maximum et, si possible, correspondre à l’exercice fiscal de votre organisation. <br><br>Les budgets peuvent également être saisis pour des périodes inférieures à un an, par exemple par trimestre. Les dates des différentes périodes budgétaires ne doivent pas se recouper.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Instructions complémentaires.</a>',
      'status' =>
      array (
        'hover_text' => 'Le statut permet de déterminer si le budget renseigné est indicatif ou officiellement adopté. La valeur saisie doit être issue de la liste de codes relative au statut du budget.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/\'>En savoir plus</a>',
        'help_text' => 'Veuillez choisir le statut qui correspond le mieux à ce budget :<br><br>(1) <b>indicatif</b> - estimation du budget concerné, qui n’a fait l’objet d’aucun accord contraignant.<br><br>(2) <b>adopté</b> - le budget concerné est soumis à un accord contraignant.<br><br>Si aucun statut n’est renseigné, le statut du budget est réputé indicatif par défaut.',
      ),
      'period_start' =>
      array (
        'hover_text' => 'Date de début de la période budgétaire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-start/\'>En savoir plus</a>',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/period-end/\'>En savoir plus</a>',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant total du budget affecté à l’organisation au titre de l’aide financière au cours de la période considérée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le montant total de ce budget.',
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. Cet élément est obligatoire pour tous les montants exprimés en devise, sauf lorsque l’attribut organisation-iita/@default-currency est indiqué.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>En savoir plus</a>',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. <br><br>Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/value/\'>En savoir plus</a>',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Ventilation du budget total en sous-catégories budgétaires. Les critères de ventilation sont fixés par l’organisation déclarante et décrits dans l’exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez ajouter des informations complémentaires relatives au budget en utilisant les lignes budgétaires. Les lignes budgétaires permettent de ventiler le budget total, par exemple selon les différents programmes mis en œuvre au cours d’une même année.<br><br>Attention : la somme des différentes lignes budgétaires ne doit <b><u>pas</u></b> nécessairement être égale au montant total du budget.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Instructions complémentaires</a>.',
        'reference' =>
        array (
          'help_text' => 'Vous pouvez saisir une référence utilisée par le système interne d’information financière de votre organisation pour désigner cette ligne budgétaire.',
        ),
        'value' =>
        array (
          'hover_text' => 'Sous-catégorie budgétaire. Le choix de la sous-catégorie est indiqué par l’élément organisation-iita/budget-total/ligne-budgétaire/exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'> En savoir plus</a>',
          'help_text' => 'Indiquez le montant total de cette ligne budgétaire.',
          'currency' =>
          array (
            'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'>En savoir plus</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/value/\'>En savoir plus</a>',
          ),
        ),
      ),
    ),
    'recipient_org_budget' =>
    array (
      'hover_text' => 'L’élément budget-organisation-bénéficiaire permet de renseigner le budget prévisionnel de chaque organisation dont les ressources ordinaires bénéficient des fonds octroyés par l’organisation déclarante. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/\'>En savoir plus</a>',
      'help_text' => 'Si votre organisation contribue aux ressources ordinaires d’une ou plusieurs organisations bénéficiaires, veuillez ajouter ici les informations relatives à ce budget. <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Instructions complémentaires</a>.<br><br>Dans la mesure du possible, vous devez fournir le budget annuel prévisionnel de chaque organisation bénéficiaire pour chacun des trois prochains exercices financiers.',
      'status' =>
      array (
        'hover_text' => 'Le statut permet de déterminer si le budget renseigné est indicatif ou officiellement adopté. La valeur saisie doit être issue de la liste de codes relative au statut du budget.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/\'>En savoir plus</a>',
        'help_text' => 'Veuillez choisir le statut qui correspond le mieux au budget de cette organisation bénéficiaire :<br><br>(1) <b>indicatif</b> - estimation de la ligne budgétaire concernée, qui n’a fait l’objet d’aucun accord contraignant.<br><br>(2) <b>adopté</b> - la ligne budgétaire concernée est soumise à un accord contraignant.<br><br>Si aucun statut n’est renseigné, le statut de la ligne budgétaire est réputé indicatif par défaut.',
      ),
      'recipient_org' =>
      array (
        'hover_text' => 'Organisation qui recevra les fonds. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/\'>En savoir plus</a>',
        'help_text' => 'Saisissez les informations relatives à l’organisation qui recevra les fonds.',
        'reference' =>
        array (
          'hover_text' => 'Organisation qui recevra les fonds.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/\'>En savoir plus</a>',
          'help_text' => 'Veuillez saisir l’<i>identifiant de l’organisation</i> bénéficiaire de l’IITA. Pour trouver cette information, le moyen le plus rapide consiste à chercher l’organisation dans la <a target=\'_blank\' href=\'https://www.iatiregistry.org/publisher/\'>Liste des signataires de l’IITA</a>. Si vous ne trouvez pas l’organisation, veuillez consulter les <a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/\'>instructions complémentaires</a>.<br><br>Si vous n’êtes pas en mesure de renseigner l’identifiant de l’organisation, vous DEVEZ saisir son nom ci-dessous.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom de l’organisation. Peut figurer en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez le nom de l’organisation bénéficiaire.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé de n’utiliser que des codes issus de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/recipient-org/narrative/\'>En savoir plus</a>',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Cet élément ne doit apparaître qu’une fois (au sein de chaque élément principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-start/\'>En savoir plus</a>',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/period-end/\'>En savoir plus</a>',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant total des fonds octroyés à l’organisation bénéficiaire au cours de la période considérée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/value/\'>En savoir plus</a>',
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. Cet élément est obligatoire pour tous les montants exprimés en devise, sauf lorsque l’attribut organisation-iita/@default-currency est indiqué. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/budget/value/\'>En savoir plus</a>',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/value/\'>En savoir plus</a>',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Ventilation du budget total en sous-catégories budgétaires. Les critères de ventilation sont fixés par l’organisation déclarante et décrits dans l’exposé.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez diviser le budget total de l’organisation bénéficiaire en plusieurs lignes budgétaires.<br><br>Attention : la somme des différentes lignes budgétaires ne doit <b>pas</b> nécessairement être égale au montant total du budget de l’organisation bénéficiaire.<a target=\'_blank\' href=\'https://iatistandard.org/en/guidance/standard-guidance/organisation-budgets-spend/\'>Instructions complémentaires</a>.',
        'value' =>
        array (
          'hover_text' => 'Sous-catégorie budgétaire. Le choix de la sous-catégorie est indiqué par l’élément organisation-iita/budget-total/ligne-budgétaire/exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>En savoir plus</a>',
          'currency' =>
          array (
            'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>En savoir plus</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-org-budget/budget-line/value/\'>En savoir plus</a>',
          ),
        ),
      ),
    ),
    'recipient_region_budget' =>
    array (
      'hover_text' => 'L’élément relatif au budget de la région bénéficiaire permet de renseigner un budget prévisionnel dans les zones où l’organisation octroie des fonds à l’échelle régionale plutôt que des budgets nationaux, ou en plus de ceux-ci.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/\'>En savoir plus</a>',
      'help_text' => 'L’IITA recommande vivement aux organisations de diviser leur budget total en lignes budgétaires plus restreintes, correspondant aux pays ou aux régions bénéficiaires dans lesquels elles interviennent.<br><br>Si vous renseignez des budgets pour plusieurs régions ou pays bénéficiaires, la période considérée peut varier et la somme de ces budgets ne <b>doit pas</b> nécessairement être égale au budget total de l’organisation.<br><br>Si vous souhaitez renseignez le budget d’une région bénéficiaire, celui-ci ne doit PAS correspondre au cumul des budgets des pays bénéficiaires. Par exemple, si vous renseignez un budget de pays pour l’Ouganda d’un montant de 100 000 dollars des États-Unis et un budget pour le Kenya de 100 000 dollars É.-U. pour l’année suivante, vous ne devez PAS renseigner un budget de région de 200 000 dollars É.-U. pour l’Afrique pour l’année suivante.',
      'status' =>
      array (
        'hover_text' => 'Le statut permet de déterminer si le budget renseigné est indicatif ou officiellement adopté. La valeur saisie doit être issue de la liste de codes relative au statut du budget.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/\'>En savoir plus</a>',
        'help_text' => 'Veuillez choisir le statut qui correspond le mieux au budget de la région bénéficiaire :<br><br>(1) <b>indicatif</b> - estimation du budget concerné, qui n’a fait l’objet d’aucun accord contraignant.<br><br>(2) <b>adopté</b> - le budget concerné est soumis à un accord contraignant.<br><br>Si aucun statut n’est renseigné, le statut du budget est réputé indicatif par défaut.',
      ),
      'recipient_region' =>
      array (
        'hover_text' => 'Région supranationale bénéficiaire des fonds octroyés.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>En savoir plus</a>',
        'vocabulary' =>
        array (
          'hover_text' => 'Code IITA pour le vocabulaire dont le code de région est issu. Si aucun code n’est renseigné, le vocabulaire 1 (CAD-OCDE) s’applique par défaut. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>En savoir plus</a>',
          'help_text' => 'Il existe deux listes de régions ; la liste du <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/codelists/region/’>CAD de l’OCDE</a> et les listes de codes de <a target=’_blank’ href=’https://unstats.un.org/unsd/methodology/m49/’>région des Nations Unies</a>. Veuillez sélectionner une option. L’IITA recommande l’usage de la liste de codes du CAD de l’OCDE. Vous pouvez également faire appel à une autre liste de régions, en sélectionnant l’option : « Organisation déclarante » et en indiquant l’URI correspondant à cette liste interne. <br></br>Si aucune option n’est sélectionnée, la liste de codes du CAD de l’OCDE s’applique par défaut.',
        ),
        'vocabulary-uri' =>
        array (
          'hover_text' => 'URI correspondant au vocabulaire sélectionné. Si le vocabulaire est égal à 99 (organisation déclarante), URI correspondant à ce vocabulaire interne. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/\'>En savoir plus</a>',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez le nom de la région bénéficiaire du budget.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/recipient-region/narrative/\'>En savoir plus</a>',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Date de début de la période budgétaire. Cet élément ne doit apparaître qu’une fois (au sein de chaque élément principal).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-start/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de début de la période budgétaire de la région bénéficiaire.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année).<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/period-end/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de fin de la période budgétaire de la région bénéficiaire.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant total des fonds octroyés au pays concerné au cours de la période considérée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le montant total des fonds correspondant au budget de la région bénéficiaire.',
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>En savoir plus</a>',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Ventilation du budget du pays bénéficiaire en sous-catégories budgétaires. Les critères de ventilation sont fixés par l’organisation déclarante et décrits dans l’exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez ajouter des informations complémentaires relatives à ce budget de région bénéficiaire en utilisant les lignes budgétaires. Les lignes budgétaires permettent de ventiler le budget de la région bénéficiaire, par exemple selon les différents projets mis en œuvre au cours d’une même année.<br><br>Attention : la somme des différentes lignes budgétaires <b>ne doit pas</b> nécessairement être égale au montant total du budget de la région bénéficiaire.',
        'reference' =>
        array (
          'hover_text' => 'Référence interne utilisée par le système de l’organisation déclarante pour désigner cette ligne budgétaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/\'>En savoir plus</a>',
        ),
        'value' =>
        array (
          'hover_text' => 'Sous-catégorie budgétaire. Le choix de la sous-catégorie est indiqué par l’élément organisation-iita/budget-total/ligne-budgétaire/exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>En savoir plus</a>',
          'currency' =>
          array (
            'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>En savoir plus</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-region-budget/budget-line/value/\'>En savoir plus</a>',
          ),
        ),
      ),
    ),
    'recipient_country_budget' =>
    array (
      'hover_text' => 'L’élément relatif au budget du pays bénéficiaire permet de renseigner le budget prévisionnel de chacun des pays dans lesquels intervient l’organisation. <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/’>En savoir plus</a>',
      'help_text' => 'Vous pouvez renseigner le budget de votre organisation en fonction des différents pays bénéficiaires. La période considérée peut varier et la somme des budgets renseignés <b>ne doit pas</b> nécessairement être égale au budget total de l’organisation.<br><br>Si votre organisation dispose de budgets nationaux, veuillez les renseigner ici.',
      'status' =>
      array (
        'hover_text' => 'Le statut permet de déterminer si le budget renseigné est indicatif ou officiellement adopté. La valeur saisie doit être issue de la liste de codes relative au statut du budget.<a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/’>En savoir plus</a>',
        'help_text' => 'Veuillez choisir le statut qui correspond le mieux au budget du pays bénéficiaire :<br><br>(1) <b>indicatif</b> - estimation du budget concerné, qui n’a fait l’objet d’aucun accord contraignant.<br><br>(2) <b>adopté</b> - le budget concerné est soumis à un accord contraignant.<br><br>Si aucun statut n’est renseigné, le statut du budget est réputé indicatif par défaut.',
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'Pays bénéficiaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/\'>En savoir plus</a>',
        'code' =>
        array (
          'hover_text' => 'Code ISO 3166-1 alpha-2 du pays.Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez le pays bénéficiaire de ce budget.',
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/narrative/\'>En savoir plus</a>',
          'help_text' => 'Saisissez le nom du pays bénéficiaire.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé de n’utiliser que des codes issus de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/recipient-country/narrative/\'>En savoir plus</a>',
        ),
      ),
      'period_start' =>
      array (
        'hover_text' => 'Date de début de la période budgétaire. Cet élément ne doit apparaître qu’une fois (au sein de chaque élément principal). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-start/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de début de la période budgétaire du pays bénéficiaire.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/period-end/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de fin de la période budgétaire du pays bénéficiaire.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant total des fonds destinés à être versés à l’organisation bénéficiaire concernée au cours de la période considérée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le montant total de ce budget.',
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. <br><br>Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/value/\'>En savoir plus</a>',
        ),
      ),
      'budget_line' =>
      array (
        'hover_text' => 'Ventilation du budget total en sous-catégories budgétaires. Les critères de ventilation sont fixés par l’organisation déclarante et décrits dans l’exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez ajouter des informations complémentaires relatives à ce budget de pays bénéficiaire en utilisant les lignes budgétaires. Les lignes budgétaires permettent de ventiler le budget du pays bénéficiaire, par exemple selon les différents projets mis en œuvre au cours d’une même année.<br><br>Attention : la somme des différentes lignes budgétaires ne doit <b>pas</b> nécessairement être égale au montant total du budget du pays bénéficiaire.',
        'reference' =>
        array (
          'hover_text' => 'Référence interne utilisée par le système de l’organisation déclarante pour désigner cette ligne budgétaire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/\'>En savoir plus</a>',
        ),
        'value' =>
        array (
          'hover_text' => 'Sous-catégorie budgétaire. Le choix de la sous-catégorie est indiqué par l’élément organisation-iita/budget-total/ligne-budgétaire/exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>En savoir plus</a>',
          'currency' =>
          array (
            'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>En savoir plus</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/value/\'>En savoir plus</a>',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/narrative/\'>En savoir plus</a>',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/recipient-country-budget/budget-line/narrative/\'>En savoir plus</a>',
        ),
      ),
    ),
    'total_expenditure' =>
    array (
      'hover_text' => 'L’élément relatif aux dépenses totales permet de renseigner les dépenses totales de l’organisation en matière de développement international. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/\'>En savoir plus</a>',
      'help_text' => 'L’IITA vous recommande de renseigner les dépenses antérieures de votre organisation en matière d’action humanitaire et de développement. C’est ce que l’on appelle les « dépenses totales » et, dans la mesure du possible, l’IITA recommande aux organisations de renseigner leurs dépenses totales pour chacune des trois dernières années. <br><br>En matière de dépenses, la période considérée <b>ne doit pas</b> dépasser un an.',
      'period_start' =>
      array (
        'hover_text' => 'Date de début de la période budgétaire.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-start/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-start/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de début de la période de dépenses.',
        ),
      ),
      'period_end' =>
      array (
        'hover_text' => 'Date de fin de la période budgétaire (qui ne doit pas dépasser une année). <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-end/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/period-end/\'>En savoir plus</a>',
          'help_text' => 'Indiquez la date de fin de la période de dépenses.',
        ),
      ),
      'value' =>
      array (
        'hover_text' => 'Montant total des dépenses de l’organisation consacrées à l’aide au cours de la période considérée. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>En savoir plus</a>',
        'help_text' => 'Indiquez le montant total de ces dépenses.',
        'currency' =>
        array (
          'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>En savoir plus</a>',
        ),
        'value_date' =>
        array (
          'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/value/\'>En savoir plus</a>',
        ),
      ),
      'expense_line' =>
      array (
        'hover_text' => 'Ventilation des dépenses totales en sous-catégories. Les critères de ventilation sont fixés par l’organisation déclarante et décrits dans l’exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/\'>En savoir plus</a>',
        'help_text' => 'Vous pouvez ajouter des informations complémentaires relatives aux dépenses de votre organisation en utilisant les lignes de dépenses. Les lignes de dépenses permettent de ventiler les dépenses en catégories plus restreintes.<br><br>Attention : la somme des différentes lignes de dépenses <b>ne doit pas</b> nécessairement être égale au montant total des dépenses.',
        'reference' =>
        array (
          'hover_text' => 'Référence interne utilisée par le système de l’organisation déclarante pour désigner cette ligne de dépenses. <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-budget/budget-line/’><a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/\'>En savoir plus</a>',
          'help_text' => 'Vous pouvez indiquer la référence utilisée par le système de gestion financière interne de votre organisation pour désigner cette ligne de dépenses.',
        ),
        'value' =>
        array (
          'hover_text' => 'Montant total de la sous-catégorie de dépenses. Le choix de la sous-catégorie est indiqué par l’élément organisation-iita/dépenses-totales/ligne-dépenses/exposé. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>En savoir plus</a>',
          'help_text' => 'Indiquez le montant total de cette ligne de dépenses.',
          'currency' =>
          array (
            'hover_text' => 'Code ISO 4217 à trois lettres pour la devise d’origine du montant.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>En savoir plus</a>',
          ),
          'value_date' =>
          array (
            'hover_text' => 'Date à prendre en compte pour calculer le taux de change des conversions de devises.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/value/\'>En savoir plus</a>',
          ),
        ),
        'narrative' =>
        array (
          'hover_text' => 'Nom ou description en texte libre de l’élément concerné. Peut figurer en plusieurs langues. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/narrative/\'>En savoir plus</a>',
          'help_text' => 'Fournissez une description de cette ligne de dépenses.',
        ),
        'language' =>
        array (
          'hover_text' => 'Code précisant la langue du texte présent dans cet élément. Dans la mesure du possible, il est recommandé d’utiliser uniquement les codes de la norme ISO 639-1. Si aucun code n’est renseigné, la langue par défaut s’applique. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/total-expenditure/expense-line/narrative/\'>En savoir plus</a>',
        ),
      ),
    ),
    'document_link' =>
    array (
      'hover_text' => 'Lien vers un site Internet ou un document en ligne, accessible au grand public. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>En savoir plus</a>',
      'help_text' => 'Vous pouvez fournir des informations complémentaires relatives à l’élaboration de programmes humanitaires au sein de votre organisation en ajoutant un lien vers un site Internet ou un document accessible au grand public. Par exemple, vous pouvez ajouter un lien vers le rapport annuel de votre organisation ou vers un plan de travail consacré à un pays en particulier.<br><br>S’il existe des documents disponibles dans d’autres langues et stockés séparément, veuillez les ajouter également en créant de nouveaux éléments d’ajout de documents.<a target=’_blank’ href=’https://iatistandard.org/en/guidance/standard-guidance/related-documents/’>Instructions complémentaires</a>',
      'url' =>
      array (
        'hover_text' => 'URL cible du document externe, p. ex. « http://www.example.org/doc.odt ».<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>En savoir plus</a>',
      ),
      'format' =>
      array (
        'hover_text' => 'Code IANA correspondant au type MIME du document référencé, p. ex. « application/pdf ». <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/\'>En savoir plus</a>',
        'help_text' => 'Si vous connaissez le format du document, veuillez le saisir <a target=’_blank’ href=’https://iatistandard.org/en/iati-standard/203/codelists/fileformat/’>en choisissant une option dans cette liste</a>.',
      ),
      'title' =>
      array (
        'hover_text' => 'Titre court et lisible par un être humain. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/title/\'>En savoir plus</a>',
      ),
      'description' =>
      array (
        'hover_text' => 'Description du contenu du document ou instructions permettant d’accéder directement aux informations pertinentes.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/description/\'>En savoir plus</a>',
      ),
      'category' =>
      array (
        'hover_text' => 'Code IITA correspondant à la catégorie de document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/category/\'>En savoir plus</a>',
        'code' =>
        array (
          'hover_text' => 'Code IITA permettant de caractériser la catégorie du document. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/category/\'>En savoir plus</a>',
        ),
      ),
      'language' =>
      array (
        'hover_text' => 'Code de la norme ISO 639-1 correspondant à la langue dans laquelle le document cible est écrit, p. ex. « en ». Cet élément peut être répété pour caractériser des documents disponibles en plusieurs langues.<a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/language/\'>En savoir plus</a>',
        'code' =>
        array (
          'hover_text' => 'Code de langue de la norme ISO 639-1. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/language/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez la langue du document ou de la page Internet.',
        ),
      ),
      'document_date' =>
      array (
        'hover_text' => 'Date de publication du document renseigné. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/document-date/\'>En savoir plus</a>',
        'date' =>
        array (
          'hover_text' => 'Cet attribut est obligatoire. Cette valeur doit être de type xsd:date. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/document-date/\'>En savoir plus</a>',
        ),
      ),
      'recipient_country' =>
      array (
        'hover_text' => 'Pays bénéficiaire sur lequel porte principalement le document. Cet élément peut être répété pour renseigner plusieurs pays. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/recipient-country/\'>En savoir plus</a>',
        'help_text' => 'Si ce document ou ce site Internet concerne principalement un pays bénéficiaire spécifique, veuillez l’indiquer ici. Vous pouvez citer plusieurs pays.',
        'code' =>
        array (
          'hover_text' => 'Code ISO 3166-1 alpha-2 du pays. Cet attribut est obligatoire. <a target=\'_blank\' href=\'https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/document-link/recipient-country/\'>En savoir plus</a>',
          'help_text' => 'Sélectionnez le pays bénéficiaire sur lequel porte principalement le document ou le site Internet renseigné.',
        ),
        'narrative' =>
        array (
          'help_text' => 'Saisissez le nom du pays sur lequel porte principalement le document ou le site Internet renseigné.',
        ),
      ),
    ),
  ),
);
