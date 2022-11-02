<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Items\ItemContext;
use GildedRose\Items\ItemStrategy;
use GildedRose\Items\Products\AgedBrie;
use GildedRose\Items\Products\Backstage;
use GildedRose\Items\Products\Conjured;
use GildedRose\Items\Products\DefaultProduct;
use GildedRose\Items\Products\Sulfuras;

class GildedRose
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    private array $productArray = [
        'Aged Brie' => AgedBrie::class,
        'Backstage passes to a TAFKAL80ETC concert' => Backstage::class,
        'Sulfuras, Hand of Ragnaros' => Sulfuras::class,
        'Conjured Mana Cake' => Conjured::class
    ];

    private function getUpdateStrategy(Item $item): ItemStrategy
    {
        if (array_key_exists($item->name, $this->productArray)) {
            return new $this->productArray[$item->name]($item);
        }
        return new DefaultProduct($item);
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $context = new ItemContext();
            $context->setStrategy($this->getUpdateStrategy($item));
            $context->updateProduct();
        }
    }
}
