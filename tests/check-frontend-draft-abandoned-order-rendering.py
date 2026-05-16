#!/usr/bin/env python3
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

    require(text, "'label' => 'Payment',\n                    \"format\" => \"text\",", path)
    reject(text, "'label' => 'Payment',\n                    \"format\" => \"raw\",", path)

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
