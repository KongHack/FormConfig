# GCWorld FormConfig

FormConfig is a PHP library for defining forms as objects and rendering them
with Twig. It provides reusable field types, repeatable field arrays, model and
ORM metadata helpers, read-only transformations, configurable CSRF tokens, and
a generated fluent field builder.

FormConfig renders form markup but does not persist submitted values or replace
application-level validation and authorization.

### Version
3.11.23

## Requirements

- PHP 8.4 or newer
- Composer 2
- Twig 3
- A consumer-provided Bootstrap 3 frontend stack

Bootstrap 3 is currently the only implemented rendering mode. A Bootstrap 5
constant exists for future compatibility, but no Bootstrap 5 templates are
registered or shipped.

## Installation

Install the package from Packagist:

```console
composer require gcworld/formconfig
```

The Composer `post-autoload-dump` hook performs two setup tasks:

1. It creates `config/GCWorld_FormConfig.yml` in the consuming project when the
   file does not already exist.
2. It discovers the available field classes and generates the field registry
   and fluent builder under `src/Generated/` in the installed package.

Run `composer dump-autoload` after registering custom field groups or adding a
field class so the generated registry is refreshed.

## Basic usage

```php
<?php

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\Forms\FormConfig;

$form = (new FormConfig())
    ->setName('profile')
    ->setFormId('profile-form')
    ->setRenderForm('details')
    ->setRenderForms(['details' => 'Profile details'])
    ->setRenderUrlForm('/profile/details');

$form->getBuilder()
    ->createTextInput('display_name')
    ->setLabel('Display name')
    ->setValue('Ada Lovelace')
    ->setReqLevel(2);

$form->getBuilder()
    ->createSelectInput('timezone')
    ->setLabel('Time zone')
    ->setOptions([
        'America/Detroit' => 'Eastern Time',
        'America/Chicago' => 'Central Time',
    ]);

echo Twig::render(
    '@form_config_BS3/forms/controller.twig',
    $form->getTwigArray(),
);
```

Fields can also be created generically when the type is selected dynamically:

```php
use GCWorld\FormConfig\Fields\TextArea;

$form->createField('notes')
    ->setType(TextArea::getKey())
    ->setLabel('Notes');
```

The generated builder is preferable for normal application code because it
provides discoverable methods for every registered field type.

## Using an existing Twig environment

Applications that already own a Twig environment can register FormConfig's
paths, functions, and tests directly:

```php
use GCWorld\FormConfig\Core\Twig as FormConfigTwig;

FormConfigTwig::mapAll($twigEnvironment);

echo $twigEnvironment->render(
    '@form_config_BS3/forms/controller.twig',
    $form->getTwigArray(),
);
```

`mapAll()` attaches the `@form_config_BS3` namespace when the environment uses
Twig's `FilesystemLoader`. Custom form templates can be selected with
`FormConfig::setTwigTemplate()`.

## Values, requirements, and errors

Values, required levels, and validation errors can be applied by field name:

```php
$form->setValues([
    'display_name' => 'Ada Lovelace',
    'timezone' => 'America/Detroit',
]);

$form->setRequirements([
    'display_name' => 2,
]);

$form->setErrors([
    'display_name' => 'Display name is required.',
    'form' => 'The form could not be saved.',
]);
```

Requirement level `0` suppresses a field, level `1` renders an optional field,
and values greater than `1` render the configured required indicator.
Errors whose keys do not match a field are rendered as unattributed form errors.

`setValuesFromObject()` reads matching getters and legacy model metadata.
`setPropertiesFromObject()` integrates with `gcworld/interfaces` ORM description
objects when that optional model layer is available.

Call `makeReadOnly()` to convert supported fields to their non-editable
representation before rendering.

## Repeatable field arrays

`createFieldArray()` creates table, div, or Ionic-style groups containing one or
more rows:

```php
$items = $form->createFieldArray('items');
$items->addHeader('Description', 'col-sm-8');
$items->addHeader('Quantity', 'col-sm-4');

$items->createField('description')->setLabel('Description');
$items->createField('quantity')->setLabel('Quantity');

$items->bumpIndex();
$items->createField('description')->setLabel('Description');
$items->createField('quantity')->setLabel('Quantity');
```

## Configuration

The installed `config/GCWorld_FormConfig.yml` supports these sections:

```yaml
general:
  formMode: 'BS3'
  holdOn: false
  holdOnOptions: "HoldOnOptions"
  requiredIndicator: 2

debugging:
  enabled: false
  userCheckMethod: "\\App\\Debug\\FormDebug::isAllowed"

csrf:
  enabled: false
  tokenNameMethod: "\\App\\Security\\Csrf::getTokenName"
  tokenValueMethod: "\\App\\Security\\Csrf::getTokenValue"
```

The optional `forms` section registers additional namespaces and directories
containing custom `FieldInterface` implementations. Its directories are resolved
relative to the consuming project during code generation.

Configuration is cached in process-level singletons. Applications using
long-lived PHP workers should restart workers after changing FormConfig
configuration.

## CSRF responsibility

When CSRF is enabled and both token callbacks are configured, a hidden token
field is added to each new form. The consuming application must still validate
the submitted request:

```php
use GCWorld\FormConfig\Core\CSRFController;

CSRFController::get()->doCheck();
```

FormConfig does not call `doCheck()` automatically. Applications remain
responsible for invoking it at the correct point in their request lifecycle and
handling `CSRFNotEnabledException` or `CSRFRequestFailedException`.

## Browser dependencies

Frontend assets are intentionally not installed through Composer. Consumers
must load the dependencies required by the field types they use.

| Dependency | Used by |
| --- | --- |
| Bootstrap 3 | Form layout, panels, validation states, tables, buttons, and responsive classes |
| jQuery | All templates that emit interactive JavaScript |
| Select2 and a Bootstrap-compatible Select2 theme | Normal, HTML, grouped, and Ajax select fields |
| CKEditor exposing the global `CKEDITOR` API | `CKEditor` and `CKEditorFull` fields |
| Bootstrap Datepicker or a compatible `$.fn.datepicker` plugin | Date fields |
| Spectrum or a compatible `$.fn.spectrum` plugin | Color picker fields |
| Font Awesome | Help and navigation icons |
| HoldOn | Optional submit/loading overlays and Ajax-once loading overlays |

Exact asset versions are controlled by the consuming application. Before
upgrading one of these libraries, verify the emitted initialization options and
events against the FormConfig field types used by that application.

Several extension points intentionally render trusted strings with Twig's
`raw` filter, including HTML fields, labels, notices, headings, hooks, option
content, and submit-button overrides. Do not pass untrusted content to these
APIs without sanitizing it first.

The templates emit inline scripts. Applications enforcing Content Security
Policy must account for those scripts or override the affected templates.

## Local development

The supported local environment uses the public KongHack PHP 8.4 image:

```console
./dc up -d
./dc exec php composer install
./dc exec php composer check
./dc down
```

The committed Compose configuration mounts only this repository. It does not
expose host SSH keys, Composer credentials, or host account databases to the
container. Developers who require private Composer authentication can copy
`docker-compose.override.yml.example` to the ignored
`docker-compose.override.yml`. The override exposes credentials to container
processes and should only be enabled when it is genuinely required.

Individual quality commands are also available:

```console
./dc exec php composer lint
./dc exec php composer phpstan
./dc exec php composer phpcs
./dc exec php composer test
```

PHPStan is enforced at level 6. PHPCS enforces PSR-12 errors; advisory warnings
such as line length do not fail the build.

## Releases

Releases use bare semantic-version tags such as `3.11.23`. Before tagging a
release:

1. Add the release notes to the matching version section in `CHANGELOG.md`.
2. Update `VERSION` and the value immediately below `### Version` in this file.
3. Push the release commit and matching tag.

GitHub Actions validates the release metadata and complete PHP quality matrix
before creating the GitHub Release from `CHANGELOG.md`. Packagist is connected
to this repository and receives the published tag through the existing GitHub
integration.

Release tags must not be moved or reused.

## License

FormConfig is open-source software licensed under the MIT License.
