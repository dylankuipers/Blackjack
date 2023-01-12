<?php

require_once("Card.php");
require_once("Blackjack.php");
require_once("Player.php");

class Dealer
{
    public function __construct(Blackjack $jack, Deck $deck)
    {
        $this->jack = $jack;
        $this->deck = $deck;
        $this->players = [];
        $this->dealerHand = [];
    }

    //Sends the score over to "scoreHand" where their score will be calculated.
    public function getScore($player): string
    {
        return $this->jack->scoreHand($player->hand);
    }

    //Adds a player to the game.
    public function addPlayer($player)
    {
        $this->players[] = $player;
    }

    public function playGame()
    {
        //Gives each player starting cards and checks their score.
        foreach ($this->players as $player) {
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
            $this->score = $this->getScore($player);
            $player->{"score"} = $this->score;
            echo $player->showHand($player->name);
            $playerChoice = readline($player->name . ", you have a score of " . $player->score . ". Would you like to continue playing (p) or stop (s) now?");
            if ($playerChoice == 'p' || $playerChoice == 'P') {
                $player->{"playerChoice"} = 'p';
            } else if ($playerChoice == 's' || $playerChoice == 'S') {
                $player->{"playerChoice"} = 's';
            } else {
                throw new InvalidArgumentException("Please input a valid playing option. $playerChoice is not correct");
            }
        }

        //Gives players who chose to continue playing a new card and checks their score.
        foreach ($this->players as $player) {
            while ($player->playerChoice == 'p') {
                $player->addCard($this->deck->drawCard());
                $this->score = $this->getScore($player);
                echo $player->showHand($player->name);
                $player->{"score"} = $this->score;
                switch ($player->score) {
                    case "Busted":
                    case "Blackjack":
                    case "Twenty-One":
                        $player->playerChoice = 's';
                }

                //Asks if the player wants to continue playing with the current amount of points they have.
                if ($player->playerChoice == 'p') {
                    $playerChoice = readline($player->name . ", you have a score of " . $player->score . ". Would you like to continue playing (p) or stop (s) now?");
                    if ($playerChoice == 'p') {
                        $player->{"playerChoice"} = 'p';
                    } else if ($playerChoice == 's') {
                        $player->{"playerChoice"} = 's';
                    } else {
                        throw new InvalidArgumentException("Please input a valid playing option. $playerChoice is not correct");
                    }
                }
            }
            if ($player->playerChoice == 's') {
                echo $player->name . " stopped playing with a score of: " . $player->score . PHP_EOL;
            }
        }

        //Dealer draws two cards and gets a score.
        $this->dealerHand[] = $this->deck->drawCard();
        $this->dealerHand[] = $this->deck->drawCard();
        $this->dealerScore = $this->jack->scoreHand($this->dealerHand);

        //Checks if dealer score is lower than 18, which forces them to draw a new card.
        while ($this->dealerScore < 18) {
            $this->dealerHand[] = $this->deck->drawCard();
            $this->dealerScore = $this->jack->scoreHand($this->dealerHand);
        }

        echo $this->showDealerHand('The dealer');
        echo "The dealer had a score of: " . $this->dealerScore . PHP_EOL;

        //Gets the results of each player and prints it in the terminal.
        foreach ($this->players as $player) {
            if ($this->dealerScore == 'Busted' && $player->score !== 'Busted') {
                echo $player->name . " won!" . PHP_EOL;
            } elseif ($player->score < $this->dealerScore || $player->score == 'Busted') {
                echo $player->name . " lost!" . PHP_EOL;
            } elseif ($player->score >= $this->dealerScore || $player->score == 'Blackjack' || $player->score == 'Twenty-One' || $player->score == 'Five Card Charlie') {
                echo $player->name . " won!" . PHP_EOL;
            }
        }
    }

    public function showDealerHand($name): string
    {
        $response = $name . ' has ';
        foreach ($this->dealerHand as $card) {
            $response .= $card->show();
        }
        return $response .= PHP_EOL;
    }
}
