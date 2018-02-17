<?php
/**
 * Created by PhpStorm.
 * User: pacma
 * Date: 1/26/2018
 * Time: 5:48 PM
 */

namespace FactionsUI;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\{
    command\ConsoleCommandSender, Server, Player, utils\TextFormat
};
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("FactionsUI made By QuiverlyRivalry\nThis is a private plugin, want more plugins?\n Contact here QuiverlyRivalry#4535\n on Discord!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        $player = $sender->getPlayer();
        switch($command->getName()){
            case "fac":
                $this->menuForm($player);
        }
        return true;
    }

    public function menuForm(Player $player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Create a Faction
                            $this->createFactionForm($sender);
                            break;
                        case 1:
                            //Leader Commands
                            $this->leaderCommandForm($sender);
                            break;
                        case 2:
                            //Officer Commands
                            $this->officerCommandForm($sender);
                            break;
                        case 3:
                            $this->generalCommandForm($sender);
                            break;
                        case 4:
                            //Exit
                            break;
                    }
                }
            });
            $form->setTitle("§6Void§bFactions§cPE §dUI");
            $form->setContent("§aPlease choose an action to use!");
            $form->addButton(TextFormat::GREEN . "§1Create a Faction?\nIf your not in one!");
            $form->addButton("§2Faction Leader Commands");
            $form->addButton("§3Faction Officer Commands");
            $form->addButton("§4General Commands");
            $form->addButton(TextFormat::RED . "§5Exit");
            $form->sendToPlayer($player);
        }
    }

    public function createFactionForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f create " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§dFaction Creation");
        $form->addInput("§cFaction Name");
        $form->sendToPlayer($player);
    }

    public function leaderCommandForm(Player $player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //f claim
                            $this->getServer()->getCommandMap()->dispatch($sender, "f claim");
                            break;
                        case 1:
                            //f demote
                            //
                            $this->demoteForm($sender);
                            break;
                        case 2:
                            //f kick
                            //
                            $this->kickForm($sender);
                            break;
                        case 3:
                            //f leader
                            //
                            $this->leaderForm($sender);
                            break;
                        case 4:
                            //f sethome
                            $this->getServer()->getCommandMap()->dispatch($sender, "f sethome");
                            break;
                        case 5:
                            //f unclaim
                            $this->getServer()->getCommandMap()->dispatch($sender, "f unclaim");
                            break;
                        case 6:
                            //f unsethome
                            $this->getServer()->getCommandMap()->dispatch($sender, "f unsethome");
                            break;
                        case 7:
                            //f desc
                            $this->getServer()->getCommandMap()->dispatch($sender, "f desc");
                            break;
                        case 8:
                            //f promote
                            //
                            $this->promoteForm($sender);
                            break;
                        case 9:
                            //f ally <faction>
                            //
                            $this->allyForm($sender);
                            break;
                        case 10:
                            //f allyok
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allyok");
                            break;
                        case 11:
                            //f allyno
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allyno");
                            break;
                        case 12:
                            //f unally <faction>
                            //
                            $this->getServer()->getCommandMap()->dispatch($sender, "f unally");
                            break;
                        case 13:
                            //f delete
                            $this->getServer()->getCommandMap()->dispatch($sender, "f del");
                            break;
                        case 14:
                            //Back
                            $this->menuForm($sender);
                            break;
                    }
                }
            });
            $form->setTitle("§6Leader §bMenu");
            $form->setContent("§3Hello, Leader! Controll your factions settings, and much more!");
            $form->addButton("§aClaim a Faction Plot!");
            $form->addButton("§bDemote an Officer?");
            $form->addButton("vcKick a member/officer");
            $form->addButton("§dGive someone leader!");
            $form->addButton("§eSet a Faction Home");
            $form->addButton("§1Unclaim a Faction Plot");
            $form->addButton("§2Unset your Factions Home");
            $form->addButton("§3Set your description.");
            $form->addButton("§4Promote an Officer");
            $form->addButton("§5Ally with a Faction!");
            $form->addButton("§6Accept an Ally Request");
            $form->addButton("§9Decline an Ally Request");
            $form->addButton("§aBreak Alliance with a Faction");
            $form->addButton(TextFormat::RED . "§cDelete your Faction..?");
            $form->addButton("§bBack");
            $form->sendToPlayer($player);
        }
    }

    public function demoteForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f demote " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bDemote an Officer");
        $form->addInput("§3Player Name");
        $form->sendToPlayer($player);
    }

    public function kickForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f kick " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bKick a Player");
        $form->addInput("§3Player Name to Kick");
        $form->sendToPlayer($player);
    }

    public function leaderForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->leaderName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f leader " . $this->leaderName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bTransfer Ownership");
        $form->addInput("§3New Owner name");
        $form->sendToPlayer($player);
    }

    public function promoteForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->luckyPerson = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f promote " . $this->luckyPerson);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bPromote an Member");
        $form->addInput("§3Members Name");
        $form->sendToPlayer($player);
    }

    public function allyForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f ally " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bAlly with a Faction");
        $form->addInput("§3Factions Name");
        $form->sendToPlayer($player);
    }

    public function breakAllianceForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f unally " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bBreak Alliances");
        $form->addInput("§3Faction Name");
        $form->sendToPlayer($player);
    }

    public function inviteForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f invite " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bInvite a Player");
        $form->addInput("§3Players Name");
        $form->sendToPlayer($player);
    }

    public function officerCommandForm(Player $player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Invite Someone
                            $this->inviteForm($sender);
                            break;
                        case 1:
                            $this->menuForm($sender);
                            break;
                    }
                }
            });
            $form->setTitle("§6Officer §bMenu");
            $form->setContent("§aWelcome, officers control your members here!\nNot many commands though...");
            $form->addButton("§2Invite a player!");
            $form->addButton(TextFormat::RED . "§5Exit");
            $form->sendToPlayer($player);
        }
    }

    public function generalCommandForm(Player $player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Info about a faction
                            //
                            $this->factionWhoForm($sender);
                            break;
                        case 1:
                            //f ourmembers
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourmembers");
                            break;
                        case 2:
                            //f ourofficers
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourofficers");
                            break;
                        case 3:
                            //f ourleader
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourleader");
                            break;
                        case 4:
                            //f allies
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allies");
                            break;
                        case 5:
                            //f listmembers <faction>
                            //
                            $this->listmembers($sender);
                            break;
                        case 6:
                            //f listofficers <faction>
                            //
                            $this->listofficers($sender);
                            break;
                        case 7:
                            //f listleader <faction>
                            //
                            $this->listleader($sender);
                            break;
                        case 8:
                            //f top
                            $this->getServer()->getCommandMap()->dispatch($sender, "f top");
                            break;
                         case 9:
                            //f top money
                            $this->getServer()->getCommandMap()->dispatch($sender, "f top money");
                            break;
                        case 10;
                            //f bal
                            $this->getServer()->getCommandMap()->dispatch($sender, "f bal");
                            break;
                        case 11;
                            //f donate <amount>
                            $this->getServer()->getCommandMap()->dispatch($sender, "f donate");
                            break;
                        case 12;
                            //f withdraw <amount>
                            $this->getServer()->getCommandMap()->dispatch($sender, "f withdraw");
                            break;
                        case 13:
                            //f chat
                            $this->getServer()->getCommandMap()->dispatch($sender, "f chat");
                            break;
                        case 10:
                            //Exit
                            $this->menuForm($sender);
                    }
                }
            });
            $form->setTitle("§6General §bCommands");
            $form->setContent("vaChoose, an action! Faction Members!");
            $form->addButton("§aSee info about a Faction");
            $form->addButton("§bSee your Faction Members");
            $form->addButton("§cSee your Factions Officers");
            $form->addButton("§dSee your Factions Leader");
            $form->addButton("§eSee your Factions Allies");
            $form->addButton("§1See members of anoother Faction!");
            $form->addButton("§2See Officers of another Faction!");
            $form->addButton("§3See Leaders of another Faction!");
            $form->addButton("§4See the Faction Leaderboard");
            $form->addButton("§5See the Richest factions leaderBoard");
            $form->addButton("§6See The Faction balance");
            $form->addButton("§9Donate to a faction");
            $form->addButton("§aWith draw from your faction bank");
            $form->addButton("§bActivate your Faction Chat");
            $form->addButton(TextFormat::RED . "§5Exit");
            $form->sendToPlayer($player);
        }
    }

    public function factionWhoForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f who " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bInfo about a Faction");
        $form->addInput("§3Faction Name");
        $form->sendToPlayer($player);
    }

    public function listmembers(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f listmembers " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bMembers of a Faction");
        $form->addInput("§3Faction Name");
        $form->sendToPlayer($player);
    }

    public function listofficers(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f listofficers " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bOfficers of a Faction");
        $form->addInput("§3Faction Name");
        $form->sendToPlayer($player);
    }

    public function listleader(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f listleader " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bLeader of a Faction");
        $form->addInput("§3Faction Name");
        $form->sendToPlayer($player);
    }
    
    public function donate(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->balance = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f donate " . $this->balance);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bAmount to donate to a Faction");
        $form->addInput("§3Amount");
        $form->sendToPlayer($player);
    }
    
    public function withDraw(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->balance = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f withdraw " . $this->balance);
            }
        });
        $form->setTitle(TextFormat::GREEN . "§bWithdraw from your Faction bank");
        $form->addInput("§3Amount");
        $form->sendToPlayer($player);
    }

}
