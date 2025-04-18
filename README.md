## right after creating the laravel project:

go to .env and change the name of the db (DB_DATABASE) and put the name that you want for your db.

## model & migrations:

-   php artisan make:model Event -m (this will also make the migration)

-   php artisan make:model Attendee -m (this will also make the migration)

### migrations

Migrations are like version control for your database schema. They allow you to:

-   Define database structure: The migration you showed (create_events) defines a table with columns for events, including relationships to users.

-   Track changes: Each migration represents a discrete change to your database.

-   Synchronize development: Team members can run migrations to get the same database structure.

-   Roll back changes: You can undo migrations if needed (using the down method).

### models

Models represent your application's data and business logic. They:

-   Interact with database tables: Each model typically corresponds to a database table.

-   Define relationships: Like the user() and attendees() methods in your Event model.

-   Handle data operations: Create, read, update, and delete records.

-   Protect attributes: Your $fillable array specifies which fields can be mass-assigned.

## factory & seeder:

-   php artisan make:factory EventFactory --model=Event

-   php artisan make:sedeer EventSeeder

-   php artisan make:sedeer AttendeeSeeder (doesn't need a factory)
