<?php

namespace XBanCheating;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;

use XBanCheating\Database\XConfig;
use XBanCheating\Database\Message;
use XBanCheating\Eventlistener;

class Main extends PluginBase{

	public function onLoad(){
	$this->path = $this->getDataFolder();
	@mkdir($this->path.'X_Create_Block');
	@mkdir($this->path);
	}
	
 public function onEnable(){

 $this->getLogger()->info("§b ==================");
 $this->getLogger()->info("§a XBanCheating v4.2.0加载!");
 $this->getLogger()->info("§e 主要作者 SnowXxm");
 $this->getLogger()->info("§c 仅供学习交流，转载请注明出处！");
 $this->getLogger()->info("§6 如果有任何Bug请及时加群554719217提交，感谢您的使用~");
 $this->getLogger()->info("§b ==================");
	  	
	$this->getLogger()->info("§e XBanCheating 更新日志:");
	$this->getLogger()->info("§a -v4.2.0 创造背包物品可以直接移除啦");
	$this->getLogger()->info("§a -v4.1.0,添加小功能，切换非创造模式清空背包(可以自定义消息)");
	$this->getLogger()->info("§a -v4.0.0,结构整体重写，全新的配置文件以及强力禁用模式，增加切换模式清空背包");
	$this->getLogger()->info("§a -v3.9.0,配置文件结构优化，创造方块判断优化，修复大量错误和错误的调用，添加对于1.00的API支持");
	$this->getLogger()->info("§a -v3.40,支持强力禁止某些物品，重写配置文件，更加简洁明了(请务必删除之前的旧版本配置文件！！！");
	$this->getLogger()->info("§a          ...");
	
	$this->xconf = new XConfig($this->path);
	$this->xmsg = new Message($this->path);
	//$this->xcmd = new Commands();

  $this->registerEvents();
  //$this->registerCommands();

  }
  /*public function registerCommands(){
  foreach($this->xcmd->getAll() as $cmdType => $data){
  $map = $this->getServer()->getCommandMap();
  $class = "\\XBanCheating\\Commands\\".$cmdType;
  $map->register("Main", new $class($this));
  }
  }*/
  
	private function registerEvents(){
		$this->eventClass=new EventListener($this);
	}
	
	public function onCommand(CommandSender$sender, Command $command, $label, array $args){
 $myconf = $this->xconf;
 $user = $sender->getName();
 switch($command->getName()){
 case "xbc":
 if(isset($args[0])){
 switch($args[0]){
 case "admin":
 if(isset($args[1])){
 if(!$sender instanceof player){
 $admin = $myconf->get("admin");
 if(!in_array($args[1],$admin)){
 $admin[] = $args[1];
 $myconf->set("admin",$admin);
 $sender->sendMessage("§b[XBanCheating] §a成功§e添加管理员: $args[1] ");
 }else{
 $inv = array_search($args[1], $admin);
 $inv = array_splice($admin, $inv, 1); 
 $myconf->set("admin",$admin);
 $sender->sendMessage("§b[XBanCheating] §a成功§e删除管理员: $args[1] ");
 }
 }else{
 $sender->sendMessage("§b[XBanCheating] §a用法 ：§e/xbc admin <playername>");
 }
 }
 return true;
 case "adminlist":
 $admin = $myconf->get("admin");
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