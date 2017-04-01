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

class RuleCommand implements CommandExecutor {
    
    public $plugin;
    
    public function __construct(\RTG\AllInOne\Loader $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onCommand(\pocketmine\command\CommandSender $sender, \pocketmine\command\Command $command, $label, array $args) {
        
        switch(strtolower($command->getName())) {
            
            case "rule":
                
                if ($sender->hasPermission("allinone.command.rule") or $sender->isOp()) {
                    
                    if (isset($args[0])) {
                        
                        switch (strtolower($args[0])) {
                            
                            case "add":
                                
                                $rule = trim(implode(" ", array_splice($args, 1)));
                                
                                $this->plugin->ruleAdd($rule, $sender);
                                
                                break;
                            
                            case "rm":
                                
                                $rule = trim(implode(" ", array_splice($args, 1)));
                                
                                $this->plugin->ruleRemove($rule, $sender);
                                
                                break;
                            
                            case "list";
                                
                                $this->plugin->onRuleList($sender);
                                
                                break;
                            
                        }
                         
                    }
                    else {
                        $sender->sendMessage("[Usage] /rule < add | rm | list>");
                    }
                    
                }
                else {
                    $sender->sendMessage("You have no permission to use this command!");
                }
                
                break;
            
        }
        
    }
    
}