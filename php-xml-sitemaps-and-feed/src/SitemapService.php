<?php

namespace PhpFyi;

use DOMNode;

class SitemapService extends XMLService
{
    public function getXML(): string
    {
        $this->root('urlset', [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'xmlns:image' => 'http://www.google.com/schemas/sitemap-image/1.1'
        ]);
        return parent::getXML();
    }

    public function createEntry(DOMNode $node, object $page): void
    {
        $this
            ->element($node, 'url', '', fn($node) => $this
                ->element($node, 'loc', $page->absolute_url)
                ->element($node, 'lastmod', date('c', strtotime($page->updated_at)))
                ->element($node, 'changefreq', $page->change_frequency)
                ->element($node, 'priority', number_format($page->priority, 1))
        );
    }
}