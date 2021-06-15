<?php

namespace Sub2GamingAqua\CustomGUIPlus;

//Essential Class
use pocketmine\Server;
use pocketmine\Player;

//Config Class
use pocketmine\utils\Config;

//Command Class
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

//EventListener Class
use Sub2GamingAqua\CustomGUIPlus\EventListener;

//Item Class
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemFactory;

//PluginBase Class
use pocketmine\plugin\PluginBase;

//GUI Class
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\inventory\DoubleChestInventory;

class Main extends PluginBase
{
  public function onEnable(){
    //Config And Database
    $this->Config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    $this->Database = new Config($this->getDataFolder() . "database.yml", Config::YAML, array());
    $this->Player = new Config($this->getDataFolder() . "player.yml", Config::YAML, array());
    //EventListener
     $this->getServer()->getPluginManager()->registerEvents(new EventListener($this, $this->Config, $this->Database, $this->Player), $this);
     $this->EventListener = new EventListener($this, $this->Config, $this->Database, $this->Player);
     //Register
     if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
     }
  }
  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
    if($cmd->getName() == "gui"){
      if(count($args) == 0){
        if($sender->hasPermission("gui.add") && $sender->hasPermission("gui.delete")){
          $sender->sendMessage("§cUsage: /gui [add/delete/name]");
        }else{
          $sender->sendMessage("§cUsage: /gui [name]");
        }
        return false;
      }
      switch($args[0]){
        case "add":
        case "create":
         if($sender->hasPermission("gui.add")){
          if(count($args) == 1){
           $sender->sendMessage("§cUsage: /gui add {name}");
           return false;
          }
          if(empty(($this->Database->get($args[1])))){
          $sender->sendMessage("§f[§c!§f] §aRight Click To Chest To Create CustomGUI !");
          $this->Player->setNested($sender->getName().".name", $args[1]);
          $this->Player->setNested($sender->getName().".command", true);
          $this->Player->save();
            return true;
          }else{
            return false;
          }
         }else{
           $sender->sendMessage("§cYou Don't Have Permission To Use This Command");
           return false;
         }
          break;
          case "delete":
           if($sender->hasPermission("gui.delete")){
            if(count($args) == 1){
              $sender->sendMessage("§cUsage: /gui delete {name}");
              return false;
            }elseif(!empty(($this->Database->get($args[1])))){
              $this->Database->remove($args[1]);
              $sender->sendMessage("§f[§c-§f] §aThe Selected GUI Has Been Deleted !");
            }else{
              $sender->sendMessage("§f[§c!§f] §cGUI With That Name Does Not Exist !");
            }
           }else{
             $sender->sendMessage("§cYou Don't Have Permission To Use This Command");
           }
            break;
      }
      if(!empty(($this->Database->get($args[0])))){
        $this->onMenu($sender, $args[0]);
        return true;
      }elseif($args[0] !== "add" && $args[0] !== "create" && $args[0] !== "delete"){
        $sender->sendMessage("§f[§c!§f] §cGUI With That Name Does Not Exist");
        return false;
      }
      return true;
    }
  }
  public function onMenu(Player $player, $name){
    if($this->Database->getNested($name.".Size") == "TYPE_DOUBLE_CHEST"){
      $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
    }elseif($this->Database->getNested($name.".Size") == "TYPE_CHEST"){
      $menu = InvMenu::create(InvMenu::TYPE_CHEST);
    }
    $this->gui = $name;
    $menu->setListener(function(InvMenuTransaction $transaction): InvMenuTransactionResult {
      if($this->Database->getNested($this->gui.".readonly") == true){
        $readonly = $transaction->discard();
      }else{
        $readonly = $transaction->continue();
      }
      return $readonly;
    });
    $menu->setName($name);
    $inv = $menu->getInventory();
    if($this->Database->getNested($name.".Size") == "TYPE_DOUBLE_CHEST"){
    $inv->setItem(0, Item::get($this->Database->getNested($name.".Interface".".id1"), $this->Database->getNested($name.".Interface".".meta1"), 1));
    $inv->setItem(1, Item::get($this->Database->getNested($name.".Interface".".id2"), $this->Database->getNested($name.".Interface".".meta2"), 1));
    $inv->setItem(2, Item::get($this->Database->getNested($name.".Interface".".id3"), $this->Database->getNested($name.".Interface".".meta3"), 1));
    $inv->setItem(3, Item::get($this->Database->getNested($name.".Interface".".id4"), $this->Database->getNested($name.".Interface".".meta4"), 1));
    $inv->setItem(4, Item::get($this->Database->getNested($name.".Interface".".id5"), $this->Database->getNested($name.".Interface".".meta5"), 1));
    $inv->setItem(5, Item::get($this->Database->getNested($name.".Interface".".id6"), $this->Database->getNested($name.".Interface".".meta6"), 1));
    $inv->setItem(6, Item::get($this->Database->getNested($name.".Interface".".id7"), $this->Database->getNested($name.".Interface".".meta7"), 1));
    $inv->setItem(7, Item::get($this->Database->getNested($name.".Interface".".id8"), $this->Database->getNested($name.".Interface".".meta8"), 1));
    $inv->setItem(8, Item::get($this->Database->getNested($name.".Interface".".id9"), $this->Database->getNested($name.".Interface".".meta9"), 1));
    $inv->setItem(9, Item::get($this->Database->getNested($name.".Interface".".id10"), $this->Database->getNested($name.".Interface".".meta10"), 1));
    $inv->setItem(10, Item::get($this->Database->getNested($name.".Interface".".id11"), $this->Database->getNested($name.".Interface".".meta11"), 1));
    $inv->setItem(11, Item::get($this->Database->getNested($name.".Interface".".id12"), $this->Database->getNested($name.".Interface".".meta12"), 1));
    $inv->setItem(12, Item::get($this->Database->getNested($name.".Interface".".id13"), $this->Database->getNested($name.".Interface".".meta13"), 1));
    $inv->setItem(13, Item::get($this->Database->getNested($name.".Interface".".id14"), $this->Database->getNested($name.".Interface".".meta14"), 1));
    $inv->setItem(14, Item::get($this->Database->getNested($name.".Interface".".id15"), $this->Database->getNested($name.".Interface".".meta15"), 1));
    $inv->setItem(15, Item::get($this->Database->getNested($name.".Interface".".id16"), $this->Database->getNested($name.".Interface".".meta16"), 1));
    $inv->setItem(16, Item::get($this->Database->getNested($name.".Interface".".id17"), $this->Database->getNested($name.".Interface".".meta17"), 1));
    $inv->setItem(17, Item::get($this->Database->getNested($name.".Interface".".id18"), $this->Database->getNested($name.".Interface".".meta18"), 1));
    $inv->setItem(18, Item::get($this->Database->getNested($name.".Interface".".id19"), $this->Database->getNested($name.".Interface".".meta19"), 1));
    $inv->setItem(19, Item::get($this->Database->getNested($name.".Interface".".id20"), $this->Database->getNested($name.".Interface".".meta20"), 1));
    $inv->setItem(20, Item::get($this->Database->getNested($name.".Interface".".id21"), $this->Database->getNested($name.".Interface".".meta21"), 1));
    $inv->setItem(21, Item::get($this->Database->getNested($name.".Interface".".id22"), $this->Database->getNested($name.".Interface".".meta22"), 1));
    $inv->setItem(22, Item::get($this->Database->getNested($name.".Interface".".id23"), $this->Database->getNested($name.".Interface".".meta23"), 1));
    $inv->setItem(23, Item::get($this->Database->getNested($name.".Interface".".id24"), $this->Database->getNested($name.".Interface".".meta24"), 1));
    $inv->setItem(24, Item::get($this->Database->getNested($name.".Interface".".id25"), $this->Database->getNested($name.".Interface".".meta25"), 1));
    $inv->setItem(25, Item::get($this->Database->getNested($name.".Interface".".id26"), $this->Database->getNested($name.".Interface".".meta26"), 1));
    $inv->setItem(26, Item::get($this->Database->getNested($name.".Interface".".id27"), $this->Database->getNested($name.".Interface".".meta27"), 1));
    $inv->setItem(27, Item::get($this->Database->getNested($name.".Interface".".id28"), $this->Database->getNested($name.".Interface".".meta28"), 1));
    $inv->setItem(28, Item::get($this->Database->getNested($name.".Interface".".id29"), $this->Database->getNested($name.".Interface".".meta29"), 1));
    $inv->setItem(29, Item::get($this->Database->getNested($name.".Interface".".id30"), $this->Database->getNested($name.".Interface".".meta30"), 1));
    $inv->setItem(30, Item::get($this->Database->getNested($name.".Interface".".id31"), $this->Database->getNested($name.".Interface".".meta31"), 1));
    $inv->setItem(31, Item::get($this->Database->getNested($name.".Interface".".id32"), $this->Database->getNested($name.".Interface".".meta32"), 1));
    $inv->setItem(32, Item::get($this->Database->getNested($name.".Interface".".id33"), $this->Database->getNested($name.".Interface".".meta33"), 1));
    $inv->setItem(33, Item::get($this->Database->getNested($name.".Interface".".id34"), $this->Database->getNested($name.".Interface".".meta34"), 1));
    $inv->setItem(34, Item::get($this->Database->getNested($name.".Interface".".id35"), $this->Database->getNested($name.".Interface".".meta35"), 1));
    $inv->setItem(35, Item::get($this->Database->getNested($name.".Interface".".id36"), $this->Database->getNested($name.".Interface".".meta36"), 1));
    $inv->setItem(36, Item::get($this->Database->getNested($name.".Interface".".id37"), $this->Database->getNested($name.".Interface".".meta37"), 1));
    $inv->setItem(37, Item::get($this->Database->getNested($name.".Interface".".id38"), $this->Database->getNested($name.".Interface".".meta38"), 1));
    $inv->setItem(38, Item::get($this->Database->getNested($name.".Interface".".id39"), $this->Database->getNested($name.".Interface".".meta39"), 1));
    $inv->setItem(39, Item::get($this->Database->getNested($name.".Interface".".id40"), $this->Database->getNested($name.".Interface".".meta40"), 1));
    $inv->setItem(40, Item::get($this->Database->getNested($name.".Interface".".id41"), $this->Database->getNested($name.".Interface".".meta41"), 1));
    $inv->setItem(41, Item::get($this->Database->getNested($name.".Interface".".id42"), $this->Database->getNested($name.".Interface".".meta42"), 1));
    $inv->setItem(42, Item::get($this->Database->getNested($name.".Interface".".id43"), $this->Database->getNested($name.".Interface".".meta43"), 1));
    $inv->setItem(43, Item::get($this->Database->getNested($name.".Interface".".id44"), $this->Database->getNested($name.".Interface".".meta44"), 1));
    $inv->setItem(44, Item::get($this->Database->getNested($name.".Interface".".id45"), $this->Database->getNested($name.".Interface".".meta45"), 1));
    $inv->setItem(45, Item::get($this->Database->getNested($name.".Interface".".id46"), $this->Database->getNested($name.".Interface".".meta46"), 1));
    $inv->setItem(46, Item::get($this->Database->getNested($name.".Interface".".id47"), $this->Database->getNested($name.".Interface".".meta47"), 1));
    $inv->setItem(47, Item::get($this->Database->getNested($name.".Interface".".id48"), $this->Database->getNested($name.".Interface".".meta48"), 1));
    $inv->setItem(48, Item::get($this->Database->getNested($name.".Interface".".id49"), $this->Database->getNested($name.".Interface".".meta49"), 1));
    $inv->setItem(49, Item::get($this->Database->getNested($name.".Interface".".id50"), $this->Database->getNested($name.".Interface".".meta50"), 1));
    $inv->setItem(50, Item::get($this->Database->getNested($name.".Interface".".id51"), $this->Database->getNested($name.".Interface".".meta51"), 1));
    $inv->setItem(51, Item::get($this->Database->getNested($name.".Interface".".id52"), $this->Database->getNested($name.".Interface".".meta52"), 1));
    $inv->setItem(52, Item::get($this->Database->getNested($name.".Interface".".id53"), $this->Database->getNested($name.".Interface".".meta53"), 1));
    $inv->setItem(53, Item::get($this->Database->getNested($name.".Interface".".id54"), $this->Database->getNested($name.".Interface".".meta54"), 1));
    }elseif($this->Database->getNested($name.".Size") == "TYPE_CHEST"){
    $inv->setItem(0, Item::get($this->Database->getNested($name.".Interface".".id1"), $this->Database->getNested($name.".Interface".".meta1"), 1));
    $inv->setItem(1, Item::get($this->Database->getNested($name.".Interface".".id2"), $this->Database->getNested($name.".Interface".".meta2"), 1));
    $inv->setItem(2, Item::get($this->Database->getNested($name.".Interface".".id3"), $this->Database->getNested($name.".Interface".".meta3"), 1));
    $inv->setItem(3, Item::get($this->Database->getNested($name.".Interface".".id4"), $this->Database->getNested($name.".Interface".".meta4"), 1));
    $inv->setItem(4, Item::get($this->Database->getNested($name.".Interface".".id5"), $this->Database->getNested($name.".Interface".".meta5"), 1));
    $inv->setItem(5, Item::get($this->Database->getNested($name.".Interface".".id6"), $this->Database->getNested($name.".Interface".".meta6"), 1));
    $inv->setItem(6, Item::get($this->Database->getNested($name.".Interface".".id7"), $this->Database->getNested($name.".Interface".".meta7"), 1));
    $inv->setItem(7, Item::get($this->Database->getNested($name.".Interface".".id8"), $this->Database->getNested($name.".Interface".".meta8"), 1));
    $inv->setItem(8, Item::get($this->Database->getNested($name.".Interface".".id9"), $this->Database->getNested($name.".Interface".".meta9"), 1));
    $inv->setItem(9, Item::get($this->Database->getNested($name.".Interface".".id10"), $this->Database->getNested($name.".Interface".".meta10"), 1));
    $inv->setItem(10, Item::get($this->Database->getNested($name.".Interface".".id11"), $this->Database->getNested($name.".Interface".".meta11"), 1));
    $inv->setItem(11, Item::get($this->Database->getNested($name.".Interface".".id12"), $this->Database->getNested($name.".Interface".".meta12"), 1));
    $inv->setItem(12, Item::get($this->Database->getNested($name.".Interface".".id13"), $this->Database->getNested($name.".Interface".".meta13"), 1));
    $inv->setItem(13, Item::get($this->Database->getNested($name.".Interface".".id14"), $this->Database->getNested($name.".Interface".".meta14"), 1));
    $inv->setItem(14, Item::get($this->Database->getNested($name.".Interface".".id15"), $this->Database->getNested($name.".Interface".".meta15"), 1));
    $inv->setItem(15, Item::get($this->Database->getNested($name.".Interface".".id16"), $this->Database->getNested($name.".Interface".".meta16"), 1));
    $inv->setItem(16, Item::get($this->Database->getNested($name.".Interface".".id17"), $this->Database->getNested($name.".Interface".".meta17"), 1));
    $inv->setItem(17, Item::get($this->Database->getNested($name.".Interface".".id18"), $this->Database->getNested($name.".Interface".".meta18"), 1));
    $inv->setItem(18, Item::get($this->Database->getNested($name.".Interface".".id19"), $this->Database->getNested($name.".Interface".".meta19"), 1));
    $inv->setItem(19, Item::get($this->Database->getNested($name.".Interface".".id20"), $this->Database->getNested($name.".Interface".".meta20"), 1));
    $inv->setItem(20, Item::get($this->Database->getNested($name.".Interface".".id21"), $this->Database->getNested($name.".Interface".".meta21"), 1));
    $inv->setItem(21, Item::get($this->Database->getNested($name.".Interface".".id22"), $this->Database->getNested($name.".Interface".".meta22"), 1));
    $inv->setItem(22, Item::get($this->Database->getNested($name.".Interface".".id23"), $this->Database->getNested($name.".Interface".".meta23"), 1));
    $inv->setItem(23, Item::get($this->Database->getNested($name.".Interface".".id24"), $this->Database->getNested($name.".Interface".".meta24"), 1));
    $inv->setItem(24, Item::get($this->Database->getNested($name.".Interface".".id25"), $this->Database->getNested($name.".Interface".".meta25"), 1));
    $inv->setItem(25, Item::get($this->Database->getNested($name.".Interface".".id26"), $this->Database->getNested($name.".Interface".".meta26"), 1));
    $inv->setItem(26, Item::get($this->Database->getNested($name.".Interface".".id27"), $this->Database->getNested($name.".Interface".".meta27"), 1));
    }
    $menu->send($player);
  }
}
