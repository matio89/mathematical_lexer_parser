# Mathematical Lexer Parser Module

This module allows to provide a simple (plus / minus / multiplication / division) mathematical Lexer and Parser service and text formatter.
When you install the module, you will have a new Text Formatter named Mathematical text formatter.

## Installation
No special requirements to install this module.


### Composer
If your site is [managed via Composer](https://www.drupal.org/node/2718229), use Composer to
download the module.:
   ```sh
   composer require "drupal/mathematical_lexer_parser"
   ```   
###  Unit Tests 
A simple unit test with a data provider (@dataProvider) that tests the tokenization (lexing) and parsing of a few computations.

To run unit tests( PHPUnit 6.5.14 ) : 
   ```sh
   ./vendor/bin/phpunit -c core/ --testsuite unit --filter MathematicalLexerParserTest
   ```