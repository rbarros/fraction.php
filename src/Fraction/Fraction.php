<?php namespace Fraction;
/**
 * This file is part of the Nocriz API (http://nocriz.com)
 *
 * Copyright (c) 2013  Nocriz API (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

/**
 * Fraction Library convert decimal to fraction.
 *
 * @package  Math
 * @author   Ramon Barros <contato@ramon-barros.com>
 */

class Fraction {
    
    private $fraction = null;
    private $numerator = null;
    private $denominator = null;
    private $str = null;
    private $k_c_virgula = null;
    private $c_virgula = null;

    public function __construct($num=null) {
        if (!is_null($num)) {
            if ((gettype($num) === "integer" || gettype($num) === "double") and $num > -1) {
                $this->str = (string)$num;
                if (($this->k_c_virgula = strpos($this->str, ".")) !== false) {
                    $this->c_virgula = strlen(substr($this->str, $this->k_c_virgula + 1, strlen($this->str)));
                    // Se contiver mais de 1 casa após o ponto executa
                    // e menos de 9
                    if ($this->c_virgula > 1 && $this->c_virgula < 9) {

                        // Aplica potenciação Exp: 0.175
                        // 3 casas depois do ponto
                        // 0.175 x (10 x 10 x 10) = 175
                        $this->numerator = $num * pow(10, $this->c_virgula);
                        // (10 x 10 x 10) = 1000
                        $this->denominator = pow(10, $this->c_virgula);
                        // 175/1000
                    } else if($this->c_virgula >= 9) {
                        $this->checkDizima($num);
                    } else {
                        // Exp: 0.5
                        // 0.5x10 = 5
                        $this->numerator = $num * 10;
                        // 10
                        $this->denominator = 10;
                        // 5/10
                    }
                } else {
                    $this->numerator = $num;
                    $this->denominator = 1;
                }

                $this->fraction = $this->numtoString();
            } else {
                throw new \Exception("Você deve informar um inteiro ou decimal.");
            }
        }
    }

    public function getFraction() {
        return $this->fraction;
    }

    /**
     * Converte o numeral em fração
     * @return string
     */
    private function numtoString() {
        // Retorna resto da divisão do numerando pelo denominador
        $wholepart = floor($this->numerator / $this->denominator);

        $numerator = ($this->numerator % $this->denominator);
        $denominator = $this->denominator;

        // Verifica se o numerando é divisivel pelo denominador e se o resto é 0
        if ($wholepart > 0 && $numerator === 0) {
            // Exp:
            // 1/1, 2/1 e 3/1
            return ((string)$this->numerator . '/' . (string)$this->denominator);
        }
        if ($numerator > 0) {
            // Verifica se o resto da divisão é igual ao numerando  
            $x = 1;
            while ($x <= $numerator) {
                if (($wholepart === 0) && ($numerator % $this->numerator === 0) && ($this->denominator % $numerator === 0)) {
                    $y = $numerator;
                    break;
                } else if (($numerator % $x === 0) && ($denominator % $x === 0)) {
                    $y = $x;
                }
                $x += 1;
            }
            // Y = menor divisor comum;
            // Exp: 8/100 => 2/25 , 75/100 => 3/4, 5/10 => 1/5 e 6/10 => 3/5
            return ((string)($this->numerator / $y) . '/' . (string)($this->denominator / $y));
        }
    }

    private function checkDizima($num) {
        $string = (string)$num;
        $group = null;
        $string = substr($string, $this->k_c_virgula + 1, strlen($string));
        $group = new Group($string);
        $group = $group->getGroups();
        if (count($group) <= 1 && $this->countGroup($group[0]) === strlen($group[0])) {
            $this->_dizimaSimples($group);
        } else {
            $this->_dizimaComposta($group);
        }
    }

    private function countGroup($string) {
        $cnt = 0;
        for ($x = 0; $x <= strlen($string) - 1; $x += 1) {
            for ($y = 0; $y <= strlen($string) - 1; $y += 1) {
                if ($string{$x} === $string{$y}) { $cnt += 1; }
            }
            break;
        }
        return $cnt;
    }

    private function _dizimaSimples($array) {
        $this->numerator = (int)$array[0][0];
        $this->denominator = strlen($array[0]);
    }

    private function _dizimaComposta($array) {
        $ant= null;
        $cant = "";
        $per = null;
        $cper = "";
        $g = "";
        $p = false;
        if (count($array) > 1) {
            $ant = $array[0];
            $per = $array[1];
            for ($x = 0; $x < strlen($ant); $x += 1) {
                $cant .= "0";
            }
            for ($x = 0; $x < strlen($per); $x += 1) {
                if(strlen($cper) == 9) { break; }
                $g .= $per{$x};
                for ($y = 1; $y < strlen($per); $y += 1) {
                    $cper .= "9";
                    if ($per{$x} === $per{$y}) { $p = true; break; }
                    if ($per{$x} !== $per{$y}) { $g .= $per{$y}; }
                }
                if ($p) { break; }
            }
            $this->numerator = (floatval($ant) . $g) - floatval($ant);
            $this->denominator = (int)($cper . $cant);
        } else {
            $per = $array[0];
            for ($x = 0; $x < strlen($per); $x += 1) {
                if(strlen($cper) == 9) { break; }
                $g .= $per{$x};
                for ($y = 1; $y < strlen($per); $y += 1) {
                    $cper .= "9";
                    if ($per[$x] === $per[$y]) { $p = true; break; }
                    if ($per[$x] !== $per[$y]) { $g .= $per[$y]; }
                }
                if ($p) { break; }
            }
            $this->numerator = $array[0];
            $this->denominator = (int)$cper;
        }
    }
}