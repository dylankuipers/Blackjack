<?php

class Card
{
    public string $suit;
    public string $value;

    public static array $validSuits = ['schoppen', 'klaveren', 'harten', 'ruiten'];
    public static array $validValues = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'B', 'K', 'V'];

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;

        $suit = strtolower($suit);
        $value = strtolower($value);

        $this->validateSuit($suit);
        $this->validateValue($value);
    }

    //Checks if the given suit is a valid suit.
    private function validateSuit(string $suit): string
    {

        if (!in_array($suit, self::$validSuits)) {
            throw new InvalidArgumentException("Please input a valid card suit. Suit: $suit is not correct.");
        }

        if ($suit == 'klaveren') {
            $this->suit = '♣';
        } else if ($suit == 'schoppen') {
            $this->suit = '♠';
        } else if ($suit == 'harten') {
            $this->suit = '♥';
        } else if ($suit == 'ruiten') {
            $this->suit = '♦';
        }

        return $this->suit;
    }

    //Checks if the given value is a valid value.
    private function validateValue(string $value): void
    {
        if ($this->value == 'vrouw') {
            $this->value = 'V';
        } elseif ($this->value == 'boer') {
            $this->value = 'B';
        } elseif ($this->value == 'koning') {
            $this->value = 'K';
        } elseif ($this->value == 'aas') {
            $this->value = 'A';
        }

        if (!in_array($this->value, self::$validValues)) {
            throw new InvalidArgumentException("Please input a valid card value. Value: $value is not correct.");
        }
    }

    //Scores a card.
    public function score(): int
    {
        if (is_numeric($this->value)) {
            return $this->value;
        }
        return $this->value == 'A' ? 11 : 10;
    }

    //Shows a card.
    public function show(): string
    {
        return $this->suit . ' ' . $this->value . ' ';
    }
}
