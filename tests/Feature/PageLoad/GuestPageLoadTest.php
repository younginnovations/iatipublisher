<?php

declare(strict_types=1);

namespace Tests\Feature\PageLoad;

use Tests\TestCase;

/**
 * Class GuestPageLoadTest.
 */
class GuestPageLoadTest extends TestCase
{
    /**
     * Guest Page Load test.
     *
     * @param $route
     * @param null $params
     * @return void
     * @test
     * @dataProvider guestUrl
     */
    public function check_page_loads_before_login($route, $params = null): void
    {
        $response = $this->get(route($route, $params));
        $response->assertStatus(200);
    }

    /**
     * List of guest urls.
     *
     * @return array
     */
    public function guestUrl(): array
    {
        return [
            ['web.index.index'],
            ['web.index.login'],
            ['web.join', ['page' => 'random-page']],
            ['web.register'],
            ['web.password.email'],
            ['web.password.confirm'],
            ['web.iati.register'],
            ['about'],
            ['publishingchecklist'],
            ['iatistandard'],
            ['support'],
        ];
    }
}
