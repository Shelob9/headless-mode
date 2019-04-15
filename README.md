
A helper plugin for putting WordPress in "headless mode". Designed for when WordPress is the CMS for a headless/ decoupled WordPress site.

## What This Plugin Does
This plugin blocks all requests to a WordPress site accept for:

* wp-admin
* The WordPress REST API
* wp-cron (debatable)
* [WP GraphQL](https://www.wpgraphql.com/)

This is largely based on a code snippet from Jason Bahl of WP GraphQL. 

https://gist.github.com/jasonbahl/5dd6c046cd5a5d39bda9eaaf7e32a09d

## How To Use This Plugin

1. Set hte constant `HEADLESS_MODE_CLIENT_URL` to the URL for the front-end client
2. Activate plugin.
3. Profit

## Install With Composer
```json

{
  "minimum-stability": "dev",
  "repositories": [
    {
      "type": "git",
      "url": "git@github.com:Shelob9/headless-mode.git"
    }
  ],
  "require": {
    "shelob9/headless-mode": "*"
  },
  "extra": {
    "wordpress-plugin": "wp-content/plugins/{$name}",
    "wordpress-theme": "wp-content/themes/{$name}",
    "wordpress-muplugin": "wp-content/mu-plugins/{$name}"
  }
}

```
