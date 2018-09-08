### 简述
* 选购线PHPUnit最佳实践：从入门到精通
* 重点： 
* http://mp.weixin.qq.com/s?__biz=MzA4NDU3NTg2OQ==&mid=401975995&idx=1&sn=3d83d4caf4deac3a15ba66240a3aed63&mpshare=1&scene=1&srcid=0401cDEJXDYMLuLfdi0hKLdb#wechat_redirect
***



### 内容


#### 1.安装PHPUnit
```
wget https://phar.phpunit.de/phpunit-5.7.phar
chmod +x phpunit-5.7.phar
sudo mv phpunit-5.7.phar /usr/local/bin/phpunit
phpunit --version // 更高版本需要php7
```


#### 2.测试骨架代码自动生成
* 一个待测试的类： 注意这里注释的内容很重要， 用于测试骨架生成分析
```php
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

```
* 在编写PHPUnit单元测试代码时，其实很多都是_对各个类的公共函数方法进行测试验证，检测代码覆盖率，验证预期效果_。为了编写单元测试的代码，我们可以有三种方式：
    * 手动编写：重复性人工编码，耗时多，代码产出比低
    * 使用phpunit-skelgen生成测试骨架：需要安装，生成的代码更倾向国外文化，且不能直接运行
    * 使用自定义脚本生成测试骨架：更具人性化、更有趣，且生成后可直接运行
* 测试骨架 phpunit-skelgen -- https://github.com/sebastianbergmann/phpunit-skeleton-generator
    * 为避免增加开发量， 可以使用PHPUnit提供的 `phpunit-skelgen` 来生成测试骨架。
    * 只是一开始我不知道有这个脚本，就自己写了一个，大大地提高了开发效率，也不用为另外投入时间去编写测试代码而烦心。
    * 但是后来我发现自定义的脚本比`phpunit-skelgen`更具人性化、更有趣，也更为有效。特此在这里分享一下。
* 作者写的测试骨架生成脚本 -- `build_phpunit_test_tpl.php` (https://github.com/Aevit/PhalApi-Schedule-Task-Demo/blob/master/PhalApi/build_phpunit_test_tpl.php)
    * 主要是利用php中的_反射_ (ReflectionClass / ReflectionMethod / ReflectionParameter) 实现对被测试类的分析 (解析其对象 方法 注释)从而生成测试骨架
    * 几行约定的注释达到迅速完成测试的效果，可以给开发人员带上心理上的喜悦，从而很容易接受并乐意去进行下一步的测试用例完善。
* 使用自定义脚本生成测试骨架
    * 预览要生成的测试代码： `php ./build_phpunit_test_tpl.php ./Demo.php Demo`
    * 预览没问题就生成测试骨架： `php ./build_phpunit_test_tpl.php ./Demo.php Demo > ./Demo_Test.php`


#### 3、编写测试的原则、模式和指导
* 在生成了测试骨架后，虽然可以直接运行并且通常会通过。但我们只是粗糙地简单调用，并没有进行_特定场景的验证以及业务规则、逻辑、算法的校验。_
* **F.I.R.S.T.原则**, FIRST原则是用于编写单元测试时应该考虑的并尽量满足的规范，分别是：
    * 快速 Fast
    * 独立 Independent
    * 可重复 Repeatable
    * 自足验证 Self-validating
    * 及时 Timely
* **构造-操作-检验（BUILD-OPERATE-CHECK）模式**
    * 这个模式也可以理解成：“当... 做...，应该...”。
    * 构造包括测试环境的搭建、测试数据前期的准备；
    * 操作是指对被测试对象的调用， 以及被测试对象之间的通信和协助交互；
    * 最后检验则是对业务规则的断言、对功能需求的验证。
    * 上面为例，我们需要对自动生成的单元测试代码进行细化，根据构造-操作-检验模式，修改后如下：
    ```php
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
    ```
* **如何编写高效测试代码**
* 与产品代码分开，与测试代码对齐
* 利用测试骨架（phpunit-skelgen或者自定义生成器）自动生成测试代码
* 使用测试替身、测试桩构建昂贵资源、制造异常情况
* 每个测试一个概念


#### 4、执行单元测试的N种方式
* a. 执行单个测试函数: `phpunit --filter testInc ./Demo_Test.php`
* b. 执行指定单元测试内某一组测试: `phpunit --group testInc ./Demo_Test.php`
* c. 执行单个测试文件: `phpunit ./Demo_Test.php`
* d. 执行单个目录下全部的测试文件: `phpunit ./tests`
* e. 执行测试套件（可自由组合多个目录和文件）: `hpunit -c ./phpunit.xml`
* f. 一键测试（集成多个测试套件到自定义脚本）: `./run_tests.sh`


#### 5、九个PHPUnit造假技巧详解
> 在编写单元测试时，我们首先需要进行的就是构造一个测试场景。_但很多时候，我们的功能实现又依赖于第三方接口或者外部数据。_
> 例如，我们需要验证用户领取优惠券的几个业务场景：
> * 第一次成功领券
> * 超出最大限制次数时领券
> * 底层接口异常时领券失败
> 而这些场景，我们更好的方案应该是模拟测试数据，也就是利用桩、替身、外部依赖注入等技巧来模拟测试数据，以达到更灵活、覆盖率更高的测试以及制造所需要的待测试场景。
> 
> 这也是编写单元测试中难度最大、维护成本最高的一部分。为了方便更多同学掌握“造假”技巧，降低对编写单元测试的学习成本，我们根据这几年的经验，从不同的项目情况总结了以下9个造假技巧。
>
> **首先**，最重要的一个原则是：“*给我一个入口，我可以模拟任何数据。*” 还有一个前提是：*尽量不修改产品源代码*。
>
> **其次**通常情况下，部分代码的写法会严重限制、甚至根本无法对其进行模拟，也就无法进行更好地单元测试。所以不被提倡的写法有：
> * _不提倡_使用面向过程的函数
> * _不提倡_使用静态类成员函数
> * _不提倡_使用private级别的类成员函数/属性
>
* a. 通过构造参数实现外部依赖注入

* b. 通过接口参数实现外部依赖注入

* c. 通过提取成员函数制造缝纫点

* d. 通过工厂方法或者资源容器进行外部注入

* e. 对使用单例模式的实例进行替换

* f. 对PHP官方函数进行模拟

* g. 通过结果收集器对输出进行模拟输出

* h. 模拟第三方接口返回的结果

* i. 对protected方法进行模拟替换

* 小结
    * 综上发现有一个原则：测试代码与产品代码分离，且测试时不能改动任何产品代码。
    * 此外，产品代码应尽量提供一个服务入口，即缝纫点，以便使用桩、替身。


#### 6、Jenkins持续集成、Sonar报告与代码测试覆盖率
* https://codefresh.io/codefresh-vs-jenkins
* 单元测试覆盖率： `phpunit --coverage-html ...` 
    * 对于那些没测试覆盖到的产品代码，我们都有理由怀疑它们的正确性


#### 7、TDD下的意图导向编程
* 测试象限图
* 意图导向编程
    * _在编写代码前，先写测试代码，更容易提高关注点_
    > 因为，在开发过程中， 大多时候会被外界打断（如需求沟通、线上问题处理、临时会议等），而通过单元测试则可以让你“几乎忘却需要做什么”的情况下重新让你回到之前的状态，特别在并行开发多个不同项目的需求时尤其重要。
    > 除此之外，遵循“红-绿-重构”这样的流程，我们可以在更高的层面关注需要实现的功能需求，并自顶而下地进行设计优化，精益代码。
    > 这里面包含了以下两种思想：
    > * 1、做正确的事，比把事情做正确更为重要。
    > * 2、设计软件有两种方法：一种是简单到明显没有缺陷，另一种复杂到缺陷不那么明显。> —— 托尼·霍尔
