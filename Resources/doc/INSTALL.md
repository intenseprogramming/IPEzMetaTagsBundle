Intense Programming Ez Meta Tags Bundle installation instructions
============================================

Requirements
------------

* eZ Publish 5.4+ / eZ Publish Community Project 2014.11+

### Note

Intense Programming Ez Meta Tags Bundle 1.0 has to this date only been tested with the currently latest 2014.11 release (2014.11.8).

Installation steps
------------------

### Use Composer

Add the following to your composer.json and run `php composer.phar update intenseprogramming/ezmetatagsbundle` to refresh dependencies:

```
"require": {
    "intenseprogramming/ezmetatagsbundle": "0.9.0"
}
```

### Activate the bundle

Activate the bundle in `ezpublish/EzPublishKernel.php` file.

```
use IntenseProgramming\EzMetaTagsBundle\IntenseProgrammingEzMetaTagsBundle;

...

public function registerBundles()
{
   $bundles = array(
       ...
       new IntenseProgrammingEzMetaTagsBundle()
       ...
   );

   ...
}
```

### Clear the caches

Clear eZ Publish 5/4 caches.

```
php ezpublish/console cache:clear
```

### Use the bundle

1) You can now load and create content with `ipezmetatags` field type

2) Call the bundle `MetaTags`-controller inside your head-section to display the meta-tags.

`{{ render(controller('IntenseProgrammingEzMetaTagsBundle:MetaTags:render', {'contentId': content.id})) }}`
