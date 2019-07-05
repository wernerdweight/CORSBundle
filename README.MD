CORSBundle
====================================

Symfony bundle that handles cross-origin resource sharing headers.

[![Build Status](https://travis-ci.org/wernerdweight/CORSBundle.svg?branch=master)](https://travis-ci.org/wernerdweight/CORSBundle)
[![Latest Stable Version](https://poser.pugx.org/wernerdweight/cors-bundle/v/stable)](https://packagist.org/packages/wernerdweight/cors-bundle)
[![Total Downloads](https://poser.pugx.org/wernerdweight/cors-bundle/downloads)](https://packagist.org/packages/wernerdweight/cors-bundle)
[![License](https://poser.pugx.org/wernerdweight/cors-bundle/license)](https://packagist.org/packages/wernerdweight/cors-bundle)


Installation
------------

### 1. Download using composer

```bash
composer require wernerdweight/cors-bundle
```

### 2. Enable the bundle

Enable the bundle in your kernel:

```php
    <?php
    // config/bundles.php
    return [
        // ...
        WernerDweight\CORSBundle\CORSBundle::class => ['all' => true],
    ];
```

Configuration
------------

TODO:

Usage
------------

TODO:

License
-------
This bundle is under the MIT license. See the complete license in the root directiory of the bundle.
