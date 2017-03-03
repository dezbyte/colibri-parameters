<?php

    namespace Dez\Config;

    /**
     * Interface ConfigInterface
     * @package Dez\Config
     */
    interface ConfigInterface extends \ArrayAccess, \IteratorAggregate, \Countable {

        /**
         * @param $name
         * @return mixed
         */
        public function get( $name );

        /**
         * @param $path
         * @param $separator
         * @return mixed
         */
        public function path( $path, $separator );

        /**
         * @param $name
         * @return mixed
         */
        public function fetch( $name );

        /**
         * @param ConfigInterface $config
         * @return $config ConfigInterface
         */
        public function merge( ConfigInterface $config );

    }