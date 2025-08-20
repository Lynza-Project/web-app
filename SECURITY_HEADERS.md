# Security Headers Implementation

This document describes the security headers middleware implementation for the Laravel application.

## Overview

The security headers middleware provides comprehensive HTTP security headers including:
- **HSTS** (HTTP Strict Transport Security)
- **CSP** (Content Security Policy) with Vite and Livewire compatibility
- **X-Content-Type-Options**
- **X-Frame-Options**
- **Referrer-Policy**
- **Permissions-Policy**
- Additional security headers

## Files Created/Modified

### Configuration
- `config/security.php` - Main security configuration file
- `bootstrap/app.php` - Middleware registration

### Middleware
- `app/Http/Middleware/SecurityHeaders.php` - Main security headers middleware

### Tests
- `tests/Feature/Http/Middleware/SecurityHeadersTest.php` - Comprehensive test suite

### Components
- `resources/views/components/csp-nonce.blade.php` - Blade component for CSP nonces

## Environment Configuration

### Local Environment
- CSP in **Report-Only** mode
- HSTS disabled
- Vite dev server URLs included in CSP

### Staging Environment
- CSP in **Report-Only** mode
- HSTS enabled
- Production-like security headers

### Production Environment
- CSP in **Strict** mode
- HSTS enabled
- Full security headers enforcement

## CSP Configuration

The Content Security Policy is configured to be compatible with:

### Vite
- Local development server (`http://localhost:5173`)
- WebSocket connections (`ws://localhost:5173`)
- Asset compilation and hot reloading

### Livewire
- AJAX endpoints via `connect-src`
- App URL included for Livewire requests
- Compatible with Livewire's JavaScript

### Storage
- Cloudflare R2 storage URLs
- Exact host matching for security

### Reverb (WebSocket)
- WebSocket connections for real-time features
- Environment-based configuration

## Usage Examples

### Using CSP Nonces in Blade Templates

```blade
{{-- Using the CSP nonce component for scripts --}}
<x-csp-nonce>
    console.log('This script has a CSP nonce');
</x-csp-nonce>

{{-- Using the CSP nonce component for styles --}}
<x-csp-nonce tag="style">
    .custom-style { color: red; }
</x-csp-nonce>

{{-- Manual nonce usage --}}
@php
    $nonce = \App\Http\Middleware\SecurityHeaders::getNonce();
@endphp
<script nonce="{{ $nonce }}">
    // Your JavaScript code here
</script>
```

### Vite Integration

The CSP automatically includes Vite development server URLs in local environment:
- `http://localhost:5173` for assets
- `ws://localhost:5173` for WebSocket connections

### Livewire Integration

Livewire endpoints are automatically included in the CSP:
- App URL for AJAX requests
- No additional configuration needed

## Security Headers Applied

### HSTS (Production/Staging)
```
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
```

### CSP (Example)
```
Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-ABC123'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob: https://storage.example.com; connect-src 'self' http://localhost ws://localhost:8080; frame-src 'none'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'
```

### Other Headers
```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()
X-XSS-Protection: 1; mode=block
X-Download-Options: noopen
X-DNS-Prefetch-Control: off
```

## Testing

Run the security headers tests:

```bash
php artisan test tests/Feature/Http/Middleware/SecurityHeadersTest.php
```

The test suite validates:
- Presence of all security headers
- CSP directive content
- Nonce generation and uniqueness
- Environment-specific behavior
- Vite and Livewire compatibility

## Configuration Customization

Edit `config/security.php` to customize:
- CSP directives and sources
- HSTS settings
- Permissions Policy features
- Environment-specific behavior
- Storage URLs
- Additional headers

## Troubleshooting

### CSP Violations
- Check browser console for CSP violation reports
- Use Report-Only mode in staging to identify issues
- Add necessary sources to CSP configuration

### Vite Issues
- Ensure Vite dev server URLs are included in local environment
- Check that nonces are properly applied to Vite-generated scripts

### Livewire Issues
- Verify app URL is included in connect-src
- Ensure Livewire endpoints are accessible

## Security Considerations

1. **Nonce Security**: Nonces are cryptographically secure and unique per request
2. **Storage URLs**: Use exact host matching, avoid wildcards
3. **Environment Separation**: Different policies for different environments
4. **Regular Updates**: Review and update CSP sources as needed
5. **Monitoring**: Monitor CSP violation reports in production
