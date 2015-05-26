ZF2's Harmony module
====================

This package contains a module that connects the Harmony user interface to the Zend Framework 2 PHP framework.

Step 1: Download the Module
---------------------------

Include the package in your **composer.json**:

**composer.json**
```
{
  "require-dev": {
    "harmony/harmony": "~1.0",
    "harmony/zf2-module": "~1.0"
  }
}
```

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer update
```

Step 2: Register the ZF2 module with Harmony
--------------------------------------------

Now, create a **modules.php** file at the root of your package and instantiate
the ZF2 module:

**modules.php**
```php
<?php
return [
    new Harmony\Module\ZF2Module\ZF2Module()
];
```

You are done! Now, start Harmony. Harmony modules should be able to detect your ZF2 services and act accordingly!
