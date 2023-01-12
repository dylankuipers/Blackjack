<?php

require_once("Card.php");

class Deck
{
    public array $cards = [];

    //Creates a randomized deck with all the given cards and suits.
    public function __construct()
    {
        foreach (Card::$validSuits as $suit) {
            foreach (Card::$validValues as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    //Draws a random card from all possible cards, then removes the card from the deck if it has been drawn.
    public function drawCard(): Card
    {
        if (count($this->cards) == 0) {
            throw new InvalidArgumentException("Deck is empty.");
        }

        $index = rand(0, count($this->cards) - 1);
        $drawn = $this->cards["$index"];
        unset($this->cards["$index"]);

        $this->cards = array_values($this->cards);
        return $drawn;
    }
}
