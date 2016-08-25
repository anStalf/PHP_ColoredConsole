<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ColoredConsole
 *
 * @author Mikhail
 */

class BarGraph{
    private $stp;
    private $len;
    private $cnt;
    private $color;
    private $value;
    private $valx;
    private $valproc;
    private $painted;
    private $pps;
    
    public $notreset;
    
    public function __construct($color = 'green', $length = 40, $mcount = 100, $noreset = false) { 
        if ($mcount < 1) {
            CConsole::mess("Done");
            return true;
        }
        $this->stp = $length/$mcount;
        $this->pps = 100/$length;
        //echo "STP: " . $this->stp ."\n";
        $this->cnt = $mcount;
        $this->len = $length;
        $this->color = $color;
        $this->value = 0;
        $this->valx = 0;
        $this->painted = FALSE;
        $this->notreset = $noreset;
        self::draw();
    }
    
    private function draw(){
        CConsole::CursorToLeft();
        if ($this->painted){CConsole::CursorUp();}
        echo "[";
        CConsole::foreColor($this->color);
        for ($i = 0; $i <= $this->len; $i++){
            if ($i <= $this->value){
                echo "#";
            }else{
                echo " ";
            }
        }
        CConsole::ResetColor();
        $this->painted = true;
        if ($this->valproc < 1){$this->valproc = 0;}
        echo "] " . $this->valproc . "%\n";
    }
    
    public function ValInc($inc = 1){
        $this->valx += $inc;
        self::val($this->valx);
    }
    
    public function val($val){
        $this->valx = $val;
        if ($val > $this->cnt) {$val = $this->cnt;}
        $this->value = round($val * $this->stp);
        $this->valproc = round($this->value * $this->pps);
        self::draw();
    }
    
    public function ResetToMess($message, $color){
        CConsole::CursorUp();
        CConsole::ClearLine($this->len + 8);
        echo "[";
        CConsole::ForeColor($color);
        echo $message;
        CConsole::ResetColor();
        echo "]\n";
    }
    
    public function __destruct() {
        if (!$this->notreset){
            self::ResetToMess('Done', 'green');
        }
    }
}

class CConsole {
    
    static $FColor = array("black"=>30, "red"=>31, "green"=>32, "yellow"=>33, "blue"=>34, "purple"=>35, "cyan"=>36, "white"=>37);
    static $BColor = array("black"=>40, "red"=>41, "green"=>42, "yellow"=>43, "blue"=>44, "purple"=>45, "cyan"=>46, "white"=>47);
    

    public function mess($message, $color = 'green'){
        self::CursorToLeft();
        echo "[";
        self::forecolor($color);
        echo $message;
        self::ResetColor();
        echo "]\n";
    }
    
    public function CursorToLeft($cnt = null){
        if ($cnt == null){$cnt = 100;}
        echo "\x1b[".$cnt."D";
    }
    
    public function CursorToRight($cnt = 0){
        echo "\x1b[".$cnt."C";
    }
    
    public function CursorUp($move = 1){
        echo "\x1b[".$move."A";
    }
    
    public function CursorDown($move = 1){
        echo "\x1b[".$move."B";
    }
    
    public function ClearLine($len = 60){
        self::CursorToLeft();
        for($i =0; $i <= $len; $i++){
            echo " ";
        }
        self::CursorToLeft();
    }
    
    public function ForeColor($color){
        if (!isset(self::$FColor[$color])){
            if (!is_numeric($color)){
                return 0;
            }else{
                if ($color < 30 || $color > 37){
                    return 0;
                }
            }
        }else{
            $color = self::$FColor[$color];
        }
        echo "\x1b[$color"."m";
    }
    
    public function BackColor($color){
         if (!isset(self::$BColor[$color])){
            if (!is_numeric($color)){
                return 0;
            }else{
                if ($color < 30 || $color > 37){
                    return 0;
                }
            }
        }else{
            $color = self::$BColor[$color];
        }
        echo "\x1b[$color"."m";
    }
    
    public function ResetColor(){
        echo "\x1b[0m";
    }
    
    public function Underline(){
        echo "\x1b[4m";
    }
    
    public function SetField($cnt, $forecolor = 'black', $backcolor = 'white'){
        #self::UnderLine();
        self::ForeColor($forecolor);
        self::BackColor($backcolor);
        for ($i = 0; $i < $cnt; $i++){
            echo " ";
        }
        self::CursorToLeft($cnt);
        $ansv = fgets(STDIN);
        self::ResetColor();
        return $ansv;
    }
    
    public function BarGraph($val, $len = 25, $barcolor = 'green'){
        self::CursorToLeft();
        if ($val> 0) {self::CursorUp();}
        if ($val > 100){$val = 100;}
        if ($val < 0){$val = 0;}
        $cnt = $val * ($len / 100); // 2.5% per #
        echo "[";
        self::foreColor($barcolor);
        for ($i = 0; $i <= $len; $i++){
            if ($i <= $cnt) {echo "#";}else{echo " ";}
        }
        self::ResetColor();
        $val = round($val);
        echo "] $val%\n";
        
    }
}
