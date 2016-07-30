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
use pocketmine\utlis\Config as C;
use pocketmine\utlis\TextFormat as T;

Class Main extend PluginBasc implements Listender{
  public function onEnable(){
   $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->getLogger()->info(T::GREEN . "Load HUD1b by iBa4x .");
   @mkdir($this->getDetaFolder());
  }
  public function onJoin(PlayerJoinEvent $e){
   $p = $e->getPlayer();
   $n = $p->getName();
   $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
    if($d->get("K") == null){
     $d->set("K",0);
     $d->save();
    }
    if($d->get("D") == null){
     $d->set("D",0);
     $d->save();
    }
    if($d->get("S") == null){
     $d->set("S",0);
     $d->save();
    }
  }
  public function onDeath(PlayerDeathEvent $e){
   $en = $e->getEntity();
   $c = $en->getLastDamageCause();
    if($en instanceof Player){
     $n = $e->getEntity()->getName();
     $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
      $d->set("D",$d->get("D") + 1);
      $d->save();
    }
    if($c instanceof Player){
     $n = $killer()->getName();
     $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
      $d->set("K",$d->get("K") + 1);
      $d->save();
    }
    if($en instanceof Player){
     $n = $e->getEntity()->getName();
     $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
      $d->set("S",$d->get("S") - 5);
      $d->save();
    }
    if($c instanceof Player){
     $n = $killer->getName();
     $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
      $d->set("S",$d->get("S") + 5);
      $d->save();
    }
  }
  public function onMove(PlayerMoveEvent $e){
   $p = $e->getPlayer();
   $n = $p->getName();
   $cfg = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
   $k = $cfg->get("K");
   $d = $cfg->get("D");
   $s = $cfg->get("S");
    $p->sendTip(T::GREEN . "                                                                                           -+=+-" . "\n                                                                                          Kills: " . $k . "\n                                                                                          Death" . $d . "\n                                                                                          Scoer" . $s . "\n                                                                                          -+=+-");
  }
 }
