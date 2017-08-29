<?php
namespace GraphQL\Client\Query;

interface QueryInterface
{
    public function setName($name);

    public function getName();

    public function __toString();

}