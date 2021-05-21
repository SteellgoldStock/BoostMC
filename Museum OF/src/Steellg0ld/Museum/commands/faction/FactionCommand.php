<?php

namespace Steellg0ld\Museum\commands\faction;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\utils\Config;
use Steellg0ld\Museum\base\MPlayer;
use Steellg0ld\Museum\commands\faction\subcommands\ClaimsSubCommand;
use Steellg0ld\Museum\commands\faction\subcommands\InviteSubCommand;
use Steellg0ld\Museum\entity\UpgradesBlockEntity;
use Steellg0ld\Museum\forms\FactionForm;
use Steellg0ld\Museum\json\JSONProvider;
use Steellg0ld\Museum\Plugin;
use Steellg0ld\Museum\utils\Resources;
use Steellg0ld\Museum\utils\Utils;

class FactionCommand extends Command
{
    public function __construct(string $name, string $description, array $aliases)
    {
        parent::__construct($name, $description, "", $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof MPlayer) {
            $sender->sendMessage(Utils::createMessage(Utils::CONSOLE_ERROR));
            return;
        }

        $invite = new InviteSubCommand();
        $claim = new ClaimsSubCommand();

        if (isset($args[0])) {
            switch ($args[0]) {
                case "a":
                case "accept":
                    $invite->execute_accept($sender);
                    break;
                case "d":
                case "deny":
                    $invite->execute_deny($sender);
                    break;
                case "c":
                case "claim":
                    $claim->execute_claim($sender);
                    break;
                case "u":
                case "unclaim":
                    $claim->execute_unclaim($sender);
                    break;
                case "up":
                case "upgrades":
                    // $nbt = UpgradesBlockEntity::createNBT($sender);
                    // Entity::createEntity("UpgradesBlock", $sender->getLevel(), $nbt);
                    break;
            }
        } else {
            if (!$sender->hasFaction()) {
                FactionForm::createFaction($sender,new JSONProvider());
            } else {
                FactionForm::factionForm($sender);
            }
        }
    }
}