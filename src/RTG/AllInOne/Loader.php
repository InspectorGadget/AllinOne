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

namespace RTG\AllInOne;

/* Essentials */
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Config;

use RTG\AllInOne\commands\FreezeCommand;
use RTG\AllInOne\commands\RuleCommand;

class Loader extends PluginBase {
    
    public $api;
    public $frozen;
    public $rules;
    
    public function onEnable() {
        
        $this->api = $this->getServer()->getApiVersion();
        $this->getCommand("freeze")->setExecutor(new FreezeCommand($this));
        $this->getCommand("rule")->setExecutor(new RuleCommand($this));
        
        $this->frozen = array();
        
        @mkdir($this->getDataFolder());
        $this->rules = new Config($this->getDataFolder() . "rules.yml", Config::YAML, array(
            "rules" => array(
                "Do not kick for no reason"
            )
        ));
        
    }
    
    public function freezeAdd($name, $sender) {
        
        if (isset($this->frozen[strtolower($name)])) {
            
            $sender->sendMessage("$name exist!");
            
        }
        else {
            
            $this->frozen[strtolower($name)] = strtolower($name);
            $sender->sendMessage("Added $name to the list!");
            
        }
        
    }
    
    public function ruleAdd($rule, $sender) {
        
        $file = $this->rules->get("rules");
        
        if (in_array($rule, $file)) {
            
            $sender->sendMessage("The Rule exists!");
            
        }
        else {
            
            array_push($file, $rule);
            $this->rules->set("rules", $file);
            $sender->sendMessage("Rule Added!");
            $this->rules->save();
            
        }
        
    }
    
    public function ruleRemove($rule, $sender) {
        
        
        $file = $this->rules->get("rules");
        
        if (in_array($rule, $file)) {
            
            unset($file[array_search($rule, $file)]);
            $this->rules->set("rules", $file);
            $sender->sendMessage("Removed the rule!");
            $this->rules->save();
            
        }
        else {
            
            $sender->sendMessage("Rule doesn't exist!");
            
        }
        
    }
    
    public function onRuleList($sender) {
        
        $file = $this->rules->get("rules");
        
        foreach ($file as $list) {
            
            $sender->sendMessage(" -- Rules -- ");
            $sender->sendMessage(" - " . $list);
            
        }
        
    }
    
     
}