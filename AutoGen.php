<?php
/**
 * speed in 10 000 repetitions: 0.059666 s
 *
 * Generates a consecutive id as a string.
 * @oaram $keys - an array with valid values in order
 *
 * If the ID length is less than 3, the usual string is returned
 * But
 * If the ID length is longer than 2, the shortened line is returned as {number of items}_{item}.
 *
 * @Examples:
 * $gen = new AutoGen();
 *
 * echo $gen->getId(''); // a (first element in an array)
 * echo $gen->getId('F'); // G (After F in the array goes G)
 * echo $gen->getId('998'); // 3_9 (After 8 goes 9 as the ID length over 2 IDs is reduced)
 * echo $gen->getId('3_9');
 *
 */

class AutoGen
{
    private $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * @param string $lastId
     * @return string
     * @throws Exception
     */
    public function getId(string $lastId):string
    {
        if ($lastId === '') return $this->keys[0];
        $lastId = $this->unMinifyId($lastId);

        $val = array_search($lastId[-1], $this->keys, true);
        if ($val !== false) {
            if (isset($this->keys[$val+1])) {
                $newStr = substr($lastId, 0, strlen($lastId)-1);
                $newStr = $newStr . $this->keys[$val+1];
            } else {
                $newStr = $lastId . $this->keys[0];
            }
            return $this->minifyId($newStr);
        } else {
            throw new Exception('Unknown item');
        }
    }

    /**
     * @param string $id
     * @return string
     */
    public function minifyId(string $id):string
    {
        $lastValInArray = $this->get_array_key_last($this->keys);

        $re = '/^('.$lastValInArray.'+)(.)/m';

        preg_match_all($re, $id, $matches, PREG_SET_ORDER, 0);
        if (count($matches) > 0) {
            $repeat = $matches[0][1];
            $last = $matches[0][2];
            if ($last === $lastValInArray) {
                $repeat = $repeat.$last;
                $last = '';
            }
            $len = strlen($repeat);
            if ($len < 3) return $repeat . $last;
            return $len . '_' . $lastValInArray . $last;
        } else {
            return $id;
        }
    }

    /**
     * @param string $id
     * @return string
     */
    public function unMinifyId(string $id): string
    {
        $lastValInArray = $this->get_array_key_last($this->keys);
        $re = '/^(\d*)_('.$lastValInArray.')/m';

        preg_match_all($re, $id, $matches, PREG_SET_ORDER, 0);
        if (count($matches) > 0) {
            $res = '';
            $count = (int) $matches[0][1];
            $charts = $matches[0][2];
            for ($i=0;$i<$count; $i++) {
                $res = $res . $charts;
            }
            $last = substr($id, -1, 1);
            if ($last !== $lastValInArray) $res = $res.$last;
            return $res;
        } else {
            return $id;
        }
    }

    /**
     * @param $array
     * @return mixed|null
     */
    private function get_array_key_last($array) {
        if (!is_array($array) || empty($array)) {
            return NULL;
        }
        if (function_exists("array_key_last"))
            return $array[array_key_last($array)];
        return array_keys($array)[count($array)-1];
    }
}