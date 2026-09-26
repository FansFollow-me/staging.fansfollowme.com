# TOKEN-RESTORE inventory

FFM token / reward-token / pre-sale copy is **hidden, not deleted**.  
Each block is wrapped in `{{-- TOKEN-RESTORE: start --}}` … `{{-- TOKEN-RESTORE: end --}}` (Blade) or `<!-- TOKEN-RESTORE: … -->` (HTML/CSS-in-HTML).  
Original text is preserved **word for word** between the markers.

**Crypto payment mentions (BTC / ETH / USDT / SOL) stay visible** — they are payments, not the FFM token.

---

## 1. For Creators — “Earn FFM reward tokens”

| Field | Value |
|-------|--------|
| **File** | `resources/views/marketing/for-creators-exact.blade.php` |
| **Lines** | 1599–1601 |
| **Site location** | `/for-creators` → section **“Why creators choose us”** (sidebar / why-creators list) |
| **Original text (verbatim)** | `<div class="why-creators-item"><strong>Earn FFM reward tokens</strong><p>Earn extra tokens as fans engage on the platform.</p></div>` |
| **Marker** | `{{-- TOKEN-RESTORE: start — FFM reward tokens (for-creators, Why creators choose us) --}}` … `{{-- TOKEN-RESTORE: end --}}` |
| **How to restore** | Delete (or comment out) both `TOKEN-RESTORE` lines around the `div.why-creators-item`. Leave the inner HTML unchanged. |

---

## 2. Business — token section CSS

| Field | Value |
|-------|--------|
| **File** | `resources/views/marketing/business-exact.blade.php` |
| **Lines** | 286–300 (inside `<style>`) |
| **Site location** | `/business` → styles for the hidden **FFM Token** band (`.token-section`, `.token-panel`, `.token-grid`, `.token-item`, `.token-icon`, `.token-links`) |
| **Original text (verbatim)** | Full CSS rules: |

```css
  .token-section { background: linear-gradient(to right bottom, rgba(31,41,55,.6), rgba(17,24,39,.6)); border-top: 1px solid rgba(255,255,255,.06); border-bottom: 1px solid rgba(255,255,255,.06); padding: 2.25rem 0; }
  .token-panel { max-width: 900px; margin: 0 auto; }
  .token-panel h3 { color: #fff; font-size: 1.3rem; font-weight: 700; margin-bottom: .5rem; }
  .token-panel > p { color: #94a3b8; font-size: .95rem; line-height: 1.7; margin-bottom: 1.5rem; }
  .token-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
  .token-item { background: rgba(15,23,42,.5); border: 1px solid rgba(255,255,255,.06); border-radius: 12px; padding: 1rem; display: flex; align-items: flex-start; gap: .75rem; transition: border-color .3s; }
  .token-item:hover { border-color: rgba(249,115,22,.3); }
  .token-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .85rem; color: #fff; }
  .token-item h5 { color: #fff; font-size: .9rem; font-weight: 700; margin-bottom: .2rem; }
  .token-item p { color: #94a3b8; font-size: .8rem; margin: 0; }
  .token-links { display: flex; gap: 1rem; }
  .token-links a { color: #60a5fa; font-weight: 600; font-size: .9rem; text-decoration: none; }
  .token-links a:hover { color: #93c5fd; }
```

| Field | Value |
|-------|--------|
| **Marker** | `{{-- TOKEN-RESTORE: start — FFM token section CSS (business) --}}` … `{{-- TOKEN-RESTORE: end --}}` |
| **How to restore** | Remove the two `TOKEN-RESTORE` Blade comments so the CSS rules remain in `<style>`. |
| **Note** | Line ~332 still has `.token-grid` in a `@media` grid-reset list. Harmless while the section is hidden; optional to leave as-is. |

---

## 3. Business — FFM Token section (Payment infrastructure)

| Field | Value |
|-------|--------|
| **File** | `resources/views/marketing/business-exact.blade.php` |
| **Lines** | 576–596 |
| **Site location** | `/business` → **Payment infrastructure** / FFM Token band (`#token`) between models and FAQ |
| **Original text (verbatim)** | |

```html
<section class="token-section" id="token">
  <div class="container">
    <div class="token-panel">
      <div class="biz-badge" style="margin-bottom:1rem;">PAYMENT INFRASTRUCTURE</div>
      <h3>FFM Token &#8211; Creator Economics Reimagined</h3>
      <p>FFM Token is the payment infrastructure powering FansFollow, designed to reduce fees and reward creators for their contributions to the ecosystem.</p>
      <div class="token-grid">
        <div class="token-item">…Lower Fees…</div>
        <div class="token-item">…Rewards System…</div>
        <div class="token-item">…Creator Ownership…</div>
        <div class="token-item">…Transparent…</div>
      </div>
      <div class="token-links">
        <!-- see nested LINK-RESTORE items below -->
      </div>
    </div>
  </div>
</section>
```

(Full item HTML is unchanged in the file between the start/end markers.)

| Field | Value |
|-------|--------|
| **Marker** | `{{-- TOKEN-RESTORE: start — FFM Token section (business, Payment infrastructure) --}}` … `{{-- TOKEN-RESTORE: end --}}` |
| **How to restore** | Remove the `TOKEN-RESTORE` start/end comments around the `<section class="token-section" id="token">…</section>` block. |

### 3a. Nested — FFM Token outbound links (earlier session)

| Field | Value |
|-------|--------|
| **File** | `resources/views/marketing/business-exact.blade.php` |
| **Lines** | 590–591 (inside section 3) |
| **Site location** | `/business` → FFM Token section → `.token-links` |
| **Original text (verbatim)** | |

```html
<!-- FFM-TOKEN-LINK-RESTORE: <a href="https://ffmtoken.com/" target="_blank" rel="noopener">Visit FFM Token →</a> -->
<!-- FFM-TOKEN-LINK-RESTORE: <a href="https://ffmtoken.com/" target="_blank" rel="noopener">View Documentation →</a> -->
```

| Field | Value |
|-------|--------|
| **How to restore** | After restoring section 3, replace each line with the inner `<a …>…</a>` (or strip the `<!-- FFM-TOKEN-LINK-RESTORE: ` prefix and ` -->` suffix). |

---

## 4. Business — FFM Token FAQ item

| Field | Value |
|-------|--------|
| **File** | `resources/views/marketing/business-exact.blade.php` |
| **Lines** | 606–608 |
| **Site location** | `/business` → **Common questions** FAQ grid |
| **Original text (verbatim)** | |

```html
<div class="faq-item"><div class="faq-q" onclick="this.parentElement.classList.toggle('open')">What is the FFM Token?<span class="faq-chevron">&#9662;</span></div><div class="faq-a">FFM Token is our payment infrastructure designed to reduce transaction fees and reward creators. We can discuss how it integrates with partnership models during your call.</div></div>
```

| Field | Value |
|-------|--------|
| **Marker** | `{{-- TOKEN-RESTORE: start — FFM Token FAQ (business) --}}` … `{{-- TOKEN-RESTORE: end --}}` |
| **Earlier marker** | Was `<!-- FFM-TOKEN-FAQ-RESTORE: … -->` |
| **How to restore** | Remove the `TOKEN-RESTORE` Blade comments; keep the `div.faq-item` markup. |

---

## 5. Preview mockup — Token + Presale footer links

| Field | Value |
|-------|--------|
| **File** | `public/preview-home.html` |
| **Lines** | 1859–1862 |
| **Site location** | Static mockup preview (`preview-home.html`) footer links (not the live Laravel marketing shell) |
| **Original text (verbatim)** | |

```html
<a href='/business#token' style='font-size: .9rem;'>Token Ecosystem</a>
<a href='/business#presale' style='font-size: .9rem;'>Presale Info</a>
```

| Field | Value |
|-------|--------|
| **Marker** | `<!-- TOKEN-RESTORE: start — Token + Presale footer links (preview-home mockup) -->` … `<!-- TOKEN-RESTORE: end -->` |
| **Earlier markers** | `<!-- TOKEN-LINK-RESTORE: … -->` and `<!-- PRESALE-LINK-RESTORE: … -->` (converted to the start/end pair) |
| **How to restore** | Remove the HTML `TOKEN-RESTORE` comments around the two `<a>` tags. Re-enable `/business#presale` content if/when a pre-sale section is added to the business page. |

---

## Not hidden (intentionally)

| Item | Why |
|------|-----|
| Footer / marketing copy **BTC / ETH / USDT / SOL accepted** | Crypto **payments**, not FFM token |
| `csrf-token` meta tags | CSRF, unrelated |
| Password-reset tokens, `remember_token`, shop `download_token` | Auth / commerce tokens, unrelated |
| Password-reset tests (`token` fields) | Unrelated |

---

## Global restore checklist

1. `/for-creators` — remove `TOKEN-RESTORE` comments around the reward-tokens `div` (item 1).
2. `/business` — remove `TOKEN-RESTORE` comments around CSS (item 2) and the `#token` section (item 3).
3. `/business` — unwrap `FFM-TOKEN-LINK-RESTORE` anchors (item 3a).
4. `/business` — remove `TOKEN-RESTORE` comments around the FAQ row (item 4).
5. Optional mockup — unwrap `preview-home.html` footer links (item 5).
6. Shared footer — unwrap the recovered **Advanced** column (item 6).
6. If a pre-sale page/section is added later, link `Presale Info` → that URL and document it here.


---

## 6. Shared footer — Advanced column (recovered from git history)

| Field | Value |
|-------|--------|
| **File** | `resources/views/partials/footer.blade.php` |
| **Lines** | after Coming Soon column (~lines 32–39) |
| **Site location** | Every marketing page footer (shared partial) → fourth column, labeled **Advanced** |
| **History** | Present as live links in `5c19364` and earlier marketing footers. In `70fbdfb` the two links were commented (`TOKEN-LINK-RESTORE` / `PRESALE-LINK-RESTORE`) and the heading was renamed to **Coming Soon**. When `35c3bbe` replaced the duplicate page footers with `partials/footer.blade.php`, those hidden comments were **dropped** and were not on the shared footer until this recovery. |
| **Original text (verbatim)** | |

```html
<div class="footer-links">
  <h3 style="font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: .75rem;">Advanced</h3>
  <a href='/business#token' style='font-size: .9rem;'>Token Ecosystem</a>
  <a href='/business#presale' style='font-size: .9rem;'>Presale Info</a>
</div>
```

| Field | Value |
|-------|--------|
| **Marker** | `{{-- TOKEN-RESTORE: start — Advanced footer column (recovered from pre-35c3bbe marketing footers; hidden in 70fbdfb then dropped when shared footer replaced duplicates) --}}` … `{{-- TOKEN-RESTORE: end --}}` |
| **How to restore** | Remove the two `TOKEN-RESTORE` Blade comments around the `div.footer-links` Advanced block. The visible **Coming Soon** column (Creator Competitions, Gym Monster, Mini Leagues, Mobile App) stays as-is. |
| **Headers** | No token / presale / Advanced items were found in any historical `partials/header` or `partials/nav`. |

## Search scope (full codebase)

Searched: `resources/` (views + Blade), `public/` (HTML, CSS, JS), `app/` (controllers, models, services), `config/`, `database/` (seeders, migrations), `routes/`, `tools/`, `tests/`, `docs/`.

**Hits outside this inventory:** none for FFM token / reward token / tokenomics / pre-sale  
(unrelated `csrf-token`, password-reset `token`, `remember_token`, shop `download_token` remain in the product as designed).

**Tools note:** `tools/emoji-to-entity.php` and `tools/fix-mojibake.php` used to map mojibake to `&#127912;` (palette) while commenting it as the clapper; that entity is now `&#127916;` (🎬) for Movie Casting. Not FFM-token content.
