<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckSchemaCommand.
 */
class CheckSchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Aid Stream data format';

    /**
     * Gets organization ids.
     *
     * @var array|int[]
     */
    protected array $organizationIds;

    /**
     * @param DB $db
     */
    public function __construct(protected DB $db)
    {
        parent::__construct();
        $this->organizationIds = [4, 5, 9, 12, 14, 17, 18, 29, 30, 33, 35, 36, 37, 38, 41, 42, 43, 45, 48, 50, 51, 58, 62, 63, 65, 67, 68, 69, 71, 72, 73, 74, 76, 77, 78, 79, 80, 81, 84, 86, 87, 90, 93, 95, 96, 98, 101, 102, 103, 104, 106, 107, 114, 115, 116, 117, 118, 119, 121, 123, 125, 126, 127, 129, 130, 132, 133, 135, 136, 137, 138, 140, 141, 143, 144, 147, 150, 156, 162, 163, 164, 166, 168, 169, 170, 171, 172, 173, 176, 181, 183, 189, 190, 191, 193, 195, 196, 198, 200, 209, 213, 214, 215, 216, 217, 218, 227, 228, 229, 230, 231, 232, 237, 238, 239, 241, 242, 244, 246, 247, 250, 254, 255, 256, 257, 259, 260, 262, 264, 266, 267, 274, 279, 280, 282, 283, 284, 286, 288, 290, 292, 293, 294, 295, 297, 298, 299, 302, 306, 307, 309, 311, 313, 317, 318, 319, 320, 323, 324, 325, 326, 328, 330, 331, 332, 334, 338, 340, 341, 344, 345, 347, 350, 351, 352, 353, 357, 358, 359, 363, 364, 365, 367, 369, 370, 371, 375, 376, 378, 379, 381, 382, 383, 384, 385, 389, 393, 394, 395, 396, 397, 399, 400, 403, 405, 409, 411, 415, 416, 417, 419, 423, 425, 426, 428, 429, 431, 432, 434, 441, 443, 446, 447, 448, 449, 450, 452, 453, 454, 455, 456, 460, 462, 463, 464, 465, 466, 469, 470, 472, 473, 474, 475, 477, 480, 481, 482, 483, 484, 486, 488, 491, 492, 493, 495, 496, 502, 504, 506, 507, 511, 512, 514, 518, 527, 531, 534, 544, 545, 548, 554, 556, 557, 559, 561, 562, 563, 565, 567, 568, 569, 570, 571, 572, 573, 575, 576, 577, 578, 581, 583, 584, 585, 588, 591, 595, 600, 601, 602, 604, 605, 610, 613, 614, 616, 617, 618, 621, 621, 624, 625, 625, 626, 629, 630, 641, 648, 652, 655, 658, 662, 665, 666, 667, 668, 672, 677, 686, 692, 693, 694, 695, 696, 701, 703, 708, 712, 715, 719, 722, 726, 727, 730, 731, 733, 735, 737, 738, 739, 740, 741, 744, 747, 748, 749, 751, 752, 754, 755, 759, 761, 762, 763, 764, 773, 774, 775, 776, 777, 778, 780, 781, 786, 787, 788, 791, 794, 795, 799, 803, 806, 807, 809, 814, 817, 819, 820, 822, 824, 827, 833, 836, 849, 850, 853, 856, 858, 859, 863, 865, 866, 867, 871, 873, 876, 877, 878, 881, 882, 883, 885, 887, 889, 890, 891, 892, 893, 894, 896, 899, 901, 902, 903, 907, 909, 910, 912, 915, 916, 919, 922, 928, 933, 934, 936, 937, 942, 943, 954, 956, 957, 959, 962, 963, 964, 966, 967, 972, 973, 979, 986, 987, 989, 994, 995, 997, 1000, 1003, 1008, 1009, 1010, 1011, 1012, 1015, 1016, 1020, 1024, 1026, 1027, 1028, 1031, 1032, 1035, 1036, 1037, 1038, 1041, 1042, 1044, 1047, 1048, 1049, 1051, 1052, 1053, 1054, 1055, 1056, 1061, 1062, 1065, 1066, 1067, 1070, 1072, 1073, 1074, 1075, 1081, 1083, 1085, 1087, 1088, 1089, 1091, 1094, 1096, 1097, 1098, 1100, 1101, 1103, 1108, 1111, 1113, 1115, 1116, 1117, 1118, 1119, 1121, 1122, 1123, 1125, 1126, 1127, 1128, 1130, 1134, 1135, 1136, 1137, 1139, 1140, 1141, 1142, 1143, 1144, 1145, 1151, 1152, 1153, 1154, 1156, 1158, 1159, 1161, 1162, 1163, 1166, 1167, 1168, 1169, 1170, 1172, 1173, 1174, 1180, 1183, 1185, 1186, 1188, 1189, 1192, 1194, 1195, 1196, 1197, 1198, 1199, 1200, 1201, 1202, 1204, 1205, 1207, 1208, 1211, 1212, 1213, 1214, 1215, 1217, 1218, 1220, 1221, 1222, 1223, 1224, 1225, 1231, 1232, 1235, 1236, 1237, 1239, 1240, 1242, 1244, 1245, 1247, 1248, 1254, 1255, 1256, 1257, 1259, 1261, 1262, 1263, 1265, 1266, 1269, 1271, 1273, 1276, 1277, 1279, 1280, 1286, 1292, 1294, 1297, 1298, 1299, 1302, 1305, 1306, 1308, 1310, 1311, 1315, 1317, 1320, 1322, 1323, 1324, 1325, 1327, 1328, 1330, 1333, 1334, 1336, 1337, 1341, 1345, 1346, 1347, 1348, 1350, 1352, 1354, 1361, 1363, 1367, 1368, 1369, 1370, 1371, 1376, 1377, 1378, 1379, 1382, 1386, 1387, 1388, 1392, 1395, 1396, 1397, 1398, 1399, 1400, 1401, 1402, 1405, 1407, 1408, 1411, 1413, 1416, 1417, 1420, 1421, 1425, 1427, 1428, 1430, 1431, 1432, 1434, 1436, 1437, 1438, 1439, 1443, 1444, 1450, 1452, 1453, 1455, 1456, 1457, 1458, 1460, 1461, 1462, 1463, 1465, 1466, 1467, 1469, 1470, 1477, 1479, 1480, 1481, 1482, 1484, 1485, 1486, 1491, 1493, 1494, 1495, 1496, 1497, 1498, 1499, 1500, 1501, 1502, 1503, 1504, 1505, 1506, 1507, 1512, 1513, 1514, 1519, 1520, 1522, 1523, 1524, 1526, 1528, 1531, 1532, 1534, 1537, 1539, 1540, 1541, 1542, 1543, 1545, 1546, 1547, 1548, 1549, 1550, 1551, 1553, 1554, 1557, 1558, 1559, 1560, 1561, 1562, 1563, 1564, 1565, 1568, 1569, 1571, 1572, 1574, 1575, 1577, 1578, 1579, 1580, 1582, 1583, 1584, 1585, 1586, 1587, 1588, 1589, 1590, 1592, 1593, 1597, 1599, 1600, 1601, 1602, 1603, 1604, 1605, 1607, 1608, 1609, 1610, 1624, 1625, 1629, 1630, 1633, 1635, 1637, 1638, 1639, 1640, 1641, 1642, 1643, 1644, 1645, 1646, 1647, 1649, 1651, 1652, 1654, 1655, 1656, 1657, 1658, 1660, 1661, 1663, 1667, 1668, 1669, 1672, 1673, 1674, 1675, 1676, 1678, 1679, 1680, 1682, 1683, 1685, 1686, 1688, 1690, 1691, 1692, 1693, 1694, 1695, 1696, 1698, 1699, 1700, 1702, 1704, 1705, 1706, 1708, 1709, 1710, 1712, 1713, 1714, 1716, 1717, 1718, 1719, 1720, 1721, 1722, 1723, 1728, 1729, 1730, 1731, 1733, 1737, 1738, 1739, 1741, 1742, 1751, 1754, 1755, 1756, 1759, 1760, 1767, 1786, 1812, 1819, 1824, 1831, 1847, 1851, 1863, 1867, 1868, 1872, 1882, 1884, 1887, 1890, 1891, 1904, 1907, 1909, 1910, 1912, 1913, 1914, 1916, 1917, 1918, 1919, 1920, 1921, 1922, 1923, 1925, 1926, 1928, 1931, 1932, 1933, 1935, 1936, 1937, 1938, 1939, 1942, 1943, 1945, 1948, 1949, 1950, 1952, 1954, 1955, 1956, 1957, 1959, 1960, 1961, 1963, 1966, 1967, 1969, 1971, 1972, 1975, 1977, 1978, 1979, 1980, 1982, 1983, 1984, 1986, 1987, 1989, 1991, 1992, 1993, 1995, 1996, 1997, 1998, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2021, 2022, 2023, 2026, 2029, 2030, 2034, 2036, 2037, 2038, 2039, 2043, 2046, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2056, 2059, 2060, 2061, 2062, 2063, 2064, 2066, 2067, 2069, 2073, 2074, 2075, 2076, 2077, 2079, 2080, 2083, 2087, 2089, 2090, 2091, 2094, 2097, 2098, 2099, 2100, 2101, 2103, 2104, 2105, 2106, 2107, 2108, 2109, 2110, 2114, 2117, 2118, 2120, 2122, 2123, 2124, 2125, 2126, 2127, 2128, 2129, 2132, 2133, 2134, 2135, 2136, 2137, 2144, 2148, 2150, 2151, 2152, 2153, 2154, 2155, 2157, 2161, 2164, 2165, 2166, 2167, 2168, 2169, 2174, 2175, 2176, 2177, 2178, 2183, 2185, 2188, 2190, 2192, 2193, 2195, 2196, 2198, 2199, 2200, 2202, 2203, 2205, 2206, 2208, 2209, 2210, 2211, 2213, 2214, 2215, 2216, 2218, 2221, 2224, 2225, 2226, 2234, 2236, 2238, 2239, 2240, 2241, 2243, 2244, 2245, 2246, 2247, 2248, 2252, 2253, 2254, 2255, 2256, 2257, 2258, 2260, 2261, 2262, 2264, 2265, 2266, 2269, 2271, 2273, 2274, 2275, 2277, 2278, 2279, 2280, 2281, 2282, 2283, 2284, 2285, 2286, 2287, 2289, 2290, 2293, 2294, 2296, 2297, 2298, 2300, 2301, 2303, 2304, 2305, 2307, 2308, 2309, 2310, 2311, 2313, 2314, 2315, 2316, 2317, 2318, 2320, 2321, 2322, 2323, 2324, 2325, 2328, 2329, 2332, 2333, 2334, 2335, 2336, 2337, 2339, 2340, 2341, 2342, 2350, 2351, 2352, 2353, 2357, 2358, 2361, 2367, 2373, 2376, 2378, 2379, 2380, 2382, 2384, 2385, 2387, 2389, 2391, 2393, 2394, 2396, 2397, 2398, 2399, 2403, 2404, 2405, 2406, 2407, 2408, 2409, 2410, 2412, 2413, 2414, 2416, 2426, 2427, 2430, 2432, 2436, 2437, 2438, 2439, 2440, 2441, 2442, 2443, 2445, 2446, 2448, 2449, 2450, 2451, 2452, 2453, 2464, 2472, 2473, 2474, 2476, 2477, 2478, 2480, 2481, 2482, 2483, 2484, 2485, 2489, 2490, 2492, 2493, 2494, 2495, 2496, 2497, 2498, 2499, 2500, 2501, 2502, 2504, 2505, 2506, 2508, 2509, 2511, 2512, 2515, 2516, 2518, 2519, 2520, 2521, 2522, 2523, 2524, 2526, 2527, 2528, 2531, 2532, 2535, 2537, 2538, 2540, 2541, 2542, 2544, 2546, 2548, 2549, 2550, 2552, 2556, 2557, 2558, 2559, 2560, 2562, 2564, 2565, 2566, 2568, 2573, 2575, 2576, 2577, 2578, 2579, 2580, 2581, 2585, 2586, 2587, 2588, 2589, 2590, 2592];
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \JsonException
     */
    public function handle(): void
    {
        $this->checkSchema();
    }

    /**
     * @var array|string[]
     */
    protected array $organizationDataSchema = [
        'name',
        'total_budget',
        'recipient_organization_budget',
        'recipient_region_budget',
        'recipient_country_budget',
        'total_expenditure',
        'document_link',
    ];

    /**
     * @var array|string[]
     */
    protected array $settingDataSchema = [
        'registry_info',
        'default_field_values',
        'default_field_groups',
        'simplify_fields',
    ];

    /**
     * @return void
     * @throws \JsonException
     */
    public function checkSchema(): void
    {
        $this->checkOrganizationDataSchema();
        $this->checkSettingDataSchema();
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function checkOrganizationDataSchema(): void
    {
        $aidStreamOrganizationDataTemplate = readJsonFile('DataMigration/Templates/AidStreamOrganizationDataSchema.json');
        $aidStreamOrganizationData = $this->db::connection('aidstream')
            ->table('organization_data')
            ->whereIn('organization_id', $this->organizationIds)
            ->get();

        foreach ($aidStreamOrganizationData as $orgData) {
            foreach ($orgData as $key => $data) {
                if (empty($data) || $data === 'null' || !in_array($key, $this->organizationDataSchema, true)) {
                    continue;
                }

                $elementDataTemplate = Arr::get($aidStreamOrganizationDataTemplate, $key);
                $itemData = ['tableName' => 'organization_data', 'columnName' => $key, 'rows' => $orgData];
                $this->checkObjectKey($key, $data, $elementDataTemplate, $itemData);
            }
        }
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function checkSettingDataSchema(): void
    {
        $aidStreamSettingDataTemplate = readJsonFile('DataMigration/Templates/AidStreamSettingSchema.json');
        $aidStreamSettingData = $this->db::connection('aidstream')
                                           ->table('settings')
                                           ->whereIn('organization_id', $this->organizationIds)
                                           ->get();

        foreach ($aidStreamSettingData as $settingData) {
            foreach ($settingData as $key => $data) {
                if (empty($data) || $data === 'null' || !in_array($key, $this->settingDataSchema, true)) {
                    continue;
                }

                $elementDataTemplate = Arr::get($aidStreamSettingDataTemplate, $key);
                $itemData = ['tableName' => 'settings', 'columnName' => $key, 'rows' => $settingData];
                $this->checkObjectKey($key, $data, $elementDataTemplate, $itemData);
            }
        }
    }

    /**
     * @throws \JsonException
     */
    public function checkObjectKey($key, $aidStreamData, $template, array $itemData): void
    {
        $templateData = $template[0] ?? $template;
        $keys = array_keys($templateData);
        $aidData = is_array($aidStreamData) ? $aidStreamData : json_decode($aidStreamData, true, 512, JSON_THROW_ON_ERROR);
        $checkIfNestedArray = count(array_filter($aidData, 'is_array'));
        $row = $itemData['rows'];
        $tableName = $itemData['tableName'];
        $columnName = $itemData['columnName'];

        /*
         * To check if keys are matched with schema we need nested array but sometimes data are simply an array . So we convert array into nested array
         */
        if (!$checkIfNestedArray) {
            $aidData = [
                $aidData,
            ];
        }

        foreach ($aidData as $aidDatum) {
            $aidDataKeys = array_keys($aidDatum);
            $is_different = array_diff($keys, $aidDataKeys);

            if (count($is_different)) {
                $differentKeys = implode(' | ', $is_different);
                \Log::info("Table: $tableName\n\norganizationId $row->organization_id and row number $row->id in this column ($columnName) \n Missing keys are $key > ( $differentKeys )\n");
            }

            foreach ($aidDatum as $nestedKey => $nestedData) {
                if (is_array($nestedData)) {
                    $itemData = [
                        'tableName'  => $tableName,
                        'columnName' => $columnName,
                        'rows' => $row,
                    ];
                    $this->checkObjectKey($nestedKey, $nestedData, Arr::get($templateData, $nestedKey, []), $itemData);
                }
            }
        }
    }
}
