<?php

namespace App\Services\GameWebService\Interfaces;


/**
 * All new games have to be created under the same interface
 * Interface GameTypeInterface
 * @package App\Services\GameWebService\Interfaces
 */
interface GameTypeInterface
{
    /**
     * @return mixed
     */
    public function createNewRound();


    /**
     * @return mixed
     */
    public function getRoundResults() : GameResultInterface;

}