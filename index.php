<?php

use App\Model\Person;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

require_once 'vendor/autoload.php';

$encoders = [new XmlEncoder(), new JsonEncoder()];
$normalizers = [new ObjectNormalizer()];

$serializer = new Serializer($normalizers, $encoders);


$person = new Person();
$person->name = 'foo';
$person->age = 13;
$person->sportsperson = false;

$jsonContent = $serializer->serialize($person, 'json');

// $jsonContent contains {"name":"foo","age":99,"sportsperson":false,"createdAt":null}

echo $jsonContent; // or return it in a Response

$data = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <sportsperson>false</sportsperson>
</person>
EOF;

$person = $serializer->deserialize($data, Person::class, 'xml');

// dump($person);

$person2 = $serializer->deserialize($jsonContent, Person::class, 'json');

// dump($person2);

$data = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <city>Paris</city>
</person>
EOF;

// $loader is any of the valid loaders explained later in this article
$classMetadataFactory = new ClassMetadataFactory($loader);
$normalizer = new ObjectNormalizer($classMetadataFactory);
$serializer = new Serializer([$normalizer]);

// this will throw a Symfony\Component\Serializer\Exception\ExtraAttributesException
// because "city" is not an attribute of the Person class
$person = $serializer->deserialize($data, Person::class, 'xml', [
    AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
]);
