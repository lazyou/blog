<?php
namespace factoryAbstract;

class PandaZoo implements ZooInterface
{
    public function show()
    {
        echo "熊猫元开馆\n\r";
    }

    public function money()
    {
        $this->show();

        echo "买门票\n\r";
    }
}
