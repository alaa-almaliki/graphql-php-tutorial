<?php
namespace GraphQL\Client\Query;

/**
 * Class Type
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class KeyWord
{
    const KEY_WORD_QUERY      = 'query';
    const KEY_WORD_MUTATION   = 'mutation';

    /** @var  string */
    private $keyWord;

    /**
     * KeyWord constructor.
     * @param string $keyWord
     */
    public function __construct($keyWord)
    {
        $this->keyWord = $keyWord;
    }

    /**
     * @param  string $keyWord
     * @return $this
     */
    public function setKeyword($keyWord)
    {
        $this->keyWord = $keyWord;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeyWord()
    {
        return $this->keyWord;
    }

    /**
     * @return bool
     */
    public function isQuery()
    {
        return $this->getKeyWord() === self::KEY_WORD_QUERY;
    }

    /**
     * @return bool
     */
    public function isMutation()
    {
        return $this->getKeyWord() === self::KEY_WORD_MUTATION;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return in_array($this->keyWord, $this->getAvailableTypes());
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return [
            self::KEY_WORD_QUERY,
            self::KEY_WORD_MUTATION,
        ];
    }
}