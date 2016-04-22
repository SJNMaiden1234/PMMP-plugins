<?php 

namespace CooKieRun;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\entity\Effect;
class Main extends PluginBase implements Listener{
	/** @var string */
	private $dbi,$cookie1,$dbd,$money,$cookie1d,$mbi,$mbd;
	public function onEnable(){
		$this->loadConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function loadConfig(){
    	@mkdir($this->getDataFolder());
    	$this->saveDefaultConfig();
    	$this->dbi = $this->getConfig()->get("die-block-id", "");
    	$this->dbd = $this->getConfig()->get("die-block-damage", "");
    	$this->cookie1 = $this->getConfig()->get("brave-cookie", "");
    	$this->money = $this->getConfig()->get("get-money-amount","");
    	$this->cookie1d = $this->getConfig()->get("brave-cookie-damage","");
    	$this->mbi = $this->getConfig()->get("money-block-id", "");
    	$this->mbd = $this->getConfig()->get("money-block-damage","");
    }
	public function onDisable(){
		$this->getLogger()->info("Plugin Is Disable");
	}
	public function onJump(PlayerMoveEvent$event){
		$player = $event->getPlayer();
		$block = $player->level->getBlock(new Vector3((int) $player->x, (int) ($player->y - 1), (int) $player->z));
		if($block->getId() === 35 && $block->getDamage() === 1) {
			$player->sendTip("Jump!");
			$player->setMotion(new Vector3(0, 1, 0));
		}
	}
	public function onDie(PlayerMoveEvent$event){
		$player = $event->getPlayer();
		$block = $player->level->getBlock(new Vector3((int) $player->x, (int) ($player->y - 1), (int) $player->z));
		if($block->getId() === $this->dbi && $block->getDamage() === $this->dbd){
			$player->sendTip("Die!");
			$player->setHealth(0);
		}
	}
	public function onWalk(PlayerMoveEvent$event){
		$player = $event->getPlayer();
		$x = - \sin ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI );
		$y = - \sin ( $player->pitch / 180 * M_PI );
		$z =\cos ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI );
		$block = $player->level->getBlock(new Vector3((int) $player->x, (int) ($player->y - 1), (int) $player->z));
		if($block->getId() === 20 && $block->getDamage() === 0) {
			$player->sendTip("Look at the front!");
			$player->setMotion(new Vector3($x*3, $y*3, $z*3));
		}
	}
	public function onMalk(PlayerMoveEvent$event){
		$player = $event->getPlayer();
		$block = $player->level->getBlock(new Vector3((int) $player->x, (int) ($player->y - 1), (int) $player->z));
		if($block->getId() === 35 && $block->getDamage() === 2) {
			$player->setMotion(new Vector3(0, 2, 0));
			$player->sendTip("Super Jump");
		}
	}
	public function onMoney(PlayerMoveEvent$event){
		$player = $event->getPlayer();
		$block = $player->level->getBlock(new Vector3((int) $player->x, (int) ($player->y - 1), (int) $player->z));
		if($block->getId() === $this->mbi && $block->getDamage() === $this->mbd) {
			EconomyAPI::getInstance()->addMoney($player, $this->money);
			$player->sendTip("Get Money");
		}
	}
	public function onHeld(PlayerItemHeldEvent$event) {
		$cookie1 = $event->getItem()->getId() == $this->cookie1 && $event->getItem()->getDamage() == $this->cookie1d;
		if($cookie1){
			$e1 = Effect::getEffect(1);
			$p = $event->getPlayer();
			$e1->setDuration(40);
			$p->addEffect($e1);
			$this->onHeld();
		}
	}
}

?>