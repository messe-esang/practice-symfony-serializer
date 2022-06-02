<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Annotation\Ignore;


class User
{
    public $familyName;
    public $givenName;
    public $company;
}

class Company
{
    public $name;
    public $address;
}

$company = new Company();
$company->name = 'Les-Tilleuls.coop';
$company->address = 'Lille, France';

$user = new User();
$user->familyName = 'Dunglas';
$user->givenName = 'Kévin';
$user->company = $company;

$serializer = new Serializer([new ObjectNormalizer()]);

$data = $serializer->normalize($user, null, [AbstractNormalizer::ATTRIBUTES => ['familyName', 'company' => ['name']]]);
// $data = ['familyName' => 'Dunglas', 'company' => ['name' => 'Les-Tilleuls.coop']];

// dump($data);


use App\Model\MyClass;
use App\Model\Person;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

$obj = new MyClass();
$obj->foo = 'foo';
$obj->bar = 'bar';

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
$normalizer = new ObjectNormalizer($classMetadataFactory);
$serializer = new Serializer([$normalizer]);

$data = $serializer->normalize($obj);
// $data = ['foo' => 'foo'];

dump($data);

use Symfony\Component\Serializer\Encoder\JsonEncoder;

$person = new Person();
$person->name = 'foo';
$person->age = 99;

$normalizer = new ObjectNormalizer();
$encoder = new JsonEncoder();

$serializer = new Serializer([$normalizer], [$encoder]);
$result = $serializer->serialize($person, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['age']]); // Output: {"name":"foo"}

dump($result);
