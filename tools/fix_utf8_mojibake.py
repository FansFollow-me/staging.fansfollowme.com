#!/usr/bin/env python3
"""Fix UTF-8 mojibake in FFM staging3 marketing views and report hits."""
from pathlib import Path

ROOT = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3\resources\views")
PUBLIC = Path(r"C:\Users\Martin\XiaomiMiMoProjects\.mimo-sessions\2026-09-17\ffm-backend-staging3\public")

# Double-encoded UTF-8 (shown wrong in UI) -> correct characters
PAIRS = [
    ("Â©", "©"),
    ("â‚¿", "₿"),
    ("â†—", "→"),
    ("â†'", "→"),
    ("â†’", "→"),
    ("â†'", "→"),
    ("â†’", "→"),
    ("â†’", "→"),
    ("â†’→", "→"),
    ("Â~", "★"),
    ("â˜…", "★"),
    ("â˜†", "☆"),
    ("âœ\"", "✓"),
    ("Â·", "·"),
    ("â€™", "’"),
    ("â€œ", "“"),
    ("â€\x9d", "”"),
    ("â€\x9c", "“"),
    ("â€\"", "”"),
    ("â€\"", "—"),
    ("â€\x93", "“"),
    ("â€\x94", "”"),
    ("â€\x98", "‘"),
    ("â€\x99", "’"),
    ("â€\x9c", "“"),
    ("â€\x9d", "”"),
    ("â€\x9e", "„"),
    ("Ã©", "é"),
    ("Ã¨", "è"),
    ("Ãª", "ê"),
    ("Ã¡", "á"),
    ("Ã­", "í"),
    ("Ã³", "ó"),
    ("Ãº", "ú"),
    ("Ã±", "ñ"),
    ("Â¿", "¿"),
    ("Â¡", "¡"),
    ("â—Ź", "●"),
    ("â—Ź", "•"),
    ("â€¢", "•"),
    ("â€¢", "·"),
]

# Also generic: sequences like Â followed by high-bit that are Latin-1 of UTF-8
# We'll do a second pass: try bytes(s, 'cp1252').decode('utf-8') on remaining Â/â strings

def fix_text(s: str) -> tuple[str, list[str]]:
    hits = []
    orig = s
    for bad, good in PAIRS:
        if bad in s:
            n = s.count(bad)
            s = s.replace(bad, good)
            hits.append(f"{bad!r}->{good!r} x{n}")
    # Second pass: fix remaining double-encoded UTF-8 via latin-1/cp1252 round-trip
    # Only apply to chunks that still look mojibaked
    if "Â" in s or "â€" in s or "Ã" in s:
        try:
            # If file is UTF-8 that contains mis-decoded chars, re-encode as latin-1 and decode utf-8
            fixed = s.encode("cp1252", errors="strict").decode("utf-8", errors="strict")
            if fixed != s and ("©" in fixed or "★" in fixed or "₿" in fixed or "—" in fixed or "•" in fixed):
                hits.append("cp1252->utf8 roundtrip")
                s = fixed
        except (UnicodeEncodeError, UnicodeDecodeError):
            pass
    return s, hits


def process(path: Path) -> None:
    raw = path.read_bytes()
    # Prefer UTF-8
    try:
        text = raw.decode("utf-8")
    except UnicodeDecodeError:
        text = raw.decode("utf-8", errors="replace")
    new, hits = fix_text(text)
    if new != text:
        path.write_bytes(new.encode("utf-8"))
        print(f"FIXED {path.relative_to(ROOT.parent.parent)} :: {', '.join(hits[:6])}")
    else:
        # report if still dirty
        dirty = [p for p, _ in PAIRS if p in text]
        if dirty:
            print(f"STILL {path.name}: {dirty[:5]}")


files = list(ROOT.rglob("*.blade.php")) + list(PUBLIC.glob("preview-home.html"))
print(f"scanning {len(files)} files")
for f in files:
    process(f)

# Report remaining mojibake
print("==== REMAINING CHECK ====")
needles = ["Â©", "â‚¿", "Â~", "â†—", "Â·", "Ã©", "â€"]
for f in files:
    try:
        t = f.read_text(encoding="utf-8")
    except Exception:
        continue
    for n in needles:
        if n in t:
            print(f"  LEFT {f.name} has {n!r}")

# Sample copyright lines
for name in ["home-exact.blade.php", "celebrities-exact.blade.php", "business-exact.blade.php"]:
    p = ROOT / "marketing" / name
    if not p.exists():
        continue
    t = p.read_text(encoding="utf-8", errors="replace")
    for line in t.splitlines():
        if "2026 FansFollow" in line or "btc-mark" in line or "Coming Soon" in line and "footer" in t[max(0,t.find(line)-200):t.find(line)]:
            if "2026" in line or "btc" in line or "STAR" in line or "★" in line or "badge" in line:
                print(f"SAMPLE {name}: {line.strip()[:140]}")
                break
# Celebrities badge
celeb = (ROOT / "marketing" / "celebrities-exact.blade.php").read_text(encoding="utf-8", errors="replace")
for i, line in enumerate(celeb.splitlines(), 1):
    if "badge" in line.lower() or "★" in line or "Â~" in line or "STAR" in line:
        if i < 1800:
            print(f"CELEB L{i}: {line.strip()[:160]}")
