<?php

namespace SexMC\AntiIndian;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $playerJoinEvent): void {
        $player = $playerJoinEvent->getPlayer();
        $locale = $player->getLocale();
        if ($locale == "hi_IN" || $locale == "bn_IN" || $locale == "ta_IN") { 
            $player->kick(TextFormat::RED . "You have been kicked by Anti-Indian\nPlease relocate to a first world country to continue.");
        }

        $task = new class($player) extends AsyncTask {
            public function __construct(private Player $player) { }

            private string $endpoint = "http://ip-api.com/php/";
            public function onRun(): void {
                $res = var_export(unserialize(file_get_contents($this->endpoint.$this->player->getNetworkSession()->getIp())));
                if (!isset($res["countryCode"])) {
                    return;
                }

                $locale = $res["countryCode"];
                if ($locale == "IN" || $locale == "hi_IN" || $locale == "bn_IN" || $locale == "ta_IN") { 
                    $this->player->kick(TextFormat::RED . "You have been kicked by Anti-Indian\nPlease relocate to a first world country to continue.");
                }
             }
        };
        $this->getServer()->getAsyncPool()->submitTask($task);
    }
}
