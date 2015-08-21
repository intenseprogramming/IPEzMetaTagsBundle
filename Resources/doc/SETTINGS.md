Intense Programming Ez Meta Tags Bundle configuration instructions
============================================

The settings for this bundle behave the same way the default ezpublish-settings do.

To adjust the configuration for you needs, you may add the `intense_programming_ez_meta_tags`-section to your `config.yml`/`ezpublish.yml`.

Template
------------

You may overwrite the default-template (`meta_tags.html.twig`) if this one does not fit your needs.

```
intense_programming_ez_meta_tags:
    system:
        eng_gb:
            template: FooBundle:head:metatags.html.twig
```

The template will always have the following variables:

* location (`eZ\Publish\API\Repository\Values\Content\Location`)
* content (`eZ\Publish\API\Repository\Values\Content\Content`)
* type (`string`)

The following variables depend on the content and should always be checked:

* description (`{content: eZ\Publish\API\Repository\Values\Content\Content, field: <string>}`)
* image (`{url: <string>}`)

Image alias
------------

By default this bundle will use the `large`-alias delivered with eZ Publish.

However, if you have this alias removed from your configuration or want to use another alias for sharing (e.g. on facebook) you may want to change this setting.

```
intense_programming_ez_meta_tags:
    system:
        eng_gb:
            image_alias: your-alias
```
