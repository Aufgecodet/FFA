<?php


namespace Aufgecodet\FFA\listener;


use Aufgecodet\FFA\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;

class BasicListener implements Listener{
    /**
     * @var Main
     */
    public $main;

    /**
     * @param Main $main
     */
    public function __construct(Main  $main){
         $this->main = $main;
    }

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent  $event){

          Main::getInstance()->giveItems($event->getPlayer());
          Main::getInstance()->teleport($event->getPlayer());
          $event->getPlayer()->sendTitle("§e§lFFA");
    }

    /**
     * @param PlayerDropItemEvent $event
     * @return void
     */
    public function onDrop(PlayerDropItemEvent $event){
        $event->cancel();
    }

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event){

    }

    /**
     * @param CraftItemEvent $event
     * @return void
     */
    public function onCraft(CraftItemEvent $event){
        $event->cancel();
    }

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBreak(BlockBreakEvent $event){
        $event->cancel();
    }

    /**
     * @param BlockPlaceEvent $event
     * @return void
     */
    public function onPlace(BlockPlaceEvent $event){
        $event->cancel();
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     */
    public function  onDamage(EntityDamageEvent $event)
    {

        $entity = $event->getEntity();
        if ($event->getCause() == EntityDamageEvent::CAUSE_ENTITY_ATTACK) {
            $damage = $event->getDamager();
            if ($damage instanceof Player) {
                if ($entity instanceof Player) {
                    $bdamage = $event->getFinalDamage();
                    if ($entity->getHealth() - $bdamage <= 1) {
                        $event->cancel();
                        Main::getInstance()->teleport($entity);
                        Main::getInstance()->giveItems($entity);
                        $entity->setHealth(20);
                        $damage->setHealth(20);
                    }
                }
            }
        }else{
            $event->cancel();
        }
    }

    /**
     * @param PlayerExhaustEvent $event
     * @return void
     */
    public function onHunger(PlayerExhaustEvent $event){
        $event->cancel();
    }


}