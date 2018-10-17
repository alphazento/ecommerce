<?php

namespace Zento\Contracts\Catalog\Model;

interface Category extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['id', 'level', 'url_path', 'path', 'include_in_menu'];
}