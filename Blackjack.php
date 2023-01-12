<?php

require_once("Player.php");

class Blackjack
{
    //Gets the score of a player and checks for a "Blackjack", "Busted", "Twenty-One" or "Five Card Charlie".
    public function scoreHand(array $hand): string
    {
        $score = 0;
        
        foreach ($hand as $scoreCard) {
            $score += $scoreCard->score();
        }

        if ($score > 21) {
            return "Busted";
        } elseif ($score == 21 && count($hand) == 2) {
            return "Blackjack";
        } elseif ($score == 21) {
            return "Twenty-One";
        } elseif ($score < 21 && count($hand) > 4) {
            return "Five Card Charlie";
        }

        return $score;
    }
}
