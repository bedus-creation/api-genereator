<?php

namespace JoBins\APIGenerator\Tests;

use JoBins\APIGenerator\Generator\Field;
use JoBins\APIGenerator\Generator\Schema;

class UnionTest extends TestCase
{
    public function testOk()
    {

    }
}

class Category
{
    public int    $id;
    public string $name;
}

class Pet
{
    public int    $id;
    public string $name;

    public Category $category;

    public array $urls;
}
