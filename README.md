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
```php
ChrisBraybrooke\LaravelChromePdf\ServiceProvider::class,
```
And optionally add the Facade.
```php
'ChromePDF' => ChrisBraybrooke\LaravelChromePdf\ChromePDF::class,
```

## Usage:

Below is an example of creating a simple PDF from a view / blade file.

```php
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

## Outputs:

**There are several methods of outputting the PDF.**

Of course `download`

```php
ChromePDF::loadView('invoice')->download("invoice-{$ref}.pdf");
```

Use `inline` to show the PDF inline in the browser.

```php
ChromePDF::loadView('invoice')->inline();
```

Or `save` to save the file to the filesystem. The first argument is the filename / path - and the second is the disk to be used.

```php
ChromePDF::loadView('invoice')->save("invoice-{$ref}.pdf", 's3');
```


## Options:

It is simple to set options for the PDF.

Just use the `setOption` or `setOptions` methods.

```php
ChromePDF::loadHtml('<h1>Hello world</h1>')->setOption('scale', '0.2')->download();
```

Or set multiple options at once.

```php
ChromePDF::loadHtml('<h1>More options here!</h1>')->setOptions(['scale', 0.2, 'landscape'])->download();
```
<small>All available php-chrome-html2pdf [options](https://github.com/spiritix/php-chrome-html2pdf#options) are available.</small>

There are also a few helper methods, which can be chained.

```php
ChromePDF::loadHtml('<h1>Hello world</h1>')
    // a3 & a5 also available - pass true to set as landscape.
    ->a4()
    // Set the orientation as landscape - default is portrait.
    ->landscape()
    // Load a blade template for the page headers.
    ->headerView('default-header')
    // Load a blade template for the page footers.
    ->footerView('default-footer')
    ->download();
```
