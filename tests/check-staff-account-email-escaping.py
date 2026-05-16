#!/usr/bin/env python3
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
TEMPLATE = ROOT / "common/mail/staff/password-updated-html.php"


def require(text: str, needle: str) -> None:
    if needle not in text:
        raise SystemExit(f"missing expected pattern: {needle}")


def forbid(text: str, needle: str) -> None:
    if needle in text:
        raise SystemExit(f"found raw output pattern: {needle}")


def main() -> None:
    text = TEMPLATE.read_text()

    require(text, "$staffNameLabel = Html::encode($staff->staff_name);")
    require(text, "Hello <?= $staffNameLabel ?>,")
    forbid(text, "Hello <?= $staff->staff_name ?>,")

    print("staff account email escaping check passed")


if __name__ == "__main__":
    main()
