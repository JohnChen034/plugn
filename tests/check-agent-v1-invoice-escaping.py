#!/usr/bin/env python3
from pathlib import Path
import re
import sys


ROOT = Path(__file__).resolve().parents[1]
INVOICE_VIEW = ROOT / "agent/modules/v1/views/order/invoice.php"


def fail(message):
    print(f"agent v1 invoice escaping check failed: {message}", file=sys.stderr)
    sys.exit(1)


text = INVOICE_VIEW.read_text(encoding="utf-8")

required_snippets = [
    "use yii\\helpers\\Html;",
    "$encode = static function ($value) {",
    "return Html::encode((string) $value);",
    "rawurlencode((string) $order->restaurant_uuid)",
    "rawurlencode((string) $order->restaurant->logo)",
    "<?= $encode($restaurantLogoSrc) ?>",
    "<?= $encode($defaultLogo) ?>",
    "<?= $encode($order->armada_qr_code_link) ?>",
    "<?= $encode($order->order_uuid) ?>",
    "<?= $encode($order->restaurant->name) ?>",
    "<?= $encode($order->customer_name) ?>",
    "echo $encode($order->payment_method_name);",
    "echo $encode($order->payment_method_name_ar);",
    "echo $encode($order->paymentMethod->payment_method_name);",
    "<?= $order->special_directions ? $encode($order->special_directions) : '' ?>",
    "<?= $encode($orderItem->item_name) ?>",
    "<?= $encode($orderItem->customer_instruction) ?>",
    "<?= $encode($orderItem->getOrderExtraOptionsText()) ?>",
    "Voucher Discount (<?= $encode($order->voucher->code) ?>)",
    "<?= $encode($order->currency->code) ?> 0.000",
]

for snippet in required_snippets:
    if snippet not in text:
        fail(f"missing expected escaping guard: {snippet}")

raw_echo_patterns = [
    r'src="<\?=\s*\$defaultLogo\s*\?>"',
    r'src="<\?=\s*\$order->armada_qr_code_link\s*\?>"',
    r'<\?=\s*\$order->order_uuid\s*\?>',
    r'<\?=\s*\$order->restaurant->name\s*\?>',
    r'<\?=\s*\$order->customer_name\s*\?>',
    r'<\?=\s*\$order->customer_phone_number\s*\?>',
    r'<\?=\s*\$order->special_directions\s*\?>',
    r'echo\s+\$order->payment_method_name;',
    r'echo\s+\$order->payment_method_name_ar;',
    r'echo\s+\$order->paymentMethod->payment_method_name;',
    r'<\?=\s*\$orderItem->item_name\s*\?>',
    r'<\?=\s*\$orderItem->customer_instruction\s*\?>',
    r'<\?=\s*\$orderItem->getOrderExtraOptionsText\(\)\s*\?>',
    r'Voucher Discount \(<\?=\s*\$order->voucher->code\s*\?>\)',
    r'<\?=\s*\$order->currency->code\s*\?> 0\.000',
]

for pattern in raw_echo_patterns:
    if re.search(pattern, text):
        fail(f"found unescaped output matching {pattern}")

print("agent v1 invoice escaping check passed")
