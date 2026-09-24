@extends('layouts.app')
@section('title', 'My QR code')

@push('head')
<style>
  /* Print-ready QR: only the card is printed, code stays large */
  @media print {
    body * { visibility: hidden !important; }
    #qr-print-card, #qr-print-card * { visibility: visible !important; }
    #qr-print-card {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      box-shadow: none !important;
      border: none !important;
    }
    #qr-box {
      width: 320px !important;
      height: 320px !important;
      margin: 0 auto !important;
    }
    #qr-box img, #qr-box canvas {
      width: 320px !important;
      height: 320px !important;
    }
  }
  #qr-box {
    width: 300px;
    height: 300px;
    margin: 0 auto;
  }
  #qr-box img, #qr-box canvas {
    width: 100% !important;
    height: 100% !important;
    display: block;
    image-rendering: pixelated;
  }
  #qr-fallback {
    font-family: ui-monospace, monospace;
    font-size: 11px;
    word-break: break-all;
  }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">In-person QR signup</h1>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Back to studio</a>
</div>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card card-ffm p-4 text-center" id="qr-print-card">
            <div id="qr-box" class="bg-white p-3 rounded-3 d-inline-block mx-auto" aria-label="QR code to join {{ auth()->user()->username }}">
                <div class="text-dark small mb-2">Scan to join {{ auth()->user()->username }}</div>
                <div id="qr-canvas-wrap" class="mx-auto" style="width:260px;height:260px;"></div>
                <div id="qr-fallback" class="text-dark mt-2">{{ $link->url() }}</div>
            </div>
            <p class="small text-secondary mt-3">Print this or show it on your phone at the gym, event, or meet-and-greet.</p>
            <button class="btn btn-ffm" type="button" onclick="window.print()">Print / save PDF</button>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card card-ffm p-4">
            <h2 class="h6 text-secondary">Join link</h2>
            <code class="d-block mb-3" id="join-url">{{ $link->url() }}</code>
            <button class="btn btn-outline-primary btn-sm mb-3" type="button" id="copy-join-url">Copy link</button>
            <div class="row text-center">
                <div class="col-6">
                    <div class="fs-3 fw-bold">{{ $stats['scans'] }}</div>
                    <div class="small text-secondary">Scans</div>
                </div>
                <div class="col-6">
                    <div class="fs-3 fw-bold">{{ $stats['signups'] }}</div>
                    <div class="small text-secondary">Signups</div>
                </div>
            </div>
            <p class="small text-secondary mt-3 mb-0">New signups from this QR are attributed to you and auto-follow (default on).</p>
        </div>
    </div>
</div>

<script src="{{ asset('js/qrcode.min.js') }}?v=qr2"></script>
<script>
(function () {
  var url = @json($link->url());
  var box = document.getElementById('qr-canvas-wrap');
  var fallback = document.getElementById('qr-fallback');
  if (fallback) fallback.textContent = url;

  function showFail() {
    if (fallback) {
      fallback.style.display = 'block';
      fallback.innerHTML = '<strong>QR image unavailable</strong><br>Copy this link instead:<br>' + url;
    }
    console.warn('QR library missing or failed — showing URL fallback only');
  }

  if (!box || !window.QRCode) {
    showFail();
    return;
  }

  try {
    box.innerHTML = '';
    // Print-friendly: high contrast, ECC H (scannable when printed small)
    new QRCode(box, {
      text: url,
      width: 260,
      height: 260,
      colorDark: '#000000',
      colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.H
    });
    // qrcode.js may paint on canvas or img depending on browser
    setTimeout(function () {
      var img = box.querySelector('img');
      var canvas = box.querySelector('canvas');
      if (img) { img.id = 'qr-image'; img.alt = 'QR code for ' + url; }
      if (canvas) { canvas.id = 'qr-canvas'; canvas.setAttribute('aria-label', 'QR code for ' + url); }
      if (!img && !canvas) showFail();
    }, 50);
  } catch (e) {
    showFail();
    console.error('QR render error', e);
  }

  var copyBtn = document.getElementById('copy-join-url');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function () {
          copyBtn.textContent = 'Copied!';
          setTimeout(function () { copyBtn.textContent = 'Copy link'; }, 1500);
        });
      }
    });
  }
})();
</script>
@endsection
