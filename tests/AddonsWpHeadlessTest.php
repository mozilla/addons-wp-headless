<?php

class AddonsWpHeadlessTest extends \WP_UnitTestCase
{
    protected $oldCookies;

    public function setUp()
    {
        parent::setUp();

        $this->oldCookies = $_COOKIE;
    }

    public function tearDown()
    {
        parent::tearDown();

        $_COOKIE = $this->oldCookies;
    }

    public function testHomepageIsRestricted()
    {
        $this->expectException(\WPDieException::class);

        $this->go_to('/');
    }

    public function testAuthenticatedUsersAreNotRestricted()
    {
        $adminId = $this->factory->user->create();
        wp_set_current_user($adminId);

        $this->go_to('/');
    }

    public function testAdminsAreNotRestricted()
    {
        $adminId = $this->factory->user->create(['role' => 'administrator']);
        wp_set_current_user($adminId);

        $this->go_to('/');
    }

    public function testAuth0CallbackIsAllowed()
    {
        $_COOKIE['auth0_state'] = 'some auth0 state';

        $this->go_to('/index.php?auth0=1&code=xyz');
    }

    public function testAuth0CallbackIsRestrictedWhenThereIsNoCookie()
    {
        $this->expectException(\WPDieException::class);

        $this->go_to('/index.php?auth0=1&code=xyz');
    }
}
