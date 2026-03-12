<?php

$json = json_decode(file_get_contents('composer.json'), true);
$json['autoload']['psr-4']['Endereco\\Oxid6Client\\'] =
    'source/modules/endereco/endereco-oxid6-client/';
file_put_contents(
    'composer.json',
    json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
);
