<?php

namespace Colibri\Parameters;

/**
 * Interface ParserInterface
 * @package Colibri\Parametres
 */
interface ParserInterface
{
  
  /**
   * @param $contentString
   * @return mixed
   */
  public static function parse($contentString);
  
  /**
   * @param array $parameters
   * @return mixed
   */
  public static function dump(array $parameters);
  
}