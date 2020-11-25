<?php
declare (strict_types = 1);

namespace app\admin\controller;


use app\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        throw new \app\exception\BasicException();
//        $error='dd';
        return json($error);
    }
}
