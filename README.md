# PHP_ColoredConsole
Color text in terminal. Terminal progress bar (aka BarGraph)
Styling your php console output

#BarGraph
[#########        ] 55%


$Bar = new BarGraph('green', 10, 100); // Create new BarGraph whith legth - 10 blocks + '[] and num with %', and counts aka percent 100.
$bar.ValInc($valinc); //$valinc - count to adding on current counts in bargraph, default 1
$bar.Val($val); // $val - value for bargraph.


#CConsole::

Methods for moving and coloring output text in terminal

CursorToLeft($count); //Moves cursor left on $count pos
CursorToRight($count); //Moves cursor right on $count pos
CursorUp($stringCount); //Moves cursor up on $stringCount strings
CursorDown($stringCount); //Moves cursor down on $stringCount strings
ForeColor($color); //color 'green', 'red' and others on terminal
BackColor($color);
ResetColor();
