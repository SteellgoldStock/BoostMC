<?php

namespace Steellg0ld\Museum\base;

use Steellg0ld\Museum\api\Scoreboard;
use Steellg0ld\Museum\Plugin;
use Steellg0ld\Museum\tasks\async\RegisterPlayer;
use Steellg0ld\Museum\utils\Unicode;

class Player extends \pocketmine\Player
{
    public int $rank = Ranks::PLAYER;
    public array $settings = [
        "player_status" => 1,
        "economy_symbol" => 1,
        "unicode" => 0,
    ];


    public string $lang = "fr_FR";
    public int $money = 0;
    public string $faction = "none";
    public int $faction_role = 0;

    /** * @var string  */
    public string $discordId = "";

    /**
     * @param Int ...$ranks
     * @return bool
     */
    public function hasRank(Int ...$ranks): bool{
        if(in_array($this->rank, $ranks)) {
            return true;
        } else {
            return false;
        }
    }

    public function assign(){
        $data = Plugin::getInstance()->getDatabase()->getDatabase()->query("SELECT * FROM players WHERE player = '" . $this->getName() . "'");
        while ($resultAttr = $data->fetchArray(SQLITE3_ASSOC)){
            $this->faction = $resultAttr['faction'];
            $this->faction_role = $resultAttr['role'];
            $this->rank = $resultAttr['rank'];
            $this->money = $resultAttr['money'];
            $this->settings = unserialize(base64_decode($resultAttr['settings']));
            $this->lang = $resultAttr['lang'];
            $this->discordId = $resultAttr['discordId'];
        }
    }

    public function register() {
        $this->rank = Ranks::PLAYER;
        $this->money = 0;
        $this->lang = "fr_FR";
        $this->settings["player_status"] = 1;
        Plugin::getInstance()->getServer()->getAsyncPool()->submitTask(new RegisterPlayer($this->getName(), $this->getAddress()));
    }

    /**
     * @return string
     */
    public function getLang(): string{
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getRank(): int{
        return $this->rank;
    }

    /**
     * @return string
     */
    public function getFaction() : string {
        return $this->faction;
    }

    /**
     * @return bool
     */
    public function hasFaction() : bool {
        return $this->faction == "none";
    }

    public function setScoreboard(){
        $scoreboard = Plugin::getInstance()->getScoreboardAPI();
        $scoreboard->remove($this);
        $scoreboard->new($this,"infos","MUSEUM");
        $scoreboard->setLine($this, 1," " . $this->money . " " . Economy::SYMBOLS[$this->settings["economy_symbol"]]);
        $scoreboard->setLine($this, 2,($this->hasRank(Ranks::HELPER,Ranks::MODERATOR,Ranks::ADMIN) ? Unicode::getMFace($this->settings["unicode"], $this->getRank()) . " " : " ") . Ranks::translate($this,$this->rank));
        $scoreboard->setLine($this, 3," " . ($this->faction == "none" ? "Sans faction" : $this->faction));
    public function getArmorUnicodes(): array {
        return [
            0 => $this->getArmorInventory()->getHelmet()->getId() !== 0 ? Unicode::ARMORS[$this->getArmorInventory()->getHelmet()->getId()] : null,
            1 => $this->getArmorInventory()->getChestplate()->getId() !== 0 ? Unicode::ARMORS[$this->getArmorInventory()->getChestplate()->getId()] : null,
            2 => $this->getArmorInventory()->getLeggings()->getId() !== 0 ? Unicode::ARMORS[$this->getArmorInventory()->getLeggings()->getId()] : null,
            3 => $this->getArmorInventory()->getBoots()->getId() !== 0 ?  Unicode::ARMORS[$this->getArmorInventory()->getBoots()->getId()]  : null
        ];
    }
}