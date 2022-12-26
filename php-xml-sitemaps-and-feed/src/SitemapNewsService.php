<?php

namespace PhpFyi;

use DOMNode;

class SitemapNewsService extends XMLService
{
    public function getXML(): string
    {
        $this->root('urlset', [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'xmlns:news' => 'http://www.google.com/schemas/sitemap-news/0.9'
        ]);
        return parent::getXML();
    }

    public function createEntry(DOMNode $node, object $page): void
    {
        $this
            ->element($node, 'url', '', fn($node) => $this
                ->element($node, 'loc', $page->absolute_url)
                ->element($node, 'news:news', '', fn($node) => $this
                    ->element($node, 'news:publication', '', fn($node) => $this
                        ->element($node, 'news:name', $page->website)
                        ->element($node, 'news:language', $page->language)
                    )
                    ->element($node, 'news:publication_date', date('c', strtotime($page->published_at)))
                    ->element($node, 'news:title', $page->meta_title)
                )
            );
    }
}