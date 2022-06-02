<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\Ignore;

class MyClass
{
    public $foo;

    /**
     * @Ignore()
     */
    public $bar;
}
