<?php

namespace App\Services\GameWebService\SingleGameRoundResult;


use App\Services\GameWebService\Interfaces\GameTypeInterface;

/**
 * Class GameRoundProcessor
 * @package App\Services\GameWebService\SingleGameRoundResult
 */
class GameRoundProcessor
{

    /**
     * @var GameTypeInterface
     */
    protected $gameInstance;

    /**
     * GameRoundProcessor constructor.
     * @param GameTypeInterface $gameInstance
     */
    public function __construct(GameTypeInterface $gameInstance)
    {
        $this->setGameInstance($gameInstance);
    }

    /**
     * @param float $betAmount
     * @return GameRoundResult
     */
    public function bet(float $betAmount) : GameRoundResult
    {
        // Begin/Commit blocks, Cache spam blocking, adding transactions to the queue for further send out should reside
        // here

        // Start a new round. Get the results
        $this->gameInstance->createNewRound();
        $gameRoundResults = $this->gameInstance->getRoundResults();

        // Go threw the results and set the win amount
        $totalWin = 0;
        foreach ($gameRoundResults->getPaylines() as $payLine) {
            $totalWin += $payLine['payout'] * $betAmount;
        }

        $gameRoundResults->setTotalWin($totalWin);
        return $gameRoundResults;
    }

    /**
     * @return mixed
     */
    public function getGameInstance() : GameTypeInterface
    {
        return $this->gameInstance;
    }

    /**
     * @param mixed $gameInstance
     */
    public function setGameInstance(GameTypeInterface $gameInstance)
    {
        $this->gameInstance = $gameInstance;
    }

}