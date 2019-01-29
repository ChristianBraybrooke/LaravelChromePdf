# Laravel PHP Chrome HTML to PDF

## Installation
```sh
composer require chrisbraybrooke/laravel-chrome-pdf
```

## Setup:
**Laravel >=5.5**

Laravel 5.5 and above uses package autodiscovery so you are **All Done!**. Skip to [usage](#usage)

**Laravel 5.5<**

If you are using Laravel 5.4 or below, you will have to manually register the package. After updating composer, add the ServiceProvider to the providers array in config/app.php
```sh
ChrisBraybrooke\LaravelChromePdf\ServiceProvider::class,
```
And optionally add the Facade.
```sh
'ChromePDF' => ChrisBraybrooke\LaravelChromePdf\ChromePDF::class,
```

## Usage:

Below is an example of creating a simple PDF from a view / blade file.

```sh
<?php

namespace App\Http\Controllers;

use ChromePDF;

class InvoicesController {

    /**
     * Download a PDF version of the invoice.
     *
     * @return void
     */
    public function show()
    {
        ChromePDF::loadView('invoice')
            ->a4()
            ->landscape()
            ->download();
    }
}
```
