<?php

namespace SexMC\AntiIndian;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $playerJoinEvent): void {
        $player = $playerJoinEvent->getPlayer();
        $locale = $player->getLocale();
        if (in_array($locale, ["hi_IN", "bn_IN", "ta_IN"])) { 
            $player->kick(TextFormat::RED . "You have been kicked by Anti-Indian\nPlease relocate to a first world country to continue.");
            return;
        }

        $task = new class($player->getName(), $player->getNetworkSession()->getIp()) extends AsyncTask {
            public function __construct(private string $username, private string $addr) { }

            public function onRun(): void {
                $res = var_export(unserialize(file_get_contents("http://ip-api.com/php/". $this->addr)), true);
                if (isset($res["countryCode"])) {
                    $this->setResult($res["countryCode"]);
                }
             }

             public function onCompletion(): void {
                if ($this->getResult() == "IN") { 
                    $player = Server::getInstance()->getPlayerExact($this->username);
                    if (isset($player)) $player->kick(TextFormat::RED . "You have been kicked by Anti-Indian\nPlease relocate to a first world country to continue.");
                }
             }
        };
        $this->getServer()->getAsyncPool()->submitTask($task);
    }
}
