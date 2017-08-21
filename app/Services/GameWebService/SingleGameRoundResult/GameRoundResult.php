<?php


namespace App\Services\GameWebService\SingleGameRoundResult;


use App\Services\GameWebService\Interfaces\GameResultInterface;

/**
 * Class GameRoundResult
 * @package App\Services\GameWebService\SingleGameRoundResult
 */
class GameRoundResult implements GameResultInterface
{
    /**
     * @var
     */
    protected $result;

    /**
     * @var array
     */
    protected $payLines = [];

    /**
     * @var array
     */
    protected $payLineSymbols = [];

    /**
     * @var
     */
    protected $totalWin;

    /**
     * @var array
     */
    protected $roundSymbolMatrix = [];

    /**
     * @var array
     */
    protected $matchingSymbols = [];

    /**
     * GameRoundResult constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getPayLines()
    {
        return $this->payLines;
    }

    /**
     * @param mixed $payLine
     */
    public function setPayLine($lineNumber, $payLine)
    {
        $this->payLines[$lineNumber] = $payLine;
        $this->payLineSymbols[$lineNumber] = $payLine['winningSymbolPositions'];
    }

    /**
     * @return mixed
     */
    public function getTotalWin()
    {
        return $this->totalWin;
    }

    /**
     * @param mixed $totalWin
     */
    public function setTotalWin($totalWin)
    {
        $this->totalWin = $totalWin;
    }

    /**
     * @return array
     */
    public function getRoundSymbolMatrix(): array
    {
        return $this->roundSymbolMatrix;
    }

    /**
     * @param $id
     * @param $symbol
     */
    public function setRoundSymbol($id, $symbol) : void
    {
        $this->roundSymbolMatrix[$id] = $symbol;
    }

    /**
     * @return mixed
     */
    public function getPayLineSymbols() : array
    {
        return $this->payLineSymbols;
    }

    /**
     * @param mixed $payLineSymbols
     */
    public function setPayLineSymbols($payLineSymbols) : void
    {
        $this->payLineSymbols = $payLineSymbols;
    }



}