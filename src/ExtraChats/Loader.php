<?php

declare(strict_types=1);

namespace ExtraChats;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

class Loader extends PluginBase
{

	public function onEnable(): void {
		Server::getInstance()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}

}