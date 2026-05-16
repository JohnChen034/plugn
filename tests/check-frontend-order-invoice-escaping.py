#!/usr/bin/env python3
from pathlib import Path
import re
import sys


ROOT = Path(__file__).resolve().parents[1]
INVOICE_VIEW = ROOT / "frontend/views/order/invoice.php"


def fail(message):
    print(f"frontend order invoice escaping check failed: {message}", file=sys.stderr)
    sys.exit(1)


text = INVOICE_VIEW.read_text(encoding="utf-8")

required_snippets = [
    "$encode = static function ($value) {",
    "return Html::encode((string) $value);",
    "<?= $encode($model->armada_qr_code_link) ?>",
    "<?= $encode($model->restaurant->getRestaurantLogoUrl()) ?>",
    "<?= $encode($model->restaurant->name) ?>",
    "<?= $encode($model->customer_name) ?>",
    "<?= $encode($model->customer_phone_number) ?>",
    "<?= $encode($model->order_uuid) ?>",
    "echo $encode($model->payment_method_name);",
    "echo $encode($model->payment_method_name_ar);",
    "echo $encode($model->paymentMethod->payment_method_name);",
    "<?= $encode($model->special_directions) ?>",
    "<?= $encode($model->recipient_name) ?>",
    "<?= $encode($model->gift_message) ?>",
    "<?= $encode($model->recipient_phone_number) ?>",
    "'format' => 'text',",
]

for snippet in required_snippets:
    if snippet not in text:
        fail(f"missing expected escaping guard: {snippet}")

raw_echo_patterns = [
    r'src="<\?=\s*\$model->armada_qr_code_link\s*\?>"',
    r'<\?=\s*\$model->restaurant->name\s*\?>',
    r'<\?=\s*\$model->customer_name\s*\?>',
    r'<\?=\s*\$model->customer_phone_number\s*\?>',
    r'<\?=\s*\$model->order_uuid\s*\?>',
    r'<\?=\s*\$model->special_directions\s*\?>',
    r'<\?=\s*\$model->recipient_name\s*\?>',
    r'<\?=\s*\$model->gift_message\s*\?>',
    r'<\?=\s*\$model->recipient_phone_number\s*\?>',
    r'echo\s+\$model->payment_method_name;',
    r'echo\s+\$model->payment_method_name_ar;',
    r'echo\s+\$model->paymentMethod->payment_method_name;',
    r"'format'\s*=>\s*'raw',\s*'value'\s*=>\s*'item\.(sku|barcode)'",
    r"'label'\s*=>\s*'Extra Options'.{0,400}'format'\s*=>\s*'raw'",
]

for pattern in raw_echo_patterns:
    if re.search(pattern, text, re.DOTALL):
        fail(f"found unescaped output matching {pattern}")

print("frontend order invoice escaping check passed")
