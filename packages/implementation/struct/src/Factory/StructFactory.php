<?php

declare(strict_types=1);

namespace Struct\Struct\Factory;

use Struct\Contracts\DataType\DataTypeInterface;
use Struct\Contracts\StructInterface;
use Struct\Exception\InvalidStructException;
use Struct\Struct\Private\Placeholder\Undefined;
use Struct\Struct\Struct\StructureProperty;
use Struct\Struct\Utility\StructurePropertyUtility;

class StructFactory
{
    /**
     * @template T of StructInterface
     * @param  class-string<T> $structureType
     * @return T
     */
    public static function create(string $structureType): StructInterface
    {
        if (\is_a($structureType, StructInterface::class, true) === false) {
            throw new InvalidStructException('The structureType <' . $structureType . '> must implement the interface <' . StructInterface::class . '>', 1675967937);
        }
        $structure = new $structureType();
        $properties = StructurePropertyUtility::readProperties($structure);
        foreach ($properties as $property) {
            $name = $property->name;
            $value = self::buildValue($property);
            if ($value instanceof Undefined === false) {
                $structure->$name = $value; // @phpstan-ignore-line
            }
        }
        return $structure;
    }

    /**
     * @param StructureProperty $property
     * @return mixed
     */
    protected static function buildValue(StructureProperty $property): mixed
    {
        if ($property->hasDefaultValue) {
            return $property->defaultValue;
        }
        if ($property->allowsNull) {
            return null;
        }
        $type = $property->type;
        if ($type === 'array') {
            return [];
        }
        if (\is_a($type, StructInterface::class, true) === true) {
            return self::create($type);
        }
        if (
            $type === 'string' ||
            $type === 'int' ||
            $type === 'float' ||
            $type === 'bool' ||
            \is_a($type, \DateTimeInterface::class, true) === true ||
            \is_a($type, DataTypeInterface::class, true) === true ||
            \is_a($type, \UnitEnum::class, true) === true
        ) {
            $undefined = new Undefined();
            return $undefined;
        }
        throw new InvalidStructException('The type <' . $type . '> is not supported', 1675967989);
    }
}