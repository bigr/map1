<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg  
  xmlns="http://www.w3.org/2000/svg"
  version="1.1"
  width="$size"
  height="$size">  
  
  <g transform="rotate($rotation,$sizehalf,$sizehalf)" style="opacity: $opacity">
    <line x1="$sizehalf" y1="-1000" x2="$sizehalf" y2="1000" style="stroke:$color;stroke-width:$stroke"/>
    <line x1="-1000" y1="$sizehalf" x2="1000" y2="$sizehalf" style="stroke:$color;stroke-width:$stroke"/>
  </g>
  
</svg>
EOD;
