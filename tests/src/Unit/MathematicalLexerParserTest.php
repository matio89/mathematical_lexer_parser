<?php

namespace Drupal\Tests\mathematical_lexer_parser\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\mathematical_lexer_parser\MathematicalLexerParserService;
use Drupal\Tests\UnitTestCase;

/**
 * Class MathematicalLexerParserTest
 * @package Drupal\Tests\mathematical_lexer_parser\Unit
 */
class MathematicalLexerParserTest extends UnitTestCase
{
    /**
     * Mathematical lexer parser.
     *
     * @var \Drupal\mathematical_lexer_parser\MathematicalLexerParserService
     */
    protected $mathematicalLexerParser;


    /**
     * The dependency injection container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container;

    /**
     * Setup the variables.
     */
    public function setUp()
    {

        $mathematicalLexerParser = new MathematicalLexerParserService();

        $container = new ContainerBuilder();
        $container->set('mathematical_lexer_parser.default', $mathematicalLexerParser);

        $this->mathematicalLexerParser = $mathematicalLexerParser;

    }


    /**
     * Data Provider all expressions with result.
     * @return array
     */
    public function expressionsDataProvider()
    {
        return [
            [2, '1+1'],
            [21, '1+2*5*2'],
            [8, '3*3+1-2'],
            [0, '3/3+1-2'],
            [25, '4+5+8*2']

        ];
    }

    /**
     * Test if expressions are equals with result.
     * @param $output
     * @param $expression
     * @dataProvider  expressionsDataProvider
     */
    public function testCalculateExpression($expected, $expression)
    {
        $this->assertEquals($expected, $this->mathematicalLexerParser->calculate($expression));
    }

}