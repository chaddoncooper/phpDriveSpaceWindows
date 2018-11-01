<?php

class Math
{
	public static function GetPercentage($total, $number, $rounding = 2)
    {
        if ($total > 0) {
            return round($number / ($total / 100), $rounding);
        } else {
            return 0;
        }
    }
}
