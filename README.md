# Validate states and provinces for USA and Canada with Laravel 5
[![Latest Version](https://img.shields.io/github/release/tylercd100/laravel-validator-state.svg?style=flat-square)](https://github.com/tylercd100/laravel-validator-state/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/tylercd100/laravel-validator-state.svg?branch=master)](https://travis-ci.org/tylercd100/laravel-validator-state)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tylercd100/laravel-validator-state/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/laravel-validator-state/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tylercd100/laravel-validator-state/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/laravel-validator-state/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/tylercd100/laravel-validator-state.svg?style=flat-square)](https://packagist.org/packages/tylercd100/laravel-validator-state)

## Installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require laravel-validation-rules/state
```

Now add the following to the `providers` array in your `config/app.php`
```php
LVR\State\ServiceProvider::class
```

## Usage

```php
# USA vs Canada
Validator::make(['test' => 'UT'], ['test' => 'state']); //true
Validator::make(['test' => 'UT'], ['test' => 'state:usa']); //true
Validator::make(['test' => 'BC'], ['test' => 'state:canada']); //true

# Abbreviation vs Full
Validator::make(['test' => 'Utah'], ['test' => 'state:full']); //true
Validator::make(['test' => 'UT'], ['test' => 'state:abbr']); //true

# Mix and match
Validator::make(['test' => 'UT'], ['test' => 'state:usa,abbr']); //true
Validator::make(['test' => 'Alberta'], ['test' => 'state:canada,full']); //true
```
