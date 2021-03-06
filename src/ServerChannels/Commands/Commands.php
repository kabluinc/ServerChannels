<?php

/*
 * ServerChannels (v1.2) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 17/06/2015 09:41 AM (UTC)
 * Copyright & License: (C) 2014-2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/ServerChannels/blob/master/LICENSE)
 */

namespace ServerChannels\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use ServerChannels\Main;

class Commands extends PluginBase implements CommandExecutor{

	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    	$fcmd = strtolower($cmd->getName());
    	switch($fcmd){
    		case "serverchannels":
    			if(isset($args[0])){
    				$args[0] = strtolower($args[0]);
    				if($args[0]=="help"){
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable Commands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch reload &b>>&e Reload the config"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch list &b>>&e Show the list of all channels"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch join &b>>&e Join a channel"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch leave &b>>&e Leave the current channel"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch new &b>>&e Create new channel"));
    						break;
    					}
    				}elseif($args[0]=="info"){
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eServerChannels &bv" . Main::VERSION . " &edeveloped by&b " . Main::PRODUCER));
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eWebsite &b" . Main::MAIN_WEBSITE));
    				        break;
    					}
    				}elseif($args[0]=="reload"){
    						$this->plugin->reloadConfig();
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aConfiguration Reloaded."));
    				        break;
    					}
    				}elseif($args[0]=="new"){
    						if(isset($args[1])){
    							$this->plugin->initializeChannelPermissions();
    							$this->plugin->createChannel($args[1]);
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aChannel &b" . strtolower($args[1]) . "&a created!"));
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cUsage: /sch new <channel>"));
    						}
    						break;
    					}
    				}elseif($args[0]=="list"){
    						$this->plugin->initializeChannelPermissions();
    						$list = $this->plugin->getAllChannels();
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&b>> &aAvailable Channels &b<<"));
    						for($i = 0; $i < count($list); $i++){
    							if($sender->hasPermission(strtolower("serverchannels.channels." . $list[$i]))){
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&b- &a" . $list[$i]));
    							}
    						}
    						break;
    					}
    				}elseif($args[0]=="join"){
    					//Check if Sender is a player
    					if($sender instanceof Player){
    							if(isset($args[1])){
    								//Check channel permission
    								if($sender->hasPermission(strtolower("serverchannels.channels." . $args[1]))){
    									$status = $this->plugin->joinChannel($sender, $args[1]);
    									if($status == false){
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cChannel not found."));
    									}else{
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou joined &b" . strtolower($args[1]) . "&a channel"));
    									}
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cUsage: /sch join <channelname>"));
    							}
    							break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    						break;
    					}
    				}elseif($args[0]=="leave"){
    				//Check if Sender is a player
    					if($sender instanceof Player){
    							$channel = $this->plugin->getPlayerChannel($sender);
    							$status = $this->plugin->leaveChannel($sender);
    							if($status == false){
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cYou haven't joined on a channel"));
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou left &b" . $channel . "&a channel"));
    							}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    						break;
    					}
    				}else{
    						$sender->sendMessage($this->plugin->translateColors("&",  Main::PREFIX . "&cSubcommand &a" . $args[0] . " &cnot found. Use &a/sch help &cto show available commands"));
    						break;
    				}
    				}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable Commands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch reload &b>>&e Reload the config"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch list &b>>&e Show the list of all channels"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch join &b>>&e Join a channel"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch leave &b>>&e Leave the current channel"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sch new &b>>&e Create new channel"));
    						break;
    					}
    				}
    			}
    	}
}
?>
