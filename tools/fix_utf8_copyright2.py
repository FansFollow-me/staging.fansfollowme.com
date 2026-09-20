#!/usr/bin/env python3
import re
from pathlib import Path

root = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3\resources\views\marketing")
GOOD_C = '<span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>'

for f in sorted(root.glob("*-exact.blade.php")):
    t = f.read_text(encoding="utf-8", errors="replace")
    orig = t
    t = re.sub(
        r"<span[^<>\n]*2026 FansFollow\.me\. All rights reserved\.</span>",
        GOOD_C,
        t,
    )
    # if still broken form with © inside attributes area
    t = re.sub(
        r"<span\b[^>]{0,200}2026 FansFollow\.me\. All rights reserved\.</span>",
        GOOD_C,
        t,
    )
    t = t.replace("color: #94a3b8;© © 2026", "color: #94a3b8;\">© 2026")
    t = t.replace('color: #94a3b8;© © 2026', 'color: #94a3b8;">© 2026')
    if "color: #94a3b8;© © 2026" in t or "color: #94a3b8;© © 2026" in t:
        pass
    # last resort line rewrite
    lines = t.splitlines()
    for i, ln in enumerate(lines):
        if "2026 FansFollow.me. All rights reserved." in ln and "<span" in ln:
            indent = ln[: len(ln) - len(ln.lstrip())]
            lines[i] = indent + GOOD_C
    t = "\n".join(lines) + ("\n" if orig.endswith("\n") else "")
    if t != orig:
        f.write_text(t, encoding="utf-8")
        print("WROTE", f.name)

print("==== VERIFY ====")
bad = 0
for f in sorted(root.glob("*-exact.blade.php")):
    t = f.read_text(encoding="utf-8", errors="replace")
    for ln in t.splitlines():
        if "2026 FansFollow.me. All rights reserved." in ln:
            ok = GOOD_C in ln
            print(("OK" if ok else "BAD"), f.name)
            if not ok:
                bad += 1
                print("   ", ln.strip()[:130])
            break
print("BAD_COUNT", bad)
