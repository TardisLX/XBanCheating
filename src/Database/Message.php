<?php

namespace XBanCheating\Database;

use pocketmine\utils\Config;


class Message{

 public function __construct($file){
 $this->msg = new Config($file."X_Message.yml",Config::YAML,array(
	"Message" => "§e创造模式,§c禁止与此物品交互！",
 "#1" => "［信息］创造玩家尝试和被禁止的方块交互时",
 "SuperBan-Message" => "§e创造模式,§c禁止与此物品交互，已切换生存!",
 "#2" => "［信息］创造玩家尝试和被强制禁止的方块交互时",
 "Item-Message" => "§e创造模式,§c禁止使用该物品！",
 "#3" => "［信息］创造玩家尝试使用被禁止的物品时",
 "#3" => "［信息］创造玩家尝试使用被禁止的物品时",
 "ClearInv-Message" => "§e检测到你切换了模式，已经§c清空背包",
 "#" => "［信息］当玩家模式切换清空背包时",
		));
 }
 public function get($key){
 return $this->msg->get($key);
 }
	
 public function set($key,$value){
 $this->msg->set($key,$value);
 $this->msg->save();
 }
 
 }
