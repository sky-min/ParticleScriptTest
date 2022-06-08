<?php
declare(strict_types = 1);

namespace skymin\test;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;

use skymin\ParticleScript\ScriptManager;

final class Main extends PluginBase implements Listener{

	private string $fileName;

	protected function onEnable() : void{
		$this->saveResource('test.yml');
		$this->fileName = $this->getDataFolder() . 'test.yml';
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		ScriptManager::registerFile($this->fileName);
	}

	public function onTouch(PlayerItemUseEvent $ev) : void{
		$loc = $ev->getPlayer()->getLocation();
		$pks = ScriptManager::getScriptFile($this->fileName)->getScript('test')->encode($loc, $loc->yaw, $loc->pitch);
		$server = $this->getServer();
		$server->broadcastPackets($server->getOnlinePlayers(), $pks);
	}

}