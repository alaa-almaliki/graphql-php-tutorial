<?php
namespace GraphQL\Client\Query;

/**
 * Class Parser
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Parser
{
    /** @var array  */
    private $queries = [];
    /** @var  QueryBuilder */
    private $currentQueryBuilder;

    /**
     * The query name is made required here
     * to ensure good practices so to track query builders in Parser object
     *
     * @param  string $queryName
     * @param  string $queryType
     * @return QueryBuilder
     * @throws QueryException
     */
    public function createQueryBuilder($queryName, $queryType = Type::QUERY_TYPE_QUERY)
    {
        if (!$queryName) {
            throw new QueryException(self::class . ': Query name is required');
        }

        $this->currentQueryBuilder = new QueryBuilder($queryName, $queryType);
        $this->queries[$this->currentQueryBuilder->getName()] = $this->currentQueryBuilder;
        return $this->currentQueryBuilder;
    }

    /**
     * To get specific query builder, pass in the query name, else get the last created query builder
     *
     * @param  null|string $queryName
     * @return QueryBuilder|mixed
     * @throws QueryException
     */
    public function getQueryBuilder($queryName = null)
    {
        if ($queryName === null) {
            return $this->currentQueryBuilder;
        }

        if (!isset($this->queries[$queryName])) {
            throw new QueryException('Can not found QueryBuilder with name: ' . $queryName);
        }

        $this->currentQueryBuilder =  $this->queries[$queryName];
        return $this->currentQueryBuilder;
    }

    /**
     * @param  bool $debug
     * @return string
     */
    public function parse($debug = false)
    {
        $variables = [];
        foreach ($this->currentQueryBuilder->getVariables() as $varName => $var) {
            $variables[$varName] = $var['value'];
        }

        $queryData = [
            'query' => (string) $this->currentQueryBuilder,
            'variables' => $variables
        ];

        $query =  json_encode($queryData);
        if ($debug === true) {
            print_r($query);
        }

        return $query;
    }
}