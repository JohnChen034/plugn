#!/usr/bin/env python3
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
VIEW = ROOT / "backend/views/restaurant-domain-request/view.php"


def require(text: str, needle: str) -> None:
    if needle not in text:
        raise SystemExit(f"missing expected pattern: {needle}")


def forbid(text: str, needle: str) -> None:
    if needle in text:
        raise SystemExit(f"found raw output pattern: {needle}")


def main() -> None:
    text = VIEW.read_text()

    require(text, "$siteId = rawurlencode($model->restaurant->site_id);")
    require(text, "Html::encode($siteId)")
    require(text, "Html::encode($response->data['message'])")
    require(text, "$dnsServers = array_map([Html::class, 'encode'], $arr['dns_servers']);")
    require(text, 'echo "<p>DNS Servers: " . implode(", ", $dnsServers) . "</p>";')
    require(text, "$hostnames = array_map([Html::class, 'encode'], $hostnames);")
    require(text, 'echo "<p>Hostnames: " . implode(", ", $hostnames) . "</p>";')

    forbid(text, '<?= $model->restaurant->site_id ?>')
    forbid(text, '" . $response->data[\'message\'] . "')
    forbid(text, 'implode(", ", $arr[\'dns_servers\'])')
    forbid(text, '$hostnames = \\yii\\helpers\\ArrayHelper::getColumn($arr[\'records\'], "hostname");\n\n                echo "<p>Hostnames: " . implode(", ", $hostnames) . "</p>";')

    print("domain request Netlify output escaping check passed")


if __name__ == "__main__":
    main()
