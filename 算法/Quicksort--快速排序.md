#### 快速排序
* https://zh.wikipedia.org/wiki/%E5%BF%AB%E9%80%9F%E6%8E%92%E5%BA%8F


#### 简介
> **快速排序**（英语：Quicksort），又称**划分交换排序**（partition-exchange sort），一种排序算法，最早由东尼·霍尔提出。
>
> 在平均状况下，排序n个项目要Ο(n log n)次比较。在最坏状况下则需要Ο(n2)次比较，但这种状况并不常见。
>
> 事实上，快速排序通常明显比其他Ο(n log n)算法更快，因为它的内部循环（inner loop）可以在大部分的架构上很有效率地被实现出来。


#### 算法
> 快速排序使用分治法（Divide and conquer）策略来把一个序列（list）分为两个子序列（sub-lists）。
>
> 步骤为：
    > 1. 从数列中挑出一个元素，称为"基准"（pivot），
    >
    > 2. 重新排序数列，所有比基准值小的元素摆放在基准前面，所有比基准值大的元素摆在基准后面（相同的数可以到任一边）。在这个分区结束之后，该基准就处于数列的中间位置。这个称为*分区（partition）*操作。
    >
    > 3. 递归地（recursively）把小于基准值元素的子数列和大于基准值元素的子数列排序。递归到最底部时，数列的大小是零或一，也就是已经排序好了。这个算法一定会结束，因为在每次的迭代（iteration）中，它至少会把一个元素摆到它最后的位置去。


#### PHP 
* 从尾端取元素作为比较基准
```php
function quick_sort($arr) {
	$len = count($arr);

	if ($len <= 1)
		return $arr;

	$left = $right = array();
	$mid_value = $arr[0];

	for ($i = 1; $i < $len; $i++)
		if ($arr[$i] < $mid_value)
			$left[] = $arr[$i];
		else
			$right[] = $arr[$i];

	return array_merge(quick_sort($left), (array)$mid_value, quick_sort($right));
}

$arr = array(21, 34, 3, 32, 82, 55, 89, 50, 37, 5, 64, 35, 9, 70);
$arr = quick_sort($arr);
for ($i = 0; $i < count($arr); $i++) {
	echo $arr[$i] . ' ';
}
```