<?php

namespace Colibri\Parameters;

/**
 * Interface ParametersInterface
 * @package Colibri\Parametres
 */
interface ParametersInterface extends \ArrayAccess, \IteratorAggregate, \Countable
{

  const PATH_SEPARATOR = '.';
  
  const PARSER_INI = 1;
  const PARSER_JSON = 2;
  const PARSER_YAML = 4;
  
  /**
   * @param $offset
   * @param $defaultValue
   * @return mixed
   */
  public function get($offset, $defaultValue = null);
  
  /**
   * @param $offset
   * @param $value
   * @return $this
   */
  public function set($offset, $value);
  
  /**
   * @param array $parameters
   * @return $this
   */
  public function bulk(array $parameters);
  
  /**
   * @param ParametersInterface $parameters
   * @return $this
   */
  public function merge(ParametersInterface $parameters);
  
  /**
   * @param $offset
   * @param string $separator
   * @return mixed
   */
  public function path($offset, $separator = self::PATH_SEPARATOR);
  
  /**
   * @param $content
   * @param int $parser
   * @return ParametersInterface
   */
  public static function createFromString($content, $parser = self::PARSER_YAML);
  
  /**
   * @param string $filepath
   * @return ParametersInterface
   */
  public static function createFromFile($filepath);
  
  /**
   * @param $content
   * @return ParametersInterface
   */
  public static function createFromYaml($content);
  
  /**
   * @param $content
   * @return ParametersInterface
   */
  public static function createFromJson($content);
  
  /**
   * @param $content
   * @return ParametersInterface
   */
  public static function createFromIni($content);
  
  /**
   * @param $offset
   * @return $this
   */
  public function remote($offset);
  
  /**
   * @return array
   */
  public function toArray();
  
  /**
   * @return string
   */
  public function toPHP();
  
  /**
   * @return string
   */
  public function toJSON();
  
  /**
   * @return string
   */
  public function toINI();
  
  /**
   * @return string
   */
  public function toYaml();
  
}