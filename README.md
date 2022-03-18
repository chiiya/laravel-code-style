<br />
<div align="center">
  <p align="center">
    <a href="https://php.net/" target="_blank"><img src="https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg"></a>
  </p>

  <strong>
    <h2 align="center">Laravel Code Style</h2>
  </strong>

  <p align="center">
      Code style configurations for Laravel projects using a combination of PHP-CS-Fixer, ECS and Rector. 
  </p>

  <a href="https://packagist.org/packages/chiiya/laravel-code-style">
    <img src="https://img.shields.io/packagist/v/chiiya/laravel-code-style.svg?style=flat-square" alt="Latest Version on Packagist">
  </a>
  <a href="https://github.com/chiiya/laravel-code-style/actions?query=workflow%3Alint+branch%3Amaster">
    <img src="https://img.shields.io/github/workflow/status/chiiya/laravel-code-style/lint?label=code%20style" alt="GitHub Code Style Action Status">
  </a>
  <a href="https://packagist.org/packages/chiiya/laravel-code-style">
    <img src="https://img.shields.io/packagist/dt/chiiya/laravel-code-style.svg?style=flat-square" alt="Total Downloads">
  </a>

  <p align="center">
    <strong>
    <a href="#index">index</a>
    &nbsp; &middot; &nbsp;
    <a href="#installation">installation</a>
    &nbsp; &middot; &nbsp;
    <a href="#usage">usage</a>
    </strong>
  </p>

  <br>
</div>
<br />

## Index

<pre>
<a href="#installation"
>> Installation ..................................................................... </a>
<a href="#usage"
>> Usage ............................................................................ </a>
</pre>

## Installation

Install the package using composer. When prompted to create a GrumPHP configuration file, choose "No".

```bash
composer require chiiya/laravel-code-style --dev
```

## Usage

```bash
# Publish config files
php artisan vendor:publish --tag="code-style-config"
```

Next, adjust the `ecs.php`, `.php-cs-fixer.dist.php`, `rector.php` and `phpstan.neon` files 
that have just been created in your project folder to suit your project structure.

After publishing the configuration files, you may have to re-initialize GrumPHP:

```bash
php ./vendor/bin/grumphp git:deinit
php ./vendor/bin/grumphp git:init
```

The GrumPHP config includes tasks for PHP-CS-Fixer, ECS and TLint by default. Tasks for `rector`
and `phpstan` are not included, since they can take a long time. You may choose to execute them
separately instead (for example, in a CI pipeline), or add them to your GrumPHP config if you're 
fine with the longer waiting times:

```yaml
# Add new entries in grumphp.tasks (grumphp.yml)
    rector: ~
    phpstan: ~
```
