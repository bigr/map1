<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg
   xmlns="http://www.w3.org/2000/svg"
   width="$sizeX"
   height="$sizeY"
   viewBox="0 0 $viewboxX $viewboxY"
   >    
    <path
       style="fill:$color;stroke:none;fill-opacity:$opacity"
       d="M 0,128 C 0,64 32,64 32,64 l 192,0 c 0,0 32,0 32,64 0,64 -32,64 -32,64 l -192,0 c 0,0 -32,0 -32,-64 z"    
     />  
</svg>
EOD;
