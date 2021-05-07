<?php

namespace Steellg0ld\Museum\base;

use pocketmine\Server;
use Steellg0ld\Museum\Plugin;

class MFaction{
    public $data;

    CONST ROLES = [
        0 => "Recrue",
        1 => "Membre",
        2 => "Officier",
        3 => "Chef"
    ];

    /**
     * MFaction constructor.
     * @param String $faction_id
     */
    public function __construct(String $faction_id){
        $this->data = Plugin::getInstance()->getDatabase()->getFactionData($faction_id);
    }

    /**
     * @param MPlayer $player
     * @return string
     */
    public function getFactionRole(MPlayer $player): string {
        return $player->faction_role !== null;
    }

    /**
     * @param MPlayer $player
     * @param string ...$role
     * @return string
     */
    public function getFactionAccess(MPlayer $player, string ...$role): string {
        return in_array($player->faction_role, $role) ? "§a§lACCÈS" : "§c§lNON-ACCÈS";
    }

    /**
     * @return mixed
     */
    public function getName(){
        return $this->data["name"];
    }

    public function getMembers(){
        return $this->data["members"];
    }

    /**
     * @param bool $active
     * @return int
     */
    public function getFactionClaims(bool $active): int{
        return $active ? 9 : 6;
    }

    /**
     * @param bool $connected
     * @return int
     */
    public function getMembersCount(bool $connected): int{
        return $connected ? 8 : 3;
    }

    /**
     * @param String $identifier
     * @return bool
     */
    public static function factionExist(String $identifier): bool{
        $factions = Plugin::getInstance()->getFactions();
        return $factions->exists($identifier);
    }

    public static function playerStatus($member){
        $player = Server::getInstance()->getPlayer($member);
        if($player instanceof MPlayer){
            return "§a§lCONNECTÉ";
        }else{
            return "§c§lDÉCONNECTÉ";
        }
    }
}