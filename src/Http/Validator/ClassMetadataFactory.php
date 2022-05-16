<?php

declare(strict_types=1);

namespace App\Http\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
//use Your\Package;

class ClassMetadataFactory implements MetadataFactoryInterface
{
    /**
     * Create a ClassMetaData object for your Package object
     *
     * @param object $value The object that will be validated
     */
    public function getMetadataFor($value):object
    {

        // Create a class meta data object for your entity
        $metadata = new ClassMetadata($value::class);

        // Add constraints to your metadata
        $metadata->addPropertyConstraint(
            'url', new Assert\Type(['type' => 'string']));

        // Return the class metadata object
        return $metadata;
    }

    /**
     * Test if the value provided is actually of type Package
     *
     * @param object $value The object that will be validated
     */
    public function hasMetadataFor($value):bool
    {
         if (!\is_object($value) && !\is_string($value)) {
            return false;
        }

        $class = ltrim(\is_object($value) ? \get_class($value) : $value, '\\');

        return class_exists($class) || interface_exists($class, false);
    }
}
