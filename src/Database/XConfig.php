<?php

namespace XBanCheating\Database;

use pocketmine\utils\Config;


class XConfig{

 public function __construct($file){
 $this->conf = new Config($file."X_Config.yml",Config::YAML,array(
 "#1" => "欢迎使用全新的 XBanCheating_v4",
 "#2" => "XBanCheating是永久免费的开源插件，它依赖配置文件，请在这里设置XBanCheating各种功能",
 "#3" => "它将会持续更新，获取更新请访问https://pl.zxda.net/plugins/569.html，如果有问题请及时在群里提交给塔迪斯或者雪宸，我们会尽快解决",


 "Enable-XBanCheating" => "true",
 "#4" => "#开关 控制XBanCheating插件是否开启",
 "Enable-ClearInv" => "true",
 "#a" => "#开关 切换模式是否清空背包",
 "Enable-CBlock" => "true",
 "#5" => "#开关 创造方块生存无法破坏",
 "BanBlockUpdate" => "true",
 "#6" => "#开关 禁止方块更新",


 "Ban-Block" => array(154,118,199,88,64),
 "#7" => "禁止交互 您可以自行添加需要禁止的方块",
 "SuperBan-Block" => array(58),
 "#8" => "超级禁止 创造玩家尝试使用列表中的方块时将会被切换为指定的模式",
 "BanUpdate-Block" => array(12,13),
 "#9" => "禁止更新 禁止沙子等物品掉落",
 "Ban-Item" => array(7),
 "#10" => "创造禁用 禁止创造使用的物品列表",
 "SuperBan-Item" => array(383),
 "#11" => "强力禁止创造玩家使用的物品列表",
 "##" => "以上列表无需添加特殊值，例如要禁用铁砧(ID45)、轻微损坏的铁砧(ID45:4)、严重损坏的铁砧(ID45:8)，只需要添加45即可",

 "SetChangeGM"  => "0",
 "#12" => "玩家被强制切换的模式",
 "admin" => array("SnowXxm16769334","MattTardis1239322835"),
 "#13" => "白名单 管理员列表",
 "remove_create_item" => array("57:0"),
 "#14" => "按格式输入的物品将从创造背包移除，管理员除外",
 "version" => "4.2.0"
		));
		}
	public function get($key){
   return $this->conf->get($key);
	}
	
  public function set($key,$value){
  $this->conf->set($key,$value);
  $this->conf->save();
	}
		
		
}
