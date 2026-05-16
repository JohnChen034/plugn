#!/usr/bin/env python3
"""Static guard for account email label escaping."""

from __future__ import annotations

from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]


def read(path: str) -> str:
    return (ROOT / path).read_text(encoding="utf-8")


def require(path: str, needle: str) -> None:
    if needle not in read(path):
        raise SystemExit(f"{path}: missing expected text: {needle}")


def forbid(path: str, needle: str) -> None:
    if needle in read(path):
        raise SystemExit(f"{path}: still contains unsafe direct output: {needle}")


def main() -> int:
    customer_password = "common/mail/customer/password-updated-html.php"
    require(customer_password, "$restaurantNameLabel = Html::encode($restaurant->name);")
    require(customer_password, "$customerNameLabel = Html::encode($customer->customer_name);")
    require(customer_password, "Your <?= $restaurantNameLabel ?> password has been changed")
    require(customer_password, "Hello <?= $customerNameLabel ?>,")
    forbid(customer_password, "Your <?= $restaurant->name ?> password has been changed")
    forbid(customer_password, "Hello <?= $customer->customer_name ?>,")

    for path in [
        "common/mail/agent/password-updated-html.php",
        "common/mail/agent/verify-email-html.php",
    ]:
        require(path, "$agentNameLabel = Html::encode($agent->agent_name);")
        require(path, "Hello <?= $agentNameLabel ?>,")
        forbid(path, "Hello <?= $agent->agent_name ?>,")

    print("account email label escaping checks passed")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
