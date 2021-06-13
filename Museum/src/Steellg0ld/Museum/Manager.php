<?php

namespace Steellg0ld\Museum;

use pocketmine\entity\Entity;
use pocketmine\inventory\ShapelessRecipe;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use Steellg0ld\Museum\commands\defaults\Faction;
use Steellg0ld\Museum\commands\defaults\Manage;
use Steellg0ld\Museum\commands\defaults\Settings;
use Steellg0ld\Museum\commands\defaults\Shop;
use Steellg0ld\Museum\commands\defaults\Test;
use Steellg0ld\Museum\custom\armor\NetheriteBoots;
use Steellg0ld\Museum\custom\armor\NetheriteChestplate;
use Steellg0ld\Museum\custom\armor\NetheriteHelmet;
use Steellg0ld\Museum\custom\armor\NetheriteLeggings;
use Steellg0ld\Museum\custom\items\Axe;
use Steellg0ld\Museum\custom\items\Hoe;
use Steellg0ld\Museum\custom\items\Pickaxe;
use Steellg0ld\Museum\custom\items\Shovel;
use Steellg0ld\Museum\custom\items\Sword;
use Steellg0ld\Museum\custom\items\TieredTool;
use Steellg0ld\Museum\entity\Wither;
use Steellg0ld\Museum\listeners\player\EnderPearl;
use Steellg0ld\Museum\listeners\player\Netherite;
use Steellg0ld\Museum\listeners\player\PlayerListener;

class Manager{
    const ITEM_NETHERITE_SCRAP = 752;
    const ITEM_NETHERITE_INGOT = 742;
    const ITEM_NETHERITE_SWORD = 743;
    const ITEM_NETHERITE_SHOVEL = 744;
    const ITEM_NETHERITE_PICKAXE = 745;
    const ITEM_NETHERITE_AXE = 746;
    const ITEM_NETHERITE_HOE = 747;

    public function loadCommands(Plugin $plugin){
        $plugin->getServer()->getCommandMap()->registerAll("museum",[
            new Test("emoticons","Show all emoticons","",["emoticons","png"]),
            new Faction("faction","Faction command","",["fac","f"]),
            new Settings("settings","Configure your game","",["configure","setting"]),
            new Shop("shop","Buy a item simply",""),
            new Manage("manage","Edit player informations","")
        ]);
    }

    public function loadListeners(Plugin $plugin){
        $plugin->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $plugin);
        $plugin->getServer()->getPluginManager()->registerEvents(new EnderPearl(), $plugin);
        $plugin->getServer()->getPluginManager()->registerEvents(new Netherite(), $plugin);
    }

    public function loadEntitys(Plugin $plugin){
        Entity::registerEntity(Wither::class, true, ["Wither", "minecraft:wither"]);
    }

    public function loadItems(Plugin $plugin){
        ItemFactory::registerItem(new Item(self::ITEM_NETHERITE_INGOT, 0, "Netherite Ingot"), true);
        ItemFactory::registerItem(new Item(self::ITEM_NETHERITE_SCRAP, 0, "Netherite Scrap"), true);
        ItemFactory::registerItem(new Sword(self::ITEM_NETHERITE_SWORD, 0, "Netherite Sword", TieredTool::TIER_NETHERITE), true);
        ItemFactory::registerItem(new Shovel(self::ITEM_NETHERITE_SHOVEL, 0, "Netherite Shovel", TieredTool::TIER_NETHERITE), true);
        ItemFactory::registerItem(new Pickaxe(self::ITEM_NETHERITE_PICKAXE, 0, "Netherite Pickaxe", TieredTool::TIER_NETHERITE), true);
        ItemFactory::registerItem(new Axe(self::ITEM_NETHERITE_AXE, 0, "Netherite Axe", TieredTool::TIER_NETHERITE), true);
        ItemFactory::registerItem(new Hoe(self::ITEM_NETHERITE_HOE, 0, "Netherite Hoe", TieredTool::TIER_NETHERITE), true);
        ItemFactory::registerItem(new NetheriteHelmet(), true);
        ItemFactory::registerItem(new NetheriteChestplate(), true);
        ItemFactory::registerItem(new NetheriteLeggings(), true);
        ItemFactory::registerItem(new NetheriteBoots(), true);

        Item::initCreativeItems();
    }

    public function loadRecipes(Plugin $plugin){
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_SWORD), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(self::ITEM_NETHERITE_SWORD)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_SHOVEL), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(self::ITEM_NETHERITE_SHOVEL)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_PICKAXE), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(self::ITEM_NETHERITE_PICKAXE)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_AXE), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(self::ITEM_NETHERITE_AXE)]));

        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_HELMET), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(NetheriteHelmet::NETHERITE_HELMET)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_CHESTPLATE), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(NetheriteChestplate::NETHERITE_CHESTPLATE)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_LEGGINGS), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(NetheriteLeggings::NETHERITE_LEGGINGS)]));
        $plugin->getServer()->getCraftingManager()->registerShapelessRecipe(new ShapelessRecipe([Item::get(Item::DIAMOND_BOOTS), Item::get(self::ITEM_NETHERITE_INGOT)], [Item::get(NetheriteBoots::NETHERITE_BOOTS)]));
    }
}