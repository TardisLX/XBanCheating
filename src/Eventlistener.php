<?php

namespace XBanCheating;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\level\Level;

use pocketmine\item\Item;

use XBanCheating\Main;
use XBanCheating\Database\XConfig;
use XBanCheating\Database\Message;


class EventListener implements Listener{

	public function __construct(Main $plugin){
	$this->plugin=$plugin;
	$plugin->getServer()->getPluginManager()->registerEvents($this,$plugin);
	$cids = $this->plugin->xconf->get("remove_create_item");
 foreach($cids as $cid){ 
$cid = explode(":",$cid); Item::removeCreativeItem(Item::get($cid[0],$cid[1]));
 }
	}
	
	public function playergmchange(PlayerGameModeChangeEvent $event){
  $admin = $this->plugin->xconf->get("admin");
  $player = $event->getPlayer();
  $clearinvmessage = $this->plugin->xmsg->get("ClearInv-Message");
	if($this->plugin->xconf->get("Enable-XBanCheating") == "true" && $this->plugin->xconf->get("Enable-ClearInv") == "true" && (!in_array($player->getName(),$admin))){
	if(!$event->getPlayer()->getGamemode()==0){
  $player->getInventory()->clearAll();
  $player->sendMessage("§b［XBanCheating］ $clearinvmessage");
  }
  }
  }
	
  public function playerBlockTouch(PlayerInteractEvent $event){
  if($this->plugin->xconf->get("Enable-XBanCheating") == "true"){
  if($event->getPlayer()->getGamemode()==1){
  $player = $event->getPlayer()->getName();
  $admin = $this->plugin->xconf->get("admin");
  $blockid = $event->getBlock()->getID();
  $banblockid = $this->plugin->xconf->get("Ban-Block");
  $gmbanblockid = $this->plugin->xconf->get("SuperBan-Block");
  $gmmessage = $this->plugin->xmsg->get("SuperBan-Message");
  $gm = $this->plugin->xconf->get("SetChangeGM");
  if((in_array($blockid,$banblockid)) and (!in_array($player,$admin))){
  $event->setCancelled(true);
  $message = $this->plugin->xmsg->get("Message");
  $event->getPlayer()->sendMessage("§b［XBanCheating］ $message");
 	}elseif((in_array($blockid,$gmbanblockid)) and (!in_array($player,$admin))){
  $event->getPlayer()->setGamemode("$gm");
  $event->getPlayer()->sendMessage("§b［XBanCheating］ $gmmessage");
 	}
  }
  }
  }
  
	public function onBlockUpdate(BlockUpdateEvent $event){
  if($this->plugin->xconf->get("BanBlockUpdate") == "true"){
 $bdblockid = $event->getBlock()->getID();
 $bandblockid = $this->plugin->xconf->get("BanUpdate-Block");
  if((in_array($bdblockid,$bandblockid))){
  $event->setCancelled();
 }
 }
 }
 
  public function itemheld(PlayerItemHeldEvent  $event){
  if($this->plugin->xconf->get("Enable-XBanCheating") == "true"){
  if($event->getPlayer()->getGamemode() !== 1){
  return;
  }
  $player = $event->getPlayer();
  $item = $event->getItem()->getID();
  $banitem = $this->plugin->xconf->get("Ban-Item");
  $gm = $this->plugin->xconf->get("SetChangeGM");
	$superbanitem = $this->plugin->xconf->get("SuperBan-Item");
	$admin = $this->plugin->xconf->get("admin");
	$itemmessage = $this->plugin->xmsg->get("Item-Message");
	$gmmessage = $this->plugin->xconf->get("SuperBan-Message");
	 if((in_array($item,$banitem)) and (!in_array($player->getName(),$admin))){
   $event->setCancelled();
   $player->sendMessage("§b［XBanCheating］ $itemmessage");
 	}elseif((in_array($item,$superbanitem)) and (!in_array($player,$admin))){
  $player->setGamemode("$gm");
  $player->sendMessage("§b［XBanCheating］ $gmmessage");
		
  }
  }
  }

	 public function onPlace(BlockPlaceEvent $bpevent){
  if($bpevent->isCancelled()){
 return;
 }
  $player = $bpevent->getPlayer();
  if($this->plugin->xconf->get("Enable-CBlock") == true){
  if($player->isCreative()){
  $bx = $bpevent->getBlock()->getX();
  $by = $bpevent->getBlock()->getY();
  $bz = $bpevent->getBlock()->getZ();
  $blevel = $bpevent->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->plugin->path.'X_Create_Block/'.$blevel.'.yml', Config::YAML,array());
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
  if($this->plugin->xconf->get("Enable-CBlock") == true){
  if(!$player->isCreative()){
  $bx = $bbevent->getBlock()->getX();
  $by = $bbevent->getBlock()->getY();
  $bz = $bbevent->getBlock()->getZ();
  $blevel = $bbevent->getBlock()->getLevel()->getFolderName();
  $ncbl  = new Config($this->plugin->path.'X_Create_Block/'.$blevel.'.yml', Config::YAML,array());
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

  
	}
	
