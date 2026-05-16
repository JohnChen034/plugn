#!/usr/bin/env python3
import re
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]


def read(path: str) -> str:
    return (ROOT / path).read_text()


def require(text: str, needle: str) -> None:
    if needle not in text:
        raise SystemExit(f"missing expected pattern: {needle}")


def forbid(text: str, needle: str) -> None:
    if needle in text:
        raise SystemExit(f"found raw output pattern: {needle}")


def require_regex(text: str, pattern: str) -> None:
    if not re.search(pattern, text, re.S):
        raise SystemExit(f"missing expected regex: {pattern}")


def forbid_regex(text: str, pattern: str) -> None:
    if re.search(pattern, text, re.S):
        raise SystemExit(f"found raw output regex: {pattern}")


def main() -> None:
    campaign = read("backend/views/campaign/view.php")
    require(campaign, "http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986)")
    require_regex(campaign, r"Html::a\(\s*Html::encode\(\s*\$campaignUrl\s*\)\s*,\s*\$campaignUrl")
    require_regex(campaign, r"Html::a\(\s*Html::encode\(\s*\$registrationUrl\s*\)\s*,\s*\$registrationUrl")
    require_regex(campaign, r"Html::encode\(\s*\$urlParams\s*\)")
    forbid(campaign, 'href="<?= Yii::$app->params[\'dashboardAppUrl\'] . $urlParams ?>"')
    forbid(campaign, 'href="<?= Yii::$app->params[\'dashboardAppUrl\'] . \'/register\' . $urlParams ?>"')

    blog_index = read("backend/views/blog/index.php")
    require_regex(blog_index, r"Html::encode\(\s*isset\(\s*\$post\['blogPostDescriptions'\]\[0\]\s*\)")
    forbid_regex(blog_index, r"<\?=\s*isset\(\s*\$post\['blogPostDescriptions'\]\[0\]\s*\).*?\['title'\]")

    blog_view = read("backend/views/blog/view.php")
    for needle in [
        "Html::encode($post['post_image'])",
        "Html::encode($post['post_video'])",
        "Html::encode($post['sort_number'])",
        "Html::encode($post['slug'])",
        "Html::encode($blogPostDescription[\"language_code\"])",
        "Html::encode($blogPostDescription['title'])",
        "Html::encode($blogPostDescription['description'])",
    ]:
        require(blog_view, needle)

    category_index = read("backend/views/blog-category/index.php")
    require_regex(category_index, r"Html::encode\(\s*isset\(\s*\$category\['blogCategoryDescriptions'\]\[0\]\s*\)")
    forbid_regex(category_index, r"<\?=\s*isset\(\s*\$category\['blogCategoryDescriptions'\]\[0\]\s*\).*?\['title'\]")

    category_view = read("backend/views/blog-category/view.php")
    for needle in [
        "Html::encode($category['category_image'])",
        "Html::encode($category['sort_number'])",
        "Html::encode($category['slug'])",
        "Html::encode($blogCategoryDescription[\"language_code\"])",
        "Html::encode($blogCategoryDescription['title'])",
        "Html::encode($blogCategoryDescription['description'])",
    ]:
        require(category_view, needle)

    print("campaign and blog rendering escaping check passed")


if __name__ == "__main__":
    main()
