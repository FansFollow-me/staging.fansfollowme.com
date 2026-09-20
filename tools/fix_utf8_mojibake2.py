#!/usr/bin/env python3
from pathlib import Path

root = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3")

extra = [
    ("Ã¢Ëœâ€¦", "★"),
    ("Ã¢Ëœ'", "★"),
    ("Ã¢Ëœ…", "★"),
    ("Ã¢”â‚¬", "─"),
    ("Ã¢’", "’"),
    ("Ã¢â‚¬â„¢", "’"),
    ("Ã¢â‚¬Å“", "“"),
    ("Â©", "©"),
    ("â‚¿", "₿"),
    ("Â~", "★"),
    ("â˜…", "★"),
    ("â€¢", "•"),
    ("â†—", "→"),
    ("Â·", "·"),
]


def fix_file(p: Path) -> None:
    t = p.read_text(encoding="utf-8", errors="replace")
    orig = t
    notes = []
    for bad, good in extra:
        if bad in t:
            notes.append(f"{bad}->{good}x{t.count(bad)}")
            t = t.replace(bad, good)
    for _ in range(4):
        if not any(x in t for x in ("Ã¢", "Ã‚", "â€", "Â©", "Â¿", "Â~")):
            break
        try:
            cand = t.encode("latin-1", errors="strict").decode("utf-8", errors="strict")
            if cand != t:
                t = cand
                notes.append("latin1->utf8")
            else:
                break
        except Exception:
            break
    if t != orig:
        p.write_text(t, encoding="utf-8")
        print("FIXED", p.name, notes[:8])


files = list((root / "resources/views").rglob("*.blade.php"))
files.append(root / "public/preview-home.html")
for f in files:
    if f.exists():
        fix_file(f)

print("==== CELEB BADGE ====")
celeb = (root / "resources/views/marketing/celebrities-exact.blade.php").read_text(encoding="utf-8", errors="replace")
for line in celeb.splitlines():
    if "celeb-badge" in line or "ACCOLADES" in line or "NOW SHOWING" in line or "CELEBRITY CONNECTIONS" in line:
        print(line.strip()[:140])

print("==== FOOTER COPYRIGHT / BTC ====")
for name in ["home-exact.blade.php", "celebrities-exact.blade.php", "business-exact.blade.php"]:
    t = (root / "resources/views/marketing" / name).read_text(encoding="utf-8", errors="replace")
    for line in t.splitlines():
        if "2026 FansFollow" in line:
            print(name, "COPYRIGHT:", line.strip()[:140])
        if "btc-mark" in line and "span" in line:
            print(name, "BTC:", line.strip()[:160])
            break

print("==== DIRTY LEFT ====")
needles = ["Ã¢", "Â©", "â‚¿", "Â~", "â€¢", "â†—"]
for f in files:
    if not f.exists():
        continue
    t = f.read_text(encoding="utf-8", errors="replace")
    left = [n for n in needles if n in t]
    if left:
        print(f.name, left)
