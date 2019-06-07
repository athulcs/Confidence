
<?php
echo shell_exec('python audioAnalysis.py featureExtractionFile -i baan.wav -mw 1.0 -ms 1.0 -sw 0.050 -ss 0.050 -o baan.wav 2>&1');
?>
