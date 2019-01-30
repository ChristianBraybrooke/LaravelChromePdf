# Laravel PHP Chrome HTML to PDF

## Import note regarding git
If you keep you vendor folder in source control - then you may want to consider placing the following in you `.gitignore` file. The reason for this is that the chromium rendering engine contains files that are larger than GitHubs 100mb limit.

```sh
/vendor/spiritix/php-chrome-html2pdf/node_modules/*
```

## How it works

This library is based on [puppeteer](https://github.com/GoogleChrome/puppeteer), a headless Chrome Node API which is maintained by the Chrome DevTools team.

It provides a simple PHP / Laravel wrapper around the Node API, focused on generating beautiful PDF files.

In contrast to other HTML to PDF converters like [wkhtmltopdf](https://wkhtmltopdf.org/), the corresponding PHP wrapper or similar libraries, it is based on a current Chrome version instead of outdated and unmaintained WebKit builds. This library therefore fully supports CSS3, HTML5, SVGs, SPAs, and all the other fancy stuff people use these days.

## Installation
```sh
composer require chrisbraybrooke/laravel-chrome-pdf
```

## Setup:
**Laravel >=5.5**

Laravel 5.5 and above uses package autodiscovery so you are **all done!** Skip to [Usage](#usage).

**Laravel 5.5<**

If you are using Laravel 5.4 or below, you will have to manually register the package. After updating composer, add the ServiceProvider to the providers array in `config/app.php`.
```php
ChrisBraybrooke\LaravelChromePdf\ServiceProvider::class,
```

And optionally add the Facade.
```php
'ChromePDF' => ChrisBraybrooke\LaravelChromePdf\ChromePDF::class,
```

## Usage:

Below is an example of creating a simple PDF from a blade file.

```php
namespace App\Http\Controllers;

use App\Invoice;
use ChromePDF;

class InvoicesController {

    /**
     * Download a PDF version of the invoice.
     *
     * @return void
     */
    public function show(Invoice $invoice)
    {
        // Load resources/views/invoice.blade.php
        ChromePDF::loadView('invoice', ['invoice' => $invoice])
            ->size('a4')
            ->landscape()
            ->download("invoice-{$invoice->ref}.pdf");
    }
}
```

## Outputs:

**There are several methods of outputting the PDF.**

Of course `download` is available.

```php
ChromePDF::loadView('invoice', ['invoice' => $invoice])->download("invoice-{$ref}.pdf");
```


Use `inline` to show the PDF inline in the browser.

```php
ChromePDF::loadView('invoice', ['invoice' => $invoice])->inline();
```


Or `save` to save the file to the filesystem. The first argument is the filename / path - and the second is the disk to be used.

```php
ChromePDF::loadView('invoice', ['invoice' => $invoice])->save("invoice-{$ref}.pdf", 's3');
```


## Options:

It is simple to set options for the PDF.

Just use the `setOption` or `setOptions` methods.

```php
ChromePDF::loadHtml('<h1>Hello world</h1>')->setOption('scale', '0.2')->download('hello.pdf');
```

Or set multiple options at once.

```php
ChromePDF::loadHtml('<h1>More options here!</h1>')
    ->setOptions(['scale' => 0.2, 'landscape'])
    ->download('options.pdf');
```
<small>All available php-chrome-html2pdf [options](https://github.com/spiritix/php-chrome-html2pdf#options) are available.</small>

There are also a few helper methods, which can be chained.

```php
ChromePDF::loadHtml('<h1>Hello world</h1>')
    // a3 & a5 also available - pass true to set as landscape. Or use size('') and specify a different page size.
    ->a4()
    // Set the orientation as landscape - default is portrait.
    ->landscape()
    // Load a blade template for the page headers.
    ->headerView('default-header')
    // Load a blade template for the page footers.
    ->footerView('default-footer')
    ->download();
```

## Maintenance:

My company [Purple Mountain](https://www.purplemountmedia.com) - A web development company in the UK, will try our best to keep this package up to date and free from any issues.
