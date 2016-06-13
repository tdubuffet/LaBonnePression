<?php
/**
 * Created by PhpStorm.
 * User: tdubuffet
 * Date: 05/06/2016
 * Time: 18:37
 */

namespace InstitutionBundle\Model;


class UID {

    /**
     * @var
     */
    public $prefix;

    /**
     * @var
     */
    public $entropy;

    /**
     * @param string $prefix
     * @param bool $entropy
     */
    public function __construct()
    {
        $this->uuid = md5(uniqid(rand(), TRUE));
    }

    /**
     * Limit the UUID by a number of characters
     *
     * @param $length
     * @param int $start
     * @return $this
     */
    public function limit($length, $start = 0)
    {
        $this->uuid = substr($this->uuid, $start, $length);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strtoupper($this->uuid);
    }
}