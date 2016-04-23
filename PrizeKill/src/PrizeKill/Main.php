<?php 

namespace PrizeKill;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use onebone\economyapi\EconomyAPI;
class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onKill(PlayerDeathEvent $event){
		$killer = $event->getEntity()->getLastDamageCause()->getDamager();
		EconomyAPI::getInstance()->addMoney($killer, 200);
	}
}

?>