<?php

namespace GildedRose\Items;

use GildedRose\Item;

class ItemContext
{
    private ItemStrategy $strategy;
    public function __construct()
    {
    }

    public function setStrategy(ItemStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function updateProduct(): Item
    {
        return $this->strategy->update();
    }
}
