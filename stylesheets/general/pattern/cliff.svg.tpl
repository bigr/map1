<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg
  
   xmlns="http://www.w3.org/2000/svg"
  
   width="$sizeX"
   height="$sizeY"
   viewBox="0 0 $viewboxX $viewboxY">  
  <g transform="translate(0,256)">	
    <path
       style="fill:$color;fill-opacity:$opacity;stroke:none;"
       d="m 0,256 0,-80 112,0 0,-176 32,0 0,176 112,0 0,80 z"
       transform="scale(1,-1)"
       />
  </g>
</svg>
EOD;
