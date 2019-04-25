<?php

namespace Drupal\mathematical_lexer_parser;


/**
 * Class MathematicalLexerParserService.
 */
class MathematicalLexerParserService implements MathematicalLexerParserServiceInterface
{

    /**
     * Calculate the result of an expression.
     * Mathematical expression.
     * @param $expression
     * @return mixed
     */
    public function calculate($expression)
    {
        // calculates the result of an expression in infix notation
        return $this->calculate_rpn($this->mathexp_to_rpn($expression));
    }


    /**
     * Converts infix notation to reverse polish notation
     * @param $rpnexp
     * @return mixed
     */
    function calculate_rpn($rpnexp)
    {
        $stack = [];
        foreach ($rpnexp as $item) {
            if ($this->is_operator($item)) {
                if ($item == '+') {
                    $j = array_pop($stack);
                    $i = array_pop($stack);
                    array_push($stack, $i + $j);
                }
                if ($item == '-') {
                    $j = array_pop($stack);
                    $i = array_pop($stack);
                    array_push($stack, $i - $j);
                }
                if ($item == '*') {
                    $j = array_pop($stack);
                    $i = array_pop($stack);
                    array_push($stack, $i * $j);
                }
                if ($item == '/') {
                    $j = array_pop($stack);
                    $i = array_pop($stack);
                    array_push($stack, $i / $j);
                }
                if ($item == '%') {
                    $j = array_pop($stack);
                    $i = array_pop($stack);
                    array_push($stack, $i % $j);
                }
            } else {
                array_push($stack, $item);
            }
        }
        return $stack[0];
    }

    /**
     * @param $char
     * @return bool
     */
    function is_operator($char)
    {
        static $operators = ['+', '-', '/', '*', '%'];
        return in_array($char, $operators);
    }

    /**
     * @param $mathexp
     * @return array
     */
    function mathexp_to_rpn($mathexp)
    {
        $precedence = [
            '(' => 0,
            '-' => 3,
            '+' => 3,
            '*' => 6,
            '/' => 6,
            '%' => 6
        ];

        $i = 0;
        $final_stack = [];
        $operator_stack = [];

        while ($i < strlen($mathexp)) {
            $char = $mathexp{$i};
            if ($this->is_number($char)) {

                $num = $this->read_number($mathexp, $i);
                array_push($final_stack, $num);
                $i += strlen($num);
                continue;
            }
            if ($this->is_operator($char)) {
                $top = end($operator_stack);
                if ($top && $precedence[$char] <= $precedence[$top]) {
                    $oper = array_pop($operator_stack);
                    array_push($final_stack, $oper);
                }
                array_push($operator_stack, $char);
                $i++;
                continue;
            }
            if ($char == '(') {
                array_push($operator_stack, $char);
                $i++;
                continue;
            }
            if ($char == ')') {
                // transfer operators to final stack
                do {
                    $operator = array_pop($operator_stack);
                    if ($operator == '(') break;
                    array_push($final_stack, $operator);
                } while ($operator);
                $i++;
                continue;
            }
            $i++;
        }
        while ($oper = array_pop($operator_stack)) {
            array_push($final_stack, $oper);
        }
        return $final_stack;

    }

    /**
     * @param $string
     * @param $i
     * @return string
     */
    function read_number($string, $i)
    {
        $number = '';
        while ($i < strlen($string) && $this->is_number($string{$i})) {
            $number .= $string{$i};
            $i++;
        }
        return $number;
    }

    /**
     * @param $char
     * @return bool
     */
    function is_number($char)
    {
        return (($char == '.') || ($char >= '0' && $char <= '9'));
    }
}
