<?php

namespace Tests\Feature\PageLoad;

use Tests\TestCase;

class GuestPageLoadTest extends TestCase
{
    /**
     * Guest Page Load test.
     *
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
            ['web.'],
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
