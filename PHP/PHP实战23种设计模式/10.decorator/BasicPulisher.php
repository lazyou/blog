<?php
namespace decorator;

class BasicPulisher implements PulisherInterface
{
    public function pulishText() {
        echo 'this is the text compnent'.PHP_EOL;
    }
}