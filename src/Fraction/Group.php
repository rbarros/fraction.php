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
 * Group Library find group of characters in a string.
 *
 * @package  Math
 * @author   Ramon Barros <contato@ramon-barros.com>
 */

class Group {
    
    private $version = '1.0';
    private $string;
    private $groups =  array();

    public function __construct($num=null) {
        $this->string = (string)$num;

        if(!is_null($num)) {
            $this->setGroups($this->string);
        }
    }

    /**
     * Cria os grupos de caracteres e armazena a posição de cada caractere
     * em um array
     * @param string $string string a ser verificada
     */
    private function setGroups($string) {
        for ($i = 0; strlen($string) > $i; $i += 1) {
            $caracter = $string[$i];
            if ($caracter !== "") {
                $group = $this->arrHasDupes($caracter);
                if ($group === false) {
                    $position = $this->checkIndex($caracter);
                    array_push($this->groups, array('caracter' => $caracter, 'position' =>  $position));
                }
            }
        }
        $this->checkGroups();
    }

    public function getGroups() {
        return $this->groups;
    }

    /**
     * Verifica se os proximos caracteres da string são iguais
     * @param  string $caracter caractere a ser verificado
     * @return boolean          retorn se o caractere repete
     */
    private function arrHasDupes($caracter) {
        for ($i=0; $i < count($this->groups) ; $i += 1) { 
            if ($this->groups[$i]['caracter'] === $caracter) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retorna a posição do caractere no array
     * @param  string $caracter caractere a ser verificado
     * @return array            retorna array contendo a posição do caractere
     */
    private function checkIndex($caracter) {
        $x = 0;
        $array = array();
        while ($x <= strlen($this->string) - 1) {
            if ($this->string{$x} == $caracter) {
                array_push($array, $x);
            }
            $x += 1;
        }
        return $array;
    }

    /**
     * Com a posição de cada caractere é possível montar os grupos
     * @return array retorna os grupos de caracteres
     */
    private function checkGroups() {
        
        $key = null;

        $caracter = null;

        $string = null;

        $equal = null;

        $group = "";

        $grupo_menor = array();

        $grupo_maior = array();

        $aux = array();

        $ar = array();

        $obj = $this->groups;

        $n = 0;

        /**
         * Verifica se o array de posições é menor/igual a 1
         * @var integer
         */
        for ($i=0; $i < count($obj); $i += 1) {
            if (count($obj[$i]['position']) <= 1) {
                array_push($grupo_menor, join($obj[$i]['position'], ","));
            } else if(count($obj[$i]['position']) > 1) {
                array_push($grupo_maior, join($obj[$i]['position'], ","));
            }
        }
        
        $grupo_menor = explode(',', implode(",", $grupo_menor));
        sort($grupo_menor);
        $grupo_maior = explode(',', implode(",", $grupo_maior));
        sort($grupo_maior);

        if (count($grupo_menor) === 0 || $grupo_menor[0] === "" && count($obj) > 1) {
            $string = strrev($this->string);
            $grupo_maior = array_reverse($grupo_maior);
            $group = "";
            $x = 0;
            for ($i = 0; $i < count($grupo_maior); $i += 1) { 
                $caracter = $this->string{(int)$grupo_maior[$i]};
                for ($j = 0; $j < count($obj); $j += 1) { 
                    if ($obj[$j]['caracter'] === $caracter) {
                        $n = count($obj[$j]['position']);
                    }
                }

                $key = strrpos($group, $caracter);
                if ($key !== false || $group === "") {
                    $equal = true;
                    $group .= $caracter;
                    if (!isset($aux)) {
                        $aux = array();
                    }
                    if ((strlen($group) % $n) === 0) {
                        $aux[$x] = $group;
                        $group = "";
                        $x += 1;
                    }
                } else {
                    $equal = false;
                    $group .= $caracter;
                    if (!isset($aux) || is_array($aux)) {
                        $aux = "";
                    }
                    if ((strlen($group) % $n) === 0) {
                        $aux .= strrev($group);
                        $group = "";
                        $x += 1;
                    }
                }
            }

            if ($equal) {
                $ar = array_reverse($aux);
            } else {
                $ar = array($aux);
            }
        }

        if( count($ar) === 0 ) {
            $j = 0;
            $n = count($grupo_menor);
            if ($n > 0 && $grupo_menor[0] !== "") {
                for ($i = 0; $i < $n; $i += 1) {
                    if ((int)$grupo_menor[$i] === $j) {
                        $j += 1;
                    } else if ((int)$grupo_menor[$i] !== $j) {
                        array_push($grupo_menor, (string)$i);
                        sort($grupo_menor);
                        for ($y = 0; $y < count($grupo_maior); $y += 1) {
                            $k = strrpos($grupo_maior[$y], (string)$i);
                            if ($k !== false) {
                                unset($grupo_maior[$k]);
                            }
                        }
                    }
                }

                sort($grupo_maior);

                $group = "";
                for ($x = 0; $x < count($grupo_menor); $x += 1) {
                    if (isset($grupo_menor[$x]) && strlen($grupo_menor[$x]) > 0) {
                        $group .= $this->string{(int)$grupo_menor[$x]};
                    }
                }
                if ($group !== "") {
                    array_push($ar, $group);
                }
                $group = "";
                for ($x = 0; $x < count($grupo_maior); $x += 1) {
                    if (isset($grupo_maior[$x]) && strlen($grupo_maior[$x]) > 0) {
                        $group .= $this->string{(int)$grupo_maior[$x]};
                    }
                }
                if ($group !== "") {
                    array_push($ar, $group);
                }
            } else {
                $group = "";
                for ($x = 0; $x < count($grupo_maior); $x += 1) {
                    if (isset($grupo_maior[$x]) && strlen($grupo_maior[$x]) > 0) {
                        $group .= $this->string{(int)$grupo_maior[$x]};
                    }
                }
                if ($group !== "") {
                    array_push($ar, $group);
                }
            }
        }
        $this->groups = $ar;
    }
}