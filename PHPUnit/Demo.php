<?php

class Demo {

    /**
     * 求两数和
     *
     * @testcase 2 1,1
     * @testcase -5 -10,5
     *
     * @param int $left 左操作数
     * @param int $right 右操作数
     * @return int
     */
	public function inc($left, $right) {
		return $left + $right;
	}
}
