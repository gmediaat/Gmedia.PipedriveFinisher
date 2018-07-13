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

# Finisher

More information about the available options can be found at the [official Pipedrive documentation](https://developers.pipedrive.com/docs/api/v1/).
The response, if successful, will be passed back to the form context with key `Pipedrive.{FINISHER}`, 
e.g. `Pipedrive.OrganizationFinisher` and will enable you to use the ID. For instance, you can create an organization first
and use the ID to contact the person to the organization. 

A full stack example with use of all finishers in connection can be found 
[here](https://github.com/gmediaat/Gmedia.PipedriveFinisher/tree/1.0/Examples/full-stack-example.yaml).

## Organization

```
finisher:  
  -
    identifier: 'Gmedia.PipedriveFinisher:OrganizationFinisher'
    options:
      name: ''
      owner_id: ''
      visible_to: ''
      add_time: ''
```

## Person

```
finisher:  
  -
    identifier: 'Gmedia.PipedriveFinisher:PersonFinisher'
    options:
      name: ''
      owner_id: ''
      org_id: ''
      email: ''
      phone: ''
      visible_to: ''
      add_time: ''
```

## Deal

```      
finisher:  
  -
    identifier: 'Gmedia.PipedriveFinisher:DealFinisher'
    options:
      title: "{name}'s Deal'"
      value: ''
      currency: ''
      user_id: ''
      person_id: "{Pipedrive.PersonFinisher.ID}"
      org_id: "{Pipedrive.OrganizationFinisher.ID}"
      stage_id: ''
      status: ''
      probability: ''
      lost_reason: ''
      add_time: ''
      visible_to: ''
```

## Note

```      
finisher:  
  -
    identifier: 'Gmedia.PipedriveFinisher:NoteFinisher'
    options:
      content: ''
      person_id: ''
      org_id: ''
      deal_id: ''
      add_time: ''
      pinned_to_deal_flag: ''
      pinned_to_organization_flag: ''
      pinned_to_person_flag: ''
```

## Activity
```
finisher:
  -
    identifier: 'Gmedia.PipedriveFinisher:ActivityFinisher'
    options:
      subject: ''
      done: false
      type: ''
      due_date: ''
      duration: ''
      user_id: ''
      deal_id: ''
      person_id: ''
      participants: ''
      org_id: ''
      note: ''
```  

### General Options

A explanation of options, which occur on every entity:

* **owner_id**: the ID of the Pipedrive user, who should be marked as owner. 
    Normally it should be left out, then the user linked to the API token will be set automatically.
* **visible_to**: defines, who should be able to see the entry. `1` will make the entry
    available to only the owner and the followers, `3` will make it available to the whole company.
* **add_time**: can normally be left out, default is the time at creation. 
    But if you want to define another time for whatever reason, this option is interesting for you.
    
