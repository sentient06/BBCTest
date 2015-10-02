<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

define("NORMAL", 1);
define("TRADITIONAL", 2);
define("MEDIEVAL", 3);

class IndexController extends AbstractActionController {

    private $method = NORMAL;
    private $number = 0;
    private $result = 'nulla';

    /**
     * Renders the index page.
     *
     * This method first looks for query strings, then sets the values of this class, generates the
     * roman numeral, sets the variables to be acessible in the view and renders the view.
     */
    public function indexAction() {
        $this->setMethod(isset($_GET['method']) ? $_GET['method'] : 0);
        $this->setNumber(isset($_GET['number']) ? $_GET['number'] : 0);
        $this->generateRomanNumeral();
        $data = array(
            'result' => $this->getResult(),
            'number' => $this->getNumber(),
            'method' => $this->getMethod()
        );
        return new ViewModel($data);
    }

    // --------------------------------------------------------------------------------------------
    // Public methods:

    /**
     * Updates the result variable.
     *
     * This method simply reads which method of convertion should be used and calls the responsible
     * function for that method.
     */
    public function generateRomanNumeral() {
        switch ($this->method) {
            case MEDIEVAL:
                $this->result = $this->medieval($this->number);
                break;
            case TRADITIONAL:
                $this->result = $this->traditional($this->number);
                break;
            case NORMAL:
            default:
                $this->result = $this->normal($this->number);
                break;
        }
    }

    // --------------------------------------------------------------------------------------------
    // Private methods:

    /**
     * Converts Hindu–Arabic number into Traditional Roman number.
     *
     * The traditional Roman numeral system doesn't use subtractive forms.
     *
     * @param  number $x is the number to be converted.
     * @return string the roman numeral system version of the number.
     */
    private function traditional($x) {
        $v = array(
            1    => 'I'
          , 5    => 'V'
          , 10   => 'X'
          , 50   => 'L'
          , 100  => 'C'
          , 500  => 'D'
          , 1000 => 'M'
        );
        return $this->convert($x, $v);
    }

    /**
     * Converts Hindu–Arabic number into "normal" Roman number.
     *
     * The normal Roman numeral system uses subtractive forms.
     *
     * @param  number $x is the number to be converted.
     * @return string the roman numeral system version of the number.
     */
    private function normal($x) {
        $v = array(
            1    => 'I'
          , 4    => 'IV'
          , 5    => 'V'
          , 9    => 'IX'
          , 10   => 'X'
          , 40   => 'XL'
          , 50   => 'L'
          , 90   => 'XC'
          , 100  => 'C'
          , 400  => 'CD'
          , 500  => 'D'
          , 900  => 'CM'
          , 1000 => 'M'
        );
        return $this->convert($x, $v);
    }

    /**
     * Converts Hindu–Arabic number into Medieval Roman number.
     *
     * The medieval Roman numeral system has several different notations for different values.
     *
     * @param  number $x is the number to be converted.
     * @return string the roman numeral system version of the number.
     */
    private function medieval($x) {
        $v = array(
            1    => 'I'
          , 4    => 'IV'
          , 5    => 'A'
          , 6    => 'Ϛ'
          , 7    => 'Z'
          , 9    => 'IX'
          , 10   => 'X'
          , 11   => 'O'
          , 40   => 'F'
          , 50   => 'L'
          , 70   => 'S'
          , 80   => 'R'
          , 90   => 'N'
          , 100  => 'C'
          , 160  => 'Y'
          , 200  => 'T'
          , 250  => 'H'
          , 300  => 'E'
          , 400  => 'B'
          , 500  => 'P'
          , 900  => 'Q'
          , 1000 => 'M'
          , 2000 => 'Z'
        );
        return $this->convert($x, $v);
    }

    /**
     * Converts Hindu–Arabic number into Roman number.
     *
     * This method needs two arrays with the corresponding Hindu-Arabic and Roman numerals in the
     * same index. Then it iterates the list until it finds the largest number lesser than the
     * desired value, it then adds the Roman numeral, subtracts it's value from $x and repeats.
     *
     * This process allows to replicate the succession style of Roman numerals.
     *
     * @param  number $x is the number to be converted.
     * @param  array  $v is an array of values in Hindu-Arabic and their correspondent in Roman.
     * @return string the roman numeral system version of the number.
     */
    private function convert($x, $v) {
        if ($x < 1) return 'nulla';
        if ($x > 3999) return 'nimis magna!';
        $x = round($x);
        // A single array is good for readability.
        // The faster way of doing this is passing two arrays. For this system it is fine to do a
        // single array, but for bigger data this would be a slow process.
        $n = array_keys($v);
        $c = array_values($v);
        $k = array_keys($n); //PHP error: "Only variables should be passed by reference"
        $last_key = end($k);
        // -------------------
        $r = '';
        while ($x > 0) {
            $i = -1;
            while ($x >= $n[$i+1] && $i != $last_key) $i++;
            $x -= $n[$i];
            $r .= $c[$i];
        }
        return $r;
    }

    // --------------------------------------------------------------------------------------------
    // Setters and getters:

    /**
     * Sets method.
     */
    public function setMethod($newValue) {
        $this->method = $newValue;
    }

    /**
     * Gets method.
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Sets number.
     */
    public function setNumber($newValue) {
        $this->number = $newValue;
    }

    /**
     * Gets number.
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Gets result.
     * This property is read-only.
     */
    public function getResult() {
        return $this->result;
    }

}
