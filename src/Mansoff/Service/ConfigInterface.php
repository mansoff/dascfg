<?php

namespace Mansoff\Service;

interface ConfigInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool;

    /**
     * @return array
     */
    public function getAll() : array;
}