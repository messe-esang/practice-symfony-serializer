<?php

require_once 'vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

$normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

class Person
{
    private $firstName;

    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
}

$kevin = new Person('Kévin');
$normalizer->normalize($kevin);
// ['first_name' => 'Kévin'];

$anne = $normalizer->denormalize(['first_name' => 'Anne'], 'Person');
// Person object with firstName: 'Anne'

dump($anne);


// with metadata

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Serializer;

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

$metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

$serializer = new Serializer(
    [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
    ['json' => new JsonEncoder()]
);

$serialized = $serializer->serialize(new Person('Kévin'), 'json');

dump($serialized);
