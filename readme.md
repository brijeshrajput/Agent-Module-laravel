
# Agent Module for Laravel

A comprehensive Agent Management module for Laravel applications, designed to handle agent registration, wallet management, commissions, notifications, and more. This module is suitable for platforms requiring agent-based operations, such as multi-level marketing, payment gateways, or service providers.

## Table of Contents
- [Features](#features)
- [Folder Structure](#folder-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Database Migrations](#database-migrations)
- [Contributing](#contributing)
- [License](#license)

## Features
- Agent registration, authentication, and profile management
- Agent wallet with transaction logs
- Commission calculation and history
- Withdraw requests and payment processing
- Agent notifications
- Client management for agents
- Admin panel for agent oversight
- Multi-language support
- Modular structure for easy integration

## Folder Structure
```
Agent/
├── Config/                # Module configuration files
├── Console/               # Console commands
├── Database/              # Migrations, seeders, factories
│   ├── Migrations/        # Table definitions
│   ├── Seeders/           # Database seeders
├── Entities/              # Eloquent models
├── Helper/                # Utility classes
├── Http/                  # Controllers, Middleware, Requests
│   ├── Controllers/       # Web/API controllers
│   ├── Middleware/        # Custom middleware
│   ├── Requests/          # Form requests
├── Providers/             # Service providers
├── Resources/             # Assets, views, translations
│   ├── assets/            # CSS, JS, SASS
│   ├── lang/              # Language files
│   ├── views/             # Blade templates
├── Routes/                # Route definitions
├── Tests/                 # Unit and feature tests
├── composer.json          # PHP dependencies
├── package.json           # JS dependencies
├── webpack.mix.js         # Asset compilation
```

## Installation
1. **Clone the repository:**
	```sh
	git clone <repo-url> Agent
	cd Agent
	```
2. **Install PHP dependencies:**
	```sh
	composer install
	```
3. **Install JS dependencies:**
	```sh
	npm install
	```
4. **Publish assets and config (if needed):**
	```sh
	php artisan vendor:publish --provider="Agent\\Providers\\AgentServiceProvider"
	```
5. **Run migrations:**
	```sh
	php artisan migrate
	```
6. **Seed the database (optional):**
	```sh
	php artisan db:seed --class=AgentDatabaseSeeder
	```
7. **Compile assets:**
	```sh
	npm run dev
	```

## Configuration
- Edit `Config/config.php` to set module-specific options.
- Update environment variables in `.env` as required for mail, database, etc.

## Usage
- Access agent features via the provided routes in `Routes/web.php` and `Routes/api.php`.
- Use the admin panel for agent management and oversight.
- Customize views in `Resources/views/` as needed.

## Database Migrations
- All migration files are located in `Database/Migrations/`.
- Tables include: `agents`, `agent_wallets`, `agent_clients`, `agent_commissions`, `agent_withdraw_requests`, `agent_payment_logs`, `agent_notifications`.

## Contributing
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Create a new Pull Request

## License
This project is open-source and available under the [MIT License](LICENSE).