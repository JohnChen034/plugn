#!/usr/bin/env python3
from pathlib import Path
import sys


ROOT = Path(__file__).resolve().parents[1]
VIEW = ROOT / "frontend/views/layouts/main.php"


def fail(message):
    print(f"{VIEW.relative_to(ROOT)} branding check failed: {message}", file=sys.stderr)
    sys.exit(1)


text = VIEW.read_text(encoding="utf-8")

required_snippets = [
    "Html::img($restaurant->getRestaurantLogoUrl(), [",
    "'alt' => $restaurant->name,",
    "Html::encode($restaurant->name)",
    "'class' => 'brand-text mb-0'",
]

for snippet in required_snippets:
    if snippet not in text:
        fail(f"missing expected escaped rendering snippet: {snippet}")

legacy_patterns = [
    "'<img src=\"' . $restaurant->getRestaurantLogoUrl()",
    ". $restaurant->name . '</h2>'",
]

for pattern in legacy_patterns:
    if pattern in text:
        fail(f"found legacy raw concatenation: {pattern}")

print("frontend layout branding checks passed")
