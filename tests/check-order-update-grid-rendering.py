#!/usr/bin/env python3
from pathlib import Path
import re
import sys


ROOT = Path(__file__).resolve().parents[1]
VIEWS = [
    ROOT / "backend/views/order/update.php",
    ROOT / "frontend/views/order/update.php",
]


def fail(path, message):
    print(f"{path.relative_to(ROOT)} grid rendering check failed: {message}", file=sys.stderr)
    sys.exit(1)


required_snippets = [
    "use yii\\helpers\\Json;",
    "'onclick' => 'window.location.href=' . Json::htmlEncode($url)",
    "'label' => 'Extra Options'",
    "'format' => 'text'",
]

raw_patterns = [
    r'\'onclick\'\s*=>\s*"window\.location\.href=\'\{\$url\}\'"',
    r"'label'\s*=>\s*'Extra Options'.{0,500}'format'\s*=>\s*'raw'",
]

for view in VIEWS:
    text = view.read_text(encoding="utf-8")

    for snippet in required_snippets:
        if snippet not in text:
            fail(view, f"missing expected guard: {snippet}")

    for pattern in raw_patterns:
        if re.search(pattern, text, re.DOTALL):
            fail(view, f"found unsafe rendering pattern: {pattern}")

print("order update grid rendering checks passed")
