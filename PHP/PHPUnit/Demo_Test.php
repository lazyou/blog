<?php
/**
 * PhpUnderControl_Demo_Test
 *
 * 针对 ./Demo.php Demo 类的PHPUnit单元测试
 *
 * @author: dogstar 20170503
 */

// require_once dirname(__FILE__) . '/test_env.php';

if (!class_exists('Demo')) {
    require dirname(__FILE__) . '/./Demo.php';
}

class PhpUnderControl_Demo_Test extends PHPUnit_Framework_TestCase
{
    public $demo;

    protected function setUp()
    {
        parent::setUp();

        $this->demo = new Demo();
    }

    protected function tearDown()
    {
    }


    /**
     * @group testInc
     */ 
    public function testInc()
    {
        // Step 1. 构造
        $left = 1;
        $right = 1;

        // Step 2. 操作
        $rs = $this->demo->inc($left, $right);

        // Step 3. 检测
        $this->assertTrue(is_int($rs));
        $this->assertSame(2, $rs);
    }

    /**
     * @group testInc
     */ 
    public function testIncCase0()
    {
        $rs = $this->demo->inc(1,1);

        $this->assertEquals(2, $rs);
    }

    /**
     * @group testInc
     */ 
    public function testIncCase1()
    {
        $rs = $this->demo->inc(-10,5);

        $this->assertEquals(-5, $rs);
    }

}
