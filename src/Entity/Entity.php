<?php
namespace ABWebDevelopers\PinPayments\Entity;

use Respect\Validation\Validator;
use ABWebDevelopers\PinPayments\Entity\Exception\InvalidClassException;
use ABWebDevelopers\PinPayments\Entity\Exception\InvalidClassValueException;
use ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException;

/**
 * Entity Class.
 *
 * An entity class represents a single instance of data that can be sent through the Pin Payments API. This can
 * be a card, or a recipient, or a charge, etc. Entities have
 */
abstract class Entity
{
    /**
     * An array of available attributes for this entity.
     *
     * Attributes should be specified as an array in the following format:
     * [attribute name] => [attribute type]
     * `attribute type` can be any one of the following: `string`, `bool`, `int`, `float` and `array`
     * or a fully-qualified class name.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * An array of attributes that are sent with the Pin Payments API request.
     *
     * This should contain a list of attribute names that will be sent through to the Pin Payments API on request.
     *
     * @var array
     */
    protected $apiAttributes = [];

    /**
     * An array of attributes that are masked by another value.
     *
     * Some attributes, for security purposes, may be masked by a "display" value. To define this, use the following
     * array:
     *
     * [original attribute] => [masked attribute]
     *
     * Masked values will be displayed using any normal "get" method calls, and will only be returned unmasked if the
     * first parameter of the main "get" method is true.
     *
     * @var array
     */
    protected $masked = [];

    /**
     * An array containing the current attritube data for this entity.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Inflector class.
     *
     * @var ICanBoogie\Inflector
     */
    protected $inflector;

    public function __construct($data = [])
    {
        $this->inflector = \ICanBoogie\Inflector::get('en');

        if (is_array($data) && count($data)) {
            $this->set($data);
        } elseif (is_string($data) && !empty($data) && isset($this->attributes['token'])) {
            $this->setToken($data);
        }
    }

    public function __call(string $name, array $arguments)
    {
        if (preg_match('/^(is|isNot|set|get)([a-zA-Z0-9]+)$/', $name, $matches) === 1) {
            switch ($matches[1]) {
                case 'is':
                    return $this->booleanCheck($matches[2]);
                    break;
                case 'isNot':
                    return $this->booleanCheck($matches[2], true);
                    break;
                case 'set':
                    return $this->setValue($matches[2], $arguments[0]);
                    break;
                case 'get':
                    return $this->getValue($matches[2]);
                    break;
            }
        }

        throw new \BadMethodCallException('Method "' . $name . '" not found in entity "' . get_class($this) . '"');
    }

    public function __get(string $attribute)
    {
        return $this->getValue($attribute);
    }

    public function __set(string $attribute, $newValue = null): void
    {
        $this->setValue($attribute, $newValue);
        return;
    }

    public function __isset(string $attribute): bool
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        return (isset($this->attributes[$attributeUnderscore]) && isset($this->data[$attributeUnderscore]));
    }

    public function __unset(string $attribute): void
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        $this->data[$attributeUnderscore] = null;

        return;
    }

    public function __toString(): string
    {
        return json_encode($this->getApiData(), JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION);
    }

    public function get(bool $unmasked = false): array
    {
        $data = [];

        foreach ($this->attributes as $attribute => $type) {
            $data[$attribute] = $this->getValue($attribute, $unmasked);
        }

        return $data;
    }

    public function set(array $data): Entity
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }

        return $this;
    }

    public function getApiData(bool $association = false): array
    {
        $data = [];

        foreach ($this->apiAttributes as $attribute) {
            $data[$attribute] = $this->getValue($attribute, true);

            if ($data[$attribute] instanceof Entity) {
                $data[$attribute] = $data[$attribute]->getApiData(true);
            }
        }

        return $this->onGetApiData($data, $association);
    }

    public function getValue(string $attribute, bool $unmasked = false)
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        if ($unmasked === false && isset($this->masked[$attributeUnderscore])) {
            return $this->data[$this->masked[$attributeUnderscore]] ?? null;
        } else {
            return $this->data[$attributeUnderscore] ?? null;
        }
    }

    public function setValue(string $attribute, $newValue = null): Entity
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        if ($this->validateValue($attribute, $newValue) === false) {
            throw new MissingAttributeException(
                'The value provided for the "' . $attribute . '" attribute is not a valid ' .
                $this->attributes[$attributeUnderscore]
            );
        }

        $this->data[$attributeUnderscore] = $this->castValue($attribute, $newValue);
        return $this;
    }

    public function listAttributes()
    {
        return $this->attributes;
    }

    public function listApiAttributes()
    {
        return $this->apiAttributes;
    }

    public function hasAttribute(string $attribute)
    {
        return isset($this->attributes[$attribute]);
    }

    protected function validateValue(string $attribute, $value = null): bool
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        if (!isset($value)) {
            return true;
        }

        // Determine correct validation
        switch ($this->attributes[$attributeUnderscore]) {
            case 'string':
                return Validator::scalarVal()->validate($value);
            case 'bool':
                return Validator::boolType()->validate($value);
            case 'int':
                return Validator::floatVal()->validate($value);
            case 'float':
                return Validator::floatVal()->validate($value);
            case 'array':
                return Validator::arrayType()->validate($value);
            case 'datetime':
            case 'date':
            case 'time':
                if ($value instanceof \DateTime) {
                    return true;
                } elseif (is_string($value)) {
                    try {
                        $date = new \DateTime($value);
                    } catch (\Exception $e) {
                        return false;
                    }
                    return true;
                } else {
                    return false;
                }
            default:
                if (!class_exists($this->attributes[$attributeUnderscore])) {
                    throw new InvalidClassException($this->attributes[$attributeUnderscore] . ' is not a valid
                        class to use as an entity attribute.');
                }
                return (
                    $value instanceof $this->attributes[$attributeUnderscore]
                    || is_array($value)
                    || is_string($value)
                );
        }
    }

    protected function castValue(string $attribute, $value = null)
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        if (!isset($value)) {
            return null;
        }

        // Cast new value accordingly
        switch ($this->attributes[$attributeUnderscore]) {
            case 'string':
                return strval($value);
            case 'bool':
                return boolval($value);
            case 'int':
                return intval($value);
            case 'float':
                return floatval($value);
            case 'datetime':
            case 'date':
            case 'time':
                return new \DateTime($value);
            default:
                if (class_exists($this->attributes[$attributeUnderscore])) {
                    if (is_array($value)) {
                        $value = new $this->attributes[$attributeUnderscore]($value);
                        if ($value->hasAttribute('loaded')) {
                            $value->setLoaded(true);
                        }
                    } elseif (is_string($value)) {
                        $value = new $this->attributes[$attributeUnderscore]($value);
                        if ($value->hasAttribute('loaded')) {
                            $value->setLoaded(false);
                        }
                    } elseif ($value instanceof $this->attributes[$attributeUnderscore] === false) {
                        throw new InvalidClassValueException(
                            get_class($value) . ' is not an instance of ' . $this->attributes[$attributeUnderscore]
                        );
                    }
                }
                return $value;
        }
    }

    protected function booleanCheck(string $attribute, bool $isFalse = false): bool
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new MissingAttributeException(
                'Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute'
            );
        }

        return (empty($this->data[$attributeUnderscore]) === $isFalse);
    }

    protected function onGetApiData(array $data = [], bool $associated = false): array
    {
        return $data;
    }
}
