<?php

require __DIR__ . '/vendor/autoload.php';

use PhpFyi\SitemapService;
use PhpFyi\SitemapNewsService;
use PhpFyi\NewsRssService;

$pages = [
    (object) [
        'absolute_url' => 'https://php.fyi',
        'updated_at' => '2022-12-26 21:05:11',
        'change_frequency' => 'weekly',
        'priority' => 0.9
    ]
];

$output = (new SitemapService())->setPages($pages)->getXML();
// echo $output;

/*
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
  <url>
    <loc>https://php.fyi</loc>
    <lastmod>2022-12-26T21:05:11+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
</urlset>
*/

$pages = [
    (object) [
        'absolute_url' => 'https://php.fyi',
        'published_at' => '2022-12-26 21:05:11',
        'meta_title' => 'Test title',
        'website' => 'PHP.FYI',
        'language' => 'en'
    ]
];
$output = (new SitemapNewsService())->setPages($pages)->getXML();
// echo $output;

/*
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
  <url>
    <loc>https://php.fyi</loc>
    <news:news>
      <news:publication>
        <news:name>PHP.FYI</news:name>
        <news:language>en</news:language>
      </news:publication>
      <news:publication_date>2022-12-26T21:05:11+00:00</news:publication_date>
      <news:title>Test title</news:title>
    </news:news>
  </url>
</urlset>
*/

$pages = [
    (object) [
        'slug' => 'test-slug',
        'meta_title' => 'Test title',
        'meta_description' => 'Test description',
        'published_at' => '2022-12-26 21:05:11',
        'absolute_url' => 'https://php.fyi',
        'image_url' => 'https://php.fyi/img/articles/search-engine-indexing/summary.jpg',
        'html' => '<p>Content</p>',
        'author' => 'test@php.fyi (Andrew Mc Cormack)',
        'category' => 'Site News'
    ]
];
$output = (new NewsRssService())->setPages($pages)->getXML();
// echo $output;

/*
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/">
  <channel>
    <title>Articles</title>
    <link><![CDATA[https://php.fyi]]></link>
    <description>Engineering and marketing articles</description>
    <language>en</language>
    <atom:link href="https://api.phpfyi.local/rss/news" rel="self" type="application/rss+xml"/>
    <item>
      <guid isPermaLink="false">test-slug</guid>
      <title>Test title</title>
      <link>https://php.fyi</link>
      <author>test@php.fyi (Andrew Mc Cormack)</author>
      <category>Site News</category>
      <description>Test description</description>
      <pubDate>Mon, 26 Dec 2022 21:05:11 +0000</pubDate>
      <content:encoded><![CDATA[<p>Content</p>]]></content:encoded>
      <enclosure url="https://php.fyi/img/articles/search-engine-indexing/summary.jpg" type="image/jpeg" length="0"/>
    </item>
  </channel>
</rss>
*/