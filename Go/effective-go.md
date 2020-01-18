gofmt
godoc

## 包名
* 应为其源码目录的基本名称.在 `src/pkg/encoding/base64` 中的包应作为 `encoding/base64` 导入, 其包名应为 base64,  __而非__ `encoding_base64` 或 `encodingBase64`

* bufio 包中的缓存读取器类型叫做 Reader 而非 BufReader, bufio.Reader 不会与 io.Reader 发生冲突

* 简而言之, 目录不要超过2层


## 获取器和设置器
* 获取器: 若你有个名为 owner (小写, 未导出)的字段, 其获取器应当名为 Owner(大写, 可导 出)而非 GetOwner;
* 设置器: SetOwner;


## 接口名
* 按照约定, __只包含一个方法的接口__ 应当以该方法的名称加上 - er 后缀来命名, 如 Reader、 Writer、 Formatter、CloseNotifier 等

* Read、Write、 Close、Flush、 String 等都具有典型的签名和意义.为避免冲突, 请不要用这些名称为你的 方法命名,  除非你明确知道它们的签名和意义相同.

* 驼峰记法: Go 中约定使用驼峰记法 MixedCaps 或 mixedCaps;


## 控制结构
* 警告:无论如何, 你都不应将一个控制结构(if、for、switch 或 select)的左大括号放在下一行;

* 包含类型选择和多路通信复用器的新控制结构:select.

* 若 if 语句不会执行到下一条语句时(以 break、 continue、goto 或 return 结束时), 省略不必要的 else;


## 重新声明与再次赋值
* 常见错误: "No new variables on left side of :="


## for [range]
* 对于字符串, range 能够提供更多便利.它能通过解析 UTF-8,  将每个独立的 Unicode 码点 分离出来.错误的编码将占用一个字节, 并以符文 U+FFFD 来代替.
```go
for pos, char := range "日本\x80語" { // \x80 is an illegal UTF-8 encoding
    fmt.Printf("character %#U starts at byte position %d\n", char, pos)
}
```


## switch
* switch 并不会自动下溯, case 可通过逗号分隔来列举相同的处理条件

* 若 switch 后面没有表达式, 它将匹配 true, 因此, 我们可以将 if-else-if- else 链写成一个 switch
```go
a :=1
switch { // 此处没有表达式
case a<0:
    fmt.Println("a<0")
case a>0:
    fmt.Println("a>0")
case a==1: // 满足上面case则不会继续执行, 无需break
    fmt.Println("a==0")
default:
    fmt.Println("default")
}
``` 

## 类型选择 
* t.(type)

* switch 也可用于判断接口变量的动态类型
```go
i := 1
var t interface{}
t = &i
switch t := t.(type) {
case bool:
    fmt.Printf("boolean %t\n", t) // t 是 bool 类型
case int:
    fmt.Printf("integer %d\n", t) // t 是 int 类型
case *bool:
    fmt.Printf("pointer to boolean %t\n", *t) // t 是 *bool 类型
case *int:
    fmt.Printf("pointer to integer %d\n", *t) // t 是 *int 类型
default:
    fmt.Printf("unexpected type %T", t) // %T 输出 t 是什么类型
}
```


## 函数
* 多返回值: 通常 error 放最后;

* 返回值可命名: 
    * 命名后, 一旦该函数开始执行, 它们就会被初始化为与其类型相应的 __零值__； 
    * 若该函数执行了一 条不带实参的 return 语句, 则结果形参的当前值将被返回.

* defer: 按照后进先出(LIFO)的顺序执行;
    * 被推迟函数的实参(如果该函数为方法则还包括接收者)在推迟执行时就会求值, 而不是在调用执行时才求值.

```go
// 先进后出, 保留运行时值
for i := 0; i < 5; i++ {
    defer fmt.Printf("%d \n", i)
}

fmt.Println("main:")
```


* Go 提供了两种分配原语, 即内建函数 new 和 make

## new
* 是个用来分配内存的内建函数, 它不会初始化内存, 只会将内存置零;

## make
* 它只用于创建切片、 映射和信道, 返回一个已初始化的值;

* 三种类型本质上为引用数据类型, 它们在使用前必须初始化;



## 数组
* 特别地, 若将某个数组传入某个函数, 它将接收到该数组的一份副本而非指针.

* 数组的大小是其类型的一部分.类型 [10]int 和 [20]int 是不同的.


## 切片
* 切片通过对数组进行封装, 为数据序列提供了更通用、强大而方便的接口.

* 切片保存了对底层数组的引用, 若你将某个切片赋予另一个切片, 它们会 __引用__ 同一个数组.


## 映射
* 若试图通过映射中不存在的键来取值, 就会返回与该映射中项的类型对应的零值

* 区分某项是不存在还是其值为零值, 可以使用多重赋值的形式来分辨: `seconds, ok = timeZone[tz]`


## 打印
* 打印结构体:
    * %+v 会为结构体的每 个字段添上字段名;
    * %#v 将完全按照 Go 的语法打印值;

* 打印值的类型: %T;

* 打印字符串并带双引号: %q;

* 若想控制自定义类型的默认格式, 只需为该类型定义一个具有 `String() string` 签名的方法;
    * 请勿通过调用 `Sprintf` 来构造 `String` 方法, 因为它会无 限递归你的的 `String` 方法

* 三个点作为形参或实参:
    * ... 形参可指定具体的类型;
    * ... 写在 v 之后来告诉编译器将 v 视作一个实参列表, 否则 它会将 v 当做单一的切片实参来传递;

    ```go
    // 接受不定数量的 interface{} 作为形参, 而不是接受一个 []interface{} 类型作为形参;
    func Println(v ...interface{}) {    
        std.Output(2, fmt.Sprintln(v...)) // Output 接受形参 (int, string) 
    }
    ```


## init 函数
* 其实每个文件都可以拥有多个 init 函数;

* 什么时候调用?
    * 1.只有该包中的所有变量声明都通过它们的初始化器求值后 init 才会被调用, 而那些 init 只有在所有已导入的包都 被初始化后才会被求值. (TODO: 不太明白)
    * 2.除了那些不能被表示成声明的初始化外, init 函数还常被用在程序真正开始执行前, 检验或校 正程序的状态.


## 方法: 指针 vs. 值
* 可以为任何已命名的类型（除了指针或接口）定义方法; 接收者可不必为结构体.

* 指针或值为接收者的区别在于: __值方法__ 可通过指针和值调用,  __指针方法__ 只能通过指针来调用.
    * 之所以会有这条规则是因为 __指针方法__ 可以修改接收者;
    * 通过 __值调用__ 它们会导致方法接收到该值的副本, 因此任何修改都将被丢弃, 因此该语言不允许这种错误;
    * 不过有个方便的例外: 若该值是可寻址的,  那么该语言就会自动插入取址操作符来对付一般的通过值调用的指针方法. (例如: 变量 b 是可寻址的, 通过 b.Write 调用, 编译器会将它重写为 (&b).Write)



## 接口
* 每种类型都能实现多个接口;


## 类型转换


## 接口转换与类型断言
* __类型选择__ 是类型转换的一种形式: 它接受一个 __接口__, 在选择(switch)中根据其判断选择对应的情况(case), 并在某种意义上将其转换为该种类型. (案例见上面)

* 也就是说, 只有接口(interface{})才有断言的操作?

* 已知是唯一的某种类型: `val := value.(typeName)`
    * 但是万一转换失败程序会崩溃, 那么使用 `val, ok := value.(typeName)` 来判断该值的类型是否为 typeName;
    * 若类型断言失败, val 将 __继续存在__ 且为 typeName 类型, 但它将拥有零值;


## 接口的通用性 -- TODO: 费解且重要
* 若某种现有的类型仅实现了一个接口, 且除此之外并无可导出的方法, 则该类型本身就无需 导出. 仅导出该接口能让我们更专注于其行为而非实现, 其它属性不同的实现则能镜像该原始类型的行为. 这也能够避免为每个通用接口的实例重复编写文档.

* 在这种情况下, __构造函数应当返回一个接口值__ 而非实现的类型.例如在 hash 库中,  crc32.NewIEEE() 和 adler32.New() 都返回接口类型 hash.Hash32.要在 Go 程序中用 Adler-32 算法替代 CRC-32,  只需修改构造函数调用即可, 其余代码则不受算法改变的影响.

* 通俗理解: 鸭子类型用来做返回值. (而以前一直把鸭子类型局限于作为参数)


## 接口和方法
* 由于几乎任何类型都能添加方法，因此几乎任何类型都能满足一个接口
