<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace RTG\AllInOne\commands;

/* Essentials */
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\CommandExecutor;

use RTG\AllInOne\EventClass;

class FreezeCommand implements CommandExecutor {
    
    public $plugin;
    public $class;
    public $usage;

    public function __construct(\RTG\AllInOne\Loader $plugin) {
        $this->plugin = $plugin;
        $this->class = new EventClass($plugin);
        $this->usage = "[Usage] /freeze <player>";
    }
    
    public function onCommand(\pocketmine\command\CommandSender $sender, \pocketmine\command\Command $command, $label, array $args) {
        
        switch(strtolower($command->getName())) {
            
            case "freeze":
                
                if ($sender->hasPermission("allinone.command.freeze") or $sender->isOp()) {
                    
                    if (isset($args[0])) {
                        
                        $name = $args[0];
                        $pl = $this->plugin->getServer()->getPlayer($name);
                        
                            if ($pl === true) {
                                
                                $this->plugin->freezeAdd($name, $sender);
                                
                            }
                            else {
                                
                                $sender->sendMessage("$name isn't a Valid Player! If that case, we will add so he/she will be frozen until he/she gets pass the timer!");
                                $this->plugin->freezeAdd($name, $sender);
                                
                            }
                         
                    }
                    else {
                        
                        $this->usage;
                        
                    }
                    
                }
                else {
                    
                    $sender->sendMessage("You have no permission to use this command!");
                    
                }
                
                break;
              
        }
         
    }
       
}