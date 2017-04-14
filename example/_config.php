<?php

    return [
        'app'   => [
            'file' => __FILE__,
            'root' => __DIR__,
            'db' => [
                'host' => 'localhost',
                'b' => '333qqq',
                'pass' => '12qwqw'
            ],
            'components' => [
                'auth' => [
                    'type'  => 'simple2 ',
                    'lol' => [
                        'test' => 123.11
                    ]
                ],

            ]
        ],
        'salt' => 'asd123',
        'app_name' => 'Name',
        'connection' => 'UserName: {db.connection.development.user} with password {db.connection.production.password} Main Format: [{glossary.GlossDiv.GlossList.GlossEntry.GlossDef.GlossSeeAlso.1}]'
    ];