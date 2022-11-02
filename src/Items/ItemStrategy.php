<?php

namespace GildedRose\Items;

use GildedRose\Item;

interface ItemStrategy
{
    public function update(): Item;
}
