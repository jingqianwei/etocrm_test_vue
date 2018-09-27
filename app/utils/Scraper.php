<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/9/25
 * Time: 18:13
 */

namespace App\utils;

use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use React\Filesystem\FilesystemInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * 爬虫抓取图片
 * 参考网址：https://sergeyzhuk.me/2018/08/31/fast-webscraping-images/
 * Class Scraper
 * @package App\utils
 */
final class Scraper
{
    private $client; //连接地址
    private $filesystem; //文件系统
    private $directory; //图片存放地址

    public function __construct(Browser $client, FilesystemInterface $filesystem, string $directory)
    {
        $this->client = $client;
        $this->filesystem = $filesystem;
        $this->directory = $directory;
    }

    /**
     * 执行链接地址，抓取图片
     * @param array $urls
     */
    public function scrape(array $urls)
    {
        foreach ($urls as $url) {
            $this->client->get($url)->then(
                function (ResponseInterface $response) {
                    $this->processResponse((string) $response->getBody());
                });
        }
    }

    /**
     * 解析链接执行后的结果
     * @param string $html
     */
    private function processResponse(string $html)
    {
        $crawler = new Crawler($html);
        $imageUrl = $crawler->filter('.image-section__image')->attr('src');
        preg_match('/photos\/\d+\/(?<fileDir>[\w-\.]+)\?/', $imageUrl, $matches);
        $filePath = $this->directory . DIRECTORY_SEPARATOR . $matches['fileDir']; //让匹配出的结果为关联数组，这样更有语义化
        $this->client->get($imageUrl)->then(
            function(ResponseInterface $response) use ($filePath) {
                $this->filesystem->file($filePath)->putContents((string)$response->getBody());
            }
        );
    }
}