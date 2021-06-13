<?php

namespace Steellg0ld\Museum\custom\armor;

use pocketmine\item\Armor;

class NetheriteLeggings extends Armor
{

    const NETHERITE_LEGGINGS = 750;

    public function __construct(int $meta = 0){
        parent::__construct(self::NETHERITE_LEGGINGS, $meta, "Netherite Leggings");
    }

    public function getDefensePoints() : int{
        return 6;
    }

    public function getMaxDurability() : int{
        return 556;
    }

}