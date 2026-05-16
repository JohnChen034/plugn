#!/usr/bin/env python3
from pathlib import Path
import re
import sys


ROOT = Path(__file__).resolve().parents[1]
VIEWS = [
    ROOT / "frontend/views/order/refund-order.php",
    ROOT / "backend/views/order/refund-order.php",
]


def fail(path, message):
    print(f"{path.relative_to(ROOT)} escaping check failed: {message}", file=sys.stderr)
    sys.exit(1)


required_snippets = [
    "$encode = static function ($value) {",
    "return Html::encode((string) $value);",
    "rawurlencode((string) $refundedItem->store->restaurant_uuid)",
    "rawurlencode((string) $itemItmage)",
    'src="<?= $encode($itemImageSrc) ?>"',
    "<?= $encode($refundedItem->orderItem->item_name) ?>",
    "$extraOptions .= '<span>' . $encode($extraOption->extra_option_name) . '</span>';",
    "$extraOptions .= '<span> / ' . $encode($extraOption->extra_option_name) . '</span>';",
    "echo $encode($order->payment_method_name);",
]

raw_patterns = [
    r'src="<\?=\s*"https://res\.cloudinary\.com/plugn/image/upload/restaurants/"\.',
    r'<\?=\s*\$refundedItem->orderItem->item_name\s*\?>',
    r"\$extraOptions\s*\.=\s*'<span>'\s*\.\s*\$extraOption->extra_option_name",
    r"\$extraOptions\s*\.=\s*'<span> / '\s*\.\s*\$extraOption->extra_option_name",
    r'echo\s+\$order->payment_method_name;',
]

for view in VIEWS:
    text = view.read_text(encoding="utf-8")

    for snippet in required_snippets:
        if snippet not in text:
            fail(view, f"missing expected escaping guard: {snippet}")

    for pattern in raw_patterns:
        if re.search(pattern, text):
            fail(view, f"found unescaped output matching {pattern}")

print("refund order rendering escaping checks passed")
