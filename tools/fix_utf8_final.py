#!/usr/bin/env python3
import re
from pathlib import Path

root = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3\resources\views\marketing")
GOOD_C = '<span style="font-size: .85rem; color: #94a3b8;">© 2026 FansFollow.me. All rights reserved.</span>'
GOOD_C2 = "<span style='font-size: .85rem; color: #94a3b8;'>© 2026 FansFollow.me. All rights reserved.</span>"
GOOD_BTC = '<span class="btc-mark">₿</span>'

for f in sorted(root.glob("*-exact.blade.php")):
    t = f.read_text(encoding="utf-8", errors="replace")
    orig = t
    # Fix broken copyright spans (missing quote/bracket, &co prefix, mojibake)
    t = re.sub(
        r"<span style=[\"']font-size:\s*\.85rem;\s*color:\s*#94a3b8;[\"']?\s*>[^<]*2026 FansFollow\.me\. All rights reserved\.</span>",
        GOOD_C,
        t,
    )
    t = re.sub(
        r"&co© 2026 FansFollow\.me\. All rights reserved\.",
        "© 2026 FansFollow.me. All rights reserved.",
        t,
    )
    t = re.sub(
        r"[ÂÃâ�©]*2026 FansFollow\.me\. All rights reserved\.",
        "© 2026 FansFollow.me. All rights reserved.",
        t,
    )
    # BTC mark contents
    t = re.sub(r"(<span class=[\"']btc-mark[\"']>)[^<]*(</span>)", r"\1₿\2", t)
    # leftover mojibake sequences in visible HTML
    for bad, good in [
        ("Ãƒâ€š©", "©"),
        ("Ã‚©", "©"),
        ("Ã¢â€š¿", "₿"),
        ("Ã‚¿", "₿"),
        ("Ã¢Ëœâ€¦", "★"),
        ("Ã¢”â‚¬", "─"),
        ("Â©", "©"),
        ("â‚¿", "₿"),
        ("&co©", "©"),
    ]:
        t = t.replace(bad, good)
    if t != orig:
        f.write_text(t, encoding="utf-8")
        print("WROTE", f.name)

print("==== VERIFY ====")
for f in sorted(root.glob("*-exact.blade.php")):
    t = f.read_text(encoding="utf-8", errors="replace")
    c = [ln.strip() for ln in t.splitlines() if "2026 FansFollow.me. All rights reserved." in ln]
    b = [ln.strip() for ln in t.splitlines() if "btc-mark" in ln and "span" in ln]
    star = [ln.strip() for ln in t.splitlines() if "CELEBRITY CONNECTIONS" in ln or "ACCOLADES" in ln]
    print("---", f.name)
    if c:
        print("  C:", c[0][:120])
    if b:
        print("  B:", b[0][:130])
    for s in star[:2]:
        print("  S:", s[:100])
    dirty = [n for n in ["Ã‚", "Ãƒ", "Ã¢â€š", "Â©", "&co©"] if n in t]
    # ignore CSS comment box-drawing leftovers if any
    if dirty:
        # show context
        for n in dirty:
            i = t.find(n)
            print("  DIRTY", n, "at", t[max(0,i-20):i+40].replace("\n"," ")[:80])
