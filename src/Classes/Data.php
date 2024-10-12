<?php

namespace App\Classes;

class Data 
{
    public function __construct(
        public array $dataFight = [
            'Orderus' => ['health' => 0],
            'Minyak' => ['health' => 0],
            'attacker' => null,
            'countFights' => 0,
            'gameOver' => false,
        ],
        public string $destination = 'data/savedData.txt'
    ) {
    }

    public function save(array $data): void
    {
        $saveData = file_put_contents($this->destination, serialize($data));
    }

    public function getData(): array 
    {
        $data = unserialize(file_get_contents($this->destination));

        return $data;
    }
}
