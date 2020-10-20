<?php

declare(strict_types=1);

namespace str0nix\SelfDamageBlocker;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    public function onLoad() : void {
        if($this->getConfig()->get("console_messages") === true){
            $this->getLogger()->info("Plugin loading...");
        }
    }

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if($this->getConfig()->get("console_messages") === true){
            $this->getLogger()->info("Plugin has been enabled.");
        }
    }

    public function onEntityDamage(EntityDamageEvent $event) {
        $entity = $event->getEntity();
        $damager = $event->getDamager();

        if($event instanceof EntityDamageByEntityEvent){
            if($damager instanceof Player){
                if($entity === $damager){
                    $event->setCancelled();
                    $entity->sendMessage($this->getConfig()->get("msg"));
                }
            }
        }
    }
}
