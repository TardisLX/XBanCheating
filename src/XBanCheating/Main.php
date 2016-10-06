<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener{
 
 private $path,$conf;

public function onEnable(){
             	$this->path = $this->getDataFolder();
		@mkdir($this->path);
		$this->conf = new Config($this->path."Config.yml", Config::YAML,array(
 		 "Enable-XBanCheating"=>"true",
   		 "#1" =>"总开关控制XBanCheating是否开启",
       	         "Message"=>"§e创造模式,§c禁止与此物品交互！",
                 "GM-Message"=>"§e创造模式,§c禁止与此物品交互，已切换生存!",
                 "Ban-Block"=>array(154,118,199),
                 "#2" =>"禁止交互的方块ID",
                 "admin"=>array(例子),
                 "#3" =>"管理员的游戏名",
				));
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	$this->getLogger()->info("§b XBanCheating v2.1.0加载  SnowXxm(雪宸)§6［贴吧ID: 緑搽丶］§a和 §bMattTradis(塔迪斯)§6［贴吧ID: The_Tradis］§a制作~\n§c仅供测试学习，严禁商业用途");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
  if($this->conf->get("Enable-XBanCheating") == "true"){
 if($event->getPlayer()->getGamemode()==1){
 $player = $event->getPlayer()->getName();
 $admin = $this->conf->get("admin");
 $blockid = $event->getBlock()->getID();
 $banblockid = $this->conf->get("Ban-Block");
 $gmmessage = $this->conf->get("GM-Message");
 if((in_array($blockid,$banblockid)) and (!in_array($player,$admin))){
 $event->setCancelled(true);
 $message = $this->conf->get("Message");
 $event->getPlayer()->sendMessage("§b［XBanCheating］ $message");
 	}elseif($event->getBlock()->getID() == 58){
 	$event->getPlayer()->setGamemode("0");
        $event->getPlayer()->sendMessage("§b［XBanCheating］ $gmmessage");
 	}
     }
  }
  }
  
  	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		$user = $sender->getName();
		switch($command->getName()){
			case "xbc":
				if(isset($args[0])){
					switch($args[0]){
					case "admin":
						if(isset($args[1])){
							$admin = $this->conf->get("admin");
							if(!in_array($args[1],$admin)){
								$admin[] = $args[1];
								$this->conf->set("admin",$admin);
								$this->conf->save();
								$sender->sendMessage("§b[XBanCheating] §a成功§e添加管理员: $args[1] ");
							}else{
								$inv = array_search($args[1], $admin);
								$inv = array_splice($admin, $inv, 1); 
								$this->conf->set("admin",$admin);
								$this->conf->save();
								$sender->sendMessage("§b[XBanCheating] §a成功§e删除管理员: $args[1] ");
							}
						}else{
							$sender->sendMessage("§b[XBanCheating] §a用法 ：§e/xbc admin <playername>");
						}
						return true;
					case "adminlist":
						$admin = $this->conf->get("admin");
						$adminlist="§a管理员列表：§e";
						$adminlist .=implode(",",$admin);
						$sender->sendMessage("§b[XBanCheating]        $adminlist");
					  return true;

}
					}
					}
					}
  }
  
  
?>
