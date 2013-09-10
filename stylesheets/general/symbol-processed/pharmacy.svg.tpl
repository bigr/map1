<?php $svg = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="$size" height="$size" viewBox="0 0 26880 26880">$pre<g transform="matrix(128.05184,0,0,128.05184,-2243.5294,-2187.0589)"><path style="fill:$color;fill-opacity:$opacity;fill-rule:nonzero;stroke:none" d="M 1240.75 16.375 C 1079.2977 16.375 932.1694 149.78212 917.75 301.1875 C 897.10099 517.95307 982.63079 599.67505 1162.875 684.75 C 1443.6977 817.29371 1735.3438 811.64504 1735.3438 997.65625 C 1735.3438 1179.3426 1673.3409 1275.9264 1566.625 1346.5938 C 1548.2141 1358.7984 1513.2099 1374.8049 1478.9375 1386.5938 L 1478.9375 1514.25 C 1486.0205 1513.2728 1493.1494 1512.1782 1500.3125 1510.9688 C 1739.6653 1470.5944 1930 1257.1849 1930 1014.9375 C 1930 759.71221 1696.391 690.50817 1488.75 657.34375 C 1279.471 623.92449 1037.4375 549.18977 1037.4375 325.6875 C 1037.4375 216.09913 1105.9246 107.21875 1223.4375 107.21875 C 1396.4721 107.21875 1426.7421 238.44178 1427.4688 257.1875 C 1428.1938 275.93284 1377.098 289.2504 1370.5 326.40625 C 1362.5626 371.10705 1382.064 415.79409 1410.1875 451.84375 C 1435.2888 484.02807 1471.4399 549.20468 1507.5 543.4375 C 1546.1103 537.26458 1560.1483 471.32094 1570.9688 428.0625 C 1581.7889 384.8043 1600.5194 348.0307 1582.5 307.65625 C 1560.1792 257.64961 1537.8036 282.41209 1520.5 246.375 C 1510.5907 225.73785 1472.2237 16.375 1240.75 16.375 z M 283.28125 905.34375 C 283.28125 951.48611 365.67723 990.22082 415.9375 993.3125 C 509.66466 999.08194 630.79123 1033.6924 759.125 1133.1875 C 890.19254 1234.8048 1037.8062 1368.59 1346.7188 1381.625 L 1346.7188 1774.5312 C 1364.6567 1777.8331 1384.6557 1779.625 1406.5625 1779.625 C 1415.7215 1779.625 1429.9421 1779.0913 1446.2188 1777.3438 L 1446.2188 1551.1875 L 1446.2188 1381.625 L 1446.2188 1362.5625 C 1611.9628 1326.2478 1702.6562 1184.7634 1702.6562 997.65625 C 1702.6442 959.15025 1686.8107 930.18044 1653.75 905.34375 L 283.28125 905.34375 z M 1948.3125 905.34375 C 1957.6331 937.58561 1962.6875 973.89387 1962.6875 1014.9375 C 1962.6875 1087.4854 1946.8022 1157.4708 1918.3438 1221.5625 C 1960.1376 1191.8008 1997.6016 1161.2534 2033.8125 1133.1875 C 2162.146 1033.6924 2283.2729 999.08038 2377 993.3125 C 2427.2601 990.22281 2509.6562 951.48611 2509.6562 905.34375 L 1948.3125 905.34375 z M 1314.0312 1393.5312 C 1175.1775 1404.2593 1060.5 1531.9579 1060.5 1640.75 C 1060.5 1720.0577 1074.513 1844.366 1294.0938 1907.5 C 1524.8058 1973.8301 1790.125 1828.2003 1790.125 1682.5625 C 1790.125 1611.9066 1753.9571 1577.6984 1706.5 1562.875 C 1667.1177 1550.567 1620.3679 1533.0071 1478.9062 1573.8438 L 1478.9062 1663.7188 C 1501.2396 1657.5457 1521.1032 1653.7188 1540.6562 1653.7188 C 1581.0306 1653.7188 1599.7812 1666.7106 1599.7812 1709.9688 C 1599.7812 1779.1828 1508.9409 1812.3438 1406.5625 1812.3438 C 1304.1839 1812.3438 1209 1771.9731 1209 1689.7812 C 1209 1588.3605 1250.7237 1552.1828 1314.0312 1535.9062 L 1314.0312 1393.5312 z M 373.4375 1615 C 345.3379 1615.0088 317.25603 1615.0385 289.15625 1615.0625 C 289.11183 1709.6289 289.17542 1804.1812 289.125 1898.75 C 193.66535 1898.798 98.175935 1898.7702 2.71875 1898.8125 C 2.6611267 2011.6917 2.6599635 2124.5535 2.75 2237.4375 C 98.204387 2237.4735 193.66814 2237.412 289.125 2237.4688 C 289.16942 2332.033 289.10583 2426.6142 289.15625 2521.1875 C 401.55533 2521.2475 513.97113 2521.2595 626.375 2521.1875 C 626.41942 2426.6155 626.31498 2332.0318 626.375 2237.4688 C 721.82893 2237.4207 817.28691 2237.4615 912.75 2237.4375 C 912.79802 2124.5536 912.83523 2011.6914 912.75 1898.8125 C 817.28967 1898.7645 721.82605 1898.8046 626.375 1898.75 C 626.33058 1804.1802 626.41702 1709.5987 626.375 1615.0312 C 542.07204 1614.9832 457.73619 1614.976 373.4375 1615 z M 1314.0312 1637.3125 C 1286.2879 1652.9434 1262.3103 1670.4591 1241.7188 1689.7812 C 1241.7071 1713.7522 1256.0532 1735.5605 1282.5625 1751.6875 C 1291.9065 1742.1013 1302.5765 1733.743 1314.0312 1726.4062 L 1314.0312 1637.3125 z M 1138.4062 1874.4375 C 1131.4048 1907.4183 1128.2812 1941.72 1128.2812 1976.7188 C 1128.2812 2122.3564 1285.2424 2184.2189 1396.4688 2200.2188 C 1511.825 2216.8065 1619.9791 2221.1304 1635.125 2227.625 C 1650.4215 2234.1805 1659.6301 2241.3323 1666.125 2248.5312 C 1672.619 2255.7294 1689.8984 2265.8348 1700.7188 2258.625 C 1711.539 2251.415 1702.8898 2218.9689 1676.2188 2198.7812 C 1622.8668 2158.4071 1553.656 2149.0209 1430.375 2133.875 C 1284.4152 2115.937 1245.8963 2024.1195 1241.5938 1927.3125 C 1203.722 1914.7499 1168.6763 1897.2789 1138.4062 1874.4375 z M 1346.7188 1949.25 L 1346.7188 2074.6875 C 1374.5889 2091.6797 1408.8432 2099.135 1446.2188 2104.1875 L 1446.2188 1950.75 C 1412.9386 1952.9861 1379.457 1952.5498 1346.7188 1949.25 z M 1346.7188 2224.0312 L 1346.7188 2327.125 C 1346.7188 2390.5704 1230.6491 2399.9294 1185.9375 2410.75 C 1142.1247 2421.3515 1108.7776 2433.8253 1087.875 2451.8438 C 1072.7057 2464.925 1004.9566 2467.7048 954.5 2472.0312 C 904.04293 2476.3584 845.65625 2502.3249 845.65625 2520.3438 L 1947.2812 2520.3438 C 1947.2812 2502.3249 1888.8858 2476.3686 1838.4062 2472.0312 C 1787.9263 2467.6973 1720.2005 2464.925 1705.0312 2451.8438 C 1684.1285 2433.8253 1650.8121 2421.3401 1607 2410.75 C 1562.2994 2399.9295 1446.2188 2390.571 1446.2188 2327.125 L 1446.2188 2239.0312 C 1428.0154 2237.2216 1409.8544 2235.1604 1391.8125 2232.5625 C 1377.8315 2230.5464 1362.6149 2227.7602 1346.7188 2224.0312 z " transform="matrix(0.0832996,0,0,0.0832996,17.520478,17.07948)"/></g>$post</svg>
EOD;
