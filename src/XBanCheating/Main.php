<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
 
 private $path,$conf;

public function onEnable(){
             	$this->path = $this->getDataFolder();
		@mkdir($this->path);
		$this->conf = new Config($this->path."Config.yml", Config::YAML,array(
 				"Enable-XBanCheating"=>"true",
   		  "#1" =>"总开关控制XBanCheating是否开启",
 				"Message"=>"§e创造模式,§c禁止与此物品交互！",
          "Ban-Block"=>array(154,118,199),
         "#2" =>"禁止交互的方块ID",
				));
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	$this->getLogger()->info("§b SnowXxm(雪宸)§6［贴吧ID: 緑搽丶］§a和 §bMattTradis(塔迪斯)§6［贴吧ID: The_Tradis］§a制作~\n§c仅供测试学习，严禁商业用途");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
 if($event->getPlayer()->getGamemode()==1){
 $blockid = $event->getBlock()->getID();
 $banblockid = $this->conf->get("Ban-Block");
 if(in_array($blockid,$banblockid)){
 if($this->conf->get("Enable-XBanCheating") == "true"){
 $event->setCancelled(true);
 $message = $this->conf->get("Message");
 $event->getPlayer()->sendMessage("§b［XBanCheating］ $message");
 	}
 	}
     }
  }
  
  }
  
  
?>
