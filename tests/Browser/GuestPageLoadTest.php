<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestPageLoadTest extends DuskTestCase
{
    /**
     * All Pages Load Test Before login.
     *
     * @test
     * @throws \Throwable
     * @dataProvider guestUrl
     */
//    public function check_page_loads_before_login($route, $text, $param = null): void
//    {
//        $this->browse(function (Browser $browser) use ($route, $text, $param) {
//            $browser->visitRoute($route, $param)
//                    ->waitForText($text)
//                    ->assertSee($text);
//        });
//    }

    /**
     * List of guest urls.
     *
     * @return array
     */
    public function guestUrl(): array
    {
        return [
            ['web.', 'Sign In.'],
            ['web.index.login', 'Sign In.'],
            ['web.join', 'Join Now.', ['page' => 'random-page']],
            ['web.register', 'Create IATI Publisher Account'],
            ['web.password.email', 'Password Recovery'],
            ['web.password.confirm', 'Password Recovery'],
            ['web.iati.register', 'Create IATI Publisher Account and IATI Registry Account'],
            ['about', 'What is IATI Publisher?'],
            ['publishingchecklist', 'Organisations using IATI Publisher need to take the following steps to publish your data:'],
            ['iatistandard', 'IATI Standard'],
            ['support', 'Support'],
        ];
    }
}
