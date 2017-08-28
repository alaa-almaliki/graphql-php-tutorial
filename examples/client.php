<?php
require_once __DIR__ . '/../src/Graphql/Client/Query/Argument.php';
require_once __DIR__ . '/../src/Graphql/Client/Query/Field.php';
require_once __DIR__ . '/../src/Graphql/Client/Query/Parser.php';
return [
    'send' => function ($url, $query, $toArray = false) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($query))
        );
        $result = curl_exec($ch);
        curl_close($ch);

        if ($toArray) {
            $result =  json_decode($result, true);
        }
        return $result;
    }
];
