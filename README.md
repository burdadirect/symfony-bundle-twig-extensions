# HBM Twig Extensions Bundle

## Team

### Developers
Christian Puchinger - puchinger@playboy.de

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require burdanews/twig-extensions-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new HBM\TwigExtensionsBundle\HBMTwigExtensionsBundle(),
        );

        // ...
    }

    // ...
}
```

### Usage

#### Datetime

```twig
{{ datetime|datetime_diff(datetime_to_compare) }}
{{ datetime|datetime_diff(datetime_to_compare, format) }}
```

#### Filter

```twig
{{ 'test  test   test'|token }} => ['test', 'test', 'test']
{{ 1048576|bytes }} => 1024KB
{{ 1048576|bytes(' ') }} => 1024 KB
```

#### Object

```twig
{{ classShort(object) }} => ThisIsTheClassName
{{ classFull(object) }} => Fully\Qualiefied\Path\ThisIsTheClassName
{% if object is instanceof('Fully\\Qualiefied\\Path\\ThisIsTheClassName') %} => true|false
```

#### String

```twig
{{ uuid() }} => asdfadsfasdfasdf
{% if someVar is prefixed(['http://', 'https://']) %} => true|false
```

#### BaseUrl

```twig
{{ imageUrl|baseurlImages }} => http://this.is.the.baseurl/path/to/image.jpg
{{ videoUrl|baseurlVideos }} => http://this.is.the.baseurl/path/to/video.mp4
```
