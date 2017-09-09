<?php
namespace GraphQL\Client\Query\Utils\Data;

/**
 * Class Normaliser
 * @package GraphQL\Client\Query\Utils\Data
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Normaliser
{
    /**
     * @param  array $data
     * @return array
     */
    static public function normaliseFragmentData(array $data)
    {
        static $fieldsKey       = 'fields';
        static $fieldKeys       = ['field', 'field_name'];
        static $fragmentKeys    = ['fragment_name', 'name', 'fragment'];
        static $typeKeys        = ['type', 'type_name'];

        $normalisedData = [
            'fields' => $data[$fieldsKey],
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, $fieldKeys)) {
                $normalisedData['field'] = $value;
            }

            if (in_array($key, $fragmentKeys)) {
                $normalisedData['name'] = $value;
            }

            if (in_array($key, $typeKeys)) {
                $normalisedData['type'] = $value;
            }
        }

        return $normalisedData;
    }

    /**
     * @param  array $data
     * @return array
     */
    static public function normaliseFieldData(array $data)
    {
        static $fieldNameKeys       = ['name', 'field_name', 'field'];
        static $fieldAliasNameKeys  = ['alias_name', 'field_alias_name', 'field_alias', 'alias'];
        static $argumentKeys        = ['argument', 'arguments', 'argument_data', 'arguments_data'];
        static $fragmentKeys        = ['fragment', 'fragment_data'];
        static $inlineFragmentKeys  = ['inline', 'inline_fragment', 'inline_data', 'inline_fragment_data'];
        static $directiveKeys       = ['directive', 'directive_data'];
        static $fieldsKeys          = ['fields', 'child_fields', 'fields_data', 'child'];

        $normalisedData = [
            'name'              => null,
            'alias_name'        => null,
            'arguments'         => [],
            'fragment'          => [],
            'inline_fragment'   => [],
            'directive'         => [],
            'fields'            => []
        ];

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }

            if (in_array($key, $fieldNameKeys)) {
                $normalisedData['name'] = $value;
            }

            if (in_array($key, $fieldAliasNameKeys)) {
                $normalisedData['alias_name'] = $value;
            }

            if (in_array($key, $argumentKeys)) {
                $normalisedData['arguments'] = $value;
            }

            if (in_array($key, $fragmentKeys)) {
                $normalisedData['fragment'] = $value;
            }

            if (in_array($key, $inlineFragmentKeys)) {
                $normalisedData['inline_fragment'] = $value;
            }

            if (in_array($key, $directiveKeys)) {
                $normalisedData['directive'] = $value;
            }

            if (in_array($key, $fieldsKeys)) {
                $normalisedData['fields'] = $value;
            }
        }

        return $normalisedData;
    }
}