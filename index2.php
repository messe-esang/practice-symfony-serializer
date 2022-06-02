<?php

require_once 'vendor/autoload.php';

use App\Model\MyObj;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

// $classMetadataFactory = new ClassMetadataFactory(new YamlFileLoader(__DIR__ . '/mappings.yml'));

$obj = new MyObj();
$obj->foo = 'foo';
$obj->setBar('bar');

$normalizer = new ObjectNormalizer($classMetadataFactory);
$serializer = new Serializer([$normalizer]);

$data = $serializer->normalize($obj, null, ['groups' => 'group2']);
// $data = ['foo' => 'foo'];

$obj2 = $serializer->denormalize(
    ['foo' => 'foo', 'bar' => 'bar'],
    MyObj::class,
    null,
    ['groups' => ['group1', 'group3']]
);
// $obj2 = MyObj(foo: 'foo', bar: 'bar');

dump($data, $obj2);
