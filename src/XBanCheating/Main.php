<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as MT;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
 
 private $path,$conf;

public function onEnable(){
             	$this->path = $this->getDataFolder();
		@mkdir($this->path);
		$this->conf = new Config($this->path."Config.yml", Config::YAML,array(
				"admin"=>array()
				"message"=>"[XBanCheating]创造模式禁止使用此方块！",
				"item-touch"=>array(118,199,154)
				));
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	$this->getLogger()->info("§c xxm［雪宸］制作，仅供测试学习，禁止商业用途~");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
 if($event->getPlayer()->getGamemode()==1){
 $blockid = $event->getBlock()->getID();
 $banblockid = $this->conf->get("Ban-Block");
 if(in_array($blockid,$banblockid)){
 $event->setCancelled(true);
 $message = $this->conf->get("message");
 $event->getPlayer()->sendMessage($message);
 	}
 	}
     }
  }
?>
