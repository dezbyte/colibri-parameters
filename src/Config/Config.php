<?php

namespace Dez\Config;

use Dez\Config\Adapter\Ini as IniAdapter;
use Dez\Config\Adapter\Json as JsonAdapter;
use Dez\Config\Adapter\NativeArray as ArrayAdapter;

/**
 * Class Config
 * @package Dez\Config
 */
class Config implements ConfigInterface
{

    const CONFIG_INI_SECTOR = 'dez-app-config';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $configArray
     */
    public function __construct(array $configArray = [])
    {
        foreach ($configArray as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return $this
     */
    public function offsetSet($name, $value)
    {
        $this->config[$name] = is_array($value) ? new self($value) : $value;

        return $this;
    }

    /**
     * @param $configResource
     * @return IniAdapter|JsonAdapter|ArrayAdapter|Config
     * @throws Exception
     */
    static public function factory($configResource)
    {
        if (is_array($configResource)) {
            return new Config($configResource);
        }

        list($fileExtension) = array_reverse(explode('.', $configResource));

        switch ($fileExtension) {
            case 'json': {
                return new JsonAdapter($configResource);
                break;
            }
            case 'php': {
                return new ArrayAdapter($configResource);
                break;
            }
            case 'ini': {
                return new IniAdapter($configResource);
                break;
            }
            default: {
                throw new Exception('Unknown config resource');
            }
        }

    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param null $name
     * @param null $default
     * @return null|static
     */
    public function get($name = null, $default = null)
    {
        return $this->has($name) ? $this->config[$name] : $default;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * @param ConfigInterface $config
     * @return Config
     */
    public function merge(ConfigInterface $config)
    {
        return $this->_merge($config, $this);
    }

    /**
     * @param ConfigInterface $config
     * @param ConfigInterface $instance
     * @return ConfigInterface
     */
    protected function _merge(ConfigInterface $config, ConfigInterface $instance)
    {
        foreach ($config as $key => $value) {
            if (isset($instance[$key]) && is_object($instance[$key]) && is_object($value)) {
                $this->_merge($value, $instance[$key]);
            } else {
                $instance[$key] = $value;
            }
        }

        return $instance;
    }

    /**
     * @param $path
     * @param string $separator
     * @return Config
     */
    public function path($path, $separator = '.')
    {
        $parts = explode($separator, $path);

        $target = $this;

        foreach ($parts as $part) {
            $target = $target->fetch($part);
        }

        return $target;
    }

    /**
     * @param $name
     * @return Config
     */
    public function fetch($name)
    {
        return $this->get($name, new Config());
    }

    /**
     * @param int $stringOffset
     * @return string
     */
    public function toString($stringOffset = 0)
    {
        $text = null;

        foreach ($this as $property => $value) {
            $offset = str_repeat("   ", $stringOffset);

            if ($value instanceof Config) {
                $value = $value->toString($stringOffset + 1);
                $text .= "{$offset}{$property} = \n{$value}";
            } else {
                $text .= "{$offset}{$property} = {$value}\n";
            }
        }

        return $text;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return json_decode(json_encode($this->toObject()), true);
    }

    /**
     * @return string
     */
    public function toPHP()
    {
        return var_export($this->toArray(), true) . ';' . PHP_EOL;
    }

    /**
     * @return string
     */
    public function toIni()
    {
        $lines = ['[dez-app-config]'];
        $this->createIni($this->toArray(), [], $lines);

        return implode(PHP_EOL, $lines);
    }

    /**
     * @param array $array
     * @param array $indexes
     * @param array $lines
     */
    private function createIni(array $array = [], $indexes = [], &$lines = [])
    {
        foreach ($array as $index => $value) {
            $indexes[] = $index;

            if(is_array($value)) {
                $this->createIni($value, $indexes, $lines);
            } else {
                $lines[] = implode('.', $indexes) . '="' . addcslashes($value, '"') . '"';
            }

            array_pop($indexes);
        }
    }

    /**
     * @return \stdClass
     */
    public function toObject()
    {
        $configObject = new \stdClass();

        foreach ($this as $property => $value) {
            $configObject->{$property} = (is_object($value) && $value instanceof ConfigInterface)
                ? $value->toObject() : $value;
        }

        return $configObject;
    }

    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this->toObject(), JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->config);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->config);
    }

    /**
     * @param mixed $index
     * @return bool
     */
    public function offsetExists($index)
    {
        return $this->has($index);
    }

    /**
     * @param mixed $index
     * @return null
     */
    public function offsetUnset($index)
    {
        unset($this->config[$index]);

        return null;
    }

    /**
     * @param mixed $index
     * @return null
     */
    public function offsetGet($index)
    {
        return $this->get($index);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->config);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->toString();
    }

}