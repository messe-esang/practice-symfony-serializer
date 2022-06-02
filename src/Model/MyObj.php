<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\Groups;

class MyObj
{
    /**
     * @Groups({"group1", "group2"})
     */
    public $foo;

    private $bar;

    /**
     * @Groups("group3")
     */
    public function getBar()
    {
        return $this->bar;
    }

    public function setBar($bar)
    {
        return $this->bar = $bar;
    }
}
