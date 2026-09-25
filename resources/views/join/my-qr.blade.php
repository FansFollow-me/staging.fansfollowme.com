@extends('layouts.app')
@section('title', 'My QR code')

@php
    $me = auth()->user();
    $avatarUrl = $me->profile?->avatar_path ? asset($me->profile->avatar_path) : '/public/logo-monogram.png';
    $displayName = $me->displayName();
    $username = $me->username;
@endphp

@push('head')
<style>
  .qr-hero-card {
    background: #ffffff;
    color: #0b0f1a;
    border-radius: 20px;
    padding: 1.25rem 1rem 1.5rem;
    text-align: center;
    box-shadow: 0 18px 50px rgba(0,0,0,.28);
  }
  .qr-hero-card .qr-avatar {
    width: 72px; height: 72px; border-radius: 50%; object-fit: cover;
    border: 3px solid #f97316; margin: 0 auto .65rem;
  }
  .qr-hero-card .qr-display-name {
    font-size: 1.35rem; font-weight: 800; color: #0b0f1a; margin: 0;
    line-height: 1.2;
  }
  .qr-hero-card .qr-handle {
    color: #64748b; font-size: .95rem; margin: .15rem 0 .85rem;
  }
  #qr-box {
    width: min(320px, 86vw);
    aspect-ratio: 1;
    margin: 0 auto;
    background: #fff;
    padding: 14px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
  }
  #qr-box img, #qr-box canvas {
    width: 100% !important;
    height: 100% !important;
    display: block;
    image-rendering: pixelated;
    background: #fff;
    border-radius: 4px;
  }
  .qr-tagline {
    margin: .95rem 0 0;
    font-weight: 700;
    color: #0b0f1a;
    font-size: 1.05rem;
  }
  .qr-shortlink {
    margin: .35rem 0 0;
    color: #64748b;
    font-size: .82rem;
    word-break: break-all;
    font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  }
  .qr-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .65rem;
    margin-top: 1rem;
  }
  .qr-actions .btn { min-height: 48px; font-weight: 700; }
  .qr-actions .btn-span { grid-column: 1 / -1; }
  .qr-stats-box {
    background: rgba(15,23,42,.55);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px;
    padding: 1.15rem;
  }
  .qr-stats-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: .75rem;
  }
  .qr-stat {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: 12px;
    padding: .85rem .75rem;
    text-align: center;
  }
  .qr-stat .num { font-size: 1.55rem; font-weight: 800; color: #fff; line-height: 1.1; }
  .qr-stat .lbl { font-size: .78rem; color: #94a3b8; margin-top: .2rem; }
  #qr-fullscreen {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: #ffffff;
    color: #0b0f1a;
    padding: 1.25rem;
    overflow: auto;
    text-align: center;
    cursor: pointer;
  }
  #qr-fullscreen.is-open { display: flex; flex-direction: column; align-items: center; justify-content: center; }
  #qr-fullscreen .fs-close {
    position: absolute; top: 12px; right: 12px;
    width: 44px; height: 44px; border-radius: 999px;
    border: 1px solid #d1d5db; background: #fff; color: #0b0f1a;
    font-size: 1.4rem; line-height: 1; cursor: pointer;
  }
  #qr-fullscreen .fs-avatar {
    width: 84px; height: 84px; border-radius: 50%; object-fit: cover;
    border: 3px solid #f97316; margin-bottom: .75rem;
  }
  #qr-fullscreen .fs-name { font-size: clamp(1.5rem, 5vw, 2.25rem); font-weight: 800; margin: 0; }
  #qr-fullscreen .fs-handle { color: #64748b; font-size: 1.15rem; margin: .25rem 0 1rem; }
  #qr-fullscreen #fs-qr-wrap {
    width: min(82vw, 520px);
    aspect-ratio: 1;
    margin: 0 auto;
    background: #fff;
    padding: 18px;
    border-radius: 18px;
    border: 2px solid #e5e7eb;
  }
  #qr-fullscreen #fs-qr-wrap img, #qr-fullscreen #fs-qr-wrap canvas {
    width: 100% !important; height: 100% !important; display: block; image-rendering: pixelated;
  }
  #qr-fullscreen .fs-tag {
    margin-top: 1.15rem;
    font-size: clamp(1.15rem, 4vw, 1.65rem);
    font-weight: 800;
  }
  #qr-poster-stage {
    position: absolute; left: -10000px; top: 0;
    width: 1240px; height: 1754px;
    background: #fff;
    overflow: hidden;
  }
  @media (max-width: 576px) {
    .qr-actions { grid-template-columns: 1fr; }
    .qr-actions .btn-span { grid-column: auto; }
  }
</style>
@endpush

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h1 class="h3 mb-0">My QR Code</h1>
        <p class="text-secondary small mb-0">Show this at events so fans can follow you instantly.</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Back to studio</a>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="qr-hero-card" id="qr-print-card">
            <img class="qr-avatar" src="{{ $avatarUrl }}" alt="{{ $displayName }}">
            <h2 class="qr-display-name">{{ $displayName }}</h2>
            <div class="qr-handle">{{ '@'.$username }}</div>
            <div id="qr-box" aria-label="QR code for {{ $username }}">
                <div id="qr-canvas-wrap"></div>
            </div>
            <p class="qr-tagline">Scan to follow me on FansFollow.me</p>
            <p class="qr-shortlink" id="qr-shortlink">{{ $link->url() }}</p>
            <div class="qr-actions">
                <button type="button" class="btn btn-ffm" id="btn-fullscreen">
                    <i class="fas fa-expand"></i> Show Full Screen
                </button>
                <button type="button" class="btn btn-outline-primary" id="btn-download-png">
                    <i class="fas fa-download"></i> Download QR (PNG)
                </button>
                <button type="button" class="btn btn-outline-primary" id="btn-download-poster">
                    <i class="fas fa-file-pdf"></i> Download Poster (PDF)
                </button>
                <button type="button" class="btn btn-outline-primary" id="btn-copy-link">
                    <i class="fas fa-copy"></i> <span>Copy Link</span>
                </button>
                <button type="button" class="btn btn-ffm btn-span" id="btn-share">
                    <i class="fas fa-share-nodes"></i> Share
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="qr-stats-box">
            <h2 class="h5 text-white mb-3">Stats</h2>
            <div class="qr-stats-grid mb-3">
                <div class="qr-stat">
                    <div class="num">{{ number_format($stats['scans_30d']) }}</div>
                    <div class="lbl">Scans · Last 30 days</div>
                </div>
                <div class="qr-stat">
                    <div class="num">{{ number_format($stats['signups_30d']) }}</div>
                    <div class="lbl">Sign-ups · Last 30 days</div>
                </div>
                <div class="qr-stat">
                    <div class="num">{{ number_format($stats['scans']) }}</div>
                    <div class="lbl">Scans · All time</div>
                </div>
                <div class="qr-stat">
                    <div class="num">{{ number_format($stats['signups']) }}</div>
                    <div class="lbl">Sign-ups · All time</div>
                </div>
            </div>
            <h2 class="h6 text-white">Join link</h2>
            <code class="d-block mb-3 text-break">{{ $link->url() }}</code>
            <p class="small text-secondary mb-0">Every scan is counted (no personal data stored). New sign-ups from this QR are attributed to you and auto-follow (default on).</p>
        </div>
    </div>
</div>

<div id="qr-fullscreen" role="dialog" aria-modal="true" aria-label="QR code full screen">
    <button type="button" class="fs-close" id="fs-close" aria-label="Close">&times;</button>
    <img class="fs-avatar" src="{{ $avatarUrl }}" alt="">
    <h2 class="fs-name">{{ $displayName }}</h2>
    <div class="fs-handle">{{ '@'.$username }}</div>
    <div id="fs-qr-wrap"></div>
    <div class="fs-tag">Scan to follow me on FansFollow.me</div>
</div>

<div id="qr-poster-stage" aria-hidden="true"></div>

<script src="{{ asset('js/qrcode.min.js') }}?v=qr3"></script>
<script>
(function () {
  var url = @json($link->url());
  var displayName = @json($displayName);
  var username = @json($username);
  var avatarUrl = @json($avatarUrl);
  var box = document.getElementById('qr-canvas-wrap');
  var fallback = document.getElementById('qr-shortlink');

  function renderQr(el, size) {
    if (!el || !window.QRCode) return null;
    el.innerHTML = '';
    new QRCode(el, {
      text: url,
      width: size,
      height: size,
      colorDark: '#000000',
      colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.H
    });
    return el;
  }

  function qrCanvasSource() {
    var canvas = box && box.querySelector('canvas');
    if (canvas) return canvas;
    var img = box && box.querySelector('img');
    return img || null;
  }

  function waitForQr(cb) {
    var tries = 0;
    (function tick() {
      var src = qrCanvasSource();
      if (src) { cb(src); return; }
      if (++tries > 40) { cb(null); return; }
      setTimeout(tick, 50);
    })();
  }

  function copyLink(btn, labelEl) {
    var done = function () {
      if (!labelEl) return;
      var prev = labelEl.textContent;
      labelEl.textContent = 'Copied!';
      setTimeout(function () { labelEl.textContent = prev; }, 1500);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(done).catch(function () {
        window.prompt('Copy this link:', url);
      });
    } else {
      window.prompt('Copy this link:', url);
    }
  }

  // Primary QR (high contrast, white quiet zone via padding)
  renderQr(box, 288);
  if (!window.QRCode && fallback) {
    fallback.innerHTML = '<strong>QR image unavailable</strong><br>Copy this link instead:<br>' + url;
  }

  // Copy Link
  var copyBtn = document.getElementById('btn-copy-link');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      copyLink(copyBtn, copyBtn.querySelector('span'));
    });
  }

  // Share (Web Share API with copy fallback)
  var shareBtn = document.getElementById('btn-share');
  if (shareBtn) {
    shareBtn.addEventListener('click', function () {
      var payload = {
        title: displayName + ' on FansFollow.me',
        text: 'Scan to follow me on FansFollow.me',
        url: url
      };
      if (navigator.share) {
        navigator.share(payload).catch(function () {});
      } else {
        copyLink(shareBtn, null);
        var span = shareBtn;
        var prev = span.innerHTML;
        span.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(function () { span.innerHTML = prev; }, 1500);
      }
    });
  }

  // Full screen
  var fs = document.getElementById('qr-fullscreen');
  var fsWrap = document.getElementById('fs-qr-wrap');
  var openFs = function () {
    if (!fs) return;
    fs.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    renderQr(fsWrap, 520);
  };
  var closeFs = function () {
    if (!fs) return;
    fs.classList.remove('is-open');
    document.body.style.overflow = '';
    if (fsWrap) fsWrap.innerHTML = '';
  };
  var fsBtn = document.getElementById('btn-fullscreen');
  if (fsBtn) fsBtn.addEventListener('click', openFs);
  var fsClose = document.getElementById('fs-close');
  if (fsClose) fsClose.addEventListener('click', function (e) { e.stopPropagation(); closeFs(); });
  if (fs) fs.addEventListener('click', closeFs);

  // Download high-res PNG (1024x1024)
  var pngBtn = document.getElementById('btn-download-png');
  if (pngBtn) {
    pngBtn.addEventListener('click', function () {
      var tmp = document.createElement('div');
      tmp.style.position = 'absolute';
      tmp.style.left = '-10000px';
      document.body.appendChild(tmp);
      renderQr(tmp, 1024);
      setTimeout(function () {
        var src = tmp.querySelector('canvas') || tmp.querySelector('img');
        var out = document.createElement('canvas');
        out.width = 1024;
        out.height = 1024;
        var ctx = out.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, 1024, 1024);
        // white margin around modules
        var pad = 64;
        if (src) {
          try {
            if (src.tagName === 'CANVAS') {
              ctx.drawImage(src, pad, pad, 1024 - pad * 2, 1024 - pad * 2);
            } else {
              // img may need a beat
              var im = new Image();
              im.onload = function () {
                ctx.drawImage(im, pad, pad, 1024 - pad * 2, 1024 - pad * 2);
                triggerDownload(out.toDataURL('image/png'), 'qr-' + username + '.png');
              };
              im.src = src.src;
              document.body.removeChild(tmp);
              return;
            }
          } catch (e) {
            console.error(e);
          }
        }
        triggerDownload(out.toDataURL('image/png'), 'qr-' + username + '.png');
        document.body.removeChild(tmp);
      }, 80);
    });
  }

  function triggerDownload(href, filename) {
    var a = document.createElement('a');
    a.href = href;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
  }

  // Minimal single-page PDF with embedded JPEG (A4 poster)
  function buildPdfFromJpeg(jpegBytes, width, height) {
    // PDF user-space A4: 595.28 x 841.89 pt
    var pageW = 595.28;
    var pageH = 841.89;
    var enc = new TextEncoder();
    var chunks = [];
    var offsets = [0];
    function push(str) {
      var b = typeof str === 'string' ? enc.encode(str) : str;
      chunks.push(b);
      return b.length;
    }
    function pushBytes(arr) {
      chunks.push(arr);
      return arr.length;
    }
    var length = 0;
    function xrefPos() { return length; }

    length += push('%PDF-1.4\n');
    offsets[1] = length;
    length += push('1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n');
    offsets[2] = length;
    length += push('2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n');
    offsets[3] = length;
    length += push('3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' + pageW + ' ' + pageH + '] /Resources << /XObject << /Im0 4 0 R >> /ProcSet [/PDF /ImageC] >> /Contents 5 0 R >>\nendobj\n');
    offsets[4] = length;
    var imgDict = '4 0 obj\n<< /Type /XObject /Subtype /Image /Width ' + width + ' /Height ' + height +
      ' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ' + jpegBytes.length + ' >>\nstream\n';
    length += push(imgDict);
    length += pushBytes(jpegBytes);
    length += push('\nendstream\nendobj\n');
    offsets[5] = length;
    var content = 'q ' + pageW + ' 0 0 ' + pageH + ' 0 0 cm /Im0 Do Q\n';
    var contentObj = '5 0 obj\n<< /Length ' + content.length + ' >>\nstream\n' + content + 'endstream\nendobj\n';
    length += push(contentObj);
    var startxref = length;
    var xref = 'xref\n0 6\n0000000000 65535 f \n';
    for (var i = 1; i <= 5; i++) {
      xref += ('0000000000' + offsets[i]).slice(-10) + ' 00000 n \n';
    }
    xref += 'trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n' + startxref + '\n%%EOF\n';
    push(xref);

    var total = 0;
    chunks.forEach(function (c) { total += c.length; });
    var out = new Uint8Array(total);
    var pos = 0;
    chunks.forEach(function (c) {
      out.set(c, pos);
      pos += c.length;
    });
    return new Blob([out], { type: 'application/pdf' });
  }

  function dataUrlToBytes(dataUrl) {
    var base64 = dataUrl.split(',')[1];
    var bin = atob(base64);
    var arr = new Uint8Array(bin.length);
    for (var i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
    return arr;
  }

  function drawPosterCanvas(cb) {
    var W = 1240;
    var H = 1754;
    var canvas = document.createElement('canvas');
    canvas.width = W;
    canvas.height = H;
    var ctx = canvas.getContext('2d');

    // Background
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, W, H);

    // Top brand bar
    var grad = ctx.createLinearGradient(0, 0, W, 0);
    grad.addColorStop(0, '#f97316');
    grad.addColorStop(0.5, '#ec4899');
    grad.addColorStop(1, '#a855f7');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, W, 28);

    // Logo
    var logo = new Image();
    logo.onload = function () {
      try {
        var lw = 280;
        var lh = logo.height * (lw / logo.width);
        ctx.drawImage(logo, (W - lw) / 2, 70, lw, lh);
      } catch (e) {}
      drawRest();
    };
    logo.onerror = function () {
      ctx.fillStyle = '#0b0f1a';
      ctx.font = 'bold 64px Inter, Arial, sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText('FansFollow.me', W / 2, 140);
      drawRest();
    };
    logo.src = '/public/logo-monogram.png';

    function drawRest() {
      // Avatar
      var av = new Image();
      av.onload = function () {
        var size = 180;
        var x = (W - size) / 2;
        var y = 220;
        ctx.save();
        ctx.beginPath();
        ctx.arc(x + size / 2, y + size / 2, size / 2, 0, Math.PI * 2);
        ctx.closePath();
        ctx.clip();
        ctx.drawImage(av, x, y, size, size);
        ctx.restore();
        ctx.lineWidth = 8;
        ctx.strokeStyle = '#f97316';
        ctx.beginPath();
        ctx.arc(x + size / 2, y + size / 2, size / 2, 0, Math.PI * 2);
        ctx.stroke();
        drawTextAndQr();
      };
      av.onerror = function () { drawTextAndQr(); };
      av.src = avatarUrl;
    }

    function drawTextAndQr() {
      ctx.fillStyle = '#0b0f1a';
      ctx.textAlign = 'center';
      ctx.font = 'bold 56px Inter, Arial, sans-serif';
      ctx.fillText(displayName, W / 2, 470);
      ctx.fillStyle = '#64748b';
      ctx.font = '40px Inter, Arial, sans-serif';
      ctx.fillText('@' + username, W / 2, 530);

      // QR area
      var qrSize = 720;
      var qx = (W - qrSize) / 2;
      var qy = 580;
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(qx - 24, qy - 24, qrSize + 48, qrSize + 48);
      ctx.strokeStyle = '#e5e7eb';
      ctx.lineWidth = 4;
      ctx.strokeRect(qx - 24, qy - 24, qrSize + 48, qrSize + 48);

      // Render high-res QR into temp then draw
      var tmp = document.createElement('div');
      tmp.style.position = 'absolute';
      tmp.style.left = '-10000px';
      document.body.appendChild(tmp);
      renderQr(tmp, qrSize);
      setTimeout(function () {
        var src = tmp.querySelector('canvas') || tmp.querySelector('img');
        var finish = function () {
          document.body.removeChild(tmp);
          ctx.fillStyle = '#0b0f1a';
          ctx.font = 'bold 44px Inter, Arial, sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText('Scan to follow me on FansFollow.me', W / 2, 1420);
          ctx.fillStyle = '#64748b';
          ctx.font = '32px ui-monospace, Menlo, monospace';
          ctx.fillText(url, W / 2, 1485);
          ctx.fillStyle = '#f97316';
          ctx.fillRect(0, H - 28, W, 28);
          cb(canvas);
        };
        if (!src) {
          ctx.fillStyle = '#0b0f1a';
          ctx.font = '28px Inter, Arial, sans-serif';
          ctx.fillText('QR unavailable — use link below', W / 2, qy + qrSize / 2);
          finish();
          return;
        }
        try {
          if (src.tagName === 'CANVAS') {
            ctx.drawImage(src, qx, qy, qrSize, qrSize);
            finish();
          } else {
            var im = new Image();
            im.onload = function () {
              ctx.drawImage(im, qx, qy, qrSize, qrSize);
              finish();
            };
            im.onerror = finish;
            im.src = src.src;
          }
        } catch (e) {
          finish();
        }
      }, 100);
    }
  }

  // Poster PDF
  var posterBtn = document.getElementById('btn-download-poster');
  if (posterBtn) {
    posterBtn.addEventListener('click', function () {
      posterBtn.disabled = true;
      var prev = posterBtn.innerHTML;
      posterBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Building…';
      drawPosterCanvas(function (canvas) {
        try {
          var jpegData = canvas.toDataURL('image/jpeg', 0.92);
          var bytes = dataUrlToBytes(jpegData);
          var blob = buildPdfFromJpeg(bytes, canvas.width, canvas.height);
          var link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'ffm-poster-' + username + '.pdf';
          document.body.appendChild(link);
          link.click();
          setTimeout(function () {
            URL.revokeObjectURL(link.href);
            link.remove();
          }, 1000);
        } catch (e) {
          console.error(e);
          window.print();
        }
        posterBtn.disabled = false;
        posterBtn.innerHTML = prev;
      });
    });
  }
})();
</script>
@endsection
