<?php
namespace iBa4x;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config as C;
use pocketmine\utils\TextFormat as T;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;

Class Main extends PluginBase implements Listener{
  public function onEnable(){
   $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->getLogger()->info(T::GREEN . "Load HUD1b by iBa4x .");
   @mkdir($this->getDataFolder());
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
	  $d->set("S",$d->get("S") - 5);
      $d->save();
    }
    if($c instanceof Player){
     $n = $killer()->getName();
     $d = new Config($this->getDetaFolder() . $n . ".yml", C::YAML);
      $d->set("K",$d->get("K") + 1);
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
  	$y = str_repeat(" ", 70);
  	$g = "\n";
  	$p->sendTip(T::GREEN . $y . " -+=+-" . $g . $y . "Kills: " . $k . $g . $y . "Death" . $d . $g . $y . "Score" . $s . $g . $y . " -+=+-" . $g . $g);
  }
}
