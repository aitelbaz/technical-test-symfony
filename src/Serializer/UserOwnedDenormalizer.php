<?php


namespace App\Serializer;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class UserOwnedDenormalizer implements ContextAwareDenormalizerInterface
{

    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        // TODO: Implement supportsDenormalization() method.
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        // TODO: Implement denormalize() method.
    }
}