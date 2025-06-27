# 🌱 Bonsai Site Maker: Beginner's Guide

A simple step-by-step guide for beginner developers building a website with the Bonsai PHP Site Maker.

Call it a micro-framework, a starter kit, or just a simple structure — Bonsai was created to solve a real-world problem I encountered: building clean, modern websites for clients who insist on keeping control of their own domain and host everything on shared hosting platforms.

It's intentionally lightweight, easy to understand, and works out of the box without needing a build process, database, or special server. Whether you call it a framework or not, Bonsai is here to make small-site development faster, simpler, and more maintainable — without giving up modern tooling like Tailwind CSS and Alpine.js. 

**NOTE:** There is a base assumption that the shared hosting you use will be run by Apache, thus an .htaccess file is included as part of the setup.

### 🎨 Tailwind CSS Resources

[![Tailwind Docs](https://img.shields.io/badge/docs-tailwindcss-blue?style=flat&logo=tailwindcss)](https://tailwindcss.com/docs/installation/play-cdn)  
The official documentation for Tailwind CSS. Use it to look up utility classes, responsive behavior, theming, and more.

[![Tailwind Play](https://img.shields.io/badge/Tailwind%20Play-online%20editor-green?style=flat&logo=codepen)](https://play.tailwindcss.com)  
An online playground to experiment with Tailwind classes without installing anything. Perfect for quick mockups and demos.

[![Tailwind UI](https://img.shields.io/badge/Tailwind%20UI-premium-lightgrey?style=flat&logo=figma)](https://tailwindui.com)  
A premium component library from the creators of Tailwind. Built by [@adamwathan](https://twitter.com/adamwathan) and the Tailwind team. It's a one-time or team license that gives you **production-ready HTML components** you can drop into any project.

### 🧠 Alpine.js Resources

[![Alpine.js Docs](https://img.shields.io/badge/docs-alpine.js-blue?style=flat&logo=javascript)](https://alpinejs.dev/start-here)  
Learn how to use Alpine's powerful JavaScript features to add interactivity with minimal code. Thanks to [Caleb Porzio](https://twitter.com/calebporzio) for creating such a fantastic tool!

[![Alpine Components](https://img.shields.io/badge/Alpine%20Components-premium-lightgrey?style=flat&logo=html5)](https://alpinejs.dev/components)  
A one-time purchase that unlocks a full set of **copy-paste UI components** for professional-looking sites, crafted by Caleb himself.

---

## Part 1: Getting Started

### What is Bonsai?

Bonsai is a lightweight PHP-based site kit using:

- **HTML** for structure  
- **Tailwind CSS** for styling  
- **Alpine.js** for interactivity  

It works perfectly on shared hosting (like GoDaddy, Bluehost, etc.) and can also generate **static HTML** pages for platforms like **Vercel**.

### Requirements

- A code editor (e.g., VS Code)  
- A shared hosting plan or Vercel account  
- Basic understanding of HTML (no PHP knowledge required to begin)

### Installation

1. Download or clone the Bonsai starter kit.  
2. Upload the folder to your server (via FTP or File Manager).  
3. Visit your domain to test if the homepage loads.

---

## Part 2: File Structure

Bonsai follows a clean, organized structure:

```
bonsai/
├── bonsai/                    # Framework core (don't touch)
│   ├── core.php              # Main framework functions
│   ├── router.php            # Simple routing
│   ├── template.php          # View helpers
│   ├── markdown.php          # Markdown processing
│   └── Parsedown.php         # Markdown parser
├── pages/                    # Your page content
│   ├── home.php              # Homepage
│   ├── about.php             # Example page
│   └── test.md               # Example markdown page
├── templates/                # Your templates
│   ├── layouts/
│   │   └── app.php           # Main layout template
│   ├── partials/
│   │   ├── header.php        # Header partial
│   │   └── footer.php        # Footer partial
│   └── components/
│       ├── card.php          # Card wrapper component
│       └── sidebar.php       # Sidebar wrapper component
├── content/                  # Markdown files
├── config/                   # Configuration files
│   └── site.php              # Basic site configuration
├── public/                   # Web-accessible files
│   ├── index.php             # Main entry point
│   ├── .htaccess             # Apache rewrite rules
│   └── assets/               # CSS, JS, images
├── dist/                     # Static build output
└── build.php                 # Static site generator
```

### Key Directories

- **`/bonsai/`** — Framework core files (don't modify these)
- **`/pages/`** — Your page content (PHP or Markdown files)
- **`/templates/`** — Layouts, partials, and reusable components
- **`/config/`** — Site configuration
- **`/public/`** — Web root with entry point and assets
- **`/content/`** — Additional Markdown content files
- **`/dist/`** — Generated static HTML files (created by build process)

---

## Part 3: Page Creation Options

**Bonsai** gives you multiple ways to create pages, each suited for different needs. You can mix and match these approaches within the same project.

---

### Option 1: Simple PHP Pages

Perfect for basic static content with minimal setup.

**Example:** `/pages/contact.php`

```php
<?php
$title = "Contact Us";
$description = "Get in touch with our team!";
$use_layout = true;

ob_start();
?>
<h1 class="text-3xl font-bold mb-6">Contact Us</h1>
<p class="mb-6">Get in touch with our team!</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="p-4 bg-white rounded shadow">
    <h3 class="font-semibold mb-2">Email</h3>
    <p>hello@example.com</p>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <h3 class="font-semibold mb-2">Phone</h3>
    <p>(555) 123-4567</p>
  </div>
</div>
<?php
$content = ob_get_clean();
?>
```

---

### Option 2: Layout Pages with Custom Wrappers

Use this when you need custom metadata, specific styling, or wrapper modes.

**Example:** `/pages/services.php`

```php
<?php
$use_layout = true;
$title = "Our Services";
$description = "Professional web design and development services";
$wrap_mode = "card";

ob_start();
?>
<h1 class="text-3xl font-bold mb-6">Our Services</h1>
<div class="space-y-6">
  <div class="p-4 border rounded">
    <h3 class="text-xl font-semibold mb-2">Web Design</h3>
    <p>Beautiful, responsive websites</p>
  </div>
  <div class="p-4 border rounded">
    <h3 class="text-xl font-semibold mb-2">Development</h3>
    <p>Custom functionality and integrations</p>
  </div>
</div>
<?php
$content = ob_get_clean();
?>
```

---

### Option 3: Pure Markdown Pages

Write content in Markdown for faster content creation and better version control.

**Example:** `/pages/about.md`

```markdown
---
title: About Our Company
description: Learn about our mission and team
wrap_mode: card
body_class: bg-white text-gray-800
---

# About Our Company

We're a **creative agency** focused on building amazing websites.

## Our Mission

To help businesses succeed online with:

- Modern, responsive design
- Clean, maintainable code
- Excellent user experiences

## Our Team

Our diverse team brings together designers, developers, and strategists to create digital solutions that work.
```

---

### Option 4: Mixed PHP + Markdown

Combine the power of PHP with the simplicity of Markdown – perfect when you need both dynamic functionality and easy content editing.

**Example:** `/pages/blog.php`

```php
<?php
$use_layout = true;
$title = "Our Blog";
$wrap_mode = "sidebar";

ob_start();
?>
<div class="blog-intro mb-8">
  <?= bonsai_markdown_file('content/blog-intro.md') ?>
</div>

<div class="recent-posts">
  <h2 class="text-2xl font-bold mb-4">Recent Posts</h2>
  <?php
  $posts = glob('content/blog/*.md');
  foreach(array_slice($posts, 0, 3) as $post) {
      $title = basename($post, '.md');
      echo "<article class='mb-6 p-4 bg-white rounded shadow'>";
      echo "<h3 class='text-xl font-semibold mb-2'><a href='/blog/{$title}' class='text-blue-600 hover:underline'>" . ucwords(str_replace('-', ' ', $title)) . "</a></h3>";
      echo "<div class='text-gray-600'>" . bonsai_markdown_file($post, 150) . "...</div>";
      echo "</article>";
  }
  ?>
</div>
<?php
$content = ob_get_clean();
?>
```

**Content File:** `/content/blog-intro.md`

```markdown
Welcome to our blog! Here we share insights about:

- **Web Development** trends and best practices
- **Design** inspiration and tutorials  
- **Business** growth strategies for digital success

Stay tuned for regular updates from our team.
```

---

## Choosing the Right Option

| Option                  | Best For                                                              |
|-------------------------|-----------------------------------------------------------------------|
| **Simple PHP**          | Quick static pages, landing pages, basic content                     |
| **Layout Pages**        | Complex pages with custom logic, forms, dynamic content              |
| **Pure Markdown**       | Blog posts, documentation, content-heavy pages                       |
| **Mixed PHP + Markdown**| Flexible pages that need both easy content editing and functionality |

All approaches work with both **dynamic hosting** and **static site generation**, giving you maximum flexibility for any project.

---

## Part 4: Configuration

### Site Configuration

Edit `/config/site.php` to customize your site:

```php
return [
    'name' => 'Your Site Name',
    'description' => 'Your site description.',
    'base_url' => '', // Set this for subdirectory installs
    
    // Custom routes (optional)
    'routes' => [
        '/custom-url' => 'page-name',
    ],
    
    // Default layout settings
    'layout' => [
        'default' => 'app',
        'wrap_mode' => '',
        'body_class' => 'bg-gray-100 text-gray-900'
    ],
    
    // Navigation (for auto-generation)
    'nav' => [
        'Home' => '/',
        'About' => '/about',
        'Services' => '/services',
    ]
];
```

### Layout Variables

In your page files, you can set these variables:

- `$title` — Page title
- `$description` — Meta description
- `$body_class` — CSS classes for the body element
- `$wrap_mode` — Content wrapper ('card', 'sidebar', or '')
- `$use_layout` — Whether to use the main layout (true/false)

---

## Part 5: Templates and Components

### Main Layout

The main layout (`/templates/layouts/app.php`) provides the HTML structure:

- Responsive design with Tailwind CSS
- Alpine.js for interactivity
- SEO-friendly meta tags
- Automatic content wrapping

### Content Wrappers

Set `$wrap_mode` to apply different content wrappers:

- `""` – No wrapper (default)
- `"card"` – White card with shadow
- `"sidebar"` – Two-column layout with sidebar

### Custom Components

Create reusable components in `/templates/components/`:

```php
// /templates/components/alert.php
<div class="border-l-4 p-4 mb-4 <?= $type === 'error' ? 'border-red-500 bg-red-100 text-red-700' : 'border-blue-500 bg-blue-100 text-blue-700' ?>">
    <?= $content ?>
</div>
```

Use components with the `bonsai_view()` helper:

```php
<?= bonsai_view('components/alert', ['content' => 'Success!', 'type' => 'success']) ?>
```

---

## Part 6: Styling and Interactions

### Tailwind CSS

Use utility-first classes for rapid styling:

```html
<div class="bg-white shadow-lg rounded-lg p-6 max-w-md mx-auto">
  <h2 class="text-xl font-bold text-gray-900 mb-4">Card Title</h2>
  <p class="text-gray-600">Card content goes here.</p>
  <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Click Me
  </button>
</div>
```

### Alpine.js

Add interactivity with minimal JavaScript:

```html
<div x-data="{ open: false }">
  <button @click="open = !open" class="bg-blue-500 text-white px-4 py-2 rounded">
    Toggle Menu
  </button>
  <div x-show="open" x-transition class="mt-2 p-4 bg-gray-100 rounded">
    <p>This menu toggles open and closed!</p>
  </div>
</div>
```

---

## Part 7: Static Site Generation

Convert your dynamic site into flat HTML files for static hosting platforms like Vercel or Netlify.

### How to Generate Static Files

1. Make sure your site works normally (dynamically).
2. Run the build script:

```bash
php build.php
```

This will:

- Discover all pages in `/pages/`
- Render each page with its layout
- Save static `.html` versions in the `/dist/` folder
- Copy assets from `/public/assets/` to `/dist/assets/`

### Deploy to Static Hosting

1. Upload the contents of the `/dist/` folder to your static host
2. Set `index.html` as your homepage
3. Configure redirects if needed for clean URLs

**Vercel Example:**
Create a `vercel.json` file in your `/dist/` folder:

```json
{
  "cleanUrls": true,
  "trailingSlash": false
}
```

---

## Part 8: Going Live (Shared Hosting)

### Why Shared Hosting?

This option is why the original Site Maker was created. I needed a simple option for hosting custom code on a shared hosting site. Not my choice, done for a customer. PHP just works, but I wanted better routing options, so I started with a simple .htaccess file and some custom routing. Then the build bug hit me and Bonsai was born.

### Deployment Steps

1. Use FTP tools (e.g., FileZilla) or cPanel File Manager
2. Upload all files to your web root directory
3. Make sure `.htaccess` is included (for clean URL routing)
4. Ensure `/public/` is your document root, or move contents to web root
5. Test that `home.php` loads as your homepage
6. The built-in 404 page handles missing routes

### URL Structure

- `/` → `home.php`
- `/about` → `about.php` or `about.md`
- `/services` → `services.php` or `services.md`
- Custom routes can be defined in `/config/site.php`

---

## Part 9: Helper Functions

### Core Functions

Bonsai provides several helpful functions:

```php
// Configuration
bonsai_config('name') // Get config value
bonsai_config('nav', []) // Get config with default

// URLs and Assets
bonsai_url('/about') // Generate site URL
bonsai_asset('css/custom.css') // Generate asset URL

// Templates
bonsai_view('components/card', ['content' => 'Hello']) // Render template

// Markdown
bonsai_markdown($text) // Convert markdown to HTML
bonsai_markdown_file('content/post.md') // Render markdown file
bonsai_parse_markdown_page('pages/about.md') // Parse with frontmatter

// Content Wrapping
bonsai_wrap($content, 'card') // Wrap content with component
```

---

## Part 10: Tips & Next Steps

### Best Practices

- Use layout pages for consistent design and metadata
- Break reusable parts into components in `/templates/components/`
- Store shared content in `/content/` as Markdown files
- Use Tailwind + Alpine for rapid, modern UI building
- Duplicate existing pages to create new ones quickly
- Run `php build.php` anytime to generate static files

### Advanced Usage

- Create custom components for repeated UI patterns
- Use the configuration system for site-wide settings
- Implement custom routing in `/config/site.php`
- Mix and match page types based on content needs
- Leverage Markdown frontmatter for page metadata

### Development Workflow

1. Create pages in `/pages/` (PHP or Markdown)
2. Build templates and components in `/templates/`
3. Configure site settings in `/config/site.php`
4. Test locally with a PHP server
5. Deploy to shared hosting OR generate static files for JAMstack hosting

---

**Happy coding with Bonsai! 🌿**