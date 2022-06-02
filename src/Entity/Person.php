<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Person
{
    /**
     * @SerializedName("customer_name")
     */
    private $firstName;

    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    // ...
}
