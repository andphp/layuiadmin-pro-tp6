<?php
declare (strict_types = 1);

namespace app\home\controller;

use think\facade\View;

class IndexController
{
    public function index()
    {
        return "AndPHP: Hello LayuiAdmin!";
    }
}
