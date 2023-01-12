<?php

require_once("Card.php");

class Player
{
    public string $name;
    public array $hand;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    //Adds a card to a player's hand.
    public function addCard(Card $card): void
    {
        $this->hand[] = $card;
    }
    
    //Shows the player's hand.
    public function showHand($name): string
    {
        $response = $name . ' has ';
        foreach ($this->hand as $card) {
            $response .= $card->show();
        }
        return $response .= PHP_EOL;
    }
}
