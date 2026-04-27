# Laravel DDD Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rabnawazak1/laravel-ddd-generator.svg?style=flat-square)](https://packagist.org/packages/rabnawazak1/laravel-ddd-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/rabnawazak1/laravel-ddd-generator.svg?style=flat-square)](https://packagist.org/packages/rabnawazak1/laravel-ddd-generator)
[![License](https://img.shields.io/packagist/l/rabnawazak1/laravel-ddd-generator.svg?style=flat-square)](LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/rabnawazak1/laravel-ddd-generator.svg?style=flat-square)](composer.json)

A Laravel Artisan command to scaffold **Domain-Driven Design (DDD)** module structure instantly — complete with Actions, Controller, Requests, Service, Repository, Model, and DTO stubs.

---

## Why DDD?

Domain-Driven Design keeps large Laravel applications maintainable by grouping all files related to a domain feature together, rather than scattering them across `app/Http/Controllers`, `app/Models`, etc. This package gives you that structure with a single command.

---

## Generated Structure

Running `php artisan make:domain Hospital Patient` produces:

```
app/
└── Domains/
    └── Hospital/
        └── Patient/
            ├── Actions/
            │   ├── Create.php
            │   ├── Update.php
            │   ├── Delete.php
            │   ├── ChangeStatus.php
            │   └── Search.php
            ├── Controllers/
            │   └── PatientController.php
            ├── Requests/
            │   ├── StorePatientRequest.php
            │   ├── UpdatePatientRequest.php
            │   └── ChangePatientStatusRequest.php
            ├── Services/
            │   └── PatientService.php
            ├── Repositories/
            │   └── PatientRepository.php
            ├── Models/
            │   └── Patient.php
            └── DTO/
                └── PatientData.php
```

Every file is generated with a namespace-correct stub and `TODO` markers to guide your implementation.

---

## Requirements

| Dependency | Version |
|---|---|
| PHP | ^8.5 |
| Laravel | 10.x / 11.x / 12.x / 13.x |

---

## Installation

Install via Composer:

```bash
composer require rabnawazak1/laravel-ddd-generator --dev
```

> The `--dev` flag is recommended since this is a development scaffolding tool. The package is auto-discovered by Laravel — no manual provider registration needed.

---

## Usage

```bash
php artisan make:domain {Domain} {Module}
```

### Examples

```bash
# Hospital Management System
php artisan make:domain Hospital Patient
php artisan make:domain Hospital Doctor
php artisan make:domain Hospital Appointment

# E-commerce
php artisan make:domain Shop Product
php artisan make:domain Shop Order
php artisan make:domain Shop Invoice

# Multi-word inputs use StudlyCase automatically
php artisan make:domain HumanResources LeaveRequest
```

**Arguments:**

| Argument | Description | Example |
|---|---|---|
| `domain` | The top-level domain group | `Hospital`, `Shop`, `Auth` |
| `module` | The specific module inside the domain | `Patient`, `Product`, `User` |

Both arguments are automatically converted to `StudlyCase`, so `hospital` and `Hospital` produce the same result.

---

## What Gets Generated

| File | Purpose |
|---|---|
| `Actions/Create.php` | Single-responsibility action for creating a record |
| `Actions/Update.php` | Single-responsibility action for updating a record |
| `Actions/Delete.php` | Single-responsibility action for deleting a record |
| `Actions/ChangeStatus.php` | Action for toggling/changing status |
| `Actions/Search.php` | Action for search/filter logic |
| `Controllers/{Module}Controller.php` | HTTP controller extending Laravel's base Controller |
| `Requests/Store{Module}Request.php` | Form request for store validation |
| `Requests/Update{Module}Request.php` | Form request for update validation |
| `Requests/Change{Module}StatusRequest.php` | Form request for status change |
| `Services/{Module}Service.php` | Service layer for orchestrating actions |
| `Repositories/{Module}Repository.php` | Repository for database query logic |
| `Models/{Module}.php` | Eloquent model |
| `DTO/{Module}Data.php` | Data Transfer Object for passing data between layers |

All files are created only if they **do not already exist**, so re-running the command is safe.

---

## Suggested Architecture

Once generated, a typical request flow looks like:

```
Request → Controller → Service → Action → Repository → Model
                                     ↑
                                    DTO (carries validated data between layers)
```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature/my-feature`
5. Open a Pull Request

Please make sure your code follows PSR-12 coding standards.

---

## Changelog

### v1.0.0
- Initial release
- `make:domain` command with full DDD scaffold
- Support for Laravel 10, 11, 12, 13

---

## License

The MIT License (MIT). See the [LICENSE](LICENSE) file for details.
