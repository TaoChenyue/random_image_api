import argparse
from pathlib import Path
from picuimanager import PicuiManager

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument(
        "--token",
        type=str,
        help="Token to use for authentication",
        required=True,
    )
    args = parser.parse_args()

    pm = PicuiManager(token=args.token)

    root: Path = Path("resource/images/blog")
    root.mkdir(parents=True, exist_ok=True)
    h_urls = []
    v_urls = []
    s_urls = []

    for image in pm.get_images():
        url = image["links"]["url"]
        width = image["width"]
        height = image["height"]
        ratio = width / height
        if ratio >= 4 / 3:
            dst = h_urls
        elif ratio <= 3 / 4:
            dst = v_urls
        else:
            dst = s_urls
        dst.append(url)

    with open(root / "h.csv", "w") as f:
        f.write("\n".join(h_urls))

    with open(root / "v.csv", "w") as f:
        f.write("\n".join(v_urls))

    with open(root / "s.csv", "w") as f:
        f.write("\n".join(s_urls))
