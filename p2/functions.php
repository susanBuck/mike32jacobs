<?php
function build_deck()
{
    // Dynamically create a deck of cards using a multidimensional array.
    $cardNames = array('2','3','4','5','6','7','8','9','10','J','Q','K','A');
    $cardValues = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10, 11);
    $cardSuits = array('Hearts','Spades','Diamonds','Clubs');

    $deck = array();

    foreach ($cardSuits as $suit) {
        for ($cardNumber = 0; $cardNumber< 13; $cardNumber++) {
            array_push($deck, array($cardNames[$cardNumber], $suit, $cardValues[$cardNumber]));
        }
    }

    return $deck;
}

// Find the sum of any hand
function calculate_total(array $hand)
{
    $sum = 0;

    // Iterate through cards, and sum the values
    for ($i=0; $i <count($hand); $i++) {
        $sum=$sum + $hand[$i][2];
    }

    // If sum is greater than 21, check to see if there is an ace
    // in the player's hand. If there is, count the total using a 1 instead of an 11.
    if ($sum>21) {
        if (in_array('A', $hand)) {
            //recalculate the sum using 1 instead of 11
            $sum = $sum -10;
        }
    }

    return $sum;
}

function deal_to_player(array $player, int $numCards)
{
    global $deck;

    for ($i = 0; $i < $numCards; $i++) {
        $drawCard=array_shift($deck);
        array_push($player, $drawCard);
    }

    return $player;
}

function check_total(int $total)
{
    if ($total == 21) {
        return "blackjack";
    } elseif ($total > 21) {
        return "over";
    } elseif ($total < 21) {
        return "under";
    }
}