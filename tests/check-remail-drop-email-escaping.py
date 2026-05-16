#!/usr/bin/env python3
"""Guard remail dropped-message templates against raw HTML output."""

from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]


def read_template(relative_path: str) -> str:
    return (ROOT / relative_path).read_text()


def require(text: str, needle: str, path: str) -> None:
    if needle not in text:
        raise AssertionError(f"{path} is missing expected pattern: {needle}")


def forbid(text: str, needle: str, path: str) -> None:
    if needle in text:
        raise AssertionError(f"{path} still contains raw output: {needle}")


def check_unauthorized_template() -> None:
    path = "common/mail/remail/email-dropped-unauthorized-html.php"
    text = read_template(path)

    for needle in (
        "use yii\\helpers\\Html;",
        "$emailFromLabel = Html::encode($emailFrom);",
        "$ticketUuidLabel = Html::encode($ticket_uuid);",
        "$emailTextLabel = nl2br(Html::encode($emailText));",
        "<?= $emailFromLabel ?>",
        "<?= $ticketUuidLabel ?>",
        "<?= $emailTextLabel ?>",
    ):
        require(text, needle, path)

    for needle in (
        "<?= $emailFrom ?>",
        "<?= $ticket_uuid ?>",
        'str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $emailText)',
    ):
        forbid(text, needle, path)


def check_ticket_not_found_template() -> None:
    path = "common/mail/remail/email-dropped-ticket-not-found-html.php"
    text = read_template(path)

    for needle in (
        "use yii\\helpers\\Html;",
        "$ticketUuidLabel = Html::encode($ticket_uuid);",
        "$emailTextLabel = nl2br(Html::encode($emailText));",
        "<?= $ticketUuidLabel ?>",
        "<?= $emailTextLabel ?>",
    ):
        require(text, needle, path)

    for needle in (
        "<?= $ticket_uuid ?>",
        'str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $emailText)',
    ):
        forbid(text, needle, path)


def main() -> None:
    check_unauthorized_template()
    check_ticket_not_found_template()
    print("remail drop email escaping checks passed")


if __name__ == "__main__":
    main()
