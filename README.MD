# Endereco Implementation for OXID 6

## Contributing

For information on how to contribute to this project, please see our [Contributing Guidelines](CONTRIBUTING.md).

## Installation

The installation is done in the following steps:

1. **Install the module via Composer**

   ```bash
   composer require endereco/endereco-oxid6-client
   ```

   This command downloads the latest version. To install a specific version, for example *4.5.2*, the command can be adjusted as follows:

   ```bash
   composer require endereco/endereco-oxid6-client:4.5.2
   ```

2. **Run migrations (optional)**

   By default, the Endereco-Oxid6 module automatically executes necessary database changes after activation. All adjustments are located in the [Installer file](./Installer/Installer.php) in the *onActivate* method.

   However, if you have at least version 6.2.3 of the shop and want to execute database changes via migrations, you can disable the default database adjustments.

   For this, the following code must be added to the shop's *config.inc.php* file:

   ```php
   $this->bEnderecoUseMigrations = true;
   ```

   From now on, the entire code block in *onActivate* will no longer be executed. After reinstalling the Endereco-Oxid6 module, as well as after each module update, migrations should be checked and possibly applied:

   ```bash
   vendor/bin/oe-eshop-db_migrate migrations:migrate
   ```

   [See documentation for migrations in OXID 6](https://docs.oxid-esales.com/developer/en/6.2/development/tell_me_about/migrations.html#module-migrations)

3. **Activate the module**

   In OXID admin panel: Extensions → Modules → Endereco → Activate

## Development Setup

### Prerequisites

- PHP 5.6 or higher
- Composer
- OXID eShop 6.1+ installation
- Nodejs and npm
- Git

### Setting up the Development Environment

**Important:** Before setting up the development environment, make sure the module is properly installed via Composer first (see Installation section above). This ensures all autoload paths are registered correctly.

1. **Fork and Clone the Repository**
   ```bash
   git clone https://github.com/your-username/endereco-oxid6-client.git
   cd endereco-oxid6-client
   ```

2. **Install Development Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Set up Git Hooks** (automatically runs quality checks before commits)
   ```bash
   composer post-install-cmd
   ```

4. **Link Module to OXID Shop**
   
   **Note:** The module must be installed properly first via `composer require endereco/endereco-oxid6-client` so that all paths are registered in the composer autoload.
   
   After proper installation, create a symlink from your OXID shop's modules directory to your development directory:
   ```bash
   ln -s /path/to/your/endereco-oxid6-client /path/to/oxid/source/modules/endereco/endereco-oxid6-client
   ```

5. **Activate the Module**
   
   In OXID admin panel: Extensions → Modules → Endereco → Activate

### Development Workflow

1. **Build Endereco Bundle**
   ```bash
   npm run build      # Build the Endereco bundle
   ```

2. **Run Quality Checks**
   ```bash
   composer qa        # Run all checks
   composer phpcs     # Code style check only
   composer phpcbf    # Auto-fix code style issues
   ```

3. **Testing with Multiple OXID Versions**
   
   The project includes PHPStan configurations for different OXID versions:
   - `phpstan.6.1.neon` - OXID 6.1
   - `phpstan.6.2.neon` - OXID 6.2
   - `phpstan.6.3.neon` - OXID 6.3
   - `phpstan.6.4.neon` - OXID 6.4
   - `phpstan.6.5.neon` - OXID 6.5

4. **Before Committing**
   
   Ensure all quality checks pass:
   ```bash
   composer qa
   ```

