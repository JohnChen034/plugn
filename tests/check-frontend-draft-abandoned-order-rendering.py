#!/usr/bin/env python3
import re
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]


def read(path):
    return (ROOT / path).read_text()


def require(text, needle, path):
    if needle not in text:
        raise SystemExit(f"{path}: missing {needle!r}")


def reject(text, needle, path):
    if needle in text:
        raise SystemExit(f"{path}: still contains {needle!r}")


def check_grid(path, has_phone=False):
    text = read(path)

    require(text, "use yii\\helpers\\Json;", path)
    require(text, "'onclick' => 'window.location.href=' . Json::htmlEncode($url)", path)
    reject(text, "'onclick' => \"window.location.href='{$url}'\"", path)

    require(
        text,
        "Html::a(Html::encode($data->customer->customer_name), ['customer/view'",
        path,
    )
    reject(text, "Html::a($data->customer->customer_name", path)

    if not re.search(r"'label'\s*=>\s*'Payment'\s*,\s*\"format\"\s*=>\s*\"text\"", text, re.S):
        raise SystemExit(f"{path}: Payment column is not rendered as text")
    if re.search(r"'label'\s*=>\s*'Payment'\s*,\s*\"format\"\s*=>\s*\"raw\"", text, re.S):
        raise SystemExit(f"{path}: Payment column still rendered as raw")

    if has_phone:
        require(text, "$phoneNumber = str_replace(' ', '', $model->customer_phone_number);", path)
        require(text, "Html::a(Html::encode($phoneNumber), 'tel:' . rawurlencode($phoneNumber))", path)
        reject(text, "return '<a href=\"tel:'. $model->customer_phone_number", path)


def main():
    check_grid("frontend/views/order/draft.php")
    check_grid("frontend/views/order/abandoned-checkout.php", has_phone=True)
    print("frontend draft/abandoned order rendering checks passed")


if __name__ == "__main__":
    main()
