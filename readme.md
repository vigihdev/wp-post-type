# WP Post Type

WordPress custom post type management library dengan fluent API dan dependency injection support.

## 📦 Installation

```bash
composer require vigihdev/wp-post-type
```

## 🚀 Quick Start

```php
use Vigihdev\WpPostType\PostType;
use Vigihdev\WpPostType\Taxonomy;

// Initialize post type
$book = new PostType('book', 'Book', 'Books');

// Add basic configuration
$book->labels([
    'name' => 'Books',
    'singular_name' => 'Book',
    'menu_name' => 'Book Library'
])->supports([
    'title', 'editor', 'thumbnail', 'excerpt'
])->public(true)
->menuIcon('dashicons-book')
->menuPosition(5);

// Register the post type
$book->register();

// Add taxonomy
$genre = new Taxonomy('genre', 'Book', 'Genres');
$genre->hierarchical(true)->public(true)->register();
```

## 🔧 Advanced Usage

### Dengan Dependency Injection

```php
use Vigihdev\WpPostType\PostType;
use Vigihdev\WpKernel\Attributes\Service;

#[Service]
class BookPostType
{
    public function __construct() {
        $this->register();
    }

    public function register(): void
    {
        $book = new PostType('book', 'Book', 'Books');
        $book->labels([
            'name' => 'Books',
            'singular_name' => 'Book'
        ])->supports(['title', 'editor', 'thumbnail'])
          ->public(true)
          ->register();
    }
}
```

### Custom Meta Fields

```php

// Add custom meta box
$book->metaBox('book_details', 'Book Details', function($post) {
    // Meta box content
    $author = get_post_meta($post->ID, 'book_author', true);
    echo '<input type="text" name="book_author" value="'.esc_attr($author).'">';
});

// Save meta data
$book->saveMeta(function($postId) {
    if (isset($_POST['book_author'])) {
        update_post_meta($postId, 'book_author', sanitize_text_field($_POST['book_author']));
    }
});
```

## 📚 Features

- ✅ Fluent API untuk mudah digunakan
- ✅ Dependency Injection support
- ✅ Custom post type registration
- ✅ Taxonomy management
- ✅ Meta fields support
- ✅ WordPress standards compliant

## 🏗️ Requirements

- PHP 8.1 or higher
- WordPress 6.0 or higher
- vigihdev/wp-kernel
- vigihdev/serializer

## 🔗 Dependencies

```json
{
  "require": {
    "php": "^8.1",
    "vigihdev/wp-kernel": "dev-main",
    "vigihdev/serializer": "dev-main"
  }
}
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

MIT License. See [LICENSE](LICENSE) file for details.

---

**Simple & Powerful WordPress Post Type Management** 🎯

Package ini masih dalam pengembangan aktif. Silakan kontribusi atau laporkan issues!
