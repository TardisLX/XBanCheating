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
				"Enable-XBanCheating"=>array(),
				"#总开关"=>array(),
                                "Ban-Block"=>array(154,118,199),
				"#配置文件暂时无用"=>array()
				));
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	$this->getLogger()->info("§c xxm［雪宸］制作，仅供测试学习，禁止商业用途~");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
 if($event->getPlayer()->getGamemode()==1){
 if($event->getBlock()->getID() == 154 || $event->getBlock()->getID() == 118 || $event->getBlock()->getID() == 199){
 $event->setCancelled(true);
 $event->getPlayer()->sendMessage("§b［XBanCheating］§e创造模式§c禁止使用此物品！");
 	}
 	}
     }
  }
?>
