<?php

declare(strict_types=1);

namespace str0nix\SelfDamageBlocker;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
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
        $this->saveDefaultConfig();
        if($this->getConfig()->get("console_messages") === true){
            $this->getLogger()->info("Plugin has been enabled.");
        }
    }

    public function onSelfDamage(EntityDamageByChildEntityEvent $event) {
        $entity = $event->getEntity();
        $cause = $event->getCause();
        $damager = $event->getDamager();

        if($cause === EntityDamageByChildEntityEvent::CAUSE_PROJECTILE){
            if($cause === EntityDamageByChildEntityEvent::CAUSE_FIRE && EntityDamageByChildEntityEvent::CAUSE_FIRE_TICK){
                if($entity === $damager){
                    $event->setCancelled();
                    $entity->sendMessage($this->getConfig()->get("msg"));
                }
            } else {
                if($entity === $damager){
                    $event->setCancelled();
                    $entity->sendMessage($this->getConfig()->get("msg"));
                }
            }
        }
    }

    /*
    public function onEntityDamage(EntityDamageEvent $event) {
        $entity = $event->getEntity()->getName();
        $damager = $event->getDamager()->getName();
        $cause = $event->getCause();

        if($event instanceof EntityDamageByEntityEvent){
            if($event->getCause() != EntityDamageEvent::CAUSE_FIRE_TICK){
                if($entity === $damager){
                    $event->setCancelled();
                    $entity->sendMessage($this->getConfig()->get("msg"));
                }
            }
        }
    }
    */
}
