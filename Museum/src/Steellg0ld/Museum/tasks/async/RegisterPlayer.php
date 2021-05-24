<?php

namespace Steellg0ld\Museum\tasks\async;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Steellg0ld\Museum\base\Database;
use Steellg0ld\Museum\base\Faction;
use Steellg0ld\Museum\base\Player;
use Steellg0ld\Museum\base\Ranks;
use Steellg0ld\Museum\Plugin;

class RegisterPlayer extends AsyncTask {

    private String $player;
    private String $address;
    private $db;

    public function __construct(String $player, String $address) {
        $this->player = $player;
        $this->address = $address;
        $this->db = array(Plugin::getInstance()->getDataFolder() . Plugin::FILE_DB);;
    }

    public function onRun() {
        $db = new \SQLite3($this->db[0]);

        $name = $this->player;
        $adress = base64_encode(base64_encode(base64_encode($this->address)));
        $settings = base64_encode(serialize(["player_status" => 1]));
        $db->query("INSERT INTO players (player, address, faction, role, rank, money, lang, settings) VALUES ('$name', '$adress', 'none', 0, 0, 0, 'fr_FR', '$settings')");
    }
}