# Laravel Dev Helpers

Laravel helpers for quick development.
<small style="color: gray;">v1.0.0</small>

> ###### Part of mphpmaster/laravel-helpers:^3

## Dependencies:
* php >=8.1 **REQUIRED IN YOUR PROJECT**
* laravel >=9 **REQUIRED IN YOUR PROJECT**
* illuminate/support >=9 _composer will install it automaticly_
* laravel/helpers ^1.5 _composer will install it automaticly_

## Installation:
  ```shell
  composer require mphpmaster/laravel-dev-helpers
  ```

## Content:
- Functions:
  - `hasDeveloper`
  - `getDeveloper`
  - `isDeveloper`
  - `isDeveloperMode`
  - `returnCallable`
  - `returnClosure`
  - `returnArgs`
  - `returnString`
  - `returnArray`
  - `returnCollect`
  - `returnNull`
  - `returnTrue`
  - `returnFalse`
  - `isCommandExists`
  - `getSql`
  - `unauthenticated`
  - `throwUnauthenticated`
  - `logout`
  - `login`
  - `isLoggedIn`
  - `isGuest`
  - `notifyWhenTerminating`
  - `real_path`
  - `fromCallable`
  - `getDumpOutput`
  - `_gcm`
  - `_gc`
  - `_ce`
  - `bindTo`
  - `getClassPropertyValue`
  - `getMethodName`

---

## <span style="color: red;">To add:</span>
  - Add `developer` key to `config/app.php`  
  - Add `dev_mode` key to `config/app.php`  

```php
// example:
return [
//  ...
    'dev_mode' => env('DEV_MODE', false),
    'developer' => env('DEVELOPER', 'safadi'),
//  ...
];
```

---

## To do:
  - add `dump` helper to print file path and line. 
  - add `d` helper to print file path and line.

> *Inspired by laravel/helpers.*

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

These Helpers are open-sourced software licensed under the [MIT license](https://github.com/mPhpMaster/laravel-dev-helpers/blob/master/LICENSE).
