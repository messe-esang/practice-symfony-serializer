<?php

require_once 'vendor/autoload.php';

use App\Model\Person;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

$encoder = new JsonEncoder();

// all callback parameters are optional (you can omit the ones you don't use)
$dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
    return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
};

$defaultContext = [
    AbstractNormalizer::CALLBACKS => [
        'createdAt' => $dateCallback,
    ],
];

$normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

$serializer = new Serializer([$normalizer], [$encoder]);

$person = new Person();
$person->name = 'cordoval';
$person->age = 34;
$person->createdAt = new \DateTime('now');

$result = $serializer->serialize($person, 'json');
// Output: {"name":"cordoval", "age": 34, "createdAt": "2014-03-22T09:43:12-0500"}

dump($result);
