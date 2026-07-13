<?php

class AddonsWpHeadlessTest extends \WP_UnitTestCase
{
    protected $oldCookies;

    public function set_up()
    {
        parent::set_up();

        $this->oldCookies = $_COOKIE;
    }

    public function tear_down()
    {
        parent::tear_down();

        $_COOKIE = $this->oldCookies;
    }

    public function testHomepageIsRestricted()
    {
        $this->expectException(\WPDieException::class);

        $this->go_to('/');
    }

    public function testWpDieParameters()
    {
        try {
            $this->go_to('/');
            $this->fail('an exception is expected');
        } catch (\Exception $e) {
            $dieError = $e->getTrace()[0];
            // See: https://developer.wordpress.org/reference/functions/wp_die/
            $this->assertEquals(
                $dieError['args'][0],
                'Access is restricted, sorry.'
            );
            $this->assertEquals($dieError['args'][1], ''); // title, not set
            $this->assertEquals($dieError['args'][2]['response'], 401);
        }
    }

    public function testAuthenticatedUsersAreNotRestricted()
    {
        $adminId = $this->factory->user->create();
        wp_set_current_user($adminId);

        $this->go_to('/');

        // Not restricted => the request proceeded and resolved to the homepage.
        $this->assertTrue(is_home());
    }

    public function testAdminsAreNotRestricted()
    {
        $adminId = $this->factory->user->create(['role' => 'administrator']);
        wp_set_current_user($adminId);

        $this->go_to('/');

        // Not restricted => the request proceeded and resolved to the homepage.
        $this->assertTrue(is_home());
    }

    public function testAuth0CallbackIsAllowed()
    {
        $_COOKIE['auth0_state'] = 'some auth0 state';

        $this->go_to('/index.php?auth0=1&code=xyz');

        // Not restricted => the request proceeded and resolved to the homepage.
        $this->assertTrue(is_home());
    }

    public function testAuth0CallbackIsRestrictedWhenThereIsNoCookie()
    {
        $this->expectException(\WPDieException::class);

        $this->go_to('/index.php?auth0=1&code=xyz');
    }
}
