<?php

namespace XBanCheating;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\level\Level;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use XBanCheating\CBlock;

class Main extends PluginBase implements Listener{

	public function onLoad(){
	$this->path = $this->getDataFolder();
	@mkdir($this->path.'X_Create_Block');
	@mkdir($this->path);
	}
	
public function onEnable(){
		$this->conf = new Config($this->path."Config.yml", Config::YAML,array(
		"#" => "欢迎使用全新的 XBanCheating",
"#" => "XBanCheating是永久免费的开源插件",
"#" => "XBanCheating依赖配置文件，请在这里设置XBanCheating各种功能",
"#" => "它将会持续更新，获取更新请访问https://pl.zxda.net/plugins/569.html，如果有问题请及时在群里提交给塔迪斯或者雪宸",
"#" => "同时我们提供高性能高性价比防堵租服，详情请在X系列插件群输入“服务器”了解，或者加入我们的售前群 568816872 ，感谢支持！",
'分割线' => "---------------------------------------",
"Enable-XBanCheating" => "true",
"#" => "［开关］控制XBanCheating插件是否开启",
"Enable-CBlock" => "true",
"#" => "［开关］创造方块生存无法破坏",
"BanBlockUpdate" => "true",
"#" => "［开关］禁止方块更新",
'分割线' => "---------------------------------------",
"Ban-Block" => array(154,118,199,88,64),
"#" => "被禁止的方块列表，您可以自行添加需要禁止的方块",
"SuperBan-Block" => array(58),
"#" => "超级禁止，创造玩家尝试使用列表中的方块时将会被切换为指定的模式",
"BanUpdate-Block" => array(12,13),
"SetChangeGM"  => "0",
"#" => "一个小功能，可以指定创造玩家使用被超级禁止的方块时被切换的模式，默认为0(生存模式)",
"admin" => array("SnowXxm16769334","MattTardis1239322835"),
"#" => "管理员列表",
"version" => "3.9.1",
		));
		
		$this->msg = new Config($this->path."Message.yml",Config::YAML,array(
		"Message" => "§e创造模式,§c禁止与此物品交互！",
"#" => "［信息］创造玩家尝试和被禁止的方块交互时",
"SuperBan-Message" => "§e创造模式,§c禁止与此物品交互，已切换生存!",
"#" => "［信息］创造玩家尝试和被强制禁止的方块交互时",
"Item-Message" => "§e创造模式,§c禁止使用该物品！",
"#" => "［信息］创造玩家尝试使用被禁止的物品时",

		));

	  	$this->getLogger()->info("§b ==================");
	  	$this->getLogger()->info("§a XBanCheating v3.9.0加载!");
	 		$this->getLogger()->info("§e 作者 SnowXxm and MattTardis");
	 		$this->getLogger()->info("§c 仅供学习交流，转载请注明出处！");
	 		$this->getLogger()->info("§6 如果有任何Bug请及时加群554719217提交，感谢您的使用~");
	 		$this->getLogger()->info("§b ==================");
	  	
	$this->getLogger()->info("§e XBanCheating 更新日志:");
	$this->getLogger()->info("§a -v3.9.1,去除禁止创造使用某些物品的功能，同时去除该功能源码");
	$this->getLogger()->info("§a -v3.9.0,配置文件结构优化，创造方块判断优化，修复大量错误和错误的调用，添加对于1.00的API支持");
	$this->getLogger()->info("§a -v3.40,支持强力禁止某些物品，重写配置文件，更加简洁明了(请务必删除之前的旧版本配置文件！！！");
	$this->getLogger()->info("§a -v3.30,支持禁止创造使用某些物品(实现该功能的部分源码来自开源插件BanItemAdd");
	$this->getLogger()->info("§a -v3.20,支持禁止方块更新(防止生存玩家利用沙子沙烁卡透视");
	$this->getLogger()->info("§a          ...");
	if($this->conf->get("version") !== "3.9.1"){
	$this->getLogger()->info("§c 检测到您的配置文件过期，请删除旧的配置文件！否则无法使用！{创造方块数据不需要}");
	$this->getLogger()->info("§c 检测到您的配置文件过期，请删除旧的配置文件！否则无法使用！{创造方块数据不需要}");
	$this->getLogger()->info("§c 检测到您的配置文件过期，请删除旧的配置文件！否则无法使用！{创造方块数据不需要}");
	}
	$this->getServer()->getPluginManager()->registerEvents($this,$this);
}
 public function playerBlockTouch(PlayerInteractEvent $event){
  if($this->conf->get("Enable-XBanCheating") == "true"){
 if($event->getPlayer()->getGamemode()==1){
 $player = $event->getPlayer()->getName();
 $admin = $this->conf->get("admin");
 $blockid = $event->getBlock()->getID();
 $banblockid = $this->conf->get("Ban-Block");
 $gmbanblockid = $this->conf->get("SuperBan-Block");
 $gmmessage = $this->msg->get("SuperBan-Message");
 $gm = $this->conf->get("SetChangeGM");
 if((in_array($blockid,$banblockid)) and (!in_array($player,$admin))){
 $event->setCancelled(true);
 $message = $this->msg->get("Message");
 $event->getPlayer()->sendMessage("§b［XBanCheating］ $message");
 	}elseif((in_array($blockid,$gmbanblockid)) and (!in_array($player,$admin))){
 	$event->getPlayer()->setGamemode("$gm");
        $event->getPlayer()->sendMessage("§b［XBanCheating］ $gmmessage");
 	}
     }
  }
  }
  
	public function onBlockUpdate(BlockUpdateEvent $event){
	if($this->conf->get("BanBlockUpdate") == "true"){
 $bdblockid = $event->getBlock()->getID();
 $bandblockid = $this->conf->get("BanUpdate-Block");
  if((in_array($bdblockid,$bandblockid))){
	$event->setCancelled();
 }
 }
 }
 
	 public function onPlace(BlockPlaceEvent $bpevent){
  if($bpevent->isCancelled()){
 return;
 }
  $player = $bpevent->getPlayer();
  if($this->conf->get("Enable-CBlock") == true){
  if($player->isCreative()){
  $bx = $bpevent->getBlock()->getX();
  $by = $bpevent->getBlock()->getY();
  $bz = $bpevent->getBlock()->getZ();
  $blevel = $bpevent->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->getDataFolder().'X_Create_Block/'.$blevel.'.yml', Config::YAML,array());
  $b = $bx.":".$by.":".$bz;
  $ncbl->set("$b");
  $ncbl->save(true);
  }
  }
  }
  
  public function onBreak(BlockBreakEvent $bbevent){
  if($bbevent->isCancelled()){
 return;
 }
  $player = $bbevent->getPlayer();
  if($this->conf->get("Enable-CBlock") == true){
  if(!$player->isCreative()){
  $bx = $bbevent->getBlock()->getX();
  $by = $bbevent->getBlock()->getY();
  $bz = $bbevent->getBlock()->getZ();
  $blevel = $bbevent->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->getDataFolder().'X_Create_Block/'.$blevel.'.yml', Config::YAML,array());
  $b = $bx.":".$by.":".$bz;
  if($ncbl->exists($b)){
  $bbevent->setDrops(array());
					$player->sendTip("§b［XBanCheating］§6创造方块无产物掉落喔~");
					$ncbl->exists($bx.":".$by.":".$bz);
					$ncbl->remove($bx.":".$by.":".$bz);
					$ncbl->save(true);
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
						if(!$sender instanceof player){
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
