# Multi-Level Commenting System

A Laravel-based multi-level commenting system with recursive depth checking, built with Laravel 11. This application demonstrates nested comments with a maximum depth limit and includes automated cleanup functionality.

## Features

- **Multi-level Comments**: Support for nested replies up to 3 levels deep
- **Depth Limitation**: Automatic prevention of comments exceeding maximum depth
- **Recursive Display**: Comments displayed in a hierarchical tree structure
- **Scheduled Cleanup**: Automated removal of old comments with empty content
- **Modern UI**: Clean, responsive Bootstrap-based interface
- **Real-time Validation**: Client-side and server-side validation

## Requirements

- PHP 8.2 or higher
- Composer
- SQLite (default) or MySQL/PostgreSQL
- Node.js and NPM (for assets compilation)

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd multi-level-comments
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

The application uses SQLite by default. The database file is already created during installation.

```bash
# Run migrations
php artisan migrate

# Seed with sample data (optional)
php artisan db:seed
```

### 5. Compile Assets

```bash
npm run build
```

### 6. Start the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Database Schema

### Posts Table
- `id` - Primary key
- `title` - Post title
- `content` - Post content
- `created_at`, `updated_at` - Timestamps

### Comments Table
- `id` - Primary key
- `content` - Comment content (nullable)
- `post_id` - Foreign key to posts table
- `parent_comment_id` - Self-referencing foreign key for nested comments
- `depth` - Integer representing comment depth level
- `created_at`, `updated_at` - Timestamps

## Key Features Explained

### 1. Depth Limitation Logic

The system enforces a maximum depth of 3 levels through:

- **Model-level validation**: The `Comment` model automatically calculates and validates depth
- **Database constraints**: Depth is stored and validated at the database level
- **UI restrictions**: Reply buttons are hidden at maximum depth

```php
// In Comment model
const MAX_DEPTH = 3;

public function canHaveReplies(): bool
{
    return $this->depth < self::MAX_DEPTH;
}
```

### 2. Recursive Comment Display

Comments are displayed recursively using Blade partials:

```blade
@foreach($post->rootComments as $comment)
    @include('partials.comment', ['comment' => $comment, 'post' => $post])
@endforeach
```

### 3. Scheduled Command

The cleanup command removes old comments with empty content:

```bash
# Manual execution
php artisan comments:cleanup --days=30

# Scheduled execution (runs every minute)
php artisan schedule:run
```

## Usage

### Creating Posts

1. Navigate to the home page
2. Click "Create Post"
3. Fill in title and content
4. Submit the form

### Adding Comments

1. Open a post
2. Use the comment form at the top to add a root comment
3. Use "Reply" buttons to add nested replies
4. Maximum depth of 3 levels is enforced

### Managing Comments

- Empty comments are automatically cleaned up by the scheduled command
- Comments at maximum depth cannot have replies
- The system prevents circular references and invalid parent relationships

## API Endpoints

- `GET /` - List all posts
- `GET /posts/create` - Show post creation form
- `POST /posts` - Store new post
- `GET /posts/{post}` - Show single post with comments
- `POST /posts/{post}/comments` - Store new comment

## Scheduled Tasks

The application includes a scheduled command that runs every minute:

```php
// In routes/console.php
Schedule::command('comments:cleanup')->everyMinute();
```

This command:
- Finds comments older than specified days (default: 30)
- Removes comments with empty content
- Removes comments with no replies
- Logs cleanup activities

## Testing the Application

### 1. Basic Functionality

1. Create a few posts
2. Add comments to posts
3. Add nested replies (up to 3 levels)
4. Verify that reply buttons disappear at maximum depth

### 2. Scheduled Command

```bash
# Test manual cleanup
php artisan comments:cleanup --days=30

# Test scheduled execution
php artisan schedule:run
```

### 3. Depth Limitation

Try to create deeply nested comments and verify the system prevents exceeding maximum depth.

## Technical Implementation

### Models

- **Post**: Has many comments, with specific relationship for root comments
- **Comment**: Self-referencing model with parent-child relationships
- **Depth calculation**: Automatic depth calculation on comment creation

### Controllers

- **PostController**: Handles post CRUD operations
- **CommentController**: Handles comment creation with depth validation

### Views

- **Recursive partials**: `partials.comment` for hierarchical display
- **Bootstrap styling**: Modern, responsive UI
- **JavaScript interactions**: Toggle reply forms, dynamic interactions

## Architecture Decisions

1. **Self-referencing model**: Clean approach for hierarchical data
2. **Depth field**: Stored depth for efficient querying and validation
3. **Partial views**: Recursive rendering for nested comments
4. **Scheduled commands**: Automated maintenance tasks
5. **Bootstrap UI**: Quick, professional interface

## Customization

### Changing Maximum Depth

Update the constant in the Comment model:

```php
// In app/Models/Comment.php
const MAX_DEPTH = 5; // Change from 3 to 5
```

### Customizing Cleanup Schedule

Modify the schedule in `routes/console.php`:

```php
Schedule::command('comments:cleanup')->daily(); // Change from everyMinute()
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
