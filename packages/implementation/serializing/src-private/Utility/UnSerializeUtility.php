<?php

declare(strict_types=1);

namespace Struct\Serializing\Private\Utility;

use Exception\Unexpected\UnexpectedException;
use Struct\Contracts\DataType\DataTypeInterface;
use Struct\Contracts\StructCollectionInterface;
use Struct\Contracts\StructInterface;

use Struct\Exception\InvalidValueException;
use Struct\Serializing\Enum\KeyConvert;
use Struct\Serializing\Exception\TransformException;
use Struct\Serializing\Private\Enum\SerializeDataType;
use Struct\Serializing\Private\Helper\TransformHelper;
use Struct\Struct\Factory\DataTypeFactory;
use Struct\Struct\Helper\PropertyReflectionHelper;
use Struct\Struct\Struct\PropertyReflection;

class UnSerializeUtility
{
    /**
     * @template T of StructInterface|StructCollectionInterface
     * @param array<mixed>|Object $data
     * @param class-string<T> $type
     * @return T
     */
    public function unSerialize(array|Object $data, string $type, ?KeyConvert $keyConvert): StructInterface|StructCollectionInterface
    {
        $structure = null;
        if (\is_a($type, StructInterface::class, true) === true) {
            $structure = $this->_unSerializeStructure($data, $type, $keyConvert);
        }
        if (\is_a($type, StructCollectionInterface::class, true) === true) {
            $propertyReflection = PropertyReflectionHelper::readPropertyOfStructCollection($type);
            $structure = $this->_unSerializeStructCollection($data, $propertyReflection, $keyConvert);
        }
        if ($structure === null) {
            throw new \LogicException('The type: <' . $type . '> must be an StructInterface or StructCollectionInterface', 1698960691);
        }
        return $structure; // @phpstan-ignore-line
    }

    protected function _unSerialize(mixed $data, string $type, PropertyReflection $propertyReflection, ?KeyConvert $keyConvert): mixed
    {
        $dataType = $this->_findDataType($data, $type);
        $result = match ($dataType) {
            SerializeDataType::StructureType  => $this->_unSerializeStructure($data, $type, $keyConvert), // @phpstan-ignore-line
            SerializeDataType::NullType => $this->parseNull($propertyReflection),
            SerializeDataType::EnumType => $this->_unSerializeEnum($data, $type),
            SerializeDataType::StructCollection => $this->_unSerializeStructCollection($data, $propertyReflection, $keyConvert),
            SerializeDataType::ArrayType => $this->_unSerializeArray($data, $propertyReflection, $keyConvert),
            SerializeDataType::DataType => $this->_unSerializeDataType($data, $propertyReflection), // @phpstan-ignore-line
            SerializeDataType::BuildInType => $this->_unSerializeBuildIn($data, $type, $propertyReflection),
        };
        return $result;
    }

    /**
     * @template T of StructInterface
     * @param class-string<T> $type
     * @return T
     */
    protected function _unSerializeStructure(mixed $data, string $type, ?KeyConvert $keyConvert): StructInterface
    {
        $dataArray = $this->_transformObjectToArray($data);
        if (is_a($type, StructInterface::class, true) === false) {
            throw new InvalidValueException('The type: <' . $type . '> must implement <' . StructInterface::class . '>', 1652123590);
        }
        $structure = new $type();
        $propertyReflections = PropertyReflectionHelper::readProperties($structure);

        foreach ($propertyReflections as $propertyReflection) {
            $propertyName = $propertyReflection->name;
            $value = null;
            $arrayKey = CaseStyleUtility::buildArrayKeyFromPropertyName($propertyName, $keyConvert);
            if (\array_key_exists($arrayKey, $dataArray) === true) {
                $value = $dataArray[$arrayKey];
            }
            $structure->$propertyName = $this->_unSerialize($value, $propertyReflection->type, $propertyReflection, $keyConvert);  // @phpstan-ignore-line
        }

        return $structure;
    }

    protected function _findDataType(mixed $data, string $type): SerializeDataType
    {
        if ($data === null) {
            return SerializeDataType::NullType;
        }
        if (is_a($type, \UnitEnum::class, true) === true) {
            return SerializeDataType::EnumType;
        }
        if (is_a($type, DataTypeInterface::class, true) === true) {
            return SerializeDataType::DataType;
        }
        if (is_a($type, StructInterface::class, true) === true) {
            return SerializeDataType::StructureType;
        }
        if (is_a($type, StructCollectionInterface::class, true) === true) {
            return SerializeDataType::StructCollection;
        }
        if ($type === 'array') {
            return SerializeDataType::ArrayType;
        }
        return SerializeDataType::BuildInType;
    }

    protected function _unSerializeEnum(mixed $data, string $type): \UnitEnum
    {
        if (is_string($data) === false && is_int($data) === false) {
            throw new \LogicException('The value for <' . $data . '> must be string or int', 1652900283);
        }

        if (is_a($type, \BackedEnum::class, true) === true) {
            $enum = $type::tryFrom($data);
            if ($enum === null) {
                throw new \LogicException('The value <' . $data . '> is not allowed for Enum <' . $type . '>', 1652900286);
            }
            return $enum;
        }
        $cases = $type::cases();
        /** @var \UnitEnum $case */
        foreach ($cases as $case) {
            if ($case->name === $data) {
                return $case;
            }
        }
        throw new \LogicException('The value <' . $data . '> is not allowed for Enum <' . $type . '>', 1652899974);
    }

    /**
     * @param mixed $data
     * @return array<mixed>
     */
    protected function _transformObjectToArray(mixed $data): array
    {
        if (\is_array($data) === true) {
            return $data;
        }

        if (
            \is_object($data) === true &&
            is_a($data, \DateTimeInterface::class) === false
        ) {
            $dataArray = [];
            $dataArrayTransform = (array) $data;
            foreach ($dataArrayTransform as $key => $value) {
                if (is_a($value, \DateTimeInterface::class)) {
                    $value = TransformHelper::formatDateTime($value);
                }
                if ($value instanceof \UnitEnum) {
                    $value = TransformHelper::formatEnum($value);
                }
                $dataArray[$key] = $value;
            }
            return $dataArray;
        }
        throw new UnexpectedException(1676979096);
    }

    protected function _unSerializeDataType(string|\Stringable $serializedData, PropertyReflection $propertyReflection): DataTypeInterface
    {
        $serializedData = (string) $serializedData;
        /** @var class-string<DataTypeInterface> $type */
        $type = $propertyReflection->type;
        $dataType = DataTypeFactory::create($type, $serializedData);
        return $dataType;
    }

    protected function _unSerializeStructCollection(mixed $dataArray, PropertyReflection $propertyReflection, ?KeyConvert $keyConvert): StructCollectionInterface
    {
        if (
            \is_array($dataArray) === false &&
            $dataArray instanceof StructCollectionInterface === false
        ) {
            throw new UnexpectedException(1675967242);
        }
        $type = $propertyReflection->type;
        /** @var StructCollectionInterface $structCollection */
        $structCollection = new $type();
        /** @var string $type */
        $type = $propertyReflection->structTypeOfArrayOrCollection;

        $values = $dataArray;
        if ($dataArray instanceof StructCollectionInterface === true) {
            $values = $dataArray->getValues();
        }
        foreach ($values as $value) {
            /** @var StructInterface $value */
            $value = $this->_unSerialize($value, $type, $propertyReflection, $keyConvert);
            $structCollection->addValue($value);
        }
        return $structCollection;
    }

    /**
     * @return array<mixed>
     */
    protected function _unSerializeArray(mixed $dataArray, PropertyReflection $propertyReflection, ?KeyConvert $keyConvert): array
    {
        if (\is_array($dataArray) === false) {
            throw new UnexpectedException(1675967242);
        }
        /** @var string $type */
        $type = $propertyReflection->structTypeOfArrayOrCollection;
        $isArrayKeyList = $propertyReflection->isArrayKeyList;
        $parsedOutput = $this->_buildArray($dataArray, $propertyReflection, $type, $isArrayKeyList, $keyConvert);
        return $parsedOutput;
    }

    /**
     * @param array<mixed> $dataArray
     * @return array<mixed>
     */
    protected function _buildArray(array $dataArray, PropertyReflection $propertyReflection, string $type, bool $isArrayKeyList, ?KeyConvert $keyConvert): array
    {
        $parsedOutput = [];
        foreach ($dataArray as $key => $value) {
            $valueToSet = $value;
            if ($type !== 'mixed') {
                $valueToSet = $this->_unSerialize($value, $type, $propertyReflection, $keyConvert);
            }
            if ($isArrayKeyList === true) {
                $parsedOutput[$key] = $valueToSet;
            } else {
                $parsedOutput[] = $valueToSet;
            }
        }
        return $parsedOutput;
    }

    protected function _unSerializeBuildIn(mixed $value, string $type, PropertyReflection $propertyReflection): mixed
    {
        try {
            return TransformHelper::transformBuildIn($value, $type);
        } catch (TransformException $transformException) {
            throw new \LogicException('Can not transform property <' . $propertyReflection->name . '>', 1652190689, $transformException);
        }
    }

    protected function parseNull(PropertyReflection $propertyReflection): mixed
    {
        if ($propertyReflection->isAllowsNull === true) {
            return null;
        }
        if ($propertyReflection->isHasDefaultValue === true) {
            return $propertyReflection->defaultValue;
        }
        throw new \LogicException('No value for <' . $propertyReflection->name . '> found', 1675967217);
    }
}
