<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<svg  
  xmlns="http://www.w3.org/2000/svg"  
  width="$size"
  height="$size"
  viewBox="0 0 256 256">
    $pre
    <path
       style="fill:#000000"
       d="m 0.69575243,128.16781 0,-127.2499983 63.57886957,0 63.578868,0 -0.3598,63.7500003 -0.35981,63.749998 64.03094,0 64.03093,0 0,63.5 0,63.5 -127.25,0 -127.24999757,0 0,-127.25 z"
    />
    $post
</svg>
EOD;
