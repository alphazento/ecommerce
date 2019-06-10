<?php

namespace Zento\Contracts\Interfaces\Catalog;

interface ICategory extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['id', 'level', 'url_path', 'path', 'include_in_menu'];
}