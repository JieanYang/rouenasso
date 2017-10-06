<?php 

namespace App\Model;

use App\Model\Enum;

abstract class Position extends Enum {
	const ZHUXI = "主席";
    const FUZHUXI = "副主席";
    const BUZHANG = "部长";
    const FUBUZHANG = "副部长";
    const CHENGYUAN = "成员";
}

////

