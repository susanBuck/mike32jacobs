<?php
session_start();

require 'functions.php';

if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];
    $deck = $results['deck'];
    $dealerHand = $results['dealerHand'];
    $playerHand = $results['playerHand'];
    $playerTotal = $results['playerTotal'];
    $dealerTotal = $results['dealerTotal'];
    $move = $results['move'] ?? null;

    # Here's where we check to see if they were over/under/blackjack
    $outcome = check_total($playerTotal);

    # Note we don't clear the session data here so that if
    # they choose to hit again, we'll still have the data
    # It's only down below in the "new game" scenario that the sesssion
    # data is cleared
}

# Display a new game if there are no results to work with
# (e.g. we're coming to the page for the first time)
#
# Or...
#
# If the user is coming to this page from the "Play again" link.
# That link appends a `reset` query string like so:
# <a href='index.php?reset=true'>Play again</a>
# So we look for that `rese`t value in the $_GET superglobal
if (!isset($results) or isset($_GET['reset'])) {
    
    # Clear previous game data
    $outcome = null;
    $_SESSION['results'] = null;
    
    # Build a new game
    $deck = build_deck();
    shuffle($deck);

    $playerHand = [];
    $dealerHand = [];

    # Deal two cards to player, and to the dealer
    $playerHand = deal_to_player($playerHand, 2);
    $dealerHand = deal_to_player($dealerHand, 2);

    # Calculate sum of cards
    $playerTotal = calculate_total($playerHand);
    $dealerTotal = calculate_total($dealerHand);

    # Persist the results for process.php
    $_SESSION['results'] = [
        'deck' => $deck,
        'playerHand' => $playerHand,
        'dealerHand' => $dealerHand,
        'playerTotal' => $playerTotal,
        'dealerTotal' => $dealerTotal,
    ];
}

require 'index-view.php';