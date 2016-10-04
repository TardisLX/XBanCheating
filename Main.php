<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;

class Main extends PluginBase implements Listener{
public function onEnable(){
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	$this->getLogger()->info("§c xxm［雪宸］制作，仅供测试学习，禁止商业用途~");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
 if($event->getPlayer()->getGamemode()==1){
 if($event->getBlock()->getID() == 154 || $event->getBlock()->getID() == 118){
 $event->setCancelled(true);
 $event->getPlayer()->sendMessage("§b［XBanCheating］§e创造模式§c禁止使用此物品！");
 	}
 	}
     }
  }
?>