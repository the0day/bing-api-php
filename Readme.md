# BING AI API

Welcome to the Bing AI API, an open-source project designed for reverse engineering Bing AI without relying on cookie usage. This initiative aims to provide a transparent and privacy-conscious approach to interact with Bing AI's functionalities.

## Latest Stable Version and Downloads

[![Latest Stable Version](http://poser.pugx.org/fakellyh/bing-api-php/v)](https://packagist.org/packages/fakellyh/bing-api-php) [![Total Downloads](http://poser.pugx.org/fakellyh/bing-api-php/downloads)](https://packagist.org/packages/fakellyh/bing-api-php) [![Latest Unstable Version](http://poser.pugx.org/fakellyh/bing-api-php/v/unstable)](https://packagist.org/packages/fakellyh/bing-api-php) [![License](http://poser.pugx.org/fakellyh/bing-api-php/license)](https://packagist.org/packages/fakellyh/bing-api-php) [![PHP Version Require](http://poser.pugx.org/fakellyh/bing-api-php/require/php)](https://packagist.org/packages/fakellyh/bing-api-php)

## Installation

For seamless integration, we recommend using Composer:

```bash
composer require fakellyh/bing-api-php
```

## Usage

To get started, add the autoloader to your project:

```php
require_once __DIR__.'/vendor/autoload.php';
```

Now, let's demonstrate how to use the Bing AI API with a simple example. Add the following PHP code to your project:

```php
use Fakell\Bing\Bing;

// Include the Composer autoloader
require __DIR__ . "/vendor/autoload.php";

// Create an instance of the Bing class
$bing = new Bing;


// Make a request to Bing AI
$bing->ask("Hello world!", Tones::CREATIVE);

// Display the response data
$response = $bing->getResponse();
print_r($response);
```
Response example : 
```
Array
(
    [text] => Hello! 🌎
    [author] => bot
    [createdAt] => 2024-04-03T01:03:32.0349726+00:00
    [timestamp] => 2024-04-03T01:03:32.0349726+00:00
    [messageId] => 449951c5-76f4-46d2-becd-5212ee627ff3
    [requestId] => 2fb1546f775cb27d171741ae9cd8195a
    [offense] => None
    [adaptiveCards] => Array
        (
            [0] => Array
                (
                    [type] => AdaptiveCard
                    [version] => 1.0
                    [body] => Array
                        (
                            [0] => Array
                                (
                                    [type] => TextBlock
                                    [text] => Hello! 🌎

                                    [wrap] => 1
                                )

                        )

                )

        )

    [sourceAttributions] => Array
        (
        )

    [feedback] => Array
        (
            [tag] => 
            [updatedOn] => 
            [type] => None
        )

    [contentOrigin] => DeepLeo
    [suggestedResponses] => Array
        (
            [0] => Array
                (
                    [text] => Hi there!
                    [author] => user
                    [createdAt] => 2024-04-03T01:03:33.3900432+00:00
                    [timestamp] => 2024-04-03T01:03:33.3900432+00:00
                    [messageId] => 02ecee3f-b62d-4db2-849c-700fc0b7ef90
                    [messageType] => Suggestion
                    [offense] => Unknown
                    [feedback] => Array
                        (
                            [tag] => 
                            [updatedOn] => 
                            [type] => None
                        )

                    [contentOrigin] => SuggestionChipsFalconService
                )

            [1] => Array
                (
                    [text] => Greetings!
                    [author] => user
                    [createdAt] => 2024-04-03T01:03:33.390047+00:00
                    [timestamp] => 2024-04-03T01:03:33.390047+00:00
                    [messageId] => fd477fca-7a2c-4efe-bcf2-0138c19462b7
                    [messageType] => Suggestion
                    [offense] => Unknown
                    [feedback] => Array
                        (
                            [tag] => 
                            [updatedOn] => 
                            [type] => None
                        )

                    [contentOrigin] => SuggestionChipsFalconService
                )

            [2] => Array
                (
                    [text] => What can I help you with?
                    [author] => user
                    [createdAt] => 2024-04-03T01:03:33.3900483+00:00
                    [timestamp] => 2024-04-03T01:03:33.3900483+00:00
                    [messageId] => 9ce7eaf7-739f-4e79-b57e-acb43872b4c7
                    [messageType] => Suggestion
                    [offense] => Unknown
                    [feedback] => Array
                        (
                            [tag] => 
                            [updatedOn] => 
                            [type] => None
                        )

                    [contentOrigin] => SuggestionChipsFalconService
                )

        )

)

```

## Support

If you encounter any issues or believe there is a problem with this library, please feel free to [open an issue](https://github.com/fakellgit/bing-api-php/issues/new) if one doesn't already exist.

## Author

Nombana Fahendrena FIOMBONANTSOA

- Email: [fakellyh@gmail.com](mailto:fakellyh@gmail.com)
- Facebook: [fakellyh](https://www.facebook.com/fakellyh)

## License

This project is licensed under the  GPL-3.0 license.
