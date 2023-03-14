<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AuthController;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    /**
     * A test to check if the login page is reachable.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get(route('author.login'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.auth.login');
    }

    /**
     * A test to check if the forgot password page is reachable.
     *
     * @return void
     */
    public function testForgotPasswordPage()
    {
        $response = $this->get(route('author.forgot-password'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.auth.forgot');
    }

    /**
     * A test to check if the reset password form is reachable.
     *
     * @return void
     */
    public function testResetPasswordForm()
    {
        $response = $this->get(route('author.reset-form', 'token'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.auth.reset-form');
    }

    /**
     * A test to check if the home page is reachable.
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.home'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.home');
    }

    /**
     * A test to check if the profile page is reachable.
     *
     * @return void
     */
    public function testProfilePage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.profile'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.profile');
    }

    /**
     * A test to check if the settings page is reachable.
     *
     * @return void
     */
    public function testSettingsPage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.settings'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.settings');
    }

    /**
     * A test to check if the authors page is reachable.
     *
     * @return void
     */
    public function testAuthorsPage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.authors'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.authors');
    }

    /**
     * A test to check if the categories page is reachable.
     *
     * @return void
     */
    public function testCategoriesPage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.categories'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.categories');
    }

    /**
     * A test to check if the add post page is reachable.
     *
     * @return void
     */
    public function testAddPostPage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.posts.add-post'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.add-post');
    }

    /**
     * A test to check if the all posts page is reachable.
     *
     * @return void
     */
    public function testAllPostsPage()
    {
        $response = $this->actingAs(User::factory()->create())
                         ->get(route('author.posts.all-posts'));

        $response->assertSuccessful();
        $response->assertViewIs('back.pages.all-posts');
    }
}
