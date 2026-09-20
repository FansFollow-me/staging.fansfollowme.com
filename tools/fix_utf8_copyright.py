#!/usr/bin/env python3
import re
from pathlib import Path

root = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3\resources\views\marketing")
GOOD_C = '<span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>'

for f in sorted(root.glob("*-exact.blade.php")) + sorted(root.glob("login*.blade.php")):
    if not f.exists():
        continue
    t = f.read_text(encoding="utf-8", errors="replace")
    orig = t
    # Any span that mentions the copyright line -> normalize
    t = re.sub(
        r"<span\b[^>]*>[\s\S]{0,80}?2026 FansFollow\.me\. All rights reserved\.</span>",
        GOOD_C,
        t,
        count=1,
    )
    # bullet separators
    t = t.replace("&#8212;Ã‚Â¢", "&#8226;")
    t = t.replace("Ã‚Â¢", "&#8226;")
    t = t.replace("Â¢", "&#8226;")
    # btc
    t = re.sub(r"(<span class=[\"']btc-mark[\"']>)[^<]*(</span>)", r"\1₿\2", t)
    if t != orig:
        f.write_text(t, encoding="utf-8")
        print("WROTE", f.name)

print("==== VERIFY COPYRIGHT / STARS ====")
for f in sorted(root.glob("*-exact.blade.php")):
    t = f.read_text(encoding="utf-8", errors="replace")
    for ln in t.splitlines():
        if "2026 FansFollow.me. All rights reserved." in ln:
            ok = GOOD_C in ln
            print(("OK " if ok else "BAD") , f.name, ":", ln.strip()[:110])
            break
    for ln in t.splitlines():
        if "CELEBRITY CONNECTIONS" in ln or "ACCOLADES" in ln:
            print("  STAR", ln.strip()[:90])
    for ln in t.splitlines():
        if "btc-mark" in ln and "span" in ln:
            print("  BTC", ln.strip()[:100])
            break
