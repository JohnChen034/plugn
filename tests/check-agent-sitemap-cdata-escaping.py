from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
SOURCE = ROOT / "agent/modules/v1/views/sitemap/index.php"


def require(condition, message):
    if not condition:
        raise SystemExit(message)


source = SOURCE.read_text()

require(
    "function agentSitemapCdata($value): string" in source,
    "agent sitemap CDATA helper is missing",
)
require(
    "str_replace(']]>', ']]]]><![CDATA[>', (string) $value)" in source,
    "CDATA helper must split embedded CDATA terminators",
)
require(
    "<![CDATA[<?= $" not in source and "<![CDATA[<?php" not in source,
    "raw inline CDATA/PHP output should not remain in loc elements",
)
require(
    "agentSitemapCdata($restaurant->restaurant_domain)" in source,
    "restaurant domain loc must use CDATA helper",
)
require(
    "agentSitemapCdata($category->slug" in source,
    "category loc must use CDATA helper",
)
require(
    "'/product-list/' . $category->category_id" in source,
    "category fallback path must continue to use category_id",
)
require(
    "agentSitemapCdata($product->slug" in source,
    "product loc must use CDATA helper",
)
require(
    "agentSitemapCdata($restaurant->restaurant_domain . '/order-status')" in source,
    "order-status loc must use CDATA helper",
)

sample = "https://example.test/a]]>b"
escaped = "<![CDATA[" + sample.replace("]]>", "]]]]><![CDATA[>") + "]]>"
require(
    escaped == "<![CDATA[https://example.test/a]]]]><![CDATA[>b]]>",
    "sample CDATA terminator split should preserve text across CDATA sections",
)

print("agent sitemap CDATA escaping checks passed")
