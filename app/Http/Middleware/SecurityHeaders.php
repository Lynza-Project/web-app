<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get current environment
        $environment = app()->environment();
        $envConfig = config("security.environments.{$environment}", config('security.environments.production'));

        // Add HSTS header
        if ($envConfig['strict_transport_security'] && $request->isSecure()) {
            $this->addHstsHeader($response);
        }

        // Add Content Security Policy
        $this->addCspHeader($response, $envConfig['csp_report_only']);

        // Add other security headers
        $this->addSecurityHeaders($response);

        return $response;
    }

    /**
     * Add HTTP Strict Transport Security header
     */
    private function addHstsHeader(Response $response): void
    {
        $hstsConfig = config('security.hsts');
        $hstsValue = "max-age={$hstsConfig['max_age']}";

        if ($hstsConfig['include_subdomains']) {
            $hstsValue .= '; includeSubDomains';
        }

        if ($hstsConfig['preload']) {
            $hstsValue .= '; preload';
        }

        $response->headers->set('Strict-Transport-Security', $hstsValue);
    }

    /**
     * Add Content Security Policy header
     */
    private function addCspHeader(Response $response, bool $reportOnly = false): void
    {
        $cspConfig = config('security.csp');
        $cspDirectives = [];

        // Generate nonce for scripts
        $nonce = $this->generateNonce();
        $response->headers->set('X-CSP-Nonce', $nonce);

        foreach ($cspConfig as $directive => $sources) {
            if ($directive === 'upgrade-insecure-requests') {
                if ($sources) {
                    $cspDirectives[] = 'upgrade-insecure-requests';
                }
                continue;
            }

            if (is_array($sources)) {
                // Filter out null values
                $sources = array_filter($sources, function ($source) {
                    return $source !== null;
                });

                if (!empty($sources)) {
                    // Add nonce to script-src
                    if ($directive === 'script-src') {
                        $sources[] = "'nonce-{$nonce}'";
                    }

                    $cspDirectives[] = $directive . ' ' . implode(' ', $sources);
                }
            }
        }

        // Add report-uri if configured
        $reportUri = config('security.csp_report_uri');
        if ($reportUri) {
            $cspDirectives[] = "report-uri {$reportUri}";
        }

        $cspValue = implode('; ', $cspDirectives);
        $headerName = $reportOnly ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';

        $response->headers->set($headerName, $cspValue);
    }

    /**
     * Add other security headers
     */
    private function addSecurityHeaders(Response $response): void
    {
        // X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', config('security.content_type_options'));

        // X-Frame-Options
        $response->headers->set('X-Frame-Options', config('security.frame_options'));

        // Referrer-Policy
        $response->headers->set('Referrer-Policy', config('security.referrer_policy'));

        // Permissions-Policy
        $this->addPermissionsPolicyHeader($response);

        // X-Permitted-Cross-Domain-Policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', config('security.cross_domain_policies'));

        // Additional headers
        $additionalHeaders = config('security.additional_headers', []);
        foreach ($additionalHeaders as $name => $value) {
            $response->headers->set($name, $value);
        }
    }

    /**
     * Add Permissions Policy header
     */
    private function addPermissionsPolicyHeader(Response $response): void
    {
        $permissionsConfig = config('security.permissions_policy', []);
        $policies = [];

        foreach ($permissionsConfig as $feature => $allowlist) {
            if (empty($allowlist)) {
                $policies[] = "{$feature}=()";
            } else {
                $allowlistStr = implode(' ', array_map(function ($origin) {
                    return "\"{$origin}\"";
                }, $allowlist));
                $policies[] = "{$feature}=({$allowlistStr})";
            }
        }

        if (!empty($policies)) {
            $response->headers->set('Permissions-Policy', implode(', ', $policies));
        }
    }

    /**
     * Generate a cryptographically secure nonce
     */
    private function generateNonce(): string
    {
        return base64_encode(random_bytes(16));
    }

    /**
     * Get the nonce for use in views
     */
    public static function getNonce(): string
    {
        return request()->header('X-CSP-Nonce', '');
    }
}
