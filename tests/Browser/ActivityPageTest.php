<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ActivityPageTest extends DuskTestCase
{
//    use DatabaseMigrations;

    /**
     * Checks if activity pages loads.
     *
     * @throws \Throwable
     * @test
     * @dataProvider activityUrl
     */
//    public function check_activity_page_load($route, $text, $params = null): void
//    {
//        $this->signIn();
//        $this->browse(function (Browser $browser) use ($route, $text) {
//            $browser->visitRoute($route)
//                    ->assertSee($text);
//        });
//    }

    /**
     * List of activity urls.
     *
     * @return array
     */
    public function activityUrl(): array
    {
        return [
            ['admin.activities.index', 'Your Activities'],
        ];
    }

    /**
     * Checks page load for activity detail pages.
     *
     * @return void
     * @test
     * @dataProvider activity_detail_url
     * @throws \Throwable
     */
//    public function check_activity_detail_page_load($route, $text = null): void
//    {
//        $this->signIn();
//        $activity = $this->createActivity();
//        $this->browse(function (Browser $browser) use ($route, $text, $activity) {
//            $browser->visitRoute($route,['id' => $activity->id])
//                ->assertSee($text ?? $activity->title[0]['narrative'])
//                ->assertSee($activity->title[0]['narrative']);
//        });
//    }

    /**
     * Returns Activity Detail url with text for assertSee.
     *
     * @return array
     */
    public function activity_detail_url(): array
    {
        return [
            ['admin.activity.show'],
            ['admin.activity.title.edit', 'title'],
            ['admin.activity.status.edit', 'activity-status'],
            ['admin.activity.scope.edit', 'activity-scope'],
            ['admin.activity.default-flow-type.edit', 'default-flow-type'],
            ['admin.activity.default-finance-type.edit', 'default-finance-type'],
            ['admin.activity.default-aid-type.edit', 'default-aid-type'],
            ['admin.activity.default-tied-status.edit', 'default-tied-status'],
            ['admin.activity.collaboration-type.edit', 'collaboration-type'],
            ['admin.activity.capital-spend.edit', 'capital-spend'],
            ['admin.activity.related-activity.edit', 'related-activity'],
            ['admin.activity.legacy-data.edit', 'legacy-data'],
            ['admin.activity.description.edit', 'description'],
            ['admin.activity.date.edit', 'activity-date'],
            ['admin.activity.recipient-country.edit', 'recipient-country'],
            ['admin.activity.humanitarian-scope.edit', 'humanitarian-scope'],
            ['admin.activity.sector.edit', 'sector'],
            ['admin.activity.conditions.edit', 'conditions'],
            ['admin.activity.country-budget-items.edit', 'country-budget-items'],
            ['admin.activity.policy-marker.edit', 'policy-marker'],
            ['admin.activity.recipient-region.edit', 'recipient-region'],
            ['admin.activity.tag.edit', 'tag'],
            ['admin.activity.other-identifier.edit', 'other-identifier'],
            ['admin.activity.identifier.edit', 'identifier'],
            ['admin.activity.document-link.edit', 'document-link'],
            ['admin.activity.contact-info.edit', 'contact-info'],
            ['admin.activity.location.edit', 'location'],
            ['admin.activity.participating-org.edit', 'participating-org'],
            ['admin.activity.planned-disbursement.edit', 'planned-disbursement'],
            ['admin.activity.budget.edit', 'budget'],
            ['admin.activity.reporting-org.edit', 'reporting-org'],
        ];
    }
}
