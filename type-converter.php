<?php

namespace Acme;

require_once 'vendor/autoload.php';

use App\Domain\Doc;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

// class ObjectOuter
// {
//     private $inner;
//     private $date;

//     public function getInner()
//     {
//         return $this->inner;
//     }

//     public function setInner(ObjectInner $inner)
//     {
//         $this->inner = $inner;
//     }

//     public function setDate(\DateTimeInterface $date)
//     {
//         $this->date = $date;
//     }

//     public function getDate()
//     {
//         return $this->date;
//     }
// }

// class ObjectInner
// {
//     public $foo;
//     public $bar;
// }

// $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
// $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);

// $obj = $serializer->denormalize(
//     ['inner' => ['foo' => 'foo', 'bar' => 'bar'], 'date' => '1988/01/21'],
//     'Acme\ObjectOuter'
// );

// dump($obj->getInner()->foo); // 'foo'
// dump($obj->getInner()->bar); // 'bar'
// dump($obj->getDate()->format('Y-m-d')); // '1988-01-21'

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));


// $normalizer = new ObjectNormalizer(null, null, null, new PhpDocExtractor());
$normalizer = new ObjectNormalizer(null, null, null, new PhpStanExtractor());
$serializer = new Serializer([new DateTimeNormalizer(), $normalizer], [new JsonEncoder()]);

$data = [
    'id' => 30,
    'name' => 'doc test',
    'applet' => [
        'id' => 100,
        'name' => 'applet test'
    ]
];
$json = json_encode($data);

dump($json);

// $doc = $serializer->denormalize($data, Doc::class);
$doc = $serializer->deserialize($json, Doc::class, 'json');

dump($doc);
