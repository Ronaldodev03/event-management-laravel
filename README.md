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

## controllers:

-   php artisan make:controller Api/EventController --api (/Api for the route & --api for having default methods for apis in the controller)

### Route Model Binding:

Route Model Binding automatically injects Laravel model instances into controller methods by matching route parameters (like {event}) to database records - when you type-hint a model (e.g., Event $event), Laravel fetches it by ID (or custom column) and returns a 404 if not found, eliminating manual queries like Event::find($id). It works for both primary keys (/events/1) and custom fields (like slugs /events/my-event), and can enforce relationships in nested routes (e.g., ensuring an attendee belongs to an event).
