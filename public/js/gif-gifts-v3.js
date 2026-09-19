/**
 * FFM Gift FX V3 — SugarBook-class
 * Illustrated SVG products + multi-stage choreography + Web Audio + fever combos.
 */
(function (global) {
  'use strict';

  global.GIFT_FX_ENGINE = 'v3';
  var ACTIVE = false;
  var AUDIO = null;
  var COMBO = { key: null, count: 0, timer: null };
  var FEVER = 0; // 0..1 intensity from recent gifts

  /* ── Colors per gift ── */
  var GIFT = {
    high_five:        { glow: '#f97316', accent: '#fdba74', spark: '#fff7ed', scene: 'impact' },
    rose:             { glow: '#f43f5e', accent: '#fb7185', spark: '#ffe4e6', scene: 'rose' },
    beer:             { glow: '#f59e0b', accent: '#fbbf24', spark: '#fef3c7', scene: 'beer' },
    wine:             { glow: '#be123c', accent: '#fb7185', spark: '#ffe4e6', scene: 'wine' },
    champagne:        { glow: '#facc15', accent: '#fde68a', spark: '#fffbeb', scene: 'champagne' },
    bouquet:          { glow: '#ec4899', accent: '#f9a8d4', spark: '#fdf2f8', scene: 'petals' },
    sunglasses:       { glow: '#38bdf8', accent: '#7dd3fc', spark: '#e0f2fe', scene: 'shine' },
    shoes:            { glow: '#a855f7', accent: '#c4b5fd', spark: '#f3e8ff', scene: 'impact' },
    purse:            { glow: '#ec4899', accent: '#f9a8d4', spark: '#fdf2f8', scene: 'shine' },
    home_gym:         { glow: '#22c55e', accent: '#86efac', spark: '#dcfce7', scene: 'slam' },
    designer_bag:     { glow: '#f59e0b', accent: '#fde68a', spark: '#fffbeb', scene: 'shine' },
    diamond_bracelet: { glow: '#60a5fa', accent: '#e0e7ff', spark: '#ffffff', scene: 'diamond' },
    luxury_watch:     { glow: '#eab308', accent: '#fef08a', spark: '#fffbeb', scene: 'watch' },
    luxury_holiday:   { glow: '#06b6d4', accent: '#67e8f9', spark: '#ecfeff', scene: 'flight' },
    sports_car:       { glow: '#ef4444', accent: '#fca5a5', spark: '#fee2e2', scene: 'car' },
    mystery_box:      { glow: '#fbbf24', accent: '#fde68a', spark: '#fffbeb', scene: 'mystery' },
  };

  /* ── Illustrated SVG products (no emoji for tier 5+) ── */
  var SVG = {};

  SVG.sports_car = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 240 120" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="carBody" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#f87171"/><stop offset="55%" stop-color="#ef4444"/><stop offset="100%" stop-color="#991b1b"/></linearGradient>' +
      '<linearGradient id="carGlass" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#e0f2fe"/><stop offset="100%" stop-color="#0ea5e9"/></linearGradient></defs>' +
      '<ellipse cx="120" cy="108" rx="90" ry="8" fill="rgba(0,0,0,.35)"/>' +
      '<path d="M28 78 C40 48 70 40 100 38 C130 36 160 42 185 55 C200 62 210 70 215 78 L210 88 L30 88 Z" fill="url(#carBody)" stroke="#7f1d1d" stroke-width="1.5"/>' +
      '<path d="M75 42 C95 28 140 28 165 48 L155 55 L85 55 Z" fill="url(#carGlass)" opacity=".9"/>' +
      '<rect x="40" y="72" width="18" height="8" rx="2" fill="#fef08a"/>' +
      '<rect x="190" y="72" width="14" height="8" rx="2" fill="#fecaca"/>' +
      '<circle cx="70" cy="88" r="14" fill="#1e293b" stroke="#475569" stroke-width="3"/><circle cx="70" cy="88" r="6" fill="#94a3b8"/>' +
      '<circle cx="175" cy="88" r="14" fill="#1e293b" stroke="#475569" stroke-width="3"/><circle cx="175" cy="88" r="6" fill="#94a3b8"/>' +
      '<path d="M30 78 L18 70" stroke="'+c.accent+'" stroke-width="3" stroke-linecap="round" class="gif-speed-line"/>' +
      '<path d="M28 84 L10 82" stroke="'+c.accent+'" stroke-width="2" stroke-linecap="round" class="gif-speed-line" style="animation-delay:.1s"/>' +
      '</svg>';
  };

  SVG.diamond_bracelet = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 200 160" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="gem" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ffffff"/><stop offset="40%" stop-color="#93c5fd"/><stop offset="100%" stop-color="#1d4ed8"/></linearGradient>' +
      '<linearGradient id="chain" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#fde68a"/><stop offset="50%" stop-color="#f59e0b"/><stop offset="100%" stop-color="#fef3c7"/></linearGradient></defs>' +
      '<path d="M30 90 Q100 130 170 90" fill="none" stroke="url(#chain)" stroke-width="6" stroke-linecap="round"/>' +
      '<path d="M40 88 Q100 120 160 88" fill="none" stroke="#fbbf24" stroke-width="2" opacity=".6"/>' +
      '<g class="gif-gem-main" transform="translate(100 70)">' +
      '<polygon points="0,-38 28,-8 18,28 -18,28 -28,-8" fill="url(#gem)" stroke="#e0e7ff" stroke-width="1.5"/>' +
      '<polygon points="0,-38 12,-8 0,20 -12,-8" fill="#fff" opacity=".35"/>' +
      '<polygon points="-28,-8 0,-20 28,-8 0,8" fill="#bfdbfe" opacity=".5"/>' +
      '</g>' +
      '<circle cx="55" cy="95" r="5" fill="url(#gem)"/><circle cx="145" cy="95" r="5" fill="url(#gem)"/>' +
      '<circle cx="70" cy="105" r="4" fill="#e0e7ff"/><circle cx="130" cy="105" r="4" fill="#e0e7ff"/>' +
      '</svg>';
  };

  SVG.luxury_watch = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 180 200" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><radialGradient id="dial" cx="50%" cy="40%"><stop offset="0%" stop-color="#1e293b"/><stop offset="100%" stop-color="#020617"/></radialGradient>' +
      '<linearGradient id="bezel" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#fef3c7"/><stop offset="50%" stop-color="#f59e0b"/><stop offset="100%" stop-color="#d97706"/></linearGradient></defs>' +
      '<rect x="70" y="8" width="40" height="36" rx="6" fill="url(#bezel)"/>' +
      '<rect x="70" y="156" width="40" height="36" rx="6" fill="url(#bezel)"/>' +
      '<circle cx="90" cy="100" r="72" fill="url(#bezel)"/>' +
      '<circle cx="90" cy="100" r="62" fill="url(#dial)" stroke="#fbbf24" stroke-width="2"/>' +
      '<circle cx="90" cy="100" r="56" fill="none" stroke="#fde68a" stroke-width="1" opacity=".4"/>' +
      '<g class="gif-watch-hands" transform="translate(90 100)">' +
      '<line x1="0" y1="0" x2="0" y2="-32" stroke="#f8fafc" stroke-width="3" stroke-linecap="round"/>' +
      '<line x1="0" y1="0" x2="22" y2="10" stroke="#f8fafc" stroke-width="2.5" stroke-linecap="round"/>' +
      '<line x1="0" y1="0" x2="-12" y2="18" stroke="#f43f5e" stroke-width="1.5" stroke-linecap="round" class="gif-sec-hand"/>' +
      '<circle cx="0" cy="0" r="4" fill="#fbbf24"/>' +
      '</g>' +
      '<circle cx="90" cy="38" r="4" fill="#fde68a"/><circle cx="90" cy="162" r="4" fill="#fde68a"/>' +
      '<circle cx="38" cy="100" r="4" fill="#fde68a"/><circle cx="142" cy="100" r="4" fill="#fde68a"/>' +
      '</svg>';
  };

  SVG.champagne = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 120 220" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="bottle" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#14532d"/><stop offset="50%" stop-color="#166534"/><stop offset="100%" stop-color="#052e16"/></linearGradient>' +
      '<linearGradient id="foil" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#fde68a"/><stop offset="100%" stop-color="#d97706"/></linearGradient></defs>' +
      '<ellipse cx="60" cy="208" rx="28" ry="6" fill="rgba(0,0,0,.3)"/>' +
      '<path d="M42 70 L42 195 Q42 205 60 205 Q78 205 78 195 L78 70 Z" fill="url(#bottle)"/>' +
      '<path d="M50 30 L50 70 L70 70 L70 30 Q70 22 60 22 Q50 22 50 30 Z" fill="url(#bottle)"/>' +
      '<rect x="48" y="18" width="24" height="14" rx="3" fill="url(#foil)"/>' +
      '<rect x="46" y="28" width="28" height="8" rx="2" fill="#fbbf24"/>' +
      '<rect x="44" y="100" width="32" height="50" rx="4" fill="#fef3c7" opacity=".9"/>' +
      '<text x="60" y="130" text-anchor="middle" font-size="10" font-weight="700" fill="#92400e" font-family="system-ui,sans-serif">FFM</text>' +
      '<g class="gif-cork"><ellipse cx="60" cy="18" rx="10" ry="6" fill="#d6a56c"/></g>' +
      '<g class="gif-spray"></g>' +
      '</svg>';
  };

  SVG.luxury_holiday = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 260 120" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="plane" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#f8fafc"/><stop offset="100%" stop-color="#cbd5e1"/></linearGradient></defs>' +
      '<ellipse cx="130" cy="95" rx="100" ry="8" fill="rgba(0,0,0,.15)"/>' +
      '<path d="M40 70 L180 55 L220 62 L200 72 L80 80 Z" fill="url(#plane)"/>' +
      '<path d="M100 62 L130 30 L150 32 L130 60 Z" fill="#e2e8f0"/>' +
      '<path d="M90 72 L70 100 L95 95 L110 72 Z" fill="#cbd5e1"/>' +
      '<path d="M170 60 L195 40 L205 45 L180 62 Z" fill="#94a3b8"/>' +
      '<circle cx="200" cy="62" r="6" fill="#0ea5e9"/>' +
      '<path class="gif-trail" d="M20 78 Q60 70 100 68" fill="none" stroke="#bae6fd" stroke-width="3" stroke-linecap="round" opacity=".7"/>' +
      '</svg>';
  };

  SVG.home_gym = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 220 140" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="plate" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#4ade80"/><stop offset="100%" stop-color="#15803d"/></linearGradient>' +
      '<linearGradient id="bar" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#94a3b8"/><stop offset="50%" stop-color="#e2e8f0"/><stop offset="100%" stop-color="#64748b"/></linearGradient></defs>' +
      '<rect x="20" y="62" width="180" height="12" rx="4" fill="url(#bar)"/>' +
      '<rect x="28" y="40" width="22" height="56" rx="4" fill="url(#plate)" stroke="#166534" stroke-width="2"/>' +
      '<rect x="55" y="48" width="16" height="40" rx="3" fill="#22c55e" stroke="#15803d" stroke-width="1.5"/>' +
      '<rect x="149" y="48" width="16" height="40" rx="3" fill="#22c55e" stroke="#15803d" stroke-width="1.5"/>' +
      '<rect x="170" y="40" width="22" height="56" rx="4" fill="url(#plate)" stroke="#166534" stroke-width="2"/>' +
      '<circle cx="39" cy="68" r="5" fill="#14532d"/><circle cx="181" cy="68" r="5" fill="#14532d"/>' +
      '<path d="M70 100 L150 100" stroke="#166534" stroke-width="4" stroke-linecap="round" opacity=".4"/>' +
      '</svg>';
  };

  SVG.designer_bag = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 180 160" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="bag" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#fbbf24"/><stop offset="100%" stop-color="#d97706"/></linearGradient></defs>' +
      '<path d="M55 50 Q90 20 125 50" fill="none" stroke="#92400e" stroke-width="6" stroke-linecap="round"/>' +
      '<rect x="35" y="48" width="110" height="90" rx="12" fill="url(#bag)" stroke="#92400e" stroke-width="2"/>' +
      '<rect x="50" y="70" width="80" height="50" rx="8" fill="#fef3c7" opacity=".35"/>' +
      '<circle cx="90" cy="95" r="10" fill="none" stroke="#92400e" stroke-width="3"/>' +
      '<rect x="80" y="48" width="20" height="12" rx="3" fill="#f59e0b"/>' +
      '</svg>';
  };

  SVG.sunglasses = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 220 100" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="lens" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#0ea5e9"/><stop offset="100%" stop-color="#0c4a6e"/></linearGradient></defs>' +
      '<path d="M20 40 L100 40 L110 55 L120 40 L200 40" fill="none" stroke="#1e293b" stroke-width="6" stroke-linecap="round"/>' +
      '<ellipse cx="60" cy="58" rx="38" ry="28" fill="url(#lens)" stroke="#0f172a" stroke-width="3"/>' +
      '<ellipse cx="160" cy="58" rx="38" ry="28" fill="url(#lens)" stroke="#0f172a" stroke-width="3"/>' +
      '<path d="M98 58 L122 58" stroke="#1e293b" stroke-width="5"/>' +
      '<path d="M40 45 L70 70" stroke="#e0f2fe" stroke-width="3" opacity=".5"/>' +
      '<path d="M140 45 L170 70" stroke="#e0f2fe" stroke-width="3" opacity=".5"/>' +
      '</svg>';
  };

  SVG.shoes = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="shoe" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#c4b5fd"/><stop offset="100%" stop-color="#7c3aed"/></linearGradient></defs>' +
      '<path d="M20 85 Q30 50 70 48 L140 55 Q180 60 190 85 L185 95 L25 95 Z" fill="url(#shoe)" stroke="#5b21b6" stroke-width="2"/>' +
      '<path d="M70 48 L90 30 L110 35 L100 50" fill="#a78bfa"/>' +
      '<path d="M40 85 Q90 75 160 85" fill="none" stroke="#ede9fe" stroke-width="3"/>' +
      '<circle cx="55" cy="70" r="4" fill="#fde68a"/><circle cx="75" cy="68" r="4" fill="#fde68a"/>' +
      '</svg>';
  };

  /* fallback pretty orb for gifts without custom SVG */
  SVG.orb = function (c) {
    return '<div class="gif-orb-product" style="background:radial-gradient(circle at 35% 30%, #fff, '+c.glow+' 45%, '+c.accent+' 80%)"></div>';
  };

  function svgFor(key, st) {
    if (SVG[key]) return SVG[key](st);
    return SVG.orb(st);
  }

  /* ── Web Audio ── */
  function audio() {
    if (AUDIO) return AUDIO;
    try {
      var Ctx = global.AudioContext || global.webkitAudioContext;
      if (!Ctx) return null;
      AUDIO = new Ctx();
    } catch (e) { AUDIO = null; }
    return AUDIO;
  }

  function tone(ctx, opts) {
    var t = ctx.currentTime + (opts.delay || 0);
    var osc = ctx.createOscillator();
    var gain = ctx.createGain();
    osc.type = opts.type || 'sine';
    osc.frequency.setValueAtTime(opts.f0 || 440, t);
    if (opts.f1) osc.frequency.exponentialRampToValueAtTime(opts.f1, t + (opts.dur || 0.2));
    gain.gain.setValueAtTime(opts.vol || 0.08, t);
    gain.gain.exponentialRampToValueAtTime(0.001, t + (opts.dur || 0.2));
    osc.connect(gain).connect(ctx.destination);
    osc.start(t);
    osc.stop(t + (opts.dur || 0.2) + 0.05);
  }

  function noiseBurst(ctx, dur, vol, filterFreq) {
    var t = ctx.currentTime;
    var len = Math.floor(ctx.sampleRate * dur);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) data[i] = (Math.random() * 2 - 1) * (1 - i / len);
    var src = ctx.createBufferSource();
    src.buffer = buf;
    var flt = ctx.createBiquadFilter();
    flt.type = 'lowpass';
    flt.frequency.value = filterFreq || 800;
    var g = ctx.createGain();
    g.gain.setValueAtTime(vol || 0.12, t);
    g.gain.exponentialRampToValueAtTime(0.001, t + dur);
    src.connect(flt).connect(g).connect(ctx.destination);
    src.start(t);
  }

  function playSfx(kind) {
    var ctx = audio();
    if (!ctx) return;
    if (ctx.state === 'suspended') { try { ctx.resume(); } catch (e) {} }

    if (kind === 'pop') {
      tone(ctx, { type: 'triangle', f0: 220, f1: 70, dur: 0.22, vol: 0.18 });
      noiseBurst(ctx, 0.2, 0.12, 3500);
      tone(ctx, { type: 'sine', f0: 1200, f1: 1800, dur: 0.1, delay: 0.05, vol: 0.08 });
    } else if (kind === 'chime') {
      tone(ctx, { type: 'sine', f0: 1046, dur: 0.4, vol: 0.07 });
      tone(ctx, { type: 'sine', f0: 1318, dur: 0.45, delay: 0.06, vol: 0.06 });
      tone(ctx, { type: 'sine', f0: 1568, dur: 0.55, delay: 0.12, vol: 0.05 });
    } else if (kind === 'whoosh' || kind === 'engine') {
      engineRev(ctx);
    } else if (kind === 'jet') {
      jetRoar(ctx);
    } else if (kind === 'pour') {
      pourSound(ctx, 2.2);
    } else if (kind === 'boom') {
      tone(ctx, { type: 'sine', f0: 90, f1: 35, dur: 0.7, vol: 0.18 });
      noiseBurst(ctx, 0.5, 0.16, 400);
    } else if (kind === 'tick') {
      tone(ctx, { type: 'square', f0: 1200, dur: 0.04, vol: 0.04 });
    } else if (kind === 'ding') {
      tone(ctx, { type: 'triangle', f0: 660, f1: 990, dur: 0.25, vol: 0.08 });
    } else if (kind === 'legend') {
      tone(ctx, { type: 'sine', f0: 110, f1: 55, dur: 1.2, vol: 0.16 });
      tone(ctx, { type: 'triangle', f0: 220, f1: 440, dur: 0.8, delay: 0.15, vol: 0.08 });
      tone(ctx, { type: 'sine', f0: 880, dur: 0.6, delay: 0.4, vol: 0.07 });
      tone(ctx, { type: 'sine', f0: 1174, dur: 0.7, delay: 0.55, vol: 0.06 });
      noiseBurst(ctx, 0.8, 0.12, 600);
    } else if (kind === 'bubbles') {
      for (var b = 0; b < 12; b++) {
        (function (b) {
          setTimeout(function () {
            tone(ctx, { type: 'sine', f0: 400 + Math.random() * 900, f1: 900 + Math.random() * 1200, dur: 0.08, vol: 0.03 });
          }, b * 70 + Math.random() * 40);
        })(b);
      }
    }
  }

  /* Supercar-style multi-cylinder rev (no brand names) */
  function engineRev(ctx) {
    var t0 = ctx.currentTime;
    var master = ctx.createGain();
    master.gain.setValueAtTime(0.0001, t0);
    master.gain.exponentialRampToValueAtTime(0.22, t0 + 0.08);
    master.gain.setValueAtTime(0.22, t0 + 1.1);
    master.gain.exponentialRampToValueAtTime(0.0001, t0 + 2.4);
    master.connect(ctx.destination);

    // firing order-ish detuned saws
    var freqs = [55, 82.5, 110, 165];
    freqs.forEach(function (f, i) {
      var osc = ctx.createOscillator();
      var g = ctx.createGain();
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(f, t0);
      // idle → redline → drop
      osc.frequency.exponentialRampToValueAtTime(f * 1.8, t0 + 0.15);
      osc.frequency.exponentialRampToValueAtTime(f * 3.2, t0 + 0.55);
      osc.frequency.exponentialRampToValueAtTime(f * 2.4, t0 + 0.9);
      osc.frequency.exponentialRampToValueAtTime(f * 4.2, t0 + 1.35);
      osc.frequency.exponentialRampToValueAtTime(f * 1.2, t0 + 2.1);
      g.gain.value = 0.18 - i * 0.03;
      osc.connect(g).connect(master);
      osc.start(t0);
      osc.stop(t0 + 2.5);
    });

    // exhaust noise
    var len = Math.floor(ctx.sampleRate * 2.4);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) data[i] = (Math.random() * 2 - 1);
    var src = ctx.createBufferSource();
    src.buffer = buf;
    var flt = ctx.createBiquadFilter();
    flt.type = 'lowpass';
    flt.frequency.setValueAtTime(400, t0);
    flt.frequency.exponentialRampToValueAtTime(2200, t0 + 0.6);
    flt.frequency.exponentialRampToValueAtTime(300, t0 + 2.2);
    var ng = ctx.createGain();
    ng.gain.setValueAtTime(0.12, t0);
    ng.gain.exponentialRampToValueAtTime(0.001, t0 + 2.4);
    src.connect(flt).connect(ng).connect(master);
    src.start(t0);

    // turbo whistle
    var w = ctx.createOscillator();
    var wg = ctx.createGain();
    w.type = 'sine';
    w.frequency.setValueAtTime(1800, t0 + 0.2);
    w.frequency.exponentialRampToValueAtTime(4200, t0 + 0.9);
    w.frequency.exponentialRampToValueAtTime(1200, t0 + 1.8);
    wg.gain.setValueAtTime(0.0001, t0 + 0.2);
    wg.gain.exponentialRampToValueAtTime(0.04, t0 + 0.5);
    wg.gain.exponentialRampToValueAtTime(0.0001, t0 + 1.9);
    w.connect(wg).connect(ctx.destination);
    w.start(t0 + 0.15);
    w.stop(t0 + 2.1);
  }

  /* Jet flyby */
  function jetRoar(ctx) {
    var t0 = ctx.currentTime;
    var master = ctx.createGain();
    master.gain.setValueAtTime(0.0001, t0);
    master.gain.exponentialRampToValueAtTime(0.2, t0 + 0.4);
    master.gain.setValueAtTime(0.2, t0 + 1.6);
    master.gain.exponentialRampToValueAtTime(0.0001, t0 + 3.2);
    master.connect(ctx.destination);

    var len = Math.floor(ctx.sampleRate * 3.2);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) data[i] = (Math.random() * 2 - 1);

    // low rumble
    var src = ctx.createBufferSource();
    src.buffer = buf;
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.setValueAtTime(200, t0);
    lp.frequency.exponentialRampToValueAtTime(900, t0 + 1.2);
    lp.frequency.exponentialRampToValueAtTime(150, t0 + 3);
    var g1 = ctx.createGain();
    g1.gain.value = 0.55;
    src.connect(lp).connect(g1).connect(master);
    src.start(t0);

    // mid roar
    var src2 = ctx.createBufferSource();
    src2.buffer = buf;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.Q.value = 0.8;
    bp.frequency.setValueAtTime(400, t0);
    bp.frequency.exponentialRampToValueAtTime(1600, t0 + 1.4);
    bp.frequency.exponentialRampToValueAtTime(300, t0 + 3);
    var g2 = ctx.createGain();
    g2.gain.value = 0.35;
    src2.connect(bp).connect(g2).connect(master);
    src2.start(t0 + 0.05);

    // high whistle
    var w = ctx.createOscillator();
    var wg = ctx.createGain();
    w.type = 'sine';
    w.frequency.setValueAtTime(600, t0);
    w.frequency.exponentialRampToValueAtTime(2400, t0 + 1.3);
    w.frequency.exponentialRampToValueAtTime(500, t0 + 3);
    wg.gain.setValueAtTime(0.0001, t0);
    wg.gain.exponentialRampToValueAtTime(0.05, t0 + 0.8);
    wg.gain.exponentialRampToValueAtTime(0.0001, t0 + 2.8);
    w.connect(wg).connect(ctx.destination);
    w.start(t0);
    w.stop(t0 + 3.1);
  }

  /* Liquid pour — filtered noise with pitch-ish body */
  function pourSound(ctx, dur) {
    var t0 = ctx.currentTime;
    var len = Math.floor(ctx.sampleRate * dur);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) {
      var n = Math.random() * 2 - 1;
      // slight glug modulation
      var glug = 0.7 + 0.3 * Math.sin(i / ctx.sampleRate * 28 * Math.PI * 2);
      data[i] = n * glug;
    }
    var src = ctx.createBufferSource();
    src.buffer = buf;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.Q.value = 1.2;
    bp.frequency.setValueAtTime(900, t0);
    bp.frequency.exponentialRampToValueAtTime(1400, t0 + dur * 0.4);
    bp.frequency.exponentialRampToValueAtTime(700, t0 + dur);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t0);
    g.gain.exponentialRampToValueAtTime(0.12, t0 + 0.15);
    g.gain.setValueAtTime(0.1, t0 + dur * 0.7);
    g.gain.exponentialRampToValueAtTime(0.0001, t0 + dur);
    src.connect(bp).connect(g).connect(ctx.destination);
    src.start(t0);

    // glass ting at end
    tone(ctx, { type: 'sine', f0: 1800, f1: 2200, dur: 0.2, delay: dur - 0.15, vol: 0.04 });
  }

  /* ── helpers ── */
  function ensureCss() {
    if (document.getElementById('gif-gifts-css-v3')) return;
    var link = document.createElement('link');
    link.id = 'gif-gifts-css-v3';
    link.rel = 'stylesheet';
    link.href = '/css/gif-gifts-v3.css';
    document.head.appendChild(link);
  }
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  function money(n) {
    var num = Number(n);
    if (!isFinite(num)) return String(n == null ? '' : n);
    return num.toLocaleString('en-US', { maximumFractionDigits: num % 1 ? 2 : 0 });
  }
  function styleFor(key) { return GIFT[key] || { glow: '#60a5fa', accent: '#a855f7', spark: '#fff', scene: 'burst' }; }
  function hexA(hex, a) {
    hex = String(hex || '#60a5fa').replace('#', '');
    if (hex.length === 3) hex = hex.split('').map(function (c) { return c + c; }).join('');
    return 'rgba(' + parseInt(hex.substring(0, 2), 16) + ',' + parseInt(hex.substring(2, 4), 16) + ',' + parseInt(hex.substring(4, 6), 16) + ',' + a + ')';
  }
  function toast(text, ms) {
    var t = document.createElement('div');
    t.className = 'gif-toast';
    t.textContent = text;
    document.body.appendChild(t);
    setTimeout(function () { t.remove(); }, ms || 2600);
  }
  function shake(strength, ms) {
    var root = document.documentElement;
    root.classList.add('gif-screen-shake');
    root.style.setProperty('--gif-shake', (strength || 8) + 'px');
    setTimeout(function () { root.classList.remove('gif-screen-shake'); }, ms || 500);
  }
  function flash(color, ms) {
    var f = document.createElement('div');
    f.className = 'gif-flash';
    f.style.background = color || 'rgba(255,255,255,0.85)';
    document.body.appendChild(f);
    setTimeout(function () { f.remove(); }, ms || 320);
  }

  function bumpCombo(key) {
    if (COMBO.key === key) COMBO.count++;
    else { COMBO.key = key; COMBO.count = 1; }
    clearTimeout(COMBO.timer);
    COMBO.timer = setTimeout(function () { COMBO.key = null; COMBO.count = 0; FEVER = 0; }, 5000);
    FEVER = Math.min(1, (COMBO.count - 1) / 6);
    return COMBO.count;
  }

  /* flying gift train (bottom → top icons) */
  function giftTrain(emoji, n, color) {
    for (var i = 0; i < n; i++) {
      (function (i) {
        setTimeout(function () {
          var el = document.createElement('div');
          el.className = 'gif-train-item';
          el.style.left = (15 + Math.random() * 70) + '%';
          el.style.color = color || '#fbbf24';
          el.textContent = emoji || '🎁';
          document.body.appendChild(el);
          setTimeout(function () { el.remove(); }, 2800);
        }, i * 120);
      })(i);
    }
  }

  /* ── TIER 1–2 cute ── */
  function playCute(opts) {
    ensureCss();
    var st = styleFor(opts.gift_key);
    var combo = bumpCombo(opts.gift_key || 'gift');
    var emoji = opts.emoji || '✨';
    playSfx('ding');

    var el = document.createElement('div');
    el.className = 'gif-cute';
    el.innerHTML =
      '<span class="gif-cute-glow" style="background:radial-gradient(circle,' + st.glow + '66,transparent 70%)"></span>' +
      '<span class="gif-cute-ring" style="border-color:' + st.glow + '"></span>' +
      '<span class="gif-cute-emoji">' + esc(emoji) + '</span>' +
      (combo > 1 ? '<span class="gif-combo" style="color:' + st.accent + '">x' + combo + '</span>' : '');
    document.body.appendChild(el);

    giftTrain(emoji, 3 + Math.min(combo, 4), st.glow);

    setTimeout(function () { el.remove(); }, 2200);
    if (opts.from || opts.label) {
      toast((opts.from ? opts.from + ' · ' : '') + (opts.emoji || '') + ' ' + (opts.label || 'Gift') + (opts.amount ? ' · $' + opts.amount : '') + (combo > 1 ? '  ×' + combo : ''), 2400);
    }
  }

  /* $100+ only gets fireworks / heavy confetti */
  function wantsFireworks(amountCents) {
    return Number(amountCents) >= 10000;
  }

  /* Soft petal fall for flowers — not cheap confetti rectangles */
  function petalRain(color, accent, n) {
    for (var i = 0; i < (n || 24); i++) {
      (function (i) {
        setTimeout(function () {
          var p = document.createElement('div');
          p.className = 'gif-petal';
          p.style.left = (Math.random() * 100) + '%';
          p.style.background = i % 2 ? (color || '#f43f5e') : (accent || '#fb7185');
          p.style.animationDuration = (2.2 + Math.random() * 2) + 's';
          p.style.animationDelay = (Math.random() * 0.4) + 's';
          document.body.appendChild(p);
          setTimeout(function () { p.remove(); }, 4500);
        }, i * 50);
      })(i);
    }
  }

  /* Full-screen pour cinematic: bottle in → cork pop → tip → liquid arc → glass fill → toast */
  function playPourCinematic(opts) {
    if (ACTIVE) {
      toast((opts.from ? opts.from + ' · ' : '') + (opts.label || 'Drink'), 2000);
      return;
    }
    ACTIVE = true;
    ensureCss();

    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    var pourKind = meta.pour || 'champagne';
    var bottleUrl = meta.image || opts.image;
    var glassUrl = meta.glass;
    var st = styleFor(opts.gift_key);
    var isChampagne = pourKind === 'champagne';
    var isWine = pourKind === 'wine';
    var liquid = isChampagne ? '#fde68a' : isWine ? '#be123c' : '#f59e0b';
    var liquidHi = isChampagne ? '#fffbeb' : isWine ? '#fb7185' : '#fde68a';
    var duration = 7.5;
    var combo = bumpCombo(opts.gift_key || 'drink');
    var amountCents = opts.amount_cents != null ? opts.amount_cents : (meta.amount || 0);

    var root = document.createElement('div');
    root.id = 'gif-special-root';
    root.className = 'gif-cine scene-pour pour-' + pourKind + (FEVER > 0.4 ? ' is-fever' : '');
    root.innerHTML =
      '<div class="gif-cine-vignette"></div>' +
      '<canvas id="gif-pour-fx"></canvas>' +
      '<div class="gif-cine-flash"></div>' +
      '<div class="gif-cine-stage pour-stage">' +
        '<div class="gif-godrays" style="--ray:' + st.glow + '"></div>' +
        '<div class="gif-pour-hero">' +
          '<div class="gif-pour-bottle-hero" id="pour-bottle">' +
            (bottleUrl ? '<img src="' + esc(bottleUrl) + '" alt="" draggable="false">' : '<div class="gif-orb-product" style="width:120px;height:120px"></div>') +
            (isChampagne ? '<div class="gif-cork" id="pour-cork"></div><div class="gif-spray" id="pour-spray"></div>' : '') +
          '</div>' +
          '<div class="gif-pour-glass-hero" id="pour-glass">' +
            (glassUrl ? '<img src="' + esc(glassUrl) + '" alt="" draggable="false">' : '') +
            '<div class="gif-liquid" id="pour-liquid"></div>' +
            '<div class="gif-foam" id="pour-foam"></div>' +
          '</div>' +
        '</div>' +
        '<div class="gif-copy pour-copy">' +
          (opts.from ? '<div class="gif-from">' + esc(opts.from) + '</div>' : '') +
          '<div class="gif-title" id="pour-title" data-text="POP" style="--title-glow:' + st.glow + '">POP</div>' +
          '<div class="gif-meta">' +
            '<span class="gif-amount" style="color:' + st.accent + '">' + esc(opts.label || '') + (opts.amount ? ' · $' + esc(money(opts.amount)) : '') + '</span>' +
            (combo > 1 ? '<span class="gif-combo-cine" style="color:' + st.glow + '">×' + combo + '</span>' : '') +
          '</div>' +
        '</div>' +
      '</div>';
    document.body.appendChild(root);

    var bottle = root.querySelector('#pour-bottle');
    var glass = root.querySelector('#pour-glass');
    var cork = root.querySelector('#pour-cork');
    var spray = root.querySelector('#pour-spray');
    var liquidEl = root.querySelector('#pour-liquid');
    var foamEl = root.querySelector('#pour-foam');
    var title = root.querySelector('#pour-title');

    var canvas = root.querySelector('#gif-pour-fx');
    var ctx = canvas.getContext('2d');
    var W = canvas.width = window.innerWidth;
    var H = canvas.height = window.innerHeight;
    var particles = [];
    var pouring = false;
    var t0 = performance.now();
    var raf;

    function setTitle(text) {
      if (!title) return;
      title.setAttribute('data-text', text);
      title.textContent = text;
    }

    function mist(x, y, n, color) {
      for (var i = 0; i < n; i++) {
        var a = -Math.PI / 2 + (Math.random() - 0.5) * 1.4;
        var s = 4 + Math.random() * 10;
        particles.push({
          x: x, y: y,
          vx: Math.cos(a) * s * (0.4 + Math.random()),
          vy: Math.sin(a) * s,
          r: 2 + Math.random() * 5,
          life: 1,
          decay: 0.012 + Math.random() * 0.02,
          color: color || '#fffbeb',
          glow: true
        });
      }
    }

    function sprayStream(x, y, color) {
      for (var i = 0; i < 6; i++) {
        particles.push({
          x: x + (Math.random() - 0.5) * 10,
          y: y,
          vx: (Math.random() - 0.5) * 3,
          vy: 5 + Math.random() * 6,
          r: 2 + Math.random() * 3,
          life: 1,
          decay: 0.01,
          color: color,
          glow: true,
          trail: true,
          px: x, py: y
        });
      }
    }

    function bubble(x, y) {
      particles.push({
        x: x, y: y,
        vx: (Math.random() - 0.5) * 0.6,
        vy: -1.2 - Math.random() * 1.5,
        r: 2 + Math.random() * 3,
        life: 1,
        decay: 0.015,
        color: 'rgba(255,255,255,.9)',
        bubble: true
      });
    }

    // Timeline
    // 0–0.8s bottle flies in
    bottle.classList.add('enter');
    // champagne cork at 0.9s
    if (isChampagne) {
      setTimeout(function () {
        setTitle('POP!');
        if (cork) cork.classList.add('flying');
        if (spray) spray.classList.add('active');
        playSfx('pop');
        flash('#fffbeb', 200);
        shake(8, 350);
        var br = bottle.getBoundingClientRect();
        mist(br.left + br.width * 0.5, br.top + 8, 50, '#fffbeb');
        mist(br.left + br.width * 0.5, br.top + 8, 20, st.glow);
        playSfx('bubbles');
      }, 900);
    } else {
      setTimeout(function () {
        setTitle(isWine ? 'OPEN' : 'OPEN');
        playSfx('pop');
      }, 700);
    }

    // tilt at 1.6s / 1.2s
    setTimeout(function () {
      bottle.classList.add('tilting');
      setTitle('POUR');
    }, isChampagne ? 1800 : 1300);

    // pour starts
    setTimeout(function () {
      pouring = true;
      bottle.classList.add('pouring');
      glass.classList.add('visible');
      playSfx('pour');
      setTitle('POURING…');
    }, isChampagne ? 2300 : 1700);

    // fill liquid
    setTimeout(function () {
      if (liquidEl) {
        liquidEl.style.background = 'linear-gradient(180deg,' + liquidHi + ',' + liquid + ')';
        liquidEl.classList.add('filling');
      }
      if (foamEl && isChampagne) foamEl.classList.add('show');
    }, isChampagne ? 2600 : 1900);

    // stop pour
    setTimeout(function () {
      pouring = false;
      bottle.classList.add('untilt');
      if (liquidEl) liquidEl.classList.add('full');
      if (foamEl) foamEl.classList.add('full');
      setTitle('CHEERS');
      playSfx('ding');
      glass.classList.add('toast');
    }, isChampagne ? 4800 : 3800);

    setTimeout(function () {
      flash(hexA(st.glow, 0.3), 180);
      playSfx('chime');
    }, isChampagne ? 5200 : 4200);

    function frame(t) {
      var el = (t - t0) / 1000;
      ctx.clearRect(0, 0, W, H);

      // ambient glow
      var pulse = 0.5 + 0.5 * Math.sin(el * 3);
      var g = ctx.createRadialGradient(W / 2, H * 0.4, 30, W / 2, H * 0.4, 340 + pulse * 60);
      g.addColorStop(0, hexA(st.glow, 0.15 + pulse * 0.1));
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);

      // pour stream from bottle mouth to glass
      if (pouring && bottle && glass) {
        var bb = bottle.getBoundingClientRect();
        var gb = glass.getBoundingClientRect();
        var sx = bb.left + bb.width * 0.72;
        var sy = bb.top + bb.height * 0.15;
        var ex = gb.left + gb.width * 0.5;
        var ey = gb.top + gb.height * 0.15;
        // arc control
        var cx = (sx + ex) / 2 + 20;
        var cy = Math.min(sy, ey) - 30;

        ctx.save();
        ctx.strokeStyle = liquid;
        ctx.lineWidth = 8;
        ctx.lineCap = 'round';
        ctx.shadowBlur = 16;
        ctx.shadowColor = liquid;
        ctx.globalAlpha = 0.85;
        ctx.beginPath();
        ctx.moveTo(sx, sy);
        ctx.quadraticCurveTo(cx, cy, ex, ey);
        ctx.stroke();
        // highlight
        ctx.strokeStyle = liquidHi;
        ctx.lineWidth = 3;
        ctx.globalAlpha = 0.5;
        ctx.beginPath();
        ctx.moveTo(sx, sy);
        ctx.quadraticCurveTo(cx, cy, ex, ey);
        ctx.stroke();
        ctx.restore();

        sprayStream(sx, sy, liquid);
        if (isChampagne && Math.random() > 0.5) bubble(ex + (Math.random() - 0.5) * 16, ey + 20);
      }

      // bubbles in filled glass
      if (liquidEl && liquidEl.classList.contains('filling') && Math.random() > 0.6 && glass) {
        var gbb = glass.getBoundingClientRect();
        bubble(gbb.left + gbb.width * (0.35 + Math.random() * 0.3), gbb.top + gbb.height * 0.55);
      }

      for (var i = particles.length - 1; i >= 0; i--) {
        var p = particles[i];
        p.px = p.x; p.py = p.y;
        p.x += p.vx; p.y += p.vy;
        if (!p.bubble) p.vy += 0.15;
        else p.vy *= 0.98;
        p.vx *= 0.99;
        p.life -= p.decay;
        if (p.life <= 0 || p.y > H + 40) { particles.splice(i, 1); continue; }
        ctx.save();
        ctx.globalAlpha = Math.max(0, p.life) * (p.bubble ? 0.75 : 0.95);
        if (p.trail) {
          ctx.strokeStyle = hexA(p.color === 'rgba(255,255,255,.9)' ? '#fff' : p.color, 0.4 * p.life);
          ctx.lineWidth = Math.max(1, p.r * 0.7);
          ctx.beginPath();
          ctx.moveTo(p.px, p.py);
          ctx.lineTo(p.x, p.y);
          ctx.stroke();
        }
        ctx.shadowBlur = p.bubble ? 4 : 12;
        ctx.shadowColor = p.bubble ? '#fff' : p.color;
        ctx.beginPath();
        ctx.arc(p.x, p.y, Math.max(0.5, p.r * (p.bubble ? p.life : 1)), 0, Math.PI * 2);
        ctx.fillStyle = p.bubble ? 'rgba(255,255,255,.9)' : p.color;
        ctx.fill();
        ctx.restore();
      }

      if (el < duration) raf = requestAnimationFrame(frame);
      else cleanup();
    }
    raf = requestAnimationFrame(frame);

    function cleanup() {
      cancelAnimationFrame(raf);
      root.classList.add('is-exit');
      setTimeout(function () { root.remove(); ACTIVE = false; }, 700);
    }
    setTimeout(function () {
      if (document.getElementById('gif-special-root')) cleanup();
    }, (duration + 1.2) * 1000);
  }

  /* ── TIER 3–4 medium ── */
  function playMedium(opts) {
    ensureCss();
    var st = styleFor(opts.gift_key);
    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    var combo = bumpCombo(opts.gift_key || 'gift');
    var amountCents = opts.amount_cents != null ? opts.amount_cents : (meta.amount || 0);
    var big = wantsFireworks(amountCents);
    var isFlowers = !!meta.flowers || opts.gift_key === 'bouquet' || opts.gift_key === 'rose';
    var isPour = !!meta.pour;

    if (isPour) playSfx('pop');
    else if (isFlowers) playSfx('chime');
    else playSfx('ding');
    giftTrain(opts.emoji, big ? 8 : 4, st.glow);

    var productHtml = '';
    if (meta.image) {
      productHtml = '<img class="gif-med-photo" src="' + esc(meta.image) + '" alt="">';
    } else {
      productHtml = esc(opts.emoji || '🎉');
    }

    var root = document.createElement('div');
    root.className = 'gif-medium' + (FEVER > 0.5 ? ' is-fever' : '') + (isFlowers ? ' is-flowers' : '') + (isPour ? ' is-pour' : '');
    root.innerHTML =
      '<div class="gif-medium-bg" style="background:radial-gradient(ellipse at 50% 40%,' + st.glow + '33,transparent 65%),radial-gradient(ellipse at 50% 50%,#0f172acc,transparent)"></div>' +
      (big ? '<div class="gif-medium-rays"></div>' : '') +
      '<div class="gif-medium-ring r1" style="border-color:' + st.glow + '"></div>' +
      '<div class="gif-medium-ring r2" style="border-color:' + st.accent + '"></div>' +
      (big ? '<div class="gif-medium-ring r3" style="border-color:' + st.spark + '"></div>' : '') +
      '<div class="gif-medium-emoji' + (meta.image ? ' has-photo' : '') + '">' + productHtml + '</div>' +
      '<div class="gif-medium-label">' +
        '<div class="gif-from">' + esc(opts.from || '') + '</div>' +
        '<div class="gif-title">' + esc(opts.label || 'Gift') + '</div>' +
        (opts.amount ? '<div class="gif-sub" style="color:' + st.accent + '">$' + esc(money(opts.amount)) + '</div>' : '') +
        (combo > 1 ? '<div class="gif-combo-med" style="color:' + st.glow + '">×' + combo + '</div>' : '') +
      '</div>';
    document.body.appendChild(root);

    if (isFlowers) {
      petalRain(st.glow, st.accent, big ? 40 : 22);
    } else if (big) {
      // confetti only $100+
      var colors = [st.glow, st.accent, '#f97316', '#ec4899', st.spark, '#e2e8f0', '#fbbf24'];
      for (var i = 0; i < 48 + Math.floor(FEVER * 40); i++) {
        (function (i) {
          setTimeout(function () {
            var c = document.createElement('div');
            c.className = 'gif-conf';
            c.style.left = (Math.random() * 100) + '%';
            c.style.background = colors[i % colors.length];
            c.style.animationDuration = (1.3 + Math.random() * 1.3) + 's';
            document.body.appendChild(c);
            setTimeout(function () { c.remove(); }, 2800);
          }, i * 14);
        })(i);
      }
    }

    flash(hexA(st.glow, big ? 0.35 : 0.2), 180);
    setTimeout(function () { root.remove(); }, isPour ? 4800 : 3000);
  }

  /* ── TIER 5+ cinematic with photoreal product image ── */
  function playCinematic(opts) {
    if (ACTIVE) {
      toast((opts.from ? opts.from + ' · ' : '') + (opts.emoji || '') + ' ' + (opts.label || 'Gift'), 2200);
      return;
    }
    ACTIVE = true;
    ensureCss();

    var tier = Math.min(10, opts.tier || 5);
    var st = styleFor(opts.gift_key);
    var isLegend = tier >= 9;
    var isSpect = tier >= 7;
    var scene = st.scene || 'burst';
    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    var isMystery = !!meta.mystery || opts.gift_key === 'mystery_box';
    var imageUrl = opts.image || meta.image || null;
    if (isMystery) scene = 'mystery';
    var duration = isMystery ? 10 : (isLegend ? 9 : (isSpect ? 7.2 : 5.8));
    if (scene === 'car' || scene === 'flight') duration = Math.max(duration, 7.5);
    var combo = bumpCombo(opts.gift_key || 'gift');
    var emoji = opts.emoji || '✨';
    var label = opts.label || 'GIFT';
    var productSvg = svgFor(opts.gift_key, st);
    var productHtml = imageUrl
      ? '<img class="gif-product-photo" src="' + esc(imageUrl) + '" alt="" draggable="false">'
      : productSvg;
    var amountCents = opts.amount_cents != null ? opts.amount_cents : (meta.amount || 0);
    var bigMoney = wantsFireworks(amountCents);
    var isFlowers = !!meta.flowers || opts.gift_key === 'bouquet';
    var isPour = !!meta.pour && !!meta.glass;

    var sfx = scene === 'champagne' ? 'pop'
      : scene === 'diamond' ? 'chime'
      : scene === 'car' ? 'engine'
      : scene === 'flight' ? 'jet'
      : scene === 'watch' ? 'tick'
      : scene === 'mystery' ? 'tick'
      : isLegend ? 'legend' : 'boom';
    setTimeout(function () { playSfx(sfx); }, 80);
    if (scene === 'champagne') {
      setTimeout(function () { playSfx('bubbles'); }, 350);
    }
    if (isLegend || isMystery) setTimeout(function () { playSfx('legend'); }, 900);

    var revealLabel = label;
    var revealSub = '';
    if (isMystery) {
      var prizes = ['Sports Car', 'Luxury Holiday', 'Diamond Bracelet', 'Luxury Watch', 'Designer Bag', 'Home Gym'];
      revealLabel = prizes[(Math.random() * prizes.length) | 0];
      revealSub = 'Mystery unlocked';
      label = 'Mystery Box';
    }

    var root = document.createElement('div');
    root.id = 'gif-special-root';
    root.className = 'gif-cine is-' + (isLegend || isMystery ? 'legend' : isSpect ? 'spectacular' : 'major') + ' scene-' + scene + (FEVER > 0.4 ? ' is-fever' : '') + (imageUrl ? ' has-photo' : '');
    root.innerHTML =
      '<div class="gif-cine-vignette"></div>' +
      '<canvas id="gif-canvas"></canvas>' +
      '<div class="gif-cine-flash"></div>' +
      '<div class="gif-cine-stage">' +
        '<div class="gif-godrays" style="--ray:' + st.glow + '"></div>' +
        '<div class="gif-orbit o1" style="border-color:' + st.glow + '55"></div>' +
        '<div class="gif-orbit o2" style="border-color:' + st.accent + '44"></div>' +
        '<div class="gif-shock" style="border-color:' + st.glow + '"></div>' +
        '<div class="gif-shock s2" style="border-color:' + st.accent + '"></div>' +
        '<div class="gif-product-wrap scene-' + scene + (imageUrl ? ' has-photo' : '') + '" id="gif-product-wrap">' +
          (imageUrl ? '' : '<div class="gif-product-shadow"></div>') +
          '<div class="gif-product illustrated' + (imageUrl ? ' has-img' : '') + '">' + productHtml + '</div>' +
          (imageUrl ? '' : '<div class="gif-product-shine"></div>') +
          (isMystery ? '<div class="gif-mystery-seam"></div><div class="gif-mystery-q">?</div>' : '') +
          '<div class="gif-speed-blur"></div>' +
          '<div class="gif-ground-trail"></div>' +
        '</div>' +
        '<div class="gif-copy">' +
          (opts.from ? '<div class="gif-from">' + esc(opts.from) + '</div>' : '') +
          '<div class="gif-title" data-text="' + esc(isMystery ? 'OPENING…' : label) + '" style="--title-glow:' + st.glow + '">' + esc(isMystery ? 'OPENING…' : label) + '</div>' +
          '<div class="gif-meta">' +
            (opts.amount && !isMystery ? '<span class="gif-amount" style="color:' + st.accent + '">$' + esc(money(opts.amount)) + '</span>' : '') +
            '<span class="gif-tier-badge' + (isLegend || isMystery ? ' legend' : isSpect ? ' spec' : '') + '" style="--badge:' + st.glow + '">' +
              (isMystery ? 'SEALED' : isLegend ? 'LEGENDARY' : isSpect ? 'SPECTACULAR' : 'EPIC') +
            '</span>' +
          '</div>' +
          (combo > 1 ? '<div class="gif-combo-cine' + (FEVER > 0.5 ? ' fever' : '') + '" style="color:' + st.glow + '">×' + combo + (FEVER > 0.5 ? ' FEVER' : '') + '</div>' : '') +
        '</div>' +
      '</div>' +
      '<div class="gif-smoke-layer"></div>' +
      '<div class="gif-dust-layer"></div>';
    document.body.appendChild(root);

    // Multi-stage product choreography
    var wrap = root.querySelector('#gif-product-wrap');
    var climaxAt = isMystery ? 2800 : (isLegend ? 2200 : isSpect ? 1800 : 1400);
    if (wrap) {
      wrap.classList.add('stage-enter');
      setTimeout(function () {
        wrap.classList.remove('stage-enter');
        wrap.classList.add('stage-hero');
      }, Math.min(1200, climaxAt * 0.45));
      setTimeout(function () {
        wrap.classList.add('stage-action');
      }, climaxAt * 0.55);
      setTimeout(function () {
        wrap.classList.add('stage-climax');
      }, climaxAt);
      setTimeout(function () {
        wrap.classList.add('stage-exit');
      }, duration * 1000 - 900);
    }

    if (isMystery) {
      setTimeout(function () {
        var titleEl = root.querySelector('.gif-title');
        var badgeEl = root.querySelector('.gif-tier-badge');
        var amountEl = root.querySelector('.gif-meta');
        var seam = root.querySelector('.gif-mystery-seam');
        var q = root.querySelector('.gif-mystery-q');
        if (titleEl) {
          titleEl.setAttribute('data-text', revealLabel);
          titleEl.textContent = revealLabel;
        }
        if (badgeEl) badgeEl.textContent = 'REVEALED';
        if (amountEl && opts.amount) {
          var amt = document.createElement('span');
          amt.className = 'gif-amount';
          amt.style.color = st.accent;
          amt.textContent = '$' + money(opts.amount);
          amountEl.insertBefore(amt, badgeEl);
        }
        if (seam) seam.classList.add('is-open');
        if (q) q.classList.add('is-open');
        flash('#fffbeb', 280);
        shake(16, 600);
        playSfx('boom');
        playSfx('legend');
      }, 2800);
    }

    // dust
    var dustLayer = root.querySelector('.gif-dust-layer');
    var dustCount = (isLegend ? 40 : isSpect ? 28 : 16) + Math.floor(FEVER * 20);
    for (var d = 0; d < dustCount; d++) {
      (function (d) {
        var dot = document.createElement('i');
        dot.style.left = (Math.random() * 100) + '%';
        dot.style.top = (Math.random() * 100) + '%';
        dot.style.background = d % 2 ? st.glow : st.accent;
        dot.style.animationDelay = (Math.random() * 2) + 's';
        dot.style.animationDuration = (3 + Math.random() * 4) + 's';
        dustLayer.appendChild(dot);
      })(d);
    }
    // smoke
    var smokeLayer = root.querySelector('.gif-smoke-layer');
    for (var sm = 0; sm < (isLegend ? 6 : 3); sm++) {
      (function (sm) {
        var puff = document.createElement('span');
        puff.style.left = (10 + sm * 14 + Math.random() * 8) + '%';
        puff.style.bottom = '10%';
        puff.style.background = 'radial-gradient(circle,' + st.glow + '44,transparent 70%)';
        puff.style.animationDelay = (sm * 0.25) + 's';
        smokeLayer.appendChild(puff);
      })(sm);
    }

    giftTrain(emoji, isLegend ? 12 : isSpect ? 8 : 5, st.glow);

    var canvas = root.querySelector('#gif-canvas');
    var ctx = canvas.getContext('2d');
    var W = canvas.width = window.innerWidth;
    var H = canvas.height = window.innerHeight;
    var particles = [];
    var streaks = [];
    var fireworks = [];
    var colors = [st.glow, st.accent, st.spark, '#f97316', '#ec4899', '#fbbf24', '#60a5fa', '#e2e8f0'];
    var t0 = performance.now();
    var raf;
    var feverMul = 1 + FEVER * 0.8;

    function burst(x, y, n, speed, bo) {
      bo = bo || {};
      n = Math.floor(n * feverMul);
      for (var i = 0; i < n; i++) {
        var a = (Math.PI * 2 * i) / n + Math.random() * 0.7;
        var s = speed * (0.3 + Math.random() * 1.2);
        particles.push({
          x: x, y: y, vx: Math.cos(a) * s, vy: Math.sin(a) * s - (bo.lift || 1.4),
          r: bo.size || (2 + Math.random() * 6), life: 1,
          decay: 0.004 + Math.random() * 0.012,
          color: colors[(Math.random() * colors.length) | 0],
          glow: true, trail: !!bo.trail, px: x, py: y
        });
      }
    }
    function rain(n, goldOnly) {
      n = Math.floor(n * feverMul);
      for (var i = 0; i < n; i++) {
        particles.push({
          x: Math.random() * W, y: -20 - Math.random() * 160,
          vx: (Math.random() - 0.5) * 2.8, vy: 2.4 + Math.random() * 5.2,
          r: 2 + Math.random() * 5, life: 1,
          decay: 0.0018 + Math.random() * 0.003,
          color: goldOnly ? (Math.random() > 0.5 ? '#fbbf24' : st.glow) : colors[(Math.random() * colors.length) | 0],
          conf: true, rot: Math.random() * 6, vr: (Math.random() - 0.5) * 0.45
        });
      }
    }
    function lightStreak() {
      var fromLeft = Math.random() > 0.5;
      streaks.push({
        x: fromLeft ? -80 : W + 80, y: H * (0.25 + Math.random() * 0.5),
        vx: (fromLeft ? 1 : -1) * (16 + Math.random() * 20),
        life: 1, decay: 0.012,
        color: colors[(Math.random() * colors.length) | 0]
      });
    }
    function firework(x, y) { fireworks.push({ x: x, y: y, t: 0, exploded: false }); }

    // scene-specific openers
    if (scene === 'car') {
      for (var sp = 0; sp < 10; sp++) setTimeout(lightStreak, sp * 70);
      setTimeout(function () { burst(W * 0.5, H * 0.42, 80, 12, { trail: true, lift: 2 }); shake(14, 500); }, 900);
    }
    if (scene === 'champagne') {
      setTimeout(function () { flash('#fffbeb', 220); playSfx('pop'); }, 120);
      setTimeout(function () { playSfx('bubbles'); }, 400);
      burst(W / 2, H * 0.35, 80, 11, { lift: 3, trail: true });
      if (bigMoney) rain(40, true);
    }
    if (scene === 'diamond') {
      for (var pr = 0; pr < 6; pr++) {
        (function (pr) {
          setTimeout(function () {
            burst(W * (0.2 + Math.random() * 0.6), H * (0.25 + Math.random() * 0.4), 40, 7, { trail: true });
            playSfx('chime');
          }, 250 + pr * 320);
        })(pr);
      }
    }
    if (scene === 'watch') {
      var ticks = 8;
      for (var tk = 0; tk < ticks; tk++) setTimeout(function () { playSfx('tick'); }, 200 + tk * 120);
    }
    if (scene === 'flight') {
      for (var fl = 0; fl < 4; fl++) setTimeout(lightStreak, fl * 200);
      setTimeout(function () { playSfx('jet'); }, 200);
    }
    if (isFlowers) {
      petalRain(st.glow, st.accent, 36);
    }

    var bursts = isLegend ? 8 : isSpect ? 5 : 3;
    for (var k = 0; k < bursts; k++) {
      (function (k) {
        setTimeout(function () {
          var bx = W / 2 + (Math.random() - 0.5) * W * 0.25;
          var by = H * 0.4 + (Math.random() - 0.5) * H * 0.15;
          burst(bx, by, 55 + k * 22, 8 + k * 2.2, { trail: k > 1 });
        }, 200 + k * 380);
      })(k);
    }
    if (bigMoney) {
      rain(isLegend ? 240 : isSpect ? 140 : 80, isLegend);
    } else {
      rain(30, false);
    }

    // Fireworks only $100 and up
    if (bigMoney && (isSpect || isLegend)) {
      setTimeout(function () {
        firework(W * 0.25, H * 0.3);
        firework(W * 0.75, H * 0.32);
        if (isLegend) {
          firework(W * 0.5, H * 0.22);
          firework(W * 0.15, H * 0.45);
          firework(W * 0.85, H * 0.48);
        }
      }, 1000);
    }

    setTimeout(function () {
      if (isLegend) { flash('#ffffff', 300); shake(18, 650); playSfx('boom'); }
      else if (isSpect) { flash(hexA(st.glow, 0.5), 220); shake(12, 480); }
      else { flash(hexA(st.glow, 0.3), 160); shake(8, 360); }
    }, 100);

    var streakTimer = setInterval(function () {
      if (Math.random() > 0.3) lightStreak();
    }, isLegend ? 240 : 400);
    setTimeout(function () { clearInterval(streakTimer); }, duration * 1000 - 400);

    function frame(t) {
      var el = (t - t0) / 1000;
      ctx.clearRect(0, 0, W, H);
      var pulse = 0.5 + 0.5 * Math.sin(el * (3.4 + FEVER * 2));
      var g = ctx.createRadialGradient(W / 2, H * 0.42, 20, W / 2, H * 0.42, 360 + pulse * 140);
      g.addColorStop(0, hexA(st.glow, (0.2 + pulse * 0.18) * (1 + FEVER * 0.5)));
      g.addColorStop(0.4, hexA('#ec4899', 0.07 + pulse * 0.05));
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);

      for (var si = streaks.length - 1; si >= 0; si--) {
        var sk = streaks[si];
        sk.x += sk.vx; sk.life -= sk.decay;
        if (sk.life <= 0) { streaks.splice(si, 1); continue; }
        ctx.save();
        ctx.globalAlpha = Math.max(0, sk.life) * 0.85;
        var grad = ctx.createLinearGradient(sk.x, sk.y, sk.x - sk.vx * 4, sk.y);
        grad.addColorStop(0, sk.color); grad.addColorStop(1, 'transparent');
        ctx.strokeStyle = grad; ctx.lineWidth = 3; ctx.lineCap = 'round';
        ctx.shadowBlur = 16; ctx.shadowColor = sk.color;
        ctx.beginPath(); ctx.moveTo(sk.x, sk.y); ctx.lineTo(sk.x - sk.vx * 3.5, sk.y); ctx.stroke();
        ctx.restore();
      }

      for (var fi = fireworks.length - 1; fi >= 0; fi--) {
        var fw = fireworks[fi];
        fw.t += 16;
        if (!fw.exploded && fw.t > 280) {
          fw.exploded = true;
          burst(fw.x, fw.y, 55, 10, { trail: true });
          playSfx('boom');
        }
        if (fw.t > 900) fireworks.splice(fi, 1);
      }

      for (var i = particles.length - 1; i >= 0; i--) {
        var p = particles[i];
        p.px = p.x; p.py = p.y;
        p.x += p.vx; p.y += p.vy;
        p.vy += p.conf ? 0.055 : 0.07;
        p.vx *= 0.994; p.life -= p.decay;
        if (p.rot != null) p.rot += p.vr;
        if (p.life <= 0 || p.y > H + 80) { particles.splice(i, 1); continue; }
        ctx.save();
        ctx.globalAlpha = Math.max(0, p.life);
        if (p.conf) {
          ctx.translate(p.x, p.y); ctx.rotate(p.rot || 0);
          ctx.fillStyle = p.color;
          ctx.fillRect(-p.r, -p.r * 1.7, p.r * 2, p.r * 3.4);
        } else {
          if (p.trail) {
            ctx.strokeStyle = hexA(p.color, 0.35 * p.life);
            ctx.lineWidth = Math.max(1, p.r * 0.6);
            ctx.beginPath(); ctx.moveTo(p.px, p.py); ctx.lineTo(p.x, p.y); ctx.stroke();
          }
          ctx.shadowBlur = 18; ctx.shadowColor = p.color;
          ctx.beginPath(); ctx.arc(p.x, p.y, p.r * Math.max(0.2, p.life), 0, Math.PI * 2);
          ctx.fillStyle = p.color; ctx.fill();
        }
        ctx.restore();
      }

      if (el < duration) raf = requestAnimationFrame(frame);
      else cleanup();
    }
    raf = requestAnimationFrame(frame);

    function cleanup() {
      cancelAnimationFrame(raf);
      clearInterval(streakTimer);
      root.classList.add('is-exit');
      setTimeout(function () { root.remove(); ACTIVE = false; }, 700);
    }
    setTimeout(function () {
      if (document.getElementById('gif-special-root')) cleanup();
    }, (duration + 1.8) * 1000);
  }

  function play(opts) {
    opts = opts || {};
    var tier = opts.tier || 1;
    if (opts.emoji == null && opts.gift_key && global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) {
      var m = global.FFM_GIFT_META[opts.gift_key];
      opts.emoji = m.emoji; opts.label = m.label; opts.amount = m.amount;
      tier = m.tier || tier;
    }
    if (opts.image == null && opts.gift_key && global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) {
      opts.image = global.FFM_GIFT_META[opts.gift_key].image || null;
    }
    if (opts.amount_cents == null && opts.gift_key && global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) {
      opts.amount_cents = global.FFM_GIFT_META[opts.gift_key].amount || 0;
    }
    if (opts.amount_cents == null && opts.amount != null) {
      // showcase passes dollars; convert if looks like dollars
      opts.amount_cents = Number(opts.amount) >= 1000 ? Number(opts.amount) : Number(opts.amount) * 100;
    }
    var metaCheck = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    if (metaCheck.pour && metaCheck.glass) {
      playPourCinematic(opts);
      return;
    }
    if (tier >= 5) playCinematic(Object.assign({}, opts, { tier: tier }));
    else if (tier >= 3) playMedium(opts);
    else playCute(opts);
  }

  global.GiftFXV3 = { play: play, styles: GIFT, unlockAudio: function () { audio(); }, engine: 'v3' };

  // unlock audio on first gesture
  document.addEventListener('pointerdown', function unlock() {
    var c = audio();
    if (c && c.state === 'suspended') { try { c.resume(); } catch (e) {} }
    document.removeEventListener('pointerdown', unlock);
  }, { once: true });

  document.addEventListener('DOMContentLoaded', function () {
    try {
      var flashData = global.FFM_FLASH || {};
      if (flashData.key) {
        setTimeout(function () {
          play({ gift_key: flashData.key, from: flashData.from || '', tier: flashData.tier || 1 });
        }, 400);
      }
    } catch (e) {}
  });
})(window);
