<?php
namespace ABWebDevelopers\PinPayments\Entity;

use \Respect\Validation\Validator;

abstract class Entity
{
    /**
     * An array of available attributes for this entity.
     *
     * Attributes should be specified as an array in the following format:
     * [attribute name] => [attribute type]
     * `attribute type` can be any one of the following: `string`, `bool`, `int`, `float` and `array`
     *
     * @var array
     */
    protected $attributes = [];

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

    public function __construct(array $data = [])
    {
        $this->inflector = \ICanBoogie\Inflector::get('en');

        if (count($data)) {
            $this->set($data);
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
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
        }

        $this->data[$attributeUnderscore] = null;

        return;
    }

    public function get()
    {
        return $this->data;
    }

    public function set(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }

        return $this;
    }

    public function getValue(string $attribute)
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
        }

        return $this->data[$attributeUnderscore] ?? null;
    }

    public function setValue(string $attribute, $newValue = null): Entity
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
        }

        if ($this->validateValue($attribute, $newValue) === false) {
            throw new \InvalidArgumentException('The value provided for the "' . $attribute . '" attribute is not a valid ' . $this->attributes[$attributeUnderscore]);
        }

        $this->data[$attributeUnderscore] = $this->castValue($attribute, $newValue);
        return $this;
    }

    protected function validateValue(string $attribute, $value = null): bool
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
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
        }
    }

    protected function castValue(string $attribute, $value = null)
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
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
            default:
                return $value;
        }
    }

    protected function booleanCheck(string $attribute, bool $isFalse = false): bool
    {
        // Get underscore attribute
        $attributeUnderscore = $this->inflector->underscore($attribute);

        if (!isset($this->attributes[$attributeUnderscore])) {
            throw new \InvalidArgumentException('Entity "' . get_class($this) . '" does not have a "' . $attribute . '" attribute');
        }

        return (empty($this->data[$attributeUnderscore]) === $isFalse);
    }
}
