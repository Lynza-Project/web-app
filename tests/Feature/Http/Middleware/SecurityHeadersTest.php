<?php

namespace Tests\Feature\Http\Middleware;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    /**
     * Test that security headers are applied to web routes
     */
    public function test_security_headers_are_applied_to_web_routes(): void
    {
        $response = $this->get('/');

        // Test X-Content-Type-Options
        $response->assertHeader('X-Content-Type-Options', 'nosniff');

        // Test X-Frame-Options
        $response->assertHeader('X-Frame-Options', 'DENY');

        // Test Referrer-Policy
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Test X-Permitted-Cross-Domain-Policies
        $response->assertHeader('X-Permitted-Cross-Domain-Policies', 'none');

        // Test additional headers
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('X-Download-Options', 'noopen');
        $response->assertHeader('X-DNS-Prefetch-Control', 'off');
    }

    /**
     * Test Content Security Policy header is present
     */
    public function test_content_security_policy_header_is_present(): void
    {
        $response = $this->get('/');

        // In local environment, CSP should be in report-only mode
        if (app()->environment('local')) {
            $this->assertTrue($response->headers->has('Content-Security-Policy-Report-Only'));
        } else {
            $this->assertTrue($response->headers->has('Content-Security-Policy'));
        }
    }

    /**
     * Test CSP contains required directives
     */
    public function test_csp_contains_required_directives(): void
    {
        $response = $this->get('/');

        $cspHeader = app()->environment('local')
            ? $response->headers->get('Content-Security-Policy-Report-Only')
            : $response->headers->get('Content-Security-Policy');

        $this->assertNotNull($cspHeader);

        // Test that CSP contains essential directives
        $this->assertStringContainsString("default-src 'self'", $cspHeader);
        $this->assertStringContainsString("script-src", $cspHeader);
        $this->assertStringContainsString("style-src", $cspHeader);
        $this->assertStringContainsString("img-src", $cspHeader);
        $this->assertStringContainsString("connect-src", $cspHeader);
        $this->assertStringContainsString("frame-src 'none'", $cspHeader);
        $this->assertStringContainsString("object-src 'none'", $cspHeader);
        $this->assertStringContainsString("base-uri 'self'", $cspHeader);
        $this->assertStringContainsString("form-action 'self'", $cspHeader);
        $this->assertStringContainsString("frame-ancestors 'none'", $cspHeader);
    }

    /**
     * Test CSP includes nonce for scripts
     */
    public function test_csp_includes_nonce_for_scripts(): void
    {
        $response = $this->get('/');

        $cspHeader = app()->environment('local')
            ? $response->headers->get('Content-Security-Policy-Report-Only')
            : $response->headers->get('Content-Security-Policy');

        $this->assertNotNull($cspHeader);
        $this->assertStringContainsString("'nonce-", $cspHeader);

        // Test that nonce header is set
        $this->assertTrue($response->headers->has('X-CSP-Nonce'));
        $nonce = $response->headers->get('X-CSP-Nonce');
        $this->assertNotEmpty($nonce);
        $this->assertStringContainsString("'nonce-{$nonce}'", $cspHeader);
    }

    /**
     * Test CSP includes Cloudflare R2 storage URLs
     */
    public function test_csp_includes_storage_urls(): void
    {
        $response = $this->get('/');

        $cspHeader = app()->environment('local')
            ? $response->headers->get('Content-Security-Policy-Report-Only')
            : $response->headers->get('Content-Security-Policy');

        $this->assertNotNull($cspHeader);

        // Test that CSP includes Cloudflare R2 URLs
        $this->assertStringContainsString('https://fls-9f7b5f3d-44c0-4ed9-aa5f-91509293c572.laravel.cloud', $cspHeader);
        $this->assertStringContainsString('https://367be3a2035528943240074d0096e0cd.r2.cloudflarestorage.com', $cspHeader);
    }

    /**
     * Test CSP includes Livewire and Reverb endpoints
     */
    public function test_csp_includes_livewire_endpoints(): void
    {
        $response = $this->get('/');

        $cspHeader = app()->environment('local')
            ? $response->headers->get('Content-Security-Policy-Report-Only')
            : $response->headers->get('Content-Security-Policy');

        $this->assertNotNull($cspHeader);

        // Test that CSP includes app URL for Livewire
        $appUrl = config('app.url', 'http://localhost');
        $this->assertStringContainsString($appUrl, $cspHeader);

        // Test that CSP includes Reverb WebSocket URL
        $reverbUrl = config('reverb.connections.reverb.scheme', 'http') . '://' .
                    config('reverb.connections.reverb.host', 'localhost') . ':' .
                    config('reverb.connections.reverb.port', '8080');
        $this->assertStringContainsString($reverbUrl, $cspHeader);
    }

    /**
     * Test Permissions Policy header
     */
    public function test_permissions_policy_header(): void
    {
        $response = $this->get('/');

        $this->assertTrue($response->headers->has('Permissions-Policy'));
        $permissionsPolicy = $response->headers->get('Permissions-Policy');

        // Test that dangerous permissions are disabled
        $this->assertStringContainsString('camera=()', $permissionsPolicy);
        $this->assertStringContainsString('microphone=()', $permissionsPolicy);
        $this->assertStringContainsString('geolocation=()', $permissionsPolicy);
        $this->assertStringContainsString('interest-cohort=()', $permissionsPolicy);
        $this->assertStringContainsString('payment=()', $permissionsPolicy);
        $this->assertStringContainsString('usb=()', $permissionsPolicy);
        $this->assertStringContainsString('vr=()', $permissionsPolicy);
        $this->assertStringContainsString('xr-spatial-tracking=()', $permissionsPolicy);
    }

    /**
     * Test HSTS header is not present in local environment
     */
    public function test_hsts_header_not_present_in_local(): void
    {
        if (app()->environment('local')) {
            $response = $this->get('/');
            $this->assertFalse($response->headers->has('Strict-Transport-Security'));
        } else {
            $this->markTestSkipped('This test only runs in local environment');
        }
    }

    /**
     * Test HSTS header format when present
     */
    public function test_hsts_header_format_when_present(): void
    {
        // Mock HTTPS request for testing HSTS
        $request = Request::create('https://example.com', 'GET');
        $request->server->set('HTTPS', 'on');
        $request->server->set('SERVER_PORT', 443);

        $middleware = new SecurityHeaders();
        $response = new Response();

        // Temporarily change environment to production for this test
        $originalEnv = app()->environment();
        app()->detectEnvironment(function () {
            return 'production';
        });

        $result = $middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Restore original environment
        app()->detectEnvironment(function () use ($originalEnv) {
            return $originalEnv;
        });

        if ($result->headers->has('Strict-Transport-Security')) {
            $hstsHeader = $result->headers->get('Strict-Transport-Security');
            $this->assertStringContainsString('max-age=31536000', $hstsHeader);
            $this->assertStringContainsString('includeSubDomains', $hstsHeader);
            $this->assertStringContainsString('preload', $hstsHeader);
        }
    }

    /**
     * Test that nonce is different on each request
     */
    public function test_nonce_is_different_on_each_request(): void
    {
        $response1 = $this->get('/');
        $response2 = $this->get('/');

        $nonce1 = $response1->headers->get('X-CSP-Nonce');
        $nonce2 = $response2->headers->get('X-CSP-Nonce');

        $this->assertNotEquals($nonce1, $nonce2);
        $this->assertNotEmpty($nonce1);
        $this->assertNotEmpty($nonce2);
    }

    /**
     * Test CSP in local environment includes Vite dev server
     */
    public function test_csp_includes_vite_dev_server_in_local(): void
    {
        if (app()->environment('local')) {
            $response = $this->get('/');

            $cspHeader = $response->headers->get('Content-Security-Policy-Report-Only');
            $this->assertNotNull($cspHeader);

            // Test that CSP includes Vite dev server URLs
            $this->assertStringContainsString('http://localhost:5173', $cspHeader);
            $this->assertStringContainsString('ws://localhost:5173', $cspHeader);
        } else {
            $this->markTestSkipped('This test only runs in local environment');
        }
    }
}
