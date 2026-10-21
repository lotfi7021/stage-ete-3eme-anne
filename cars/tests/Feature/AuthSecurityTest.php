<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    /**
     * Tests non destructifs : aucune écriture en base de données.
     * Les seuls effets de bord sont les entrées de journalisation des
     * échecs de connexion (comportement normal de l'application) et
     * les compteurs du RateLimiter (cache en mémoire, isolé par test).
     */

    public function test_login_page_is_accessible_with_selectcars_title(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('Connectez-vous pour démarrer votre session');
        $response->assertSee('Connexion - SelectCars');
    }

    public function test_home_page_shows_selectcars_title(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Accueil - SelectCars');
    }

    public function test_guest_is_redirected_to_login_from_protected_pages(): void
    {
        foreach (['/admin/list_machine', '/client/list_machine', '/admin/dashboardL', '/admin/list_commandeM'] as $url) {
            $this->get($url)->assertRedirect('/admin');
        }
    }

    public function test_csrf_middleware_is_registered_in_web_group(): void
    {
        // Laravel contourne la vérification CSRF pendant les tests unitaires
        // (runningUnitTests), on vérifie donc ici que le middleware reste
        // bien enregistré dans le groupe web.
        $this->assertContains(
            \App\Http\Middleware\VerifyCsrfToken::class,
            $this->app->make(\Illuminate\Contracts\Http\Kernel::class)->getMiddlewareGroups()['web']
        );
    }

    public function test_failed_login_shows_generic_message_and_never_echoes_password(): void
    {
        $password = 'MotDePasseTest!123';

        $response = $this->from('/admin')->post('/admin/login-functionality', [
            '_token' => $this->csrfToken(),
            'login' => 'test_inexistant',
            'password' => $password,
        ]);

        $response->assertRedirect('/admin');
        $response->assertSessionHas('error-message', 'Login ou mot de passe incorrect.');
        $response->assertDontSee($password);
    }

    public function test_login_attempts_are_throttled_after_five_failures(): void
    {
        $token = $this->csrfToken();

        for ($i = 1; $i <= 5; $i++) {
            $this->from('/admin')->post('/admin/login-functionality', [
                '_token' => $token,
                'login' => 'test_throttle_inexistant',
                'password' => 'MotDePasseTest!123',
            ])->assertRedirect('/admin');
        }

        $response = $this->from('/admin')->post('/admin/login-functionality', [
            '_token' => $token,
            'login' => 'test_throttle_inexistant',
            'password' => 'MotDePasseTest!123',
        ]);

        $response->assertRedirect('/admin');
        $response->assertSessionHasErrors('login');
    }

    private function csrfToken(): string
    {
        $page = $this->get('/admin');
        preg_match('/name="_token" value="([^"]+)"/', $page->getContent(), $matches);

        return $matches[1];
    }
}
