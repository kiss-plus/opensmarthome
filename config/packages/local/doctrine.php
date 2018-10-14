<?php
$secretsDir = dirname(__DIR__, 3) . '/docker/secrets/local/';
$container->loadFromExtension(
    'doctrine', [
        'dbal' => [
            'connections' => [
                'default' => [
                    'url' => sprintf(
                        'mysql://%s:%s@%s:%s/%s',
                        file_get_contents($secretsDir . 'db_user.example'),
                        file_get_contents($secretsDir . 'db_password.example'),
                        file_get_contents($secretsDir . 'db_host.example'),
                        file_get_contents($secretsDir . 'db_port.example'),
                        file_get_contents($secretsDir . 'db_name.example')
                    )
                ]
            ]
        ]
    ]
);