<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class MigrateOrganizationTrait.
 */
trait MigrateOrganizationActivityTrait
{
    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $contactInfoReplaceArray = ['organization' => 'organisation'];

    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $participatingOrgReplaceArray
        = [
            'identifier'        => 'ref',
            'activity_id'       => 'identifier',
            'organization_type' => 'type',
        ];

    /**
     * Contains values to be removed.
     *
     * @var array
     */
    protected array $participatingOrgRemoveArray = ['country', 'org_data_id', 'Crs Channel Code', 'is_publisher'];

    /**
     * Contains key value pair to be replaced for each vocabulary.
     *
     * @var array
     */
    protected array $recipientRegionReplaceArray
        = [
            '2'  => [
                'region_code_input' => 'custom_code',
            ],
            '99' => [
                'region_code_input' => 'custom_code',
            ],
        ];

    /**
     * Contains values to be removed for each vocabulary.
     *
     * @var array
     */
    protected array $recipientRegionRemoveArray
        = [
            '1'  => ['custom_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri'],
            '2'  => ['region_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri'],
            '99' => ['region_code', 'region_code_input', 'custom_vocabulary_uri'],
        ];

    /**
     * Contains key value pair to be replaced for particular vocabulary.
     *
     * @var array
     */
    protected array $sectorReplaceArray
        = [
            '1'  => [
                'sector_code' => 'code',
            ],
            '2'  => [
                'sector_category_code' => 'category_code',
            ],
            '3'  => [
                'sector_text' => 'text',
            ],
            '4'  => [
                'sector_text' => 'text',
            ],
            '5'  => [
                'sector_text' => 'text',
            ],
            '6'  => [
                'sector_text' => 'text',
            ],
            '7'  => [
                'sector_sdg_goal' => 'sdg_goal',
            ],
            '8'  => [
                'sector_sdg_target' => 'sdg_target',
            ],
            '9'  => [
                'sector_text' => 'text',
            ],
            '10' => [
                'sector_text' => 'text',
            ],
            '99' => [
                'sector_text' => 'text',
            ],
            '98' => [
                'sector_text' => 'text',
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $sectorRemoveArray
        = [
            '1'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '2'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '3'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '4'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '5'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '6'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '7'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '8'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '9'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '10' => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '99' => [
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '98' => [
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
        ];

    /**
     * Empty budget item template.
     *
     * @var array
     */
    protected array $emptyBudgetItemTemplate
        = [
            [
                'code'        => null,
                'percentage'  => null,
                'description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => null,
                                'language'  => null,
                            ],
                        ],
                    ],
                ],
            ],
        ];

    /**
     * Empty location administrative template.
     *
     * @var array
     */
    protected array $locationAdministrativeEmptyTemplate
        = [
            [
                'vocabulary' => null,
                'code'       => null,
                'level'      => null,
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $humanitarianScopeRemoveArray
        = [
            '1-2' => ['vocabulary_uri', 'custom_vocabulary_uri', 'custom_code'],
            '2-1' => ['vocabulary_uri', 'custom_vocabulary_uri', 'custom_code'],
            '99'  => ['custom_vocabulary_uri', 'custom_code'],
        ];
}
