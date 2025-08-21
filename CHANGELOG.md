# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.2.0] - 2025-08-21
### Improvements
- Implemented security middleware (OWASP) with HSTS and CSP configuration ([#24]).
- Accessibility enhancements (RGAA) ([#25]).


## [1.1.0] - 2025-08-19
### Added
- Support contact form for users to directly reach the support team.

## [1.0.0] - 2025-08-19
### Added
- Full set of **legal pages**: Terms of use, Privacy policy, Legal mentions.
- **Ticket management system**: create, edit and manage tickets with integrated messaging.
- **User impersonation**: admins can log in as another user to provide support.
- **S3 storage integration** for images (actualities, events, documentation).
- **Dashboard modules**: actualities, events and weather widget (configured for Lyon).
- **Dark mode** and various design improvements.
- **Database seeders**: organizations, themes, events, tickets and `CoolSeeder` for demo data.
### Changed
- Logo replaced with an image asset for better layout consistency.
- Dashboard layout cleaned up (removed placeholders).
- SQLite committed for testing and PHPUnit configuration updated.

## [0.0.6] - 2025-07-29
### Added
- Legal pages for terms of use, privacy policy and legal mentions.
- Logo replaced by an image asset for layout consistency.
- S3 storage integration for actuality, event and documentation images.
- Ticket management system with create, edit and message features.
- User impersonation functionality.
- `CoolSeeder` to populate the database with sample data.
### Changed
- Removed placeholder section from the dashboard layout.
- Weather component updated to show Lyon.
- Committed SQLite database used for tests and updated PHPUnit configuration.

## [0.0.5] - 2025-07-20
### Added
- Initial ticketing features with Livewire components.
- User impersonation routes and interface.
- Database seeder for organizations, themes, events and tickets.
### Changed
- Logo assets updated and layout adjustments for S3 storage.

## [0.0.2] - 2025-06-07
### Added
- Dark mode styles and various design updates.
- Dashboard widgets for actualities, events and weather.

## [0.0.1] - 2025-03-09
### Added
- Initial release with authentication, user management and basic dashboard.
