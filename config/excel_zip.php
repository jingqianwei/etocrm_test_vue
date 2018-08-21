<?php

return [
    /**
     * if always_zip is true, when data are less than 5000, it will output as a zip;
     * if false, it will be just one xlsx
     */
    'always_zip' => false, //true 时无论数据多少是否多个或者一个Excel，都始终下载 zip；false 时当数据只足以下载一个Excel时只会下载 xlsx，多个才会下载 zip

    /**
     * each excel data number
     */
    'chunk' => 5000, //每 chunk 条数据为一个 Excel 文件，默认 5000
];
