<?php

declare(strict_types=1);

namespace GildedRose;

final class Item
{
    public string $name;
    public int $sell_in;
    public int $quality;

    public function __construct(string $name, int $sellIn, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sellIn;
        $this->quality = $quality;
    }

    public function __toString(): string
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }
}
