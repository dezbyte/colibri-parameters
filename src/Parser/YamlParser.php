<?php

namespace Colibri\Parameters\Parser;

use Colibri\Parameters\ParserInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlParser
 * @package Colibri\Parameters\Parser
 */
class YamlParser implements ParserInterface
{
  
  /**
   * @inheritDoc
   */
  public static function parse($contentString)
  {
    return Yaml::parse($contentString);
  }
  
  /**
   * @inheritDoc
   */
  public static function dump(array $parameters)
  {
    return Yaml::dump($parameters, 16);
  }
  
}