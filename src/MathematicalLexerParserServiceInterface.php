<?php

namespace Drupal\mathematical_lexer_parser;

/**
 * Interface MathematicalLexerParserServiceInterface.
 */
interface MathematicalLexerParserServiceInterface {

    /**
     * Mathematical expression.
     * @param $expression
     * @return mixed
     */
    public function calculate($expression);

    /**
     * Converts infix notation to reverse polish notation
     * @param $rpnexp
     * @return mixed
     */
    public function calculate_rpn($rpnexp);

    public function is_operator($char);

    public function mathexp_to_rpn($mathexp);


    public function is_number($char);

    public function read_number($string, $i);

}
