<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Block\BlockPlaceEvent;
use pocketmine\event\Block\BlockBreakEvent;
use pocketmine\level\Level;
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
   		 "Enable-CBlock"=>"true",
   		 "#2" =>"创造方块生存无法破坏的开关",
       	         "Message"=>"§e创造模式,§c禁止与此物品交互！",
                 "GM-Message"=>"§e创造模式,§c禁止与此物品交互，已切换生存!",
                 "Ban-Block"=>array(154,118,199,88,60),
	         "GM-Ban-Block"=>array(58),
		 "SetChangeGM"=>"0",
                 "#3" =>"禁止交互的方块ID",
                 "admin"=>array(SnowXxm),
	         "gm-admin"=>array(MattTardis),
                 "#4" =>"管理员的游戏名",
                 "version"=>"3"
				));
				
				@mkdir($this->getDataFolder().'X_Create_Block');

	  	$this->getLogger()->info("§b ==================");
	  	$this->getLogger()->info("§a XBanCheating v3.1.0加载!");
	 		$this->getLogger()->info("§e 作者 SnowXxm and MattTardis");
	 		$this->getLogger()->info("§c 仅供学习交流，转载请注明出处！");
	 		$this->getLogger()->info("§6 如果有任何Bug请及时提交，感谢您的使用~");
	 		$this->getLogger()->info("§b ==================");
	  	
	 	$this->getServer()->getPluginManager()->registerEvents($this,$this);
	  	
	$this->getLogger()->info("§e XBanCheating 更新日志:");
	$this->getLogger()->info("§a -v3.10,自动分世界(方便清理无用文件)，自动清理已经破坏的方块坐标");
	$this->getLogger()->info("§a -v3.00,加入创造方块生存破坏无掉落");
	$this->getLogger()->info("§a -v2.20,加入了阻止创造破坏农作物");
	$this->getLogger()->info("§a -v2.10,加入指令添加，移除白名单");
	$this->getLogger()->info("§a          ...");
}
 public function playerBlockTouch(PlayerInteractEvent $event){
  if($this->conf->get("Enable-XBanCheating") == "true"){
 if($event->getPlayer()->getGamemode()==1){
 $player = $event->getPlayer()->getName();
 $admin = $this->conf->get("admin");
 $gmadmin = $this->conf->get("gm-admin");
 $blockid = $event->getBlock()->getID();
 $banblockid = $this->conf->get("Ban-Block");
 $gmbanblockid = $this->conf->get("GM-Ban-Block");
 $gmmessage = $this->conf->get("GM-Message");
 $gm = $this->conf->get("SetChangeGM");
 if((in_array($blockid,$banblockid)) and (!in_array($player,$admin))){
 $event->setCancelled(true);
 $message = $this->conf->get("Message");
 $event->getPlayer()->sendMessage("§b［XBanCheating］ $message");
 	}elseif((in_array($blockid,$gmbanblockid)) and (!in_array($player,$gmadmin))){
 	$event->getPlayer()->setGamemode("$gm");
        $event->getPlayer()->sendMessage("§b［XBanCheating］ $gmmessage");
 	}
     }
  }
  }
  
  public function onPlace(BlockPlaceEvent $event){
  if($event->isCancelled()){
 return;
 }
  $player = $event->getPlayer();
  if($this->conf->get("Enable-CBlock") == true){
  if($player->isCreative()){
  $bx = $event->getBlock()->getX();
  $by = $event->getBlock()->getY();
  $bz = $event->getBlock()->getZ();
  $blevel = $event->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->getDataFolder().'X_Create_Block/'.$blevel.'.yml', Config::YAML,array(
				"CreateBlock"=>array()
				));
  $b = $bx.":".$by.":".$bz;
  $cb = $ncbl->get("CreateBlock");
  $cb[] = $b;
  $ncbl->set("CreateBlock",$cb);
  $ncbl->save();
  }
  }
  }
  
  public function onBreak(BlockBreakEvent $event){
  if($event->isCancelled()){
 return;
 }
  $player = $event->getPlayer();
  if($this->conf->get("Enable-CBlock") == true){
  if(!$player->isCreative()){
  $bx = $event->getBlock()->getX();
  $by = $event->getBlock()->getY();
  $bz = $event->getBlock()->getZ();
  $blevel = $event->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->getDataFolder().'X_Create_Block/'.$blevel.'.yml', Config::YAML,array(
				"CreateBlock"=>array()
				));
  $b = $bx.":".$by.":".$bz;
  $cbl = $ncbl->get("CreateBlock");
  if(in_array($b,$cbl)){
  $event->setDrops(array(0));
					$player->sendTip("§b［XBanCheating］§6创造方块无产物掉落喔~");
					$ncbl->exists("CreateBlock",$bx.":".$by.":".$bz);
					$ncbl->remove("CreateBlock",$bx.":".$by.":".$bz);
					$ncbl->save();
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
