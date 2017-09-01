<?php
namespace GraphQL\Client\Query\Fragment\Data;

/**
 * Class Normaliser
 * @package GraphQL\Client\Query\Fragment\Data
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Normaliser
{
    /** @var string  */
    private static $fieldsKey = 'fields';
    /** @var array  */
    private static $fieldKeys = [
        'field',
        'field_name'
    ];
    /** @var array  */
    private static $fragmentKeys = [
        'fragment_name',
        'name',
        'fragment'
    ];
    /** @var array  */
    private static $typeKeys = [
        'type',
        'type_name'
    ];

    /**
     * @param  array $data
     * @return array
     */
    static public function normalise(array $data)
    {
        $normalised = [
            'fields' => $data[static::$fieldsKey],
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, static::$fieldKeys)) {
                $normalised['field'] = $value;
            }

            if (in_array($key, static::$fragmentKeys)) {
                $normalised['name'] = $value;
            }

            if (in_array($key, static::$typeKeys)) {
                $normalised['type'] = $value;
            }
        }

        return $normalised;
    }
}