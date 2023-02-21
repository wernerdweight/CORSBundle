CORSBundle
====================================

Symfony bundle that handles cross-origin resource sharing headers.

[![Build Status](https://app.travis-ci.com/wernerdweight/CORSBundle.svg?branch=master)](https://app.travis-ci.com/wernerdweight/CORSBundle)
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

None of the configuration keys are mandatory, default values are mentioned in comments. 

```yaml
# config/packages/cors.yaml
cors:
    access_control:
        # if true, Access-Control-Allow-Credentials header will be present and set to true
        allow_credentials: true # default false
        
        # list of allowed origins (present in Access-Control-Allow-Origin header)
        allow_origin:           # default none
            - '*'               # all origins or list specific origins (see next line)
            - 'https://my-origin.com'
        
        # list of allowed headers (present in Access-Control-Allow-Headers header)
        allow_headers:          # default none
            - 'Authorization'
            - 'Content-Type'
            - 'Cache-Control'
            - 'X-Requested-With'
        
        # list of exposed headers (present in Access-Control-Expose-Headers header)
        expose_headers:         # default none
            - 'Content-Disposition'
    
    # list of controllers to target
    target_controllers:         # default 'WernerDweight\CORSBundle\Contrtoller\CORSControllerInterface'
        - '*'                   # all controllers or list specific controllers (see next line)
        - 'My\Controller\SomeInterface'
        - 'Vendor\Bundle\Controller\SomeOtherInterface'
```

### Target controllers

All controllers that implement `WernerDweight\CORSBundle\Controller\CORSControllerInterface` will be targeted automatically (no configuration required).

If you can't modify the controller (e.g. it's vendor code), you can specify an interface implemented by the vendor controller (be aware that it may also be implemented by some other controllers), or specify the class of the controller itself.

If you want to target all controllers, use `*` as configuration value for `target_controllers`.

Usage
------------

Use your API as usual, your preconfigured headers will be present in the response for specified controllers.

### Events

The following events are dispatched, so you can hook in the process. For general info on how to use events, please consult the [official Symfony documentation](https://symfony.com/doc/current/event_dispatcher.html).

**PreflightRequestInterceptedEvent (`wds.cors_bundle.preflight_request_intercepted`)** \
Issued before the response for preflight request is returned. Contains the request and response. You may want to update the response with some arbitrary headers or replace it completely (the default response is a simple `200: OK` response with configured headers).

**GetResponseHeadersEvent (`wds.cors_bundle.get_response_headers`)** \
Issued before the response headers are set to the response. Contains the request and headers (array). You may want to set some custom headers.

License
-------
This bundle is under the MIT license. See the complete license in the root directiory of the bundle.
