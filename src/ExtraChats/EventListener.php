<?php

declare(strict_types=1);

namespace ExtraChats;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Server;

class EventListener implements Listener
{

	private string $chatType;
	
	/**
	 * @priority LOWEST
	 */
    public function onPlayerChatReceive(PlayerChatEvent $event): void {
		$player = $event->getPlayer();
		$message = $event->getMessage();

		if($message[0] === "!") {
			$this->chatType = "g";

			$event->setMessage(ltrim($message, '!'));
		} else {
			$this->chatType = "l";

			$players = [];
			foreach($player->getLocation()->getWorld()->getPlayers() as $otherPlayer) {
				if(sqrt($player->getLocation()->distanceSquared($otherPlayer->getLocation())) <= 50) { 
					$players[] = $otherPlayer;
				}

			}
			$event->setRecipients($players);
		}
	
	}

	/**
	 * @priority HIGHEST
	 */
	public function onPlayerSend(PlayerChatEvent $event): void {
		$event->setFormat($this->chatType." ".Server::getInstance()->getLanguage()->translateString($event->getFormat(), [$event->getPlayer()->getDisplayName(), $event->getMessage()]));
	}

}