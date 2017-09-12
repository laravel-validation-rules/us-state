# State

Validate US States and Canada Provinces

<p >
  <a href="https://travis-ci.org/laravel-validation-rules/us-state">
    <img src="https://img.shields.io/travis/laravel-validation-rules/us-state.svg?style=flat-square">
  </a>
  <a href="https://scrutinizer-ci.com/g/laravel-validation-rules/us-state/code-structure/master/code-coverage">
    <img src="https://img.shields.io/scrutinizer/coverage/g/laravel-validation-rules/us-state.svg?style=flat-square">
  </a>
  <a href="https://scrutinizer-ci.com/g/laravel-validation-rules/us-state">
    <img src="https://img.shields.io/scrutinizer/g/laravel-validation-rules/us-state.svg?style=flat-square">
  </a>
  <a href="https://github.com/laravel-validation-rules/us-state/blob/master/LICENSE">
    <img src="https://img.shields.io/github/license/laravel-validation-rules/us-state.svg?style=flat-square">
  </a>
  <a href="https://twitter.com/tylercd100">
    <img src="http://img.shields.io/badge/author-@tylercd100-blue.svg?style=flat-square">
  </a>
</p>

## Installation

```bash
composer require laravel-validation-rules/us-state
```

## Usage

```php
use LVR\State\Abbr;
use LVR\State\Full;

# Abbreviation vs Full
$request->validate(['test' => 'UT'], ['test' => new Abbr]); // Pass!
$request->validate(['test' => 'BC'], ['test' => new Abbr); // Pass!
$request->validate(['test' => 'Utah'], ['test' => new Full]); // Pass!
$request->validate(['test' => 'Alberta'], ['test' => new Full]); // Pass!

# Abbreviation - USA vs Canada
$request->validate(['test' => 'UT'], ['test' => new Abbr]); // Pass!
$request->validate(['test' => 'UT'], ['test' => new Abbr('US')]); // Pass!
$request->validate(['test' => 'BC'], ['test' => new Abbr('CA')); // Pass!

# Full - USA vs Canada
$request->validate(['test' => 'Utah'], ['test' => new Full('US')]); // Pass!
$request->validate(['test' => 'Alberta'], ['test' => new Full('CA')]); // Pass!
```
