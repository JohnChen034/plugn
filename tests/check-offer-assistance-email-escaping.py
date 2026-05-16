#!/usr/bin/env python3
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
TEMPLATE = ROOT / "common/mail/offer-assistance.php"


def require(text: str, needle: str) -> None:
    if needle not in text:
        raise SystemExit(f"missing expected pattern: {needle}")


def forbid(text: str, needle: str) -> None:
    if needle in text:
        raise SystemExit(f"found raw output pattern: {needle}")


def main() -> None:
    text = TEMPLATE.read_text()

    require(text, "$storeContactLabel = Html::encode($store->owner_first_name ? $store->owner_first_name : $store->name);")
    require(text, "Hello <?= $storeContactLabel ?>,")
    forbid(text, "Hello <?= $store->owner_first_name ? $store->owner_first_name : $store->name ?>,")

    print("offer assistance email escaping check passed")


if __name__ == "__main__":
    main()
