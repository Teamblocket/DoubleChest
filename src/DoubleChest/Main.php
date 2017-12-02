<?php

namespace DoubleChest;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\tile\Tile;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\nbt\tag\{CompoundTag, IntTag, ListTag, StringTag, IntArrayTag};

class Main extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function getDoubleChest(Player $player){
		/** @var Chest $tile */
		$tile = Tile::createTile('Chest', $player->getLevel(), new CompoundTag('', [
			new StringTag('id', Tile::CHEST),
			new IntTag('Chest', 1),
			new IntTag('x', $player->x),
			new IntTag('y', $player->y + 1),
			new IntTag('z', $player->z)
		]));
		$block = Block::get(Block::CHEST);
		$block->x = $tile->x;
		$block->y = $tile->y;
		$block->z = $tile->z;
		$block->level = $tile->getLevel();
		$block->level->sendBlocks([$player], [$block]);
    
		/** @var Chest $tile */
		$tile_2 = Tile::createTile('Chest', $player->getLevel(), new CompoundTag('', [
			new StringTag('id', Tile::CHEST),
			new IntTag('Chest', 1),
			new IntTag('x', $player->x + 1),
			new IntTag('y', $player->y + 1),
			new IntTag('z', $player->z)
		]));
		$block_2 = Block::get(Block::CHEST);
		$block_2->x = $tile_2->x;
		$block_2->y = $tile_2->y;
		$block_2->z = $tile_2->z;
		$block_2->level = $tile->getLevel();
		$block_2->level->sendBlocks([$player], [$block_2]);
    
    $tile->pairWith($tile_2);
    
    return $tile->getInventory();
    
  }
  
  public function onJoin(PlayerJoinEvent $ev){
    sleep(10);
    $ev->getPlayer()->getInventory()->addWindow($this->getDoubleChest());
  }
}
