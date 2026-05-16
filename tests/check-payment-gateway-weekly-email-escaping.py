#!/usr/bin/env python3
"""Static guard for payment gateway and weekly summary email escaping."""

from __future__ import annotations

from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]


def read(path: str) -> str:
    return (ROOT / path).read_text(encoding="utf-8")


def require(path: str, needle: str) -> None:
    text = read(path)
    if needle not in text:
        raise SystemExit(f"{path}: missing expected text: {needle}")


def forbid(path: str, needle: str) -> None:
    text = read(path)
    if needle in text:
        raise SystemExit(f"{path}: still contains unsafe direct output: {needle}")


def main() -> int:
    gateway_templates = [
        "common/mail/payment-gateway-created.php",
        "common/mail/agent/tap-approved.php",
        "common/mail/agent/tap-rejected.php",
    ]

    for path in gateway_templates:
        require(path, "$paymentGatewayLabel = Html::encode($paymentGateway);")
        require(path, "$storeNameLabel = Html::encode($store->name);")
        require(path, "$ownerNameLabel = Html::encode($store->owner_first_name ? $store->owner_first_name : $store->name);")
        require(path, "<?= $paymentGatewayLabel ?> Account")
        require(path, "Hi <?= $ownerNameLabel ?>,")
        require(path, "<b><?= $storeNameLabel ?></b>")
        forbid(path, "<?= $paymentGateway ?> Account")
        forbid(path, "Hi <?= $store->owner_first_name ? $store->owner_first_name : $store->name ?>,")
        forbid(path, "<b><?= $store->name ?></b>")

    require("common/mail/agent/tap-rejected.php", "$statusLabel = Html::encode($status);")
    require("common/mail/agent/tap-rejected.php", "status is <?= $statusLabel ?>")
    forbid("common/mail/agent/tap-rejected.php", "status is <?= $status ?>")

    weekly = "common/mail/weekly-summary.php"
    require(weekly, "$storeNameLabel = Html::encode($store->name);")
    require(weekly, "$agentNameLabel = Html::encode($agent_name);")
    require(weekly, "Weekly store summary for <?= $storeNameLabel ?>")
    require(weekly, "Hello <?= $agentNameLabel ?>,")
    require(weekly, "weekly stats from <b><?= $storeNameLabel ?></b>")
    forbid(weekly, "Weekly store summary for <?= $store->name ?>")
    forbid(weekly, "Hello <?= $agent_name ?>,")
    forbid(weekly, "weekly stats from <b><?= $store->name ?></b>")

    print("payment gateway and weekly summary email escaping checks passed")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
