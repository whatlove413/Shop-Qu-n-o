<?php
/**
 * Itvina Library (Zend Framework based)
 *
 * LICENSE
 *
 * ...
 *
 * @category   Itvina
 * @package    Itvina_Filter
 * @copyright
 * @license
 * @version    $Id: NoMark.php 1.0 2012-08-22 (Khanh-It) $
 */

/**
 * @see Zend_Filter_Interface
 */

/**
 * @category   Itvina
 * @package    Itvina_Filter
 * @copyright
 * @license
 */

namespace App\Helpers;

class Filter
{
    /**
     * @var array
     */
    protected $_chars;

    /**
     * @var string
     */
    protected $_separator = '';

    /**
     * @var string
     */
    protected $_changeCaseFuncName;

    /**
     *
     */
    public function __construct($options = array())
    {
        $this->_chars = array(
            'A' => array('A', 'Á', 'À', 'Ả', 'Ạ', 'Ã', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ậ', 'Ẫ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ặ', 'Ẵ'),
            'a' => array('a', 'á', 'à', 'ả', 'ạ', 'ã', 'â', 'ấ', 'ầ', 'ẩ', 'ậ', 'ẫ', 'ă', 'ắ', 'ằ', 'ẳ', 'ặ', 'ẵ'),
            'B' => array('B'),
            'b' => array('b'),
            'C' => array('C'),
            'c' => array('c'),
            'D' => array('D', 'Đ'),
            'd' => array('d', 'đ'),
            'E' => array('E', 'É', 'È', 'Ẻ', 'Ẹ', 'Ẽ', 'Ê', 'Ế', 'Ế', 'Ề', 'Ệ', 'Ễ'),
            'e' => array('e', 'é', 'è', 'ẻ', 'ẹ', 'ẽ', 'ê', 'ế', 'ề', 'ể', 'ệ', 'ễ'),
            'F' => array('F'),
            'f' => array('f'),
            'G' => array('G'),
            'g' => array('g'),
            'H' => array('H'),
            'h' => array('h'),
            'J' => array('J'),
            'j' => array('j'),
            'K' => array('K'),
            'k' => array('k'),
            'L' => array('L'),
            'l' => array('l'),
            'M' => array('M'),
            'm' => array('m'),
            'N' => array('N'),
            'n' => array('n'),
            'I' => array('I', 'Í', 'Ì', 'Ỉ', 'Ị', 'Ĩ'),
            'i' => array('i', 'í', 'ì', 'ỉ', 'ị', 'ĩ'),
            'O' => array('O', 'Ó', 'Ò', 'Ỏ', 'Ọ', 'Õ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ợ', 'Ỡ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ộ', 'Ỗ'),
            'o' => array('o', 'ó', 'ò', 'ỏ', 'ọ', 'õ', 'ơ', 'ớ', 'ờ', 'ở', 'ợ', 'ỡ', 'ô', 'ố', 'ồ', 'ổ', 'ộ', 'ỗ'),
            'U' => array('U', 'Ú', 'Ù', 'Ủ', 'Ụ', 'Ũ', 'Ư', 'Ư', 'Ừ', 'Ử', 'Ự', 'Ữ'),
            'u' => array('u', 'ú', 'ù', 'ủ', 'ụ', 'ũ', 'ư', 'ư', 'ừ', 'ử', 'ự', 'ữ'),
            'Y' => array('Y', 'Ý', 'Ỳ', 'Ỵ', 'Ỷ', 'Ỹ'),
            'y' => array('y', 'ý', 'ỳ', 'ỵ', 'ỷ', 'ỹ'),
            'Q' => array('Q'),
            'q' => array('q'),
            'W' => array('W'),
            'w' => array('w'),
            'R' => array('R'),
            'r' => array('r'),
            'T' => array('T'),
            't' => array('t'),
            'P' => array('P'),
            'p' => array('p'),
            'S' => array('S'),
            's' => array('s'),
            'Z' => array('Z'),
            'z' => array('z'),
            'X' => array('X'),
            'x' => array('x'),
            'V' => array('V'),
            'v' => array('v'),
        );
    }

    public function filter($value)
    {
        if ($value != "") {
            $value = str_replace(array("\r\n", "\n\r", "\r", "\n", "\t"), "", trim($value));
            foreach ($this->_chars as $k => $v) {
                $value = str_replace($v, $k, $value);
            }
            $value = str_replace(" ", $this->_separator, $value);
        }
        return $value;
    }
}
