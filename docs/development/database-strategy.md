# Database Strategy & Environment Configuration

## Overview
Robodict2 uses Laravel's database abstraction layer with environment-based configuration for seamless development-to-production transitions.

## Database Strategy

### Development Environment
- **Database**: SQLite
- **Location**: `app/database/database.sqlite`
- **Benefits**: 
  - Zero configuration required
  - Single file database
  - Fast development cycles
  - Version control friendly
  - No external dependencies

### Production Environment
- **Database**: MySQL/PostgreSQL
- **Configuration**: Environment-based
- **Benefits**:
  - Better concurrency handling
  - Hosting provider compatibility
  - Advanced features (stored procedures, views)
  - Better backup solutions

## Environment Configuration

### Local Development (.env)
```bash
# SQLite Configuration (Default)
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=robodict2_local
# DB_USERNAME=root
# DB_PASSWORD=

# Optional: MySQL for local testing
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=robodict2_local
# DB_USERNAME=root
# DB_PASSWORD=
```

### Production (.env.production)
```bash
# MySQL Configuration
DB_CONNECTION=mysql
DB_HOST=mysql.yourhostingprovider.com
DB_PORT=3306
DB_DATABASE=robodict2_production
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_secure_password
```

### Staging (.env.staging)
```bash
# MySQL Configuration
DB_CONNECTION=mysql
DB_HOST=staging-mysql.yourhostingprovider.com
DB_PORT=3306
DB_DATABASE=robodict2_staging
DB_USERNAME=staging_user
DB_PASSWORD=staging_password
```

## Migration Strategy

### Development Workflow
1. **Create Migration**: `php artisan make:migration create_table_name`
2. **Run Migration**: `php artisan migrate`
3. **Test Locally**: All features tested with SQLite
4. **Commit Changes**: Migration files committed to git

### Production Deployment
1. **Environment Setup**: Configure production .env with MySQL credentials
2. **Run Migrations**: `php artisan migrate --env=production`
3. **Verify**: Check database structure matches development

### Key Commands
```bash
# Check migration status
php artisan migrate:status

# Run pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (development only)
php artisan migrate:fresh

# Fresh migration with seeders
php artisan migrate:fresh --seed
```

## Database Compatibility Notes

### Laravel's Database Abstraction
Laravel's Eloquent ORM and Schema Builder are database-agnostic, meaning:
- Same migration code works on SQLite and MySQL
- Same model relationships work across databases
- Same query syntax for both environments

### Supported Migration Features
```php
// These work identically on SQLite and MySQL:
Schema::create('robots', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->json('specifications'); // Works on both
    $table->timestamps();
    $table->index('name');
});
```

### Database-Specific Considerations
- **Foreign Keys**: SQLite has limited foreign key support in older versions
- **JSON Columns**: Both SQLite (3.38+) and MySQL (5.7+) support JSON
- **Full-Text Search**: MySQL has better full-text search capabilities
- **Indexing**: MySQL offers more advanced indexing options

## Environment Switching Process

### From SQLite to MySQL (Production)
1. **Export SQLite Data** (if needed):
   ```bash
   php artisan db:seed --class=ProductionDataSeeder
   ```

2. **Configure MySQL Environment**:
   ```bash
   cp .env .env.backup
   # Update DB_CONNECTION=mysql and credentials
   ```

3. **Create MySQL Database**:
   ```sql
   CREATE DATABASE robodict2_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

5. **Seed Data** (if applicable):
   ```bash
   php artisan db:seed
   ```

### From MySQL to SQLite (Testing)
1. **Configure SQLite Environment**:
   ```bash
   DB_CONNECTION=sqlite
   ```

2. **Create SQLite Database**:
   ```bash
   touch database/database.sqlite
   ```

3. **Run Migrations**:
   ```bash
   php artisan migrate:fresh
   ```

## Team Development Guidelines

### New Developer Setup
1. **Clone Repository**: `git clone https://github.com/tufan-kutlu/Robodict2.git`
2. **Install Dependencies**: `composer install`
3. **Environment Setup**: `cp .env.example .env`
4. **Generate Key**: `php artisan key:generate`
5. **Create Database**: `touch database/database.sqlite`
6. **Run Migrations**: `php artisan migrate`
7. **Seed Database**: `php artisan db:seed`

### Best Practices
- **Always test migrations on SQLite first** before production deployment
- **Use database transactions** in migrations for rollback safety
- **Never modify existing migrations** once they're in production
- **Use seeders for test data** instead of manual database manipulation
- **Document any database-specific features** used in production

## Testing Strategy

### Unit Tests (SQLite)
```php
// tests/Feature/DatabaseTest.php
use RefreshDatabase;

public function test_database_operations()
{
    // Tests run on SQLite by default
    $robot = Robot::create(['name' => 'Test Robot']);
    $this->assertDatabaseHas('robots', ['name' => 'Test Robot']);
}
```

### Integration Tests (MySQL)
```bash
# Configure testing environment for MySQL
# phpunit.xml or .env.testing
DB_CONNECTION=mysql
DB_DATABASE=robodict2_testing
```

## Monitoring & Maintenance

### Database Health Checks
```bash
# Check database connection
php artisan migrate:status

# Verify environment configuration
php artisan config:show database
```

### Performance Considerations
- **SQLite**: Single-file, good for < 1000 concurrent users
- **MySQL**: Better for high-traffic applications
- **Connection Pooling**: Consider for production MySQL setup

## Troubleshooting

### Common Issues
1. **SQLite File Permissions**: Ensure `database/database.sqlite` is writable
2. **MySQL Connection**: Verify host, port, and credentials
3. **Migration Conflicts**: Use `php artisan migrate:status` to debug
4. **Character Encoding**: Ensure UTF-8 compatibility for international content

### Emergency Recovery
```bash
# Backup current database
cp database/database.sqlite database/backup_$(date +%Y%m%d_%H%M%S).sqlite

# Reset to fresh state
php artisan migrate:fresh
php artisan db:seed
```

---

**Last Updated**: January 28, 2025  
**Version**: 1.0  
**Maintainer**: Development Team  
**Review Cycle**: Monthly
