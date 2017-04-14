<?php

use Colibri\Parameters\ParametersCollection;
use Colibri\Parameters\Parser\IniParser;
use Colibri\Parameters\Parser\JsonParser;
use Colibri\Parameters\Parser\YamlParser;

include_once '../vendor/autoload.php';

error_reporting( E_ALL | E_STRICT );
ini_set( 'display_errors', 'On' );

class PlaceholderCollection extends ParametersCollection {
  
  
}

$main = new PlaceholderCollection();

$parametersA = new ParametersCollection([
  'a' => 1,
  'b' => 2,
  'c' => [
    'd' => [
      'e' => 123
    ],
  ],
]);

$parametersB = new ParametersCollection([
  'c' => [
    'd' => [
      'f' => 777,
    ],
  ],
  'z' => 987654321,
]);

$parametersA->merge($parametersB);

$array = IniParser::parse('
[abc]
a=123
[simple]
    val_one = "some value"
    val_two = 567
    db.connection.is_mysql = true
    ');

$parametersC = new ParametersCollection($array);
$parametersC->getIterator()->getArrayCopy();
$parametersA->merge($parametersC);
$parametersA->merge(new ParametersCollection(JsonParser::parse('
{
    "glossary": {
        "title": "example glossary",
		"GlossDiv": {
            "title": "S",
			"GlossList": {
                "GlossEntry": {
                    "ID": "SGML {app.root} {app.file}",
					"SortAs": "SGML",
					"GlossTerm": "Standard Generalized Markup Language",
					"Acronym": "SGML",
					"Abbrev": ["ISO 8879", "1986"],
					"GlossDef": {
                        "para": "A meta-markup language, used to create markup languages such as DocBook.",
						"GlossSeeAlso": ["GML", "XML"]
                    },
					"GlossSee": "markup"
                }
            }
        }
    }
}
')));

//var_dump($parametersA, $array);

$parametersA->merge(ParametersCollection::createFromFile('./_config.php'));

$main->merge($parametersA)->merge(ParametersCollection::createFromFile(__DIR__ . '/_config.ini'));

$main->set('aaa.ddd', 'test app.db.host');

var_dump($main->handlePlaceholders()->toINI());

//use Dez\Config\Config;
//
//include_once '../vendor/autoload.php';
//
//$config     = new Dez\Config\Adapter\NativeArray('./_config.php');
//$configJson = new Dez\Config\Adapter\Json('./_config.json');
//
//$config = Config::factory('./_config.ini')
//    ->merge($configJson);
//
//die(var_dump($config->toArray(), $config->toIni(), $config->toJSON(), $config->toPHP()));
