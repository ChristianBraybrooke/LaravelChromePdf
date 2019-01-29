# Laravel PHP Chrome HTML to PDF

## Installation
```sh
composer require chrisbraybrooke/laravel-chrome-pdf
```

## Setup:
**Laravel 5.5 <**

If you are using Laravel 5.4 or below, you will have to manually register the package. After updating composer, add the ServiceProvider to the providers array in config/app.php
```sh
ChrisBraybrooke\\LaravelChromePdf\\ServiceProvider::class,
```
And optionally add the Facade.
```sh
'ChromePDF' => ChrisBraybrooke\\LaravelChromePdf\\ChromePDF::class,
```
