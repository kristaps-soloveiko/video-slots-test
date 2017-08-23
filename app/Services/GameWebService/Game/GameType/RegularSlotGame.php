<?php

namespace App\Services\GameWebService\Game\GameType;

use App\Services\GameWebService\Exceptions\RoundResultsMissingException;
use App\Services\GameWebService\Interfaces\GameResultInterface;
use App\Services\GameWebService\Interfaces\GameTypeInterface;
use App\Services\GameWebService\SingleGameRoundResult\GameRoundResult;

/**
 * Easily expendable do any different kind of slot
 * Class RegularSlotGame
 * @package Services\GameWebService\GameType
 */
class RegularSlotGame implements GameTypeInterface
{
    /**
     * @var array
     */
    protected $symbols = ['9', '10', 'J', 'Q', 'K', 'A', 'cat', 'dog', 'monkey', 'bird'];

    /**
     * @var int
     */
    protected $lines = 3;

    /**
     * @var int
     */
    protected $columns = 5;

    /**
     * @var GameRoundResult
     */
    protected $roundResult;

    // Pay lines represent an array of matching symbol positions that should return a win. The algorithm will look for repeating symbols in the
    // pre set positions. 0 is the position in the first left top corner and 14 is the position of the right bottom corner.
    protected $payLines = [

        // First line
       ['lineNumber' => 1, 'winningSymbolPositions' => [0,3,6,9,12]],

        // Second line
        ['lineNumber' => 2, 'winningSymbolPositions' => [1,4,7,10,13]],

        // Third line
        ['lineNumber' => 3, 'winningSymbolPositions' => [2,5,8,11,14]],

        // Fourth line
        ['lineNumber' => 4, 'winningSymbolPositions' => [0,4,8,10,12]],

        // Fifth line
        ['lineNumber' => 5, 'winningSymbolPositions' => [2,4,6,10,14]],

    ];

    /**
     * Payouts per symbol count
     * @var array
     */
    protected $payouts = [
      3 => 0.2,
      4 => 2,
      5 => 10
    ];


    /**
     * RegularSlotGame constructor.
     * @param GameRoundResult $gameRoundResult
     */
    public function __construct(GameRoundResult $gameRoundResult)
    {
        $this->roundResult = $gameRoundResult;
    }


    /**
     * +++ GETTERS AND SETTERS +++
     */

    /**
     * @return array
     */
    public function getSymbols() : array
    {
        return $this->symbols;
    }

    /**
     * @param array $symbols
     */
    public function setSymbols(array $symbols) : void
    {
        $this->symbols = $symbols;
    }

    /**
     * @return int
     */
    public function getLines() : int
    {
        return $this->lines;
    }

    /**
     * @param int $lines
     */
    public function setLines(int $lines) : void
    {
        $this->lines = $lines;
    }

    /**
     * @return int
     */
    public function getColumns() : int
    {
        return $this->columns;
    }

    /**
     * @param int $columns
     */
    public function setColumns(int $columns) : void
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getPayLines() : array
    {
        return $this->payLines;
    }

    /**
     * @param array $payLines
     */
    public function setPayLines(array $payLines)
    {
        $this->payLines = $payLines;
    }

    /**
     * --- GETTERS AND SETTERS ---
     */

    /**
     * createNewRound() fills up an empty matrix with random symbols and sets as the rounds result
     */
    public function createNewRound()
    {
        // We get the total count of the symbols. In our case, its 5 x 3 = 15. Fill up the matrix one value by one.
        // I have decided to use the symbol mapping given in the task. Left top column position is 0 and every next symbol
        // to the bottom has the index + 1
        $result = [];
        for ($requiredSymbol = 0; $requiredSymbol < $this->getColumns() * $this->getLines(); $requiredSymbol++) {
            // Get a random symbol and add it to the matrix
            $randomSymbol = $this->getSymbols()[rand(0, count($this->getSymbols()) - 1)];
            $result[$requiredSymbol] = $randomSymbol;
        }
        $this->roundResult->setResult($result);
    }


    /**
     * @return GameResultInterface
     * @throws RoundResultsMissingException
     */
    public function getRoundResults() : GameResultInterface
    {
        $result = $this->roundResult->getResult();

        if (empty($result)) {
            // If the result is not set, raise an exception. The code is internal, message is external
            throw new RoundResultsMissingException($code = 9001, $message = 'Safe Message for end User');
        }

        $payLines = $this->getPayLines();

        // Go threw every pay line and see if the symbols match on the positions set in the pay lines array above
        foreach ($payLines as $payLineId => $payLine) {
          for ($i = 1; $i < count($payLine['winningSymbolPositions']); $i++) {

              // The iteration starts with 1, so there will always be a 1-1 = 0 symbol
              $previousSymbol = $result[$payLine['winningSymbolPositions'][$i-1]];
              // The next symbol is the one currently iterated
              $nextSymbol = $result[$payLine['winningSymbolPositions'][$i]];

              // The logic is very simple. We dismiss all lines that do not have the same symbols and only register the ones
              // that pass threw this logic
              if ($previousSymbol != $nextSymbol) {
                break;
              }
          }

          // If the payout is in the payout array, mark as a winning line
          if (isset($this->payouts[$i])) {
              $payLine['payout'] = $this->payouts[$i];
              $this->roundResult->setPayLine($payLine['lineNumber'], $payLine);
          }
        }

        return $this->roundResult;

    }

}
