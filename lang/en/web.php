<?php
/*
|--------------------------------------------------------------------------
| Web Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are the default lines for texts shown at the homepage.
*/

return [
    //Lines for header
    'header' => [

        //Lines for nav-item hover card
        'about'                    => [
            'label'      => 'About',
            'uppercase'  => 'ABOUT',
            'hover_text' => 'IATI Publisher helps small and medium-sized organisations publish IATI data on development and humanitarian financing and activities',
            'button'     => 'Learn More',
        ],
        'publishing_checklist'     => [
            'label'      => 'Publishing Checklist',
            'uppercase'  => 'PUBLISHING CHECKLIST',
            'hover_text' => 'New to IATI? Use our checklist to track each step required for your organisation to successfully publish IATI data',
            'button'     => 'Read More'
        ],
        'iati_standard'            => [
            'label'      => 'IATI Standard',
            'uppercase'  => 'IATI STANDARD',
            'hover_text' => 'The IATI Standard provides information and guidance on all the data fields that your organisation can publish IATI data on',
            'button'     => 'See all data fields'
        ],
        'support'                  => [
            'label'      => 'Support',
            'uppercase'  => 'SUPPORT',
            'hover_text' => 'Any questions? Get help to publish your organisation’s data',
            'button'     => 'Read More'
        ],
        'language'                 => [
            'label'     => 'Language',
            'uppercase' => 'LANGUAGE',
        ],

        //Auth user nav menu
        'uc_activity_data'         => 'ACTIVITY DATA',
        'uc_organisation_data'     => 'ORGANISATION DATA',
        'uc_settings'              => 'SETTINGS',
        'uc_add_import_activity'   => 'ADD/IMPORT ACTIVITY',
        'uc_add_activity_manually' => 'ADD ACTIVITIES MANUALLY',
        'uc_import_activities'     => 'IMPORT ACTIVITIES FROM .CSV/.XML',
        'search_activity'          => 'Search activity...',
        'search_organisation'      => 'Search organisation...',
        'your_profile'             => 'Your Profile',
        'logout'                   => 'Logout',

    ],

    //Lines for footer
    'footer' => [
        'iati_publisher'                     => 'IATI Publisher',
        'home'                               => 'Home',
        'about'                              => 'About',
        'sign_in'                            => 'Sign In',
        'join_now'                           => 'Join Now',
        'iati_standard'                      => 'IATI Standard',
        'publishing_checklist'               => 'Publishing Checklist',
        'support'                            => 'Support',
        'part_of_iati_unified_label'         => 'Part of the IATI Unified Platform',
        'code_licensed_under_label'          => 'Code licensed under the GNU AGPL.',
        'documentation_licensed_under_label' => 'Documentation licensed under CC BY 3.0',
        'any_questions_contact_label'        => 'ANY QUESTIONS? CONTACT SUPPORT',
        'copyright_label'                    => 'Copyright IATI 2022. All rights reserved.',

        //Auth user footer
        'dashboard'                          => 'Dashboard'
    ],

    'common'                    => [
        'next'                    => 'Next',
        'prev'                    => 'Prev',
        'alerts'                  => 'Alerts',
        'show_more'               => 'Show more',
        'show_less'               => 'Show less',
        'draft'                   => 'draft',
        'publish'                 => 'Publish',
        'unpublish'               => 'Unpublish',
        'publish_selected'        => 'PUBLISH SELECTED',
        'account_not_verified'    => [
            'label'      => 'Account not Verified',
            'hover_text' => 'Please check for verification email sent to you and verify your account, <span data-v-b77b11d4=""><a class="cursor-pointer border-b-2 border-b-bluecoral font-bold text-bluecoral hover:border-b-spring-50" data-v-b77b11d4="">resend verification email</a></span> if you haven’t received your verification email. Contact <span data-v-b77b11d4=""><a target="_blank" href="mailto:PubToolTest@iatistandard.org" data-v-b77b11d4="">PubToolTest@iatistandard.org</a></span> for further assistance.',
        ],
        'completed'               => 'completed',
        'missing'                 => 'missing',
        'not_completed'           => 'not completed',
        'core'                    => 'Core',
        'all_elements'            => 'All Elements',
        'mandatory_fields'        => 'Mandatory fields',
        'iati_standard_reference' => 'IATI Standard Reference'

    ],

    /*----------------------------------------------------------------home page--------------------------------------------------------------------------------------------------*/
    'home_page'                 => [
        //Page Header
        'iati_publisher'               => 'IATI PUBLISHER',

        //IATI Publishing Tool section lines
        'iati_publishing_tool_header'  => 'IATI Publishing Tool',
        'iati_publishing_tool_section' => [
            'welcome_text'               => 'Welcome to IATI Publisher. Publish IATI data on your organisation’s development and humanitarian financing and activities. Enter your login information if you’re already a user or create a new account if you’re new here.',
            'havent_registered_label'    => 'Haven\'t registered yet?',
            'join_now_label'             => 'Join Now',
            'already_have_account_label' => 'Already have an account?',
            'sign_in_label'              => 'Sign In',
        ],

        //Join Now Section Lines
        'join_now_header'              => 'Join Now.',
        'join_now_section'             => [
            'to_begin_text'                        => 'To begin, your organisation needs to be registered as an IATI publisher. Select an option and we’ll guide you through this process.',
            'new_to_iati_label'                    => 'I am new to IATI',
            'new_to_iati_text'                     => 'Use this option if your organization <u>has not</u> registered an account with IATI on the IATI Registry',
            'my_organisation_has_registered_label' => 'My organization has registered with IATI.',
            'my_organisation_has_registered_text'  => 'Use this option if your organisation is already registered as an IATI Publisher on the <a href="https://www.iatiregistry.org/" target="_blank">IATI Registry</a>',
            'not_sure_which_one_label'             => 'Not sure which one to select?',
            'contact_support_label'                => 'Contact Support.',
        ],

        //Sign In Section lines
        'sign_in_header'               => 'Sign In.',
        'sign_in_section'              => [
            'welcome_back_label'    => 'Welcome back! Please enter your details.',
            'username_label'        => 'Username',
            'username_placeholder'  => 'Enter a registered username',
            'password_label'        => 'Password',
            'password_placeholder'  => 'Enter a correct password',
            'forgot_password_label' => 'Forgot your password?',
            'reset_label'           => 'Reset',
            'uc_sign_in_label'      => 'SIGN IN'
        ],
    ],

    /*----------------------------------------------------------------about page--------------------------------------------------------------------------------------------------*/
    'about_page'                => [
        'about_iati_publisher'               => "ABOUT IATI Publisher",
        'what_is_iati_publisher_header'      => "What is IATI Publisher?",
        'what_is_iati_publisher_description' => [
            'one' => 'IATI Publisher enables organisations to publish data on activities and resource flows according to the IATI Standard. The IATI Standard is a set of rules and guidance on how to publish useful development and humanitarian data.'
        ],
        'use_iati_publisher_to_header'       => 'Use IATI Publisher to:',
        'use_iati_publisher_to_description'  => [
            'one'   => [
                'list_items' => [
                    'one'   => 'Register your organisation with an IATI Publisher account',
                    'two'   => 'Understand the data fields in the IATI Standard (with IATI Standard Reference definitions, helpful explanations and links to guidance)',
                    'three' => 'Provide your organisation’s data easily by completing online forms. Or upload data on multiple activities on a CSV or .xml file with the Bulk Upload feature',
                    'four'  => 'Run automatic checks (via the IATI Validator) for errors before publishing your data',
                    'five'  => 'Publish your data. IATI Publisher will add your data to the IATI Registry (where links to all IATI data is found)'
                ]
            ],
            'two'   => 'IATI Publisher has been built to support organisations that publish a limited number of development and humanitarian activities. An ‘activity’ is an individual project or another unit of development and humanitarian work, which is determined by the organisation that is publishing the data. Organisations who publish a limited number of activities tend to represent small and medium sized organisations. ',
            'three' => 'Large organisations, such as donor governments or UN agencies delivering 100+ activities are advised not to use IATI Publisher. Instead these organisations likely need to use an alternative technical solution that enables the publication of large volumes of data. Please email the IATI Helpdesk for more information:<a target="_blank" rel="noopener noreferrer" href="mailto: support@iatistandard.org">support@iatistandard.org </a>'
        ],
        'development_of_iati_header'         => 'Development of IATI Publisher',
        'development_of_iati_description'    => [
            'one' => 'IATI Publisher was first launched in December 2022 by the IATI Secretariat and has been developed by <a target=""_blank"" rel=""noopener noreferrer"" href="https://younginnovations.com.np/">Young Innovations </a>, a software development firm based in Nepal. IATI Publisher is fully aligned with the IATI Standard XML <a href="https://iatistandard.org/en/iati-standard/203/schema/">schema</a> and <a target=""_blank"" rel=""noopener noreferrer"" href="https://iatistandard.org/en/iati-standard/203/rulesets/">rulesets </a>.'
        ],
    ],

    /*----------------------------------------------------------------publishing-checklist page--------------------------------------------------------------------------------------------------*/
    'publishing_checklist_page' => [
        'publishing_checklist'           =>     'Publishing Checklist',
        'organisations_using_iati_label' => 'Organisations using IATI Publisher need to take the following steps to publish your data: ',

        'register_a_publisher_header'      => 'Register a Publisher Account',
        'register_a_publisher_description' => [
            'one'   => 'Organisations who publish data to IATI are referred to as \'Publishers\'. Before publishing data, organisations need their own \'Publisher Account\' on the IATI Registry (iatiregistry.org). If your organisation does not yet have a Publisher Account on the IATI Registry, IATI Publisher will ask you for additional details and create one for you (so you don’t have to visit IATI Registry to do this).',
            'two'   => 'Create your IATI Registry Publisher Account',
            'three' => 'If your organisation has already registered a Publisher Account on the IATI Registry, IATI Publisher will ask you to provide your organisation’s account details.',
            'four'  => 'Provide your organisations existing IATI Registry Publisher Account details'
        ],

        'publish_your_organisation_header'      => 'Publish your Organisation Data',
        'publish_your_organisation_description' => [
            'one'   => 'The IATI Standard requires you to provide data about your entire organisation. For example, basic information about your organisation, such as its name and financial data about your entire organisation’s budgets and expenditure.',
            'two'   => 'The IATI Standard contains a wide range of data fields. Data fields are referred to as ‘elements’ and they represent a basic unit of information in the IATI Standard. For each element you will find its technical definition, which is labelled as “IATI Standard Reference” and helpful guidance on the data you are required to provide. Your organisation is encouraged to (at least) publish data in fields marked as “Core” in IATI Publisher. Core elements include IATI’s "mandatory and recommended" elements and it is important to provide this data to ensure your data is usable and useful.',
            'three' => 'Discover what Activity Data is required by the IATI Standard',
            'four'  => 'Publish your Activity Data'

        ],
        'publish_your_activity_header'          => 'Publish your Activity Data',
        'publish_your_activity_description'     => [
            'one'   => 'You also need to provide data about your organisation’s development and humanitarian ‘activities’. The unit of work described by an ‘activity’ is determined by the organisation that is publishing the data. For example, an activity could be a donor government providing US$ 50 million to a recipient country’s government to implement basic education over 5 years. Or an activity could be an NGO spending US$ 500,000 to deliver clean drinking water to 1000 households over 6 months.',
            'two'   => [
                'list_items' => [
                    'header' => 'Therefore your organisation will need to determine how it will divide its work internally into activities. You could consider one activity to be: ',
                    'one'    => 'a large programme at country or region level',
                    'two'    => 'a smaller project in a local area',
                    'three'  => 'the work relating to a particular grant or contract'
                ]
            ],
            'three' => [
                'list_items' => [
                    'header' => 'You can provide your Activity Data in two ways on IATI Publisher: ',
                    'one'    => 'fill out the data fields in the Activity Data form for each Activity that you create',
                    'two'    => 'If you have multiple activities, you can use the <strong>Bulk Upload</strong> feature to upload a spreadsheet of the core fields of your data then you can edit them further using the online Activity Data form.'
                ]
            ],
            'four'  => 'When publishing your Activity Data you are encouraged to (at least) publish data in fields marked as “Core” in IATI Publisher. They include IATI’s "mandatory and recommended" elements and it is important to provide this data to ensure your data is usable and useful. ',
            'five'  => 'Discover what Activity Data is required by the IATI Standard',
            'six'   => 'Publish your Activity Data'
        ],

        'understand_further_data_header'      => 'Understand further data requirements',
        'understand_further_data_description' => [
            'one' => 'If your organisation receives funding from the UK, Dutch or Belgian governments, you may also need to report IATI data according to their specific requirements. You are advised to understand the specific IATI data requirements of each government if you are receiving a grant from them.See <a target="_blank" href="https://iatistandard.org/en/guidance/standard-overview/donors-reporting-requirements/"> more information</a>.',
            'two' => 'You will also need to consider if your organisation needs to exclude data that it publishes. For example an organisation may not be able to publish data because of political sensitivity issues or if information is commercially restricted. See information on creating an <a href="https://iatistandard.org/en/guidance/preparing-organisation/organisation-data-publication/information-and-data-you-cant-publish-exclusions/"> Exclusion Policy </a>.'
        ],
        'run_automatic_checks_header'         => 'Run automatic checks on your data for errors',
        'run_automatic_checks_description'    => [
            'one' => 'After you have added your data to IATI Publisher, it will run automatic checks for errors. You will receive information about any errors that you need to fix. Make sure you fix these errors before publishing your data. '
        ],

        'publish_your_data_header'      => 'Publish your data to the IATI Registry',
        'publish_your_data_description' => [
            'one' => 'Once you are happy with the data that you have provided, you can instruct IATI Publisher to publish it. ',
            'two' => 'IATI Publisher converts your data files into XML, the format that is required by the IATI Standard. IATI Publisher will store your XML data files online, and provide a link to these files on the IATI Registry. The IATI Registry stores links to every IATI data file published and you can search for your organisation’s IATI XML files here: '
        ],

        'access_your_data_header'      => 'Access your data',
        'access_your_data_description' => [
            'one'   => 'IATI data is open data and can be accessed by anyone. It is pulled from the IATI Registry and used for many purposes. For example, IATI data can be used by governments to monitor development resources going into their countries, by donors and civil society to enable coordination, by analysts and academics to inform research and policy, or by organisations who include IATI data in their own online data portals. ',
            'two'   => 'There are many online data tools and platforms that share and visualise IATI data. You can start by looking at your organisation’s data on IATI’s simple platform called <a target="_blank" href="http://d-portal.org/ctrack.html#view=search">d-portal</a>. Within 24 hours of publishing your data, it will be displayed there. Simply search for your organisation in the “Publisher’ drop-down menu. And to see your data in a format that is used by governments and other data users, visit the <a href="https://countrydata.iatistandard.org/"> Country Development Finance Data </a>tool',
            'three' => 'See more information on <a href="https://iatistandard.org/en/iati-tools-and-resources/">IATI tools and resources</a>.'
        ],

        'update_and_improve_header'      => 'Update and improve your data',
        'update_and_improve_description' => [
            'one' => 'Once your organisation has published its first dataset, you are encouraged to <strong>update and improve</strong> your data over time. You should update your data at least every quarter. You should also aim to expand the number of data fields that you provide information for. Read more about <a href="https://iatistandard.org/en/guidance/standard-overview/preparing-your-organisation-data-publication/key-qualities-of-iati-data/">improving the quality of IATI data</a>. ',
            'two' => 'For more information about publishing IATI data please visit IATI’s main website: <a href="https://iatistandard.org/en/guidance/">iatistandard.org/guidance</a>.'
        ]
    ],

    /*----------------------------------------------------------------iati-standard page--------------------------------------------------------------------------------------------------*/
    'iati_standard_page'        => [
        'iati_standard'                      => 'IATI Standard',
        'iati_standard_description'          => [
            'one' => 'IATI Standard The IATI Standard is a set of rules and guidance on how to publish useful development and humanitarian data. IATI Publisher will take you through all data fields (which are referred to as ‘elements’) of the IATI Standard, offering helpful explanations and links to further information and guidance. The IATI Standard requires organisations to publish two sets of data: '
        ],
        'organisation_data_header'           => 'Organisation Data',
        'organisation_data_description'      => [
            'one' => [
                'list_items' => [
                    'header' => 'IATI Standard You will be asked to publish data about your entire organisation. This includes basic information about your organisation, such as your name and the type of organisation you are. You can also provide data on: ',
                    'one'    => 'Total spend by your organisation over the last year ',
                    'two'    => 'Total annual planned budget for your organisation in each of the next three years, where available',
                    'three'  => 'Planned budgets broken down by individual recipient countries or regions',
                    'four'   => 'Run automatic checks (via the IATI Validator) for errors before publishing your data',
                    'five'   => 'Useful background documents, such as country action plans and annual reports '
                ]
            ],
            'two' => 'Publish your Organisation Data'
        ],
        'activity_data_header'               => 'Activity Data',
        'activity_data_description'          => [
            'one' => [
                'list_items' => [
                    'header' => 'The IATI Standard also requires organisations to provide data about their development and humanitarian ‘activities’. For each activity, you can publish a wide range of information, including:',
                    'one'    => '<u>Basic information and identification</u> of the activity e.g. providing a title and a description for your activity ',
                    'two'    => '<u>Participating organisations</u> – information on which other organisations are involved in the activity ',
                    'three'  => '<u>Participating organisations</u> – information on which other organisations are involved in ',
                    'four'   => '<u>Financial data</u> – covers the budgets and the transactions for the activity ',
                    'five'   => '<u>Classifications</u> – helps categorise the activity using various development and humanitarian taxonomies. For example, what sector does the activity target or support (e.g. primary education or agriculture), or what type of aid is used to fund the activity (e.g. a grant or loan) ',
                    'six'    => '<u>Links to other data</u> that have already been published on the activity elsewhere ',
                    'seven'  => 'The <u>results</u> that the activity is aiming to achieve '
                ],
            ],
        ],
        'publishing_data_either_header'      => 'Publishing data at either Activity level or Transaction level ',
        'publishing_data_either_description' => [
            'one'   => 'As listed above, you will need to provide data on your activity’s transactions, which shows how the activity is being financed and how the finance is being used. ',
            'two'   => 'There are specific types of information that you can either publish about your entire activity, or about individual transactions (each transaction represents money flowing in or out of the activity). For example, you can publish data on which country/region your entire activity is benefitting, or you can publish data on which country/region each transaction is benefitting. However you must not publish this information at both activity and transaction levels. ',
            'three' => 'IATI Publisher provides explanations for each element of the IATI Standard and tells you where you have a choice of which level to publish data for. ',
            'four'  => 'Publish your Organisation Data',
        ],

        'download_pdf_header'      => 'Download PDF of IATI Standard data fields',
        'download_pdf_description' => [
            'one'   => 'IATI Standard Whilst gathering and preparing your organisation’s IATI data, you may find it helpful to view the following spreadsheets that provide information on all of the data elements in the IATI Standard. You will also be able to view this information as you work your way through completing the forms for each element on IATI Publisher.',
            'two'   => 'Activity Standard',
            'three' => 'Organisation Standard'
        ],

        'iati_standard_reference_header'      => 'IATI Standard reference',
        'iati_standard_reference_description' => [
            'one'   => "You can look up detailed and technical information about each element of the IATI Standard on the IATI Reference section of IATI’s main website: ",
            'two'   => "Activity Standard",
            'three' => "organisation Standard"
        ]

    ],

    /*----------------------------------------------------------------support page--------------------------------------------------------------------------------------------------*/
    'support_page'              => [
        'support'             => 'Support',
        'support_description' => [
            'one' => 'If your organisation needs support to use IATI Publisher or has questions about what data to publish please contact IATI’s Helpdesk: <a target="_blank" rel="noopener noreferrer" href="mailto:support@iatistandard.org">support@iatistandard.org.</a>',
            'two' => 'You may also join IATI’s online community at <a target="_blank" rel="noopener noreferrer" href="https://iaticonnect.org/"> IATI Connect </a> , where you can post messages about IATI publishing in the <a target="_blank" rel="noopener noreferrer" href="https://iaticonnect.org/data-publishing-cop/about">Data Publishing Community of Practice.</a>'
        ]
    ],

    /*----------------------------------------------------------------password recovery page--------------------------------------------------------------------------------------------------*/
    'password_recovery_page'    => [
        'password_recovery_header'            => "Password Recovery",
        'password_recovery_description'       => "Please enter your email, we will send you a link to reset your password",
        'email_label'                         => "Email",
        'email_placeholder'                   => "Enter your email address",
        'uc_send_password_reset_label'        => "SEND PASSWORD RESET LINK",
        'your_email_has_been_sent_with_label' => "An email has been sent with further instructions, please check it out when you get it."
    ]

    /*----------------------------------------------------------------password recovery page--------------------------------------------------------------------------------------------------*/
];


