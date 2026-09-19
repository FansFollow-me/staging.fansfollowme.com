from PIL import Image
import os

d = r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-11\am i able to ask you questions about you\ffm-backend\public\img\gifts"
out = r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-11\am i able to ask you questions about you\ffm-backend\public\img\gifts\masks"
os.makedirs(out, exist_ok=True)

# Glass type -> how to cut the INNER liquid region from opaque pixels
# inset_pct: shrink from left/right opaque edges per row
# top_skip: fraction of opaque height to skip (rim/foam area)
# bot_keep: fraction of opaque height to keep as bowl bottom
CFG = {
    "glass_beer.png": {
        "out": "beer-inner.png",
        "inset": 0.08,
        "top_skip": 0.06,
        "bot_keep": 0.88,
        "min_row_frac": 0.15,
    },
    "glass_wine.png": {
        "out": "wine-inner.png",
        "inset": 0.12,
        "top_skip": 0.08,
        "bot_keep": 0.62,  # stop before stem
        "min_row_frac": 0.12,
    },
    "glass_flute.png": {
        "out": "flute-inner.png",
        "inset": 0.14,
        "top_skip": 0.06,
        "bot_keep": 0.72,
        "min_row_frac": 0.08,
    },
}


def build_mask(src_name, cfg):
    im = Image.open(os.path.join(d, src_name)).convert("RGBA")
    W, H = im.size
    px = im.load()

    # opaque bbox
    xs, ys = [], []
    for y in range(H):
        for x in range(W):
            if px[x, y][3] > 20:
                xs.append(x)
                ys.append(y)
    if not xs:
        print(src_name, "no opaque pixels")
        return
    x0, x1, y0, y1 = min(xs), max(xs), min(ys), max(ys)
    oh = y1 - y0 + 1

    top = y0 + int(oh * cfg["top_skip"])
    bot = y0 + int(oh * cfg["bot_keep"])
    mask = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    mp = mask.load()
    inset = cfg["inset"]
    min_frac = cfg["min_row_frac"]

    for y in range(top, bot + 1):
        row_x = [x for x in range(x0, x1 + 1) if px[x, y][3] > 20]
        if len(row_x) < max(4, (x1 - x0 + 1) * min_frac):
            continue
        lx, rx = min(row_x), max(row_x)
        span = rx - lx + 1
        pad = int(span * inset)
        # keep a little more pad on narrow rows (stem-adjacent)
        ix0 = lx + pad
        ix1 = rx - pad
        if ix1 <= ix0:
            ix0 = lx + max(1, span // 8)
            ix1 = rx - max(1, span // 8)
        if ix1 <= ix0:
            continue
        for x in range(ix0, ix1 + 1):
            mp[x, y] = (255, 255, 255, 255)

    dest = os.path.join(out, cfg["out"])
    mask.save(dest)
    # also count white pixels
    white = sum(1 for y in range(H) for x in range(W) if mp[x, y][3] > 200)
    print(f"{src_name} -> {cfg['out']} size={W}x{H} bbox=({x0},{y0})-({x1},{y1}) inner_px={white}")


for name, cfg in CFG.items():
    build_mask(name, cfg)

print("done")
