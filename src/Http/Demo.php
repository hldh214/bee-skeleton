<?php
namespace Star\Http;

use Star\Util\Http;

class Demo extends Http
{
    public function hello()
    {
        return ['done'];
    }
}
