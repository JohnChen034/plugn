#!/usr/bin/env python3
"""Static guard for refund failure email escaping."""

from __future__ import annotations

from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
TEMPLATE = ROOT / "common/mail/refund-failure-html.php"


def main() -> int:
    text = TEMPLATE.read_text(encoding="utf-8")

    required = [
        "$orderUuidLabel = Html::encode($refund->order_uuid);",
        "$errorMessageLabel = Html::encode($errorMessage);",
        "Refund for Order #<?= $orderUuidLabel ?>",
        "<?= $errorMessageLabel ?>",
    ]
    forbidden = [
        "Refund for Order #<?= $refund->order_uuid ?>",
        "<?= $errorMessage ?>",
    ]

    for needle in required:
        if needle not in text:
            raise SystemExit(f"missing expected text: {needle}")

    for needle in forbidden:
        if needle in text:
            raise SystemExit(f"still contains unsafe direct output: {needle}")

    print("refund failure email escaping checks passed")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
