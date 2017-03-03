<?php

namespace Dez\Config\Adapter;

use Dez\Config\Config;
use Dez\Config\Exception;

class Ini extends Config
{

    /**
     * Ini constructor.
     * @param string $filePath
     * @throws Exception
     */
    public function __construct($filePath = '')
    {
        if (!file_exists($filePath)) {
            throw new Exception("Config file dont exists {$filePath}");
        }

        $configArray = parse_ini_file(realpath($filePath), true);

        if (isset($configArray[Config::CONFIG_INI_SECTOR])) {
            $configArray = $this->createConfigArray($configArray);
        }

        parent::__construct($configArray);
    }

    private function createConfigArray(array $configArray)
    {
        $config = $configArray[Config::CONFIG_INI_SECTOR];
        $configArray = [];

        foreach ($config as $path => $value) {

            $temporaryArray = &$configArray;
            foreach (explode('.', $path) as $key) {
                $temporaryArray = &$temporaryArray[$key];
            }
            $temporaryArray = $value;

        }

        return $configArray;
    }

}