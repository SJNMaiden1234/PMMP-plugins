<?php 

namespace KillM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\TextFormat;
class Main extends PluginBase implements Listener{
	private $multikill = [ ];
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		
	}
    public function onJoin(PlayerJoinEvent $event){
        if(! isset($this->multikill[$event->getPlayer()->getName()])) $this->multikill[$event->getPlayer()->getName()] = 0;
    }
    //플레이어 접속시 플레이어 킬데이터 등록. 이 구문 없으면 Undefined뜹니다

    public function onKill(PlayerDeathEvent $event){
        $killed = $event->getEntity();
        //죽은사람 변수지정
        if($killed instanceof Player){
            $cause = $killed->getLastDamageCause();
            if($cause instanceof EntityDamageByEntityEvent){
                if(($damager = $cause->getDamager()) instanceof Player){
                    $dname = $damager->getName();
                    $sname = $killed->getName();
                    $this->multikill[$sname] = 0;
                    $this->multikill[$dname] ++;
                    if($this->multikill[$dname] >= 2 && $this->multikill [$dname] < 5){
                    $this->getServer()->broadcastMessage (TextFormat::RED.$dname."님이 학살 중 입니다.");
                    return true;
					}
					if ($this->multikill[$dname] >=5 && $this->multikill[$dname] < 10){
						$this->getServer()->broadcastMessage(TextFormat::RED.$dname."불쌍한 서버원들을 어떻게 합니까?");
                                                return true;
					}
					if ($this->multikill[$dname] >=10 && $this->multikill[$dname] < 20){
						$this->getServer()->broadcastMessage(TextFormat::RED."다 같이 힘을 합쳐 ".$dname."을 처리합시다!");
                                                return true;
					}
					if ($this->multikill[$dname] >=20 && $this->multikill[$dname] < 35){
						$this->getServer()->broadcastMessage(TextFormat::RED."신의 경지에 오른".$dname."을 처리할 수가 없군요..");
                                                return true;
					}
					if ($this->multikill[$dname] >35){
						$this->getServer()->broadcastMessage(TextFormat::RED."더 이상 처리가 불가능 해진".$dname."님");
                                                return true;
					}
				}
			}
		}
	}}
?>
