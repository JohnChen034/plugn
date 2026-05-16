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


def check_phone_link(path):
    text = read(path)
    require(text, "$phoneNumber = str_replace(' ', '', $model->customer_phone_number);", path)
    require(text, "Html::a(Html::encode($phoneNumber), 'tel:' . rawurlencode($phoneNumber))", path)
    reject(text, "return '<a href=\"tel:'. $model->customer_phone_number", path)


def check_row_url(path):
    text = read(path)
    require(text, "use yii\\helpers\\Json;", path)
    require(text, "'onclick' => 'window.location.href=' . Json::htmlEncode($url)", path)
    reject(text, "'onclick' => \"window.location.href='{$url}'\"", path)


def check_status_badges(path):
    text = read(path)
    require(text, "Html::encode($model->orderStatusInEnglish)", path)
    reject(text, ". $model->orderStatusInEnglish .", path)


def main():
    check_phone_link("frontend/views/customer/index.php")
    check_row_url("frontend/views/customer/index.php")
    check_phone_link("frontend/views/customer/view.php")
    check_row_url("frontend/views/customer/view.php")
    check_status_badges("frontend/views/customer/view.php")
    print("frontend customer rendering checks passed")


if __name__ == "__main__":
    main()
