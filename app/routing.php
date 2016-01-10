<?php


return [
    'login' => [
        'route' => '/login',
        'controller' => 'Dime\Server\Endpoint\Authentication:login',
        'map' => ['POST']
    ],
    'logout' => [
        'route' => '/logout',
        'controller' => 'Dime\Server\Endpoint\Authentication:logout',
        'map' => ['POST']
    ],
    'parser_analyse' => [
        'route' => '/analyse/{name}',
        'controller' => 'Dime\Server\Endpoint\Parser:analyse',
        'map' => ['POST']
    ],
    'resource_get' => [
        'route' => '/api/{resource}/{id:\d+}',
        'controller' => 'Dime\Server\Endpoint\Resource:getAction',
        'map' => ['GET'],
        'middleware' => [
            'Dime\Server\Middleware\ContentNegotiation:run',
            'Dime\Server\Middleware\ResourceType:run',
        ]
    ],
    'resource_list' => [
        'route' => '/api/{resource}',
        'controller' => 'Dime\Server\Endpoint\Resource:listAction',
        'map' => ['GET'],
        'middleware' => [
            'Dime\Server\Middleware\ContentNegotiation:run',
            'Dime\Server\Middleware\ResourceType:run',
        ]
    ],
    'resource_post' => [
        'route' => '/api/{resource}',
        'controller' => 'Dime\Server\Endpoint\Resource:postAction',
        'map' => ['POST'],
        'middleware' => [
            'Dime\Server\Middleware\ContentNegotiation:run',
            'Dime\Server\Middleware\ResourceType:run',
        ]
    ],
    'resource_put' => [
        'route' => '/api/{resource}/{id:\d+}',
        'controller' => 'Dime\Server\Endpoint\Resource:putAction',
        'map' => ['PUT'],
        'middleware' => [
            'Dime\Server\Middleware\ContentNegotiation:run',
            'Dime\Server\Middleware\ResourceType:run',
        ]
    ],
    'resource_delete' => [
        'route' => '/api/{resource}/{id:\d+}',
        'controller' => 'Dime\Server\Endpoint\Resource:deleteAction',
        'map' => ['DELETE'],
        'middleware' => [
            'Dime\Server\Middleware\ContentNegotiation:run',
            'Dime\Server\Middleware\ResourceType:run',
        ]
    ]
];
