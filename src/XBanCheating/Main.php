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
 				"Enable-XBanCheating"=>"true",
 				"#总开关"=>"控制XBanCheating是否开启",
                                  "Ban-Block"=>array(154,118,199),
 				"#总开关暂时无用"=>array()
 				"#BanBlock可用",
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
 $event->getPlayer()->sendMessage([XBanCheating]创造模式无法使用该方块！);
 	}
 	}
     }
  }
?>
