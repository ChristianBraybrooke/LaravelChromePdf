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

## Options:

It is simple to set options for the PDF.

Just use the 'setOption' or 'setOptions' method.

```sh
ChromePDF::loadHtml('<h1>Hello world</h1>')->setOption('scale', '0.2')->download();
```

Or set multiple options at once.

```sh
ChromePDF::loadHtml('<h1>More options here!</h1>')->setOptions(['scale', 0.2, 'landscape'])->download();
```
All available php-chrome-html2pdf [options](https://github.com/spiritix/php-chrome-html2pdf#options) are available.
