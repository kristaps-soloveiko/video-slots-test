<?php

use \App\Services\GameWebService\SingleGameRoundResult\GameRoundResult;
use App\Services\GameWebService\Game\GameType\RegularSlotGame;
use App\Services\GameWebService\SingleGameRoundResult\GameRoundProcessor;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {

    try {
        // Init an empty game round result. All the calculated values will be stored here
        $gameRoundResult = new GameRoundResult();
        // Init a slot machine. All task specifics are held there. Rows, columns, symbols etc
        $slot = new RegularSlotGame($gameRoundResult);
        // The master processor.
        $processor = new GameRoundProcessor($slot);

        // Lets send a 1 EUR bet as per specification.
        $result = $processor->bet(1.0);

        // Setup the response in the correct format
        $response = [
            'result' => $result->getResult(),
            'paylines' => array_values($result->getPayLineSymbols()),
            'total_win' => $result->getTotalWin(),
        ];

        return response()->json($response);

    } catch (Exception $ex) {
        dd($ex);
        return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
    }

});
