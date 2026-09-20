#!/usr/bin/env python3
from pathlib import Path
root = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3")
reps = [
    ("Ã‚©", "©"),
    ("Ã‚Â©", "©"),
    ("Ã¢â€š¿", "₿"),
    ("Ã¢â‚¬Å" + chr(0xBF), "₿"),
    ("Ã¢â‚¬Å" + "\u00bf", "₿"),
    ("Ã¢Ëœâ€¦", "★"),
    ("Ã¢”â‚¬", "─"),
    ("Â©", "©"),
    ("â‚¿", "₿"),
]
# iterative full-file re-decode
for f in list((root/"resources/views").rglob("*.blade.php")) + [root/"public/preview-home.html"]:
    if not f.exists():
        continue
    t = f.read_text(encoding="utf-8", errors="replace")
    orig = t
    for _ in range(6):
        changed = False
        for bad, good in reps:
            if bad in t:
                t = t.replace(bad, good)
                changed = True
        try:
            cand = t.encode("latin-1", errors="strict").decode("utf-8", errors="strict")
            if cand != t and any(x in t for x in ("Ã", "â‚", "Â©", "Ã¢")):
                t = cand
                changed = True
        except Exception:
            pass
        if not changed:
            break
    if t != orig:
        f.write_text(t, encoding="utf-8")
        print("FIXED", f.name)

print("==== VERIFY ====")
for name in ["home-exact.blade.php","celebrities-exact.blade.php","business-exact.blade.php","fans-exact.blade.php","casting-exact.blade.php"]:
    p = root/"resources/views/marketing"/name
    t = p.read_text(encoding="utf-8", errors="replace")
    for line in t.splitlines():
        if "2026 FansFollow" in line:
            print(name, "=>", line.strip()[:110])
        if "btc-mark" in line and "span" in line:
            print(name, "BTC =>", line.strip()[:130])
            break
    if "celeb-badge" in t or "ACCOLADES" in t:
        for line in t.splitlines():
            if "CELEBRITY CONNECTIONS" in line or "ACCOLADES" in line:
                print(name, "BADGE =>", line.strip()[:100])
print("DIRTY:")
needles=["Ã‚","Ã¢","Â©","â‚¿","Ã¢Ëœ"]
for f in (root/"resources/views/marketing").glob("*-exact.blade.php"):
    t=f.read_text(encoding="utf-8",errors="replace")
    left=[n for n in needles if n in t]
    if left: print(f.name,left)
if not any([n in (root/"resources/views/marketing"/x).read_text(encoding="utf-8",errors="replace") for x in ["home-exact.blade.php"] for n in needles]):
    print("home clean")
