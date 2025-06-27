# 🌱 Bonsai Site Maker: Beginner’s Guide

A simple step-by-step guide for beginner developers building a website with the Bonsai PHP Site Maker.

Call it a micro-framework, a starter kit, or just a simple structure — Bonsai was created to solve a real-world problem I encountered: building clean, modern websites for clients who insist on keeping control of their own domain and host everything on shared hosting platforms.

It’s intentionally lightweight, easy to understand, and works out of the box without needing a build process, database, or special server. Whether you call it a framework or not, Bonsai is here to make small-site development faster, simpler, and more maintainable — without giving up modern tooling like Tailwind CSS and Alpine.js. 

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

- `/index.php` — The main router  
- `/pages/` — Your page content (e.g., `home.php`, `about.php`)  
- `/inc/header.php` and `/footer.php` — Included on simple pages  
- `/inc/layout.php` — Used for advanced pages with metadata or layout wrappers  
- `/inc/functions.php` — Shared helper functions  
- `/css/`, `/js/` — Optional custom styles/scripts  
- `/bonsai-static.php` — Converts your PHP pages into flat `.html` files for static hosting

---

# Part 3: Page Creation Options

**Bonsai** gives you four different ways to create pages, each suited for different needs. You can mix and match these approaches within the same project.

---

## Option 1: Simple HTML Pages

Perfect for basic static content. Just create HTML in your page file – header and footer are automatically included.

**Example:** `/pages/contact.php`

```php
<h1>Contact Us</h1>
<p>Get in touch with our team!</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div>
    <h3>Email</h3>
    <p>hello@example.com</p>
  </div>
  <div>
    <h3>Phone</h3>
    <p>(555) 123-4567</p>
  </div>
</div>
```

---

## Option 2: Layout Pages (Full Control)

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
<h1>Our Services</h1>
<div class="space-y-6">
  <div class="p-4 border rounded">
    <h3>Web Design</h3>
    <p>Beautiful, responsive websites</p>
  </div>
  <div class="p-4 border rounded">
    <h3>Development</h3>
    <p>Custom functionality and integrations</p>
  </div>
</div>
<?php
$content = ob_get_clean();
?>
```

---

## Option 3: Pure Markdown Pages

Write content in Markdown for faster content creation and better version control.

**Example:** `/pages/about.md`

```markdown
---
title: About Our Company
description: Learn about our mission and team
wrap_mode: card
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

## Option 4: Mixed PHP + Markdown

Combine the power of PHP with the simplicity of Markdown – perfect when you need both dynamic functionality and easy content editing.

**Example:** `/pages/blog.php`

```php
<?php
$use_layout = true;
$title = "Our Blog";
$wrap_mode = "sidebar";

ob_start();
?>
<div class="blog-intro">
  <?= markdown_file('content/blog-intro.md') ?>
</div>

<div class="recent-posts">
  <h2>Recent Posts</h2>
  <?php
  $posts = glob('content/blog/*.md');
  foreach(array_slice($posts, 0, 3) as $post) {
      $title = basename($post, '.md');
      echo "<article class='mb-4'>";
      echo "<h3><a href='/blog/{$title}'>" . ucwords(str_replace('-', ' ', $title)) . "</a></h3>";
      echo "<div class='text-gray-600'>" . markdown_file($post, 150) . "...</div>";
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
| **Simple HTML**         | Quick static pages, landing pages, basic content                     |
| **Layout Pages**        | Complex pages with custom logic, forms, dynamic content              |
| **Pure Markdown**       | Blog posts, documentation, content-heavy pages                       |
| **Mixed PHP + Markdown**| Flexible pages that need both easy content editing and functionality |

All four approaches work with both **dynamic hosting** and **static site generation**, giving you maximum flexibility for any project.


---

## Part 4: Navigation

To add links, edit `/inc/layout.php` or `/inc/header.php` and modify the `<nav>` section:

```html
<a href="/about" class="hover:underline">About</a>
```

---

## Part 5: Styling and Interactions

### Tailwind CSS

Use utility-first classes like:

- `text-center`
- `bg-blue-500`
- `p-4`
- `rounded`

### Alpine.js

Add interactivity easily:

```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <p x-show="open">Hello!</p>
</div>
```

---

## Part 6: Advanced Features

### Layout Modes

Set `$wrap_mode` in layout pages:

- `""` – No wrapper  
- `"card"` – White box layout  
- `"sidebar"` – For sidebar designs

### Reusable Functions

Use `functions.php` to wrap or manage components. Example:

```php
function wrap($content, $mode = '') {
  if ($mode === 'card') {
    return "<div class='bg-white p-6 shadow rounded-xl'>" . $content . "</div>";
  }
  return $content;
}
```

---

## Part 7: Static Site Generation (bonsai-static.php)

You can convert your site into flat `.html` files — great for static hosting (like Vercel or Netlify).

### How to Use It

1. Make sure your site works normally (dynamically).
2. Run the script from your terminal:

```bash
php bonsai-static.php
```

This will:

- Render each `.php` page in `/pages/`
- Save static `.html` versions in the `/dist/` folder
- Copy `/css/`, `/js/`, `/images/`, and other public assets into `/dist/`

### Deploy to Vercel or Netlify

1. Upload the contents of the `/dist/` folder  
2. Set `index.html` as your homepage  
3. Done! Your site is now running 100% static

---

## Part 8: Going Live (Shared Hosting Option)

- Use FTP tools (e.g., FileZilla) or cPanel File Manager  
- Make sure `.htaccess` is included (for dynamic routing)  
- `home.php` is the default homepage  
- A built-in 404 page handles missing routes

---

## Part 9: Tips & Next Steps

- Use layout pages for consistent design and metadata  
- Break reusable parts into includes like `sidebar.php`  
- Use Tailwind + Alpine for rapid, modern UI building  
- Duplicate existing pages to create new ones quickly  
- Run `php bonsai-static.php` anytime to flatten for static hosting

---

**Happy coding with Bonsai! 🌿**
