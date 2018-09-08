<?php
namespace builder;

/**
 * Mp3构建器
 */
class Mp3 implements ProductInterface
{
    private $_name = '';

    private $_cpu = '';

    private $_ram = '';

    private $_storage = '';

    private $_os = '';

    /**
     * 构造函数
     *
     * @param string $name     名称
     * @param array  $hardware 构建硬件
     * @param array  $software 构建软件
     */
    public function __construct($name = '', $hardware = [], $software = [])
    {
        // 名称
        $this->_name = $name;
        echo $this->_name . " 配置如下：\n";

        // 构建硬件
        $this->hardware($hardware);

        // 构建软件
        $this->software($software);
    }

    /**
     * 构建硬件
     */
    public function hardware($hardware = [])
    {
        // 创建 CPU
        $this->_cpu = new HardwareCpu($hardware['cpu']);
        // 创建内存
        $this->_ram = new HardwareRam($hardware['ram']);
        // 创建存储
        $this->_storage = new HardwareStorage($hardware['storage']);
    }
}
