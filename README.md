# Newsletter - WordPress Plugin

This is the official documentation for my custom Newsletter WordPress plugin, that provides an easy way for users to
collect newsletter subscriptions on their WordPress websites.
You can add the newsletter sign-up form anywhere on your website using a simple shortcode or a native Gutenberg block.

All styles and validation are handled by the plugin, so you don't have to worry about anything!
But if you want to customize the look and feel of the newsletter, you can easily do it by yourself.

The plugin also provides the functionality to manage the newsletter submissions and export them in CSV format.

The plugin is simple, lightweight, and operates independently of other plugins.

Moreover, the plugin is already prepared for internationalization, so you can easily translate it into your language!

## Requirements

This plugin requires the following:

- PHP 8.1 or newer
- WordPress 6.1 or newer

## Installation

You can download the zip file from this GitHub repository. You can find it in the `bundle` directory. [Download Newsletter Plugin](bundle)

When you have that plugin, you can install it in your WordPress website. 
Just click on the `Add New` button in the `Plugins` section in your WordPress dashboard and upload the zip file.

After the plugin is installed, click Activate. That's it!

If you interested in contributing to this project, please go to the [Contribution](#contribution) section.

## How to Use

You can add the newsletter sign-up form anywhere on your website using a simple shortcode or a Gutenberg block.

### Shortcode

To add the newsletter sign-up form using a shortcode, use the following code:

```php
[newsletter-wp-plugin]
```

You can also use the following attributes to customize the shortcode:

```php
[newsletter-wp-plugin title="My Newsletter" placeholder="Your email" button_title="Join Now" agreement_text="Agree to subscribe."]
```

If you don't specify any attributes, the plugin will use the default values.

### Gutenberg Block

At the beginning, I was considering using ACF plugin to create a custom block for the newsletter. But then I decided to
use the native Gutenberg block instead.
This way, the plugin is more lightweight and is not depend on other plugins.

To add the newsletter sign-up form using a Gutenberg block, search for the `Newsletter` block.
You can easily customize the block's attributes using input fields predefined in Gutenberg block instead of using the
not super handy shortcode attributes.

## Theming

With the Newsletter WordPress Plugin, you're not stuck with default styles and behaviors - oh no!

This powerful plugin gives you the ability to tailor the look and feel of your newsletter to match your unique branding
and requirements.

As modifying the plugin's code is not recommended (you can lose all your changes on update), you can use the following
filters and own templates to customize the plugin's output.

### Overriding default template

Take full control of the newsletter's layout by overriding the default template. Here's how you can do it:
Create a file named `newsletter-wp-plugin.php` in your active theme's directory - in the root folder of your theme.

The plugin will automatically check if this file exists in your active theme's directory. If it does, the plugin will
use your custom template instead of the default one.

The array `$args` inside this file contains the following keys that you can use in your custom template:

```php
$args = [
  'title' => 'Your Newsletter Title',
  'placeholder' => 'Placeholder text for the email input field',
  'button_title' => 'Button Title',
  'agreement_text' => 'Agreement Text',
]
```

### Customizing Styles (CSS) and Scripts (JavaScript)

Are you a fan of making things your own? You can easily change the path for loading CSS and JS files or even completely
remove them.

#### Customizing Styles (CSS)

To change or remove the CSS file path, use the `newsletter_wp_plugin_add_css` filter. Here's an example of how to do it:

```php
add_filter( 'newsletter_wp_plugin_add_css', function() {
    wp_dequeue_style( 'newsletter-wp-plugin-style' );
    wp_enqueue_style( 'my-newsletter-style', get_stylesheet_directory_uri() . '/my-style.css' );
} );
```

In this example, `my-style.css` is the custom stylesheet you want to use instead of the default one.

#### Customizing Scripts (JavaScript)

Just like with CSS, you can use a filter to customize the JavaScript file path. Use the `newsletter_wp_plugin_add_js`
filter, like this:

```php
add_filter( 'newsletter_wp_plugin_add_js', function() {
    wp_dequeue_script( 'newsletter-wp-plugin-script' );
    wp_enqueue_script( 'my-newsletter-script', get_stylesheet_directory_uri() . '/my-script.js', [], false, true );
} );
```

In this example, `my-script.js` is the custom JavaScript file you want to use instead of the default one.

## Data management

When you install the plugin, it will automatically create a database (if there is no conflict with other plugins or
themes) to store the newsletter submissions.

You can manage the newsletter submissions from the WordPress dashboard by going to `Admin Panel > Newsletter`.

You will find there a list of all newsletter submissions with possibility to search, sort or even delete them.

### Exporting submissions

If reviewing submissions in the WordPress dashboard is not enough, you can export them in CSV format.

To do so, go to `Admin Panel > Newsletter > Export all to CSV`.

## Contribution

If you want to contribute to the development of this plugin, you already have all build tools configured.
If you want to add some new features or fix some bugs, you can do it by creating a pull request.

### Development
To start developing, you need to clone repository, and install all dependencies by running the following command:

```shell
composer install
npm install
```

To build the plugin, run the following command:
```shell
npm run build
```

To develop the plugin in development mode, run the following command:
```shell
npm start
```

To check the code for errors, run the following commands:
```shell
npm run lint:js
npm run lint:scss
npm run lint:php
```

To fix the code for errors, run the following commands:
```shell
npm run lint:js-fix
npm run lint:scss-fix
npm run lint:php-fix
```

You already have my thanks for considering contributing to this project!

## License
This plugin is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
