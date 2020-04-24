# WP Dependency Checker
This is a simple library for a WordPress plugin that check for plugin dependencies.

Often when we do private projects we may require one or more plugins to be active. It just
isn't sensible for us to make everything work without. This saves time and money for us and our clients.a

When we do, we find ourselves in need of checking dependencies. This library helps you add it to your plugin in a
modern PHP fashion using traits.

If dependencies are not found you can handle them and an admin notice is shown.

## Getting started
All you need to do is include the `Has_Dependencies` trait in the plugin class where you want to
check your dependencies. Ideally before you execute any code.

Then specificy a list of plugin dependencies in the `$dependencies` class variable.

```
use BernskioldMedia\WP\WP_Dependency_Checker\Traits\Has_Dependencies;

class My_Plugin {

    use Has_Dependencies;

    protected static $dependencies = [
        'My Dependency' => 'folder/main-file.php',
    ];

}
```

When you need to check for your dependencies, you then run an if:

```
if(self::has_dependencies()) {
    // Run my code
}
```

The `has_dependencies` function will automatically show an admin notice if falsy.
