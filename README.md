Pipedrive Finisher for Neos.Form
=========

This package enables you to send data from a form in Neos to the Pipedrive CRM, so you can create persons, organizations or deals from the data submitted by the user.

# Installation

```bash
composer require --no-update gmedia/pipedrivefinisher
```

If you use the new NodeType based form builder you
will also like to add the NodeType based finisher:

```bash
composer require --no-update gmedia/pipedrivefinisher-nodetypes
```

After adding the requirement to your composer.json you can update your composer.lock and install the plugin.

```bash
composer update
```

## Configuration

In order to be able to send data to your Pipedrive account, 
you'll need to define your company domain and API token
in your configuration file.

```yaml
Gmedia:
  PipedriveFinisher:
    Api:
      Domain: ''
      Token: ''
```
