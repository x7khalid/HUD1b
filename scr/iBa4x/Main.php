<?php
namespace iBa4x;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\event\Listender;
use pocketmine\event\PlayerMoveEvent;
use pocketmine\event\PlayerJoinEvent;
use pocketmine\event\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utlis\Config as C;
use pocketmine\utlis\TextFormat as T;

Class Main extend PluginBasc implements Listender{
  
  public function onEnable(){
   $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->getLogger()->info(T::GREEN . "Load HUD1b by iBa4x.");
   @mkdir($this->getDetaFolder());
  }
  
  public function onJoin(PlayerJoinEvent $event){
   $player = $event->getPlayer();
   $name = $player->getName();
   $deta = new Config($this->getDetaFolder() . $name . ".yml", C::YAML);
    if($deta->get("K") == null){
     $deta->set("K",0);
     $deta->save();
    }
    if($deta->get("D") == null){
     $deta->set("D",0);
     $deta->save();
    }
    if($deta->get("S") == null){
     $deta->set("S",0);
     $deta->save();
    }
  }
  
  public function onDeath(PlayerDeathEvent $event){
   $entity = $event->getEntity();
   $cause = $entity->getLastDamageCause();
    if($entity instanceof Player){
     $name = $event->getEntity()->getName();
     $deta = new Config($this->getDetaFolder() . $name . ".yml", C::YAML);
      $deta->set("D",$deta->get("D") + 1);
      $deta->set("S",$deta->get("S") - 5);
      $deta->save();
    }
    if($cause instanceof EntityDamageByEntityEvent){
      $killer = $event->getEntity()->getLastDamageCause()->getDamage();
      
      if($killer instanceof Player){
        $name = $killer()->getName();
        $deta = new Config($this->getDetaFolder() . $name . ".yml", C::YAML);
        $deta->set("K",$deta->get("K") + 1);
        $deta->set("S",$deta->get("S") + 5);
        $deta->save();
      }
    }
  }
  
  public function onMove(PlayerMoveEvent $event){
   $player = $event->getPlayer();
   $name = $player->getName();
   $cfg = new Config($this->getDetaFolder() . $name . ".yml", C::YAML);
   $k = $cfg->get("K");
   $d = $cfg->get("D");
   $s = $cfg->get("S");
   $player->sendTip(T::GREEN . "                                                             -+=+-" . "\n                                                            Kills: " . $k . "\n                                                            Death" . $d . "\n                                                            Score" . $s . "\n                                                             -+=+-");
  }
}
