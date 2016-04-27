<?php 

namespace DefaultItem;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
class Main extends PluginBase implements Listener{
	private $player;
	private $item;
	public function onEnable(){
		$this->player = new Config($this->getDataFolder()."players.yml",Config::YAML);
		$this->item = new Config($this->getDataFolder()."item.yml",Config::YAML, ["items" => [1,2,3]]);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->broadcastMessage("정상적으로 기본템 시스템이 가동 되었습니다");
	}
	public function onDisable(){
		$this->player->save();
		$this->item->save();
	}
	public function onJoin(PlayerJoinEvent $event){
		if (!$this->player->exists($event->getPlayer()->getName())){
			$this->player->set($event->getPlayer()->getName(),false);
		}
		$pi = $event->getPlayer();
		$pin = $event->getPlayer()->getName();
		$ptf = $this->player->get($event->getPlayer()->getName());
		if (!$ptf == true){
			$this->player->set($pin,true);
			foreach ($this->item->get("items") as $itemdata){
				$pi->getInventory()->addItem(Item::get($itemdata,0,1));
				$pi->sendMessage("기본적인 아이템이 지급됩니다.");
			}
		}
		if ($ptf == true){
			$pi->sendMessage("정상적으로 서버에 접속완료.");
		}
	}
}

?>