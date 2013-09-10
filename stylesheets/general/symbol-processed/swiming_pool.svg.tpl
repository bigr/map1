<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="$size" height="$size" viewBox="0 0 26880 26880">$pre<g><g transform="matrix(10.666667,0,0,10.666667,-20763.958,4280.9699)"><g transform="matrix(4.8314063,0,0,4.8314063,1656.0154,-384.07686)" style="fill:$color;fill-opacity:$opacity"><path style="fill:$color;fill-opacity:$opacity;fill-rule:evenodd" d="M 2235.125 389.09375 C 2233.6702 389.11865 2232.1908 389.17152 2230.6875 389.25 C 2132.3748 395.21315 1831.1182 517.67237 1730.4062 560.375 C 1629.681 601.50351 1648.0402 606.2295 1634.8125 637.3125 C 1621.8845 667.45521 1631.4861 681.57286 1654.3438 745 C 1676.5946 808.74041 1714.7711 898.21676 1768.875 1016.9062 L 1081 1383.9375 C 1144.4407 1353.7812 1210.8873 1342.1628 1281.5312 1349.0938 C 1351.8891 1355.9905 1418.6272 1423.8037 1502.8125 1424.125 C 1586.6914 1422.5644 1691.3286 1344.0839 1783.0312 1343.75 C 1875.0264 1344.0839 1973.6306 1414.4213 2047.5938 1421.625 C 2120.3505 1426.9746 2174.1668 1413.4388 2214.75 1378.5938 L 1899.9688 685.96875 C 1987.4593 653.31134 2063.2351 623.81152 2132.0938 597.4375 C 2200.039 569.80287 2289.6161 561.00122 2307.0625 526.15625 C 2322.7469 490.91641 2326.777 387.52506 2235.125 389.09375 z M 2316.9062 784.59375 C 2210.8515 784.59375 2124.7812 874.46861 2124.7812 985.21875 C 2124.7812 1095.9689 2210.8584 1185.8438 2316.9062 1185.8438 C 2422.9543 1185.8438 2509.0312 1095.9689 2509.0312 985.21875 C 2509.0312 874.46861 2422.961 784.59375 2316.9062 784.59375 z M 151 1067.2812 C 148.53884 1067.2745 146.16425 1067.3099 143.84375 1067.4375 C 69.873941 1071.5197 43.10313 1161.3216 79.78125 1206.2188 C 116.46627 1249.862 271.32215 1294.4549 362.125 1327.7188 C 452.32122 1359.1426 535.30127 1382.3628 616.78125 1397.4375 C 680.52171 1367.6154 739.13883 1352.5522 795.0625 1353.5 C 850.68648 1354.7469 905.39182 1394.6131 948.6875 1401.8438 C 991.38327 1408.1272 1024.775 1403.7203 1050.0312 1389.9062 C 844.67565 1305.4482 670.59959 1237.9531 518.46875 1183.9375 C 370.21423 1131.0092 227.29609 1067.4891 151 1067.2812 z M 779.8125 1421.5312 C 778.58101 1421.5417 777.36053 1421.5546 776.125 1421.5938 C 694.94476 1424.7491 605.93657 1487.5439 526.5625 1491.3125 C 446.58871 1492.5736 374.11961 1432.9218 303.46875 1432.2812 C 232.21816 1431.0278 152.23193 1475.9164 104.125 1485.9688 C 56.017836 1495.0869 25.671856 1496.0432 14.25 1488.8125 L 14.25 1655.2188 C 25.671856 1662.4359 56.017836 1661.4865 104.125 1652.375 C 152.23193 1642.3229 232.2115 1597.4336 303.46875 1598.6875 C 374.12657 1599.3219 446.58871 1658.9862 526.5625 1657.7188 C 605.93657 1654.5904 694.94476 1590.2014 776.125 1588 C 855.19908 1584.8652 925.85025 1643.2774 1005.5312 1644.5312 C 1086.4112 1645.1708 1168.4713 1591.7762 1255.0625 1593.3438 C 1340.4475 1594.592 1427.3404 1652.6747 1514.5312 1652.375 C 1600.216 1650.4872 1681.3908 1588.6272 1770.6875 1588 C 1860.2842 1587.699 1958.9148 1648.2939 2046.7188 1649.875 C 2133.2965 1649.875 2222.91 1593.0313 2286.3438 1590.8438 C 2348.2784 1588.0084 2382.2534 1628.2107 2419.5312 1636.375 C 2456.2096 1644.226 2484.1613 1645.4731 2505.8125 1638.875 L 2505.8125 1472.4688 C 2484.1613 1479.0794 2456.2096 1477.8136 2419.5312 1469.9688 C 2382.2534 1461.4842 2348.2784 1421.9372 2286.3438 1424.125 C 2222.903 1426.3261 2133.2965 1483.1562 2046.7188 1483.1562 C 1958.9148 1481.289 1860.2842 1421.5938 1770.6875 1421.5938 C 1681.3908 1422.2281 1600.216 1484.081 1514.5312 1485.9688 C 1427.3404 1486.2741 1340.4475 1428.1914 1255.0625 1426.9375 C 1168.4713 1424.7441 1086.4112 1478.453 1005.5312 1477.8125 C 927.10211 1476.2753 857.39634 1420.87 779.8125 1421.5312 z M 779.8125 1700.0312 C 778.58101 1700.0418 777.36053 1700.0545 776.125 1700.0938 C 694.94476 1703.2285 605.93657 1766.03 526.5625 1769.8125 C 446.58871 1771.0608 374.11961 1711.4082 303.46875 1710.7812 C 232.21816 1709.533 152.23193 1754.4167 104.125 1764.4688 C 56.017836 1774.2142 25.671856 1773.9039 14.25 1767 L 14.25 1933.4062 C 25.671856 1940.3097 56.017836 1940.6202 104.125 1930.875 C 152.23193 1920.816 232.2115 1875.9403 303.46875 1877.1875 C 374.12657 1877.8142 446.58871 1937.4657 526.5625 1936.2188 C 605.93657 1932.4365 694.94476 1869.6663 776.125 1866.5312 C 855.19908 1864.0167 925.85025 1921.1515 1005.5312 1922.7188 C 1086.4112 1923.3455 1168.4713 1869.6426 1255.0625 1871.8438 C 1340.4475 1873.1049 1427.3404 1931.1953 1514.5312 1930.875 C 1600.216 1929.0001 1681.3908 1867.1448 1770.6875 1866.5312 C 1860.2842 1866.5312 1958.9148 1926.1883 2046.7188 1928.0625 C 2133.2965 1928.0625 2222.91 1871.226 2286.3438 1869.0312 C 2348.2784 1866.8301 2382.2534 1906.3835 2419.5312 1914.875 C 2456.2096 1922.7257 2484.1613 1923.9956 2505.8125 1917.4062 L 2505.8125 1750.9688 C 2484.1613 1756.925 2456.2096 1756.0072 2419.5312 1748.1562 C 2382.2534 1739.9989 2348.2784 1699.7969 2286.3438 1702.625 C 2222.903 1704.8185 2133.2965 1761.6562 2046.7188 1761.6562 C 1958.9148 1759.7813 1860.2842 1700.0938 1770.6875 1700.0938 C 1681.3908 1700.7282 1600.216 1762.5946 1514.5312 1764.4688 C 1427.3404 1764.79 1340.4475 1706.6984 1255.0625 1705.4375 C 1168.4713 1703.2364 1086.4112 1756.9395 1005.5312 1756.3125 C 927.10211 1754.7703 857.39634 1699.3635 779.8125 1700.0312 z " transform="matrix(0.20697907,0,0,0.20697907,60.149278,-3.5732982)"/></g></g></g>$post</svg>
EOD;
