#!/usr/bin/env python3
from pathlib import Path
import re
import sys


ROOT = Path(__file__).resolve().parents[1]
VIEW = ROOT / "frontend/views/voucher/index.php"


def fail(message):
    print(f"voucher index rendering check failed: {message}", file=sys.stderr)
    sys.exit(1)


text = VIEW.read_text(encoding="utf-8")

required_snippets = [
    "use yii\\helpers\\Json;",
    "'onclick' => 'window.location.href=' . Json::htmlEncode($url)",
    "$voucherStatus = Html::encode($model->voucherStatus);",
    '<span style="white-space: pre;" class="chip-text">\' . $voucherStatus . \'</span>',
    '<span class="chip-text" style="white-space: pre;">\' . $voucherStatus . \'</span>',
]

for snippet in required_snippets:
    if snippet not in text:
        fail(f"missing expected guard: {snippet}")

unsafe_patterns = [
    r'\'onclick\'\s*=>\s*"window\.location\.href=\'\{\$url\}\'"',
    r"\.\s*\$model->voucherStatus\s*\.",
]

for pattern in unsafe_patterns:
    if re.search(pattern, text):
        fail(f"found unsafe rendering pattern: {pattern}")

print("voucher index rendering checks passed")
