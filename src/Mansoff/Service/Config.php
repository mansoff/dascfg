<?php declare(strict_types=1);

namespace Mansoff\Service;

class Config implements ConfigInterface
{
    /**
     * @var array
     */
    protected $configHeap = [];

    /**
     * @var string
     */
    protected $keySeparator = '';

    /**
     * Config constructor.
     * @param array $configHeap
     * @param string $keySeparator
     */
    public function __construct(
        array $configHeap,
        string $keySeparator = ':'
    ) {
        $this->configHeap = $configHeap;
        $this->keySeparator = $keySeparator;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        $keys = $this->getAllKeys($key);

        return $this->getValue($keys);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        $keys = $this->getAllKeys($key);

        return $this->checkKeys($keys);
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->configHeap;
    }

    /**
     * @param array $keys
     * @return bool
     */
    protected function checkKeys(array $keys) : bool
    {
        if (count($keys) === 1) {
            $key = reset($keys);

            return isset($this->configHeap[$key]);
        }

        $lastNode = null;
        foreach ($keys as $key) {

            if ($lastNode === null && !isset($this->configHeap[$key])) {
                return false;
            }

            if ($lastNode !== null && !isset($lastNode[$key])) {
                return false;
            }

            if ($lastNode === null) {
                $lastNode = &$this->configHeap[$key];
            } else {
                $lastNode = &$lastNode[$key];
            }
        }

        return true;
    }

    /**
     * @param array $keys
     * @return mixed|null
     */
    protected function getValue(array $keys)
    {
        if (count($keys) === 1) {
            $key = reset($keys);

            return $this->configHeap[$key] ?? null;
        }

        $lastNode = null;
        foreach ($keys as $key) {

            if ($lastNode === null && !isset($this->configHeap[$key])) {
                return null;
            }

            if ($lastNode !== null && !isset($lastNode[$key])) {
                return null;
            }

            if ($lastNode === null) {
                $lastNode = &$this->configHeap[$key];
            } else {
                $lastNode = &$lastNode[$key];
            }
        }

        return $lastNode;
    }

    /**
     * @param string $keys
     * @return array
     */
    protected function getAllKeys(string $keys) : array
    {
        return explode($this->keySeparator, $keys);
    }
}