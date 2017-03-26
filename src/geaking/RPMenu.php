<?php 
namespace geaking;


/************************Импорты******************/
	use pocketmine\level\particle\FlameParticle;
	use pocketmine\math\Vector3;
	use pocketmine\command\ConsoleCommandSender;
	use pocketmine\plugin\PluginManager;
	use pocketmine\item\enchantment\Enchantment;
	use pocketmine\level\Level;
	use pocketmine\event\player\PlayerItemHeldEvent;
	use pocketmine\event\player\PlayerDropItemEvent;
	use pocketmine\event\player\PlayerInteractEvent;
	use pocketmine\event\player\PlayerJoinEvent;
	use pocketmine\level\sound\AnvilFallSound;
	use pocketmine\entity\Effect;
	use pocketmine\Player;
	use pocketmine\Server;
	use pocketmine\plugin\PluginBase;
	use pocketmine\event\Listener;
	use pocketmine\command\CommandSender;
	use pocketmine\command\Command;
	use pocketmine\lang\BaseLang;
    use pocketmine\item\Item;
    use pocketmine\inventory\PlayerInventory;
    use pocketmine\inventory\Inventory;
	use pocketmine\utils\Config;
	use onebone\economyapi\EconomyAPI;  
	use pocketmine\IPlayer; 
	use pocketmine\event\player\PlayerRespawnEvent;
	use pocketmine\event\player\PlayerQuitEvent;
    /*************************Код*********************/
 class RPMenu extends PluginBase implements Listener {
 	public $eco;
 	public $pp;
 	public function onEnable(){
 	$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
 	$this->pp = $this->getServer()->getPluginManager()->getPlugin("PurePerms");	
 	$this->getLogger()->info("§2Плагин включен.");	
	$this->getLogger()->info("§2Создатель vk.com/easymanfifa");					
   	$this->getServer()->getPluginManager()->registerEvents($this, $this);
   }
 public function onJoin(PlayerJoinEvent $e){
 	$p = $e->getPlayer();
 	$inv = $p->getInventory();
 	$menu = Item::get(345,0,1);
 	$menu->setCustomName("§bМеню");
 	$inv->setItem(0,$menu);
 }
  public function onRespawn(PlayerRespawnEvent $e){
 	$p = $e->getPlayer();
 	$inv = $p->getInventory();
 	$menu = Item::get(345,0,1);
 	$menu->setCustomName("§bМеню");
 	$inv->setItem(0,$menu);
 }
  public function onQuit(PlayerQuitEvent $e){
    $p = $e->getPlayer();
    $inv = $p->getInventory();
    $inv->removeItem(Item::get(345, 0, 1)); 
    $inv->removeItem(Item::get(340, 0, 1)); 
	$inv->removeItem(Item::get(341, 0, 1));  
	$inv->removeItem(Item::get(288, 0, 1));        
	$inv->removeItem(Item::get(339, 0, 1));
	$inv->removeItem(Item::get(339, 0, 1));  
	$inv->removeItem(Item::get(347, 0, 1));    
	$inv->removeItem(Item::get(340, 0, 1));       
}
  public function onUse(PlayerInteractEvent $e){
  	$p = $e->getPlayer();
  	$inv = $p->getInventory();
	$level = $p->getLevel();
	$name = $p->getName();
	$b = $e->getBlock();
	$x = $p->getX();
	$y = $p->getY();
	$z = $p->getZ();
	$time = date('H:i');	
		if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 345 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§bМеню')){
			$p->getInventory()->removeItem(Item::get(345,0,1));
			$taxi = Item::get(340,0,1);
			$taxi->setCustomName('§aТакси');
			$inv->setItem(4,$taxi);
			$balance = Item::get(341,0,1);
			$balance->setCustomName('§aБаланс');
			$inv->setItem(3,$balance);
			$xyz = Item::get(288,0,1);
			$xyz->setCustomName('§aКоординаты');
			$inv->setItem(2,$xyz);
			$time = Item::get(347,0,1);
			$time->setCustomName('§aВремя');
			$inv->setItem(1,$time);
			$job = Item::get(339,0,1);
			$job->setCustomName('§aДолжность');
			$inv->setItem(0,$job);
			$back = Item::get(345,0,1);
			$back->setCustomName('§a« Назад');
			$inv->setItem(8,$back);
		}
				if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 345 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§a« Назад')){
					    $inv->removeItem(Item::get(340, 0, 1)); 
					    $inv->removeItem(Item::get(341, 0, 1));  
					    $inv->removeItem(Item::get(288, 0, 1));        
					    $inv->removeItem(Item::get(339, 0, 1)); 
					    $inv->removeItem(Item::get(339, 0, 1));
					    $inv->removeItem(Item::get(345, 0, 1)); 
					    $inv->removeItem(Item::get(340, 0, 1)); 
					    $inv->removeItem(Item::get(347, 0, 1));
					 	$menu = Item::get(345,0,1);
					 	$menu->setCustomName("§bМеню");
					 	$inv->setItem(0,$menu);				    
				}				
				if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 340 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aТакси')){
					    $inv->removeItem(Item::get(340, 0, 1)); 
					    $inv->removeItem(Item::get(341, 0, 1));  
					    $inv->removeItem(Item::get(288, 0, 1));        
					    $inv->removeItem(Item::get(339, 0, 1));
					    $inv->removeItem(Item::get(347, 0, 1));  
					    $spawn = Item::get(339,0,1);
					    $spawn->setCustomName('§aБилет на спавн');
					    $inv->setItem(0,$spawn);				    
				}
					if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 341 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aБаланс')){
						$money = $this->eco->mymoney($p);
						$p->sendMessage('§b> Ваш баланс:§a '.$money);
				}
				if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 288 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aКоординаты')){
					$p->sendMessage('§b> Ваши координаты:§a '.$x.' '.$y.' '.$z);
				}
				if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 347 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aВремя')){
					$p->sendMessage('§b> Сейчас:§a '.$time);
				}
				if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 339 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aДолжность')){
				$group = $this->pp->getUserDataMgr()->getGroup($p)->getName();
				$p->sendMessage('§b> Ваша должность:§a '.$group);
				}				
					if(($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) && ($p->getInventory()->getItemInHand()->getId() == 339 ) && ($p->getInventory()->getItemInHand()->getCustomName() == '§aБилет на спавн')){
						$money = $this->eco->mymoney();
						if($money >= 25){
						$p->sendMessage('§b> Вы вызвали такси на спавн!');
						$this->getServer()->dispatchCommand($p , 'spawn'); 
						$this->eco->reduceMoney($p,25);
					}else{
					$p->sendMessage('§4> У вас недостаточно денег для вызова такси!');
					}
				}			
  }
}
 ?>