/**
 * FFM Gift FX V3 — SugarBook-class
 * Illustrated SVG products + multi-stage choreography + Web Audio + fever combos.
 */
(function (global) {
  'use strict';

  /** FFM Gift FX V4 — motion polish, depth particles, camera punch, beat-sync SFX, Legend/Icon acts */
  global.GIFT_FX_ENGINE = 'v4';
  var EASE = {
    outExpo: 'cubic-bezier(.16,1,.3,1)',
    outQuint: 'cubic-bezier(.22,1,.36,1)',
    inOutQuart: 'cubic-bezier(.76,0,.24,1)',
    spring: 'cubic-bezier(.2,1.35,.35,1)',
    punch: 'cubic-bezier(.2,.9,.25,1)'
  };
  var ACTIVE = false;
  var AUDIO = null;
  var COMBO = { key: null, count: 0, timer: null };
  var FEVER = 0; // 0..1 intensity from recent gifts

  /* ── Colors per gift ── */
  var GIFT = {
    high_five:        { glow: '#f97316', accent: '#fdba74', spark: '#fff7ed', scene: 'highfive' },
    protein_shake:    { glow: '#22c55e', accent: '#86efac', spark: '#dcfce7', scene: 'shake' },
    rose:             { glow: '#22c55e', accent: '#86efac', spark: '#dcfce7', scene: 'shake' },
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
  SVG.high_five = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 220 160" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="skin" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#fdba74"/><stop offset="100%" stop-color="#f97316"/></linearGradient></defs>' +
      '<ellipse cx="110" cy="140" rx="50" ry="8" fill="rgba(0,0,0,.25)"/>' +
      /* left hand */
      '<g class="gif-h5-left" transform="translate(40 70) rotate(-18)">' +
      '<rect x="20" y="30" width="36" height="50" rx="12" fill="url(#skin)"/>' +
      '<rect x="18" y="8" width="10" height="28" rx="5" fill="url(#skin)"/>' +
      '<rect x="30" y="2" width="10" height="34" rx="5" fill="url(#skin)"/>' +
      '<rect x="42" y="6" width="10" height="30" rx="5" fill="url(#skin)"/>' +
      '<rect x="54" y="12" width="9" height="24" rx="4" fill="url(#skin)"/>' +
      '</g>' +
      /* right hand */
      '<g class="gif-h5-right" transform="translate(140 70) rotate(18)">' +
      '<rect x="20" y="30" width="36" height="50" rx="12" fill="url(#skin)"/>' +
      '<rect x="14" y="12" width="9" height="24" rx="4" fill="url(#skin)"/>' +
      '<rect x="25" y="6" width="10" height="30" rx="5" fill="url(#skin)"/>' +
      '<rect x="37" y="2" width="10" height="34" rx="5" fill="url(#skin)"/>' +
      '<rect x="49" y="8" width="10" height="28" rx="5" fill="url(#skin)"/>' +
      '</g>' +
      '<g class="gif-h5-burst" transform="translate(110 72)">' +
      '<circle r="18" fill="none" stroke="' + c.spark + '" stroke-width="3" opacity=".9"/>' +
      '<path d="M0,-28 L4,-18 L14,-22 L8,-12 L20,-8 L8,-4 L12,8 L0,0 L-12,8 L-8,-4 L-20,-8 L-8,-12 L-14,-22 L-4,-18 Z" fill="' + c.spark + '" opacity=".95"/>' +
      '</g>' +
      '</svg>';
  };

  SVG.protein_shake = function (c) {
    return '<svg class="gif-svg-product" viewBox="0 0 140 200" xmlns="http://www.w3.org/2000/svg">' +
      '<defs><linearGradient id="shaker" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#e2e8f0"/><stop offset="45%" stop-color="#f8fafc"/><stop offset="100%" stop-color="#94a3b8"/></linearGradient>' +
      '<linearGradient id="shake" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#86efac"/><stop offset="100%" stop-color="#16a34a"/></linearGradient></defs>' +
      '<ellipse cx="70" cy="188" rx="36" ry="7" fill="rgba(0,0,0,.28)"/>' +
      '<rect x="38" y="48" width="64" height="130" rx="14" fill="url(#shaker)" stroke="#64748b" stroke-width="2"/>' +
      '<rect x="44" y="78" width="52" height="90" rx="8" fill="url(#shake)" opacity=".85"/>' +
      '<rect x="34" y="28" width="72" height="28" rx="8" fill="#334155"/>' +
      '<rect x="52" y="12" width="36" height="22" rx="6" fill="#22c55e"/>' +
      '<rect x="48" y="95" width="44" height="4" rx="2" fill="#fff" opacity=".35"/>' +
      '<rect x="48" y="115" width="44" height="4" rx="2" fill="#fff" opacity=".35"/>' +
      '<rect x="48" y="135" width="44" height="4" rx="2" fill="#fff" opacity=".35"/>' +
      '<text x="70" y="130" text-anchor="middle" font-size="11" font-weight="800" fill="#14532d" font-family="system-ui,sans-serif">FFM</text>' +
      '</svg>';
  };

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
    } else if (kind === 'slap') {
      noiseBurst(ctx, 0.07, 0.24, 2800);
      tone(ctx, { type: 'triangle', f0: 420, f1: 110, dur: 0.11, vol: 0.14 });
      tone(ctx, { type: 'sine', f0: 980, f1: 220, dur: 0.07, delay: 0.015, vol: 0.07 });
      noiseBurst(ctx, 0.04, 0.08, 5000);
    } else if (kind === 'fw_launch') {
      fireworkLaunchSfx(ctx);
    } else if (kind === 'fw_boom') {
      fireworkBoomSfx(ctx);
    } else if (kind === 'fw_crackle') {
      fireworkCrackleSfx(ctx);
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

  /* Firework SFX — launch whistle, deep boom, delayed crackle */
  function fireworkLaunchSfx(ctx) {
    var t0 = ctx.currentTime;
    var o = ctx.createOscillator();
    var g = ctx.createGain();
    o.type = 'sine';
    o.frequency.setValueAtTime(320, t0);
    o.frequency.exponentialRampToValueAtTime(1600, t0 + 0.5);
    o.frequency.exponentialRampToValueAtTime(2200, t0 + 0.7);
    g.gain.setValueAtTime(0.0001, t0);
    g.gain.exponentialRampToValueAtTime(0.055, t0 + 0.1);
    g.gain.exponentialRampToValueAtTime(0.001, t0 + 0.75);
    o.connect(g).connect(ctx.destination);
    o.start(t0);
    o.stop(t0 + 0.8);
    // soft rush under whistle
    var len = Math.floor(ctx.sampleRate * 0.7);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) data[i] = (Math.random() * 2 - 1) * (i / len);
    var src = ctx.createBufferSource();
    src.buffer = buf;
    var flt = ctx.createBiquadFilter();
    flt.type = 'bandpass';
    flt.frequency.setValueAtTime(600, t0);
    flt.frequency.exponentialRampToValueAtTime(2400, t0 + 0.55);
    var ng = ctx.createGain();
    ng.gain.setValueAtTime(0.0001, t0);
    ng.gain.exponentialRampToValueAtTime(0.04, t0 + 0.2);
    ng.gain.exponentialRampToValueAtTime(0.001, t0 + 0.7);
    src.connect(flt).connect(ng).connect(ctx.destination);
    src.start(t0);
  }
  function fireworkBoomSfx(ctx) {
    var t0 = ctx.currentTime;
    // sub thump
    var o = ctx.createOscillator();
    var g = ctx.createGain();
    o.type = 'sine';
    o.frequency.setValueAtTime(95, t0);
    o.frequency.exponentialRampToValueAtTime(28, t0 + 0.55);
    g.gain.setValueAtTime(0.0001, t0);
    g.gain.exponentialRampToValueAtTime(0.28, t0 + 0.02);
    g.gain.exponentialRampToValueAtTime(0.001, t0 + 0.7);
    o.connect(g).connect(ctx.destination);
    o.start(t0);
    o.stop(t0 + 0.75);
    // body noise
    noiseBurst(ctx, 0.55, 0.2, 900);
    // mid crack
    tone(ctx, { type: 'triangle', f0: 180, f1: 60, dur: 0.25, vol: 0.1 });
    // delayed crackle (real shells sparkle after the break)
    fireworkCrackleSfx(ctx, 0.08);
  }
  function fireworkCrackleSfx(ctx, delayBase) {
    var base = delayBase != null ? delayBase : 0.05;
    for (var c = 0; c < 14; c++) {
      (function (c) {
        var delay = base + c * (0.03 + Math.random() * 0.05);
        setTimeout(function () {
          var ac = audio();
          if (!ac) return;
          tone(ac, { type: 'square', f0: 900 + Math.random() * 1800, dur: 0.03 + Math.random() * 0.03, vol: 0.025 + Math.random() * 0.02 });
          noiseBurst(ac, 0.04, 0.03, 4000);
        }, delay * 1000);
      })(c);
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
    var href = '/css/gif-gifts.css?v=palm1';
    var link = document.getElementById('gif-gifts-css');
    if (link) {
      if (String(link.getAttribute('href') || '').indexOf('fx4') === -1) link.setAttribute('href', href);
      return;
    }
    link = document.createElement('link');
    link.id = 'gif-gifts-css';
    link.rel = 'stylesheet';
    link.href = href;
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
    root.classList.remove('gif-screen-shake');
    // reflow so consecutive shakes re-trigger
    void root.offsetWidth;
    root.classList.add('gif-screen-shake');
    root.style.setProperty('--gif-shake', (strength || 8) + 'px');
    setTimeout(function () { root.classList.remove('gif-screen-shake'); }, ms || 500);
  }
  function cameraPunch(root, intensity, ms) {
    if (!root) return;
    var stage = root.querySelector('.gif-cine-stage') || root.querySelector('.gif-medium') || root;
    stage.style.setProperty('--punch', String(intensity || 1));
    stage.classList.remove('is-punch');
    void stage.offsetWidth;
    stage.classList.add('is-punch');
    setTimeout(function () { stage.classList.remove('is-punch'); }, ms || 620);
  }
  function setBeatCaption(root, text) {
    if (!root) return;
    var cap = root.querySelector('.gif-beat-caption');
    if (!cap) return;
    cap.textContent = text || '';
    cap.classList.remove('is-on');
    void cap.offsetWidth;
    if (text) cap.classList.add('is-on');
  }
  /** Schedule a callback on a visual beat (ms from cinematic start). */
  function atBeat(ms, fn) {
    setTimeout(fn, Math.max(0, ms));
  }
  /** Depth layer for particles: 0=bg slow/soft, 1=mid, 2=fg fast/sharp */
  function pickDepth(preferFg) {
    var r = Math.random();
    if (preferFg) return r < 0.25 ? 1 : 2;
    if (r < 0.38) return 0;
    if (r < 0.72) return 1;
    return 2;
  }
  function depthProfile(depth) {
    if (depth === 0) return { size: 0.45, speed: 0.42, alpha: 0.38, blur: 6, trail: false, glow: 4 };
    if (depth === 1) return { size: 0.8, speed: 0.78, alpha: 0.72, blur: 2, trail: true, glow: 10 };
    return { size: 1.25, speed: 1.2, alpha: 1, blur: 0, trail: true, glow: 18 };
  }

  /** V4 intensity ladder — same system for every path; low tiers get a lighter touch. */
  function tierFx(tier) {
    var t = Math.min(10, Math.max(1, Number(tier) || 1));
    if (t <= 2) return { punch: 0.32, particles: 12, shake: 2, glow: 0.12, ring: 0.35, holdMs: 2600, sfxLead: 0 };
    if (t <= 4) return { punch: 0.52, particles: 20, shake: 4, glow: 0.16, ring: 0.5, holdMs: 3400, sfxLead: 30 };
    if (t <= 6) return { punch: 0.85, particles: 32, shake: 8, glow: 0.22, ring: 0.7, holdMs: 4200, sfxLead: 50 };
    if (t <= 8) return { punch: 1.45, particles: 52, shake: 14, glow: 0.3, ring: 0.9, holdMs: 6200, sfxLead: 60 };
    if (t === 9) return { punch: 2.05, particles: 72, shake: 20, glow: 0.38, ring: 1, holdMs: 8800, sfxLead: 80 };
    return { punch: 2.65, particles: 96, shake: 26, glow: 0.45, ring: 1, holdMs: 10000, sfxLead: 80 };
  }

  /** Lightweight depth-layered particle burst for cute/medium stages (V4). */
  function miniDepthBurst(color, accent, count, strength) {
    var n = Math.max(6, count || 12);
    var s = strength == null ? 1 : strength;
    var canvas = document.createElement('canvas');
    canvas.className = 'gif-mini-fx';
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    var ctx = canvas.getContext('2d');
    var parts = [];
    var W = canvas.width;
    var H = canvas.height;
    var cx = W * 0.5;
    var cy = H * 0.42;
    for (var i = 0; i < n; i++) {
      var depth = pickDepth(false);
      var prof = depthProfile(depth);
      var a = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 1.6;
      var sp = (3.2 + Math.random() * 5.5) * prof.speed * s;
      parts.push({
        x: cx + (Math.random() - 0.5) * 40,
        y: cy + (Math.random() - 0.5) * 30,
        vx: Math.cos(a) * sp,
        vy: Math.sin(a) * sp,
        r: (1.4 + Math.random() * 2.2) * prof.size * (0.7 + s * 0.35),
        life: 1,
        decay: 0.012 + Math.random() * 0.01 + (depth === 0 ? 0.004 : 0),
        color: Math.random() > 0.45 ? color : accent,
        depth: depth,
        alpha: prof.alpha,
        glow: prof.glow
      });
    }
    document.body.appendChild(canvas);
    var t0 = performance.now();
    function frame(now) {
      var el = now - t0;
      ctx.clearRect(0, 0, W, H);
      var alive = false;
      for (var i = 0; i < parts.length; i++) {
        var p = parts[i];
        if (p.life <= 0) continue;
        alive = true;
        p.x += p.vx;
        p.y += p.vy;
        p.vy += p.depth === 0 ? 0.045 : p.depth === 2 ? 0.09 : 0.065;
        p.vx *= 0.985;
        p.life -= p.decay;
        if (p.life <= 0) continue;
        ctx.save();
        ctx.globalAlpha = Math.max(0, p.life) * p.alpha;
        ctx.shadowBlur = p.glow;
        ctx.shadowColor = p.color;
        ctx.beginPath();
        ctx.arc(p.x, p.y, Math.max(0.4, p.r * p.life), 0, Math.PI * 2);
        ctx.fillStyle = p.color;
        ctx.fill();
        ctx.restore();
      }
      if (alive && el < 1600) requestAnimationFrame(frame);
      else canvas.remove();
    }
    requestAnimationFrame(frame);
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

  /* flying gift train (bottom → top icons) — depth-staggered, smoother ease */
  function giftTrain(emoji, n, color) {
    for (var i = 0; i < n; i++) {
      (function (i) {
        var depth = i % 3;
        var stagger = i * (depth === 2 ? 95 : depth === 1 ? 120 : 150) + Math.random() * 40;
        setTimeout(function () {
          var el = document.createElement('div');
          el.className = 'gif-train-item depth-' + depth;
          el.style.left = (12 + Math.random() * 76) + '%';
          el.style.color = color || '#fbbf24';
          el.style.setProperty('--train-dur', (depth === 2 ? 2.1 : depth === 1 ? 2.5 : 3.1) + 's');
          el.textContent = emoji || '🎁';
          document.body.appendChild(el);
          setTimeout(function () { el.remove(); }, 3600);
        }, stagger);
      })(i);
    }
  }

  /* ── TIER 1–2 cute — V4 light polish (depth particles, micro punch, beat SFX) ── */
  function playCute(opts) {
    ensureCss();
    var st = styleFor(opts.gift_key);
    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    var combo = bumpCombo(opts.gift_key || 'gift');
    var emoji = opts.emoji || meta.emoji || '✨';
    var tier = opts.tier || meta.tier || 1;
    var fx = tierFx(tier);
    var imageUrl = opts.image || meta.image || null;
    var label = opts.label || meta.label || 'Gift';

    // Beat-synced entry SFX (not fire-and-forget before paint)
    requestAnimationFrame(function () {
      setTimeout(function () { playSfx('ding'); }, fx.sfxLead);
    });

    var el = document.createElement('div');
    el.className = 'gif-cute is-v4';
    el.innerHTML =
      '<span class="gif-cute-glow" style="background:radial-gradient(circle,' + st.glow + '66,transparent 70%);opacity:' + fx.glow + '"></span>' +
      '<span class="gif-cute-ring" style="border-color:' + st.glow + ';opacity:' + fx.ring + '"></span>' +
      '<span class="gif-cute-emoji' + (imageUrl ? ' has-photo' : '') + '">' +
        (imageUrl ? '<img class="gif-cute-photo" src="' + esc(imageUrl) + '" alt="" draggable="false">' : esc(emoji)) +
      '</span>' +
      '<span class="gif-cute-v4-stamp">FX V4</span>' +
      (combo > 1 ? '<span class="gif-combo" style="color:' + st.accent + '">x' + combo + '</span>' : '');
    document.body.appendChild(el);

    // Light camera micro-punch + product glow pulse
    cameraPunch(el, fx.punch, 480);
    el.classList.add('has-glow');
    setTimeout(function () {
      miniDepthBurst(st.glow, st.accent, fx.particles, 0.55 + tier * 0.08);
      flash(hexA(st.glow, fx.glow * 0.7), 120);
      if (fx.shake > 0 && tier >= 2) shake(fx.shake, 220);
      playSfx('chime');
    }, 220);

    giftTrain(emoji, 3 + Math.min(combo, 4), st.glow);

    setTimeout(function () { el.remove(); }, Math.max(2200, fx.holdMs));
    if (opts.from || opts.label) {
      toast((opts.from ? opts.from + ' · ' : '') + (emoji) + ' ' + label + (opts.amount ? ' · $' + opts.amount : '') + (combo > 1 ? '  ×' + combo : ''), 2400);
    }
  }

  /* $250+ gets real fireworks behind the product — below that stays clean */
  function wantsFireworks(amountCents) {
    return Number(amountCents) >= 25000;
  }

  /* Soft petal fall for flowers — minimal, premium */
  function petalRain(color, accent, n) {
    for (var i = 0; i < (n || 8); i++) {
      (function (i) {
        var depth = i % 2;
        setTimeout(function () {
          var p = document.createElement('div');
          p.className = 'gif-petal depth-' + depth;
          p.style.left = (Math.random() * 100) + '%';
          p.style.background = i % 2 ? (color || '#f43f5e') : (accent || '#fb7185');
          p.style.opacity = String(depth === 0 ? 0.35 : 0.55);
          p.style.animationDuration = (2.8 + Math.random() * 1.4) + 's';
          p.style.animationDelay = (Math.random() * 0.5) + 's';
          p.style.animationTimingFunction = EASE.outQuint;
          document.body.appendChild(p);
          setTimeout(function () { p.remove(); }, 5000);
        }, i * 70);
      })(i);
    }
  }

  /* Pour cinematic: glass stationed → bottle picked up → tip toward glass → pour in → cheers */
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
    var duration = 8.2;
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
            '<div class="gif-pour-mouth bottle-mouth" id="pour-bottle-mouth"></div>' +
            (bottleUrl ? '<img src="' + esc(bottleUrl) + '" alt="" draggable="false">' : '<div class="gif-orb-product" style="width:120px;height:120px"></div>') +
            (isChampagne ? '<div class="gif-cork" id="pour-cork"></div><div class="gif-spray" id="pour-spray"></div>' : '') +
          '</div>' +
          '<div class="gif-pour-glass-hero" id="pour-glass">' +
            '<div class="gif-pour-mouth glass-mouth" id="pour-glass-mouth"></div>' +
            '<div class="gif-liquid-shell" id="pour-liquid-shell">' +
              '<div class="gif-liquid-fill" id="pour-liquid"></div>' +
            '</div>' +
            (glassUrl ? '<img src="' + esc(glassUrl) + '" alt="" draggable="false">' : '') +
            '<div class="gif-foam" id="pour-foam"></div>' +
          '</div>' +
        '</div>' +
        '<div class="gif-copy pour-copy">' +
          (opts.from ? '<div class="gif-from">' + esc(opts.from) + '</div>' : '') +
          '<div class="gif-title" id="pour-title" data-text="READY" style="--title-glow:' + st.glow + '">READY</div>' +
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
    var liquidShell = root.querySelector('#pour-liquid-shell');
    var foamEl = root.querySelector('#pour-foam');
    var title = root.querySelector('#pour-title');

    var canvas = root.querySelector('#gif-pour-fx');
    var ctx = canvas.getContext('2d');
    var W = canvas.width = window.innerWidth;
    var H = canvas.height = window.innerHeight;
    var particles = [];
    var pouring = false;
    var pourT0 = 0;
    var pourLeadMs = 180;
    var pourStreamDelayMs = 260;
    var pourFillMs = isChampagne ? 2200 : 1900;
    // ~75% full in the cup/bowl
    var pourMaxPct = isChampagne ? 62 : isWine ? 52 : 78;
    var fillPct = 0;
    var t0 = performance.now();
    var raf;

    // Mask liquid ONLY to dedicated inner cutouts (beer/wine/flute) — never full glass PNG
    // (full glass alpha includes stem/rim/base and caused liquid leaking outside the bowl)
    if (liquidShell) {
      var innerMask = isChampagne
        ? '/img/gifts/masks/flute-inner.png?v=fx4i'
        : isWine
          ? '/img/gifts/masks/wine-inner.png?v=fx4i'
          : '/img/gifts/masks/beer-inner.png?v=fx4i';
      var maskUrl = 'url("' + innerMask + '")';
      liquidShell.style.webkitMaskImage = maskUrl;
      liquidShell.style.maskImage = maskUrl;
      liquidShell.style.webkitMaskSize = '100% 100%';
      liquidShell.style.maskSize = '100% 100%';
      liquidShell.style.webkitMaskRepeat = 'no-repeat';
      liquidShell.style.maskRepeat = 'no-repeat';
      liquidShell.style.webkitMaskMode = 'alpha';
      liquidShell.style.maskMode = 'alpha';
      if ((' ' + root.className + ' ').indexOf(' pour-' + pourKind + ' ') === -1) {
        root.className += ' pour-' + pourKind;
      }
    }
    if (liquidEl) {
      liquidEl.style.background = 'linear-gradient(180deg,' + liquidHi + ' 0%,' + liquid + ' 40%,' + liquid + ' 100%)';
      liquidEl.style.height = '0%';
    }

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

    // Choreography: glass first (stationed), bottle picked up, then pours INTO the glass
    // 0ms — glass sits on the right
    glass.classList.add('visible');
    setTitle('READY');

    // 350ms — bottle is picked up / flies in from the left
    setTimeout(function () {
      bottle.classList.add('enter');
      bottle.style.opacity = '1';
      setTitle('POURING…');
    }, 350);

    // champagne cork pop after bottle lands; beer/wine just open
    if (isChampagne) {
      setTimeout(function () {
        setTitle('POP!');
        if (cork) cork.classList.add('flying');
        if (spray) spray.classList.add('active');
        playSfx('pop');
        flash('#fffbeb', 200);
        shake(8, 350);
        var br = bottle.getBoundingClientRect();
        var mouthB = root.querySelector('#pour-bottle-mouth');
        var mbb = mouthB ? mouthB.getBoundingClientRect() : br;
        mist(mbb.left + mbb.width * 0.5, mbb.top + mbb.height * 0.3, 46, '#fffbeb');
        mist(mbb.left + mbb.width * 0.5, mbb.top + mbb.height * 0.3, 18, st.glow);
        playSfx('bubbles');
      }, 1450);
    } else {
      setTimeout(function () {
        setTitle('OPEN');
        playSfx('pop');
      }, 1200);
    }

    // tip bottle toward the stationed glass
    setTimeout(function () {
      bottle.classList.add('tilting');
      setTitle('TIP');
    }, isChampagne ? 2100 : 1750);

    // pour — visible stream first; fill rises in sync as stream lands
    setTimeout(function () {
      pouring = true;
      pourT0 = performance.now();
      fillPct = 0;
      bottle.classList.add('pouring');
      if (liquidShell) liquidShell.classList.add('is-live');
      if (liquidEl) {
        liquidEl.style.height = '0%';
        liquidEl.style.opacity = '1';
      }
      playSfx('pour');
      setTitle('POUR');
    }, isChampagne ? 2700 : 2300);

    // stop pour (JS also finishes fill to pourMaxPct while stream is up)
    setTimeout(function () {
      pouring = false;
      bottle.classList.add('untilt');
      if (liquidEl) {
        fillPct = pourMaxPct;
        liquidEl.style.height = pourMaxPct + '%';
        liquidEl.classList.add('full');
      }
      if (foamEl) {
        foamEl.classList.add('show');
        foamEl.classList.add('full');
      }
      setTitle('CHEERS');
      playSfx('ding');
      glass.classList.add('toast');
    }, isChampagne ? 5200 : 4400);

    setTimeout(function () {
      flash(hexA(st.glow, 0.28), 180);
      playSfx('chime');
    }, isChampagne ? 5600 : 4800);

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

      // pour stream + synced fill
      if (pouring && bottle && glass) {
        var sincePour = performance.now() - pourT0;
        // Hold stream until bottle is in pour pose — prevents liquid “leaking” at the old upright top
        if (sincePour < pourStreamDelayMs) {
          // still allow fill prep after lead, but no stream yet
        } else {
        var mouthB = root.querySelector('#pour-bottle-mouth') || bottle;
        var mouthG = root.querySelector('#pour-glass-mouth') || glass;
        var mbb = mouthB.getBoundingClientRect();
        var mgb = mouthG.getBoundingClientRect();
        var bb = bottle.getBoundingClientRect();
        var bottleImg = bottle.querySelector('img');
        var bib = bottleImg ? bottleImg.getBoundingClientRect() : bb;

        // No stream line — glass fill only (user preference)
        if (sincePour > pourStreamDelayMs + pourLeadMs && liquidEl) {
          var fp = Math.min(1, (sincePour - pourStreamDelayMs - pourLeadMs) / pourFillMs);
          fp = 1 - Math.pow(1 - fp, 2.2);
          fillPct = fp * pourMaxPct;
          liquidEl.style.height = fillPct + '%';
          liquidEl.classList.add('filling');
          if (foamEl && fillPct > pourMaxPct * 0.7) foamEl.classList.add('show');
        }
        }
      }

      // bubbles only inside the glass while filling (no stream line)
      if (liquidEl && liquidEl.classList.contains('filling') && Math.random() > 0.7 && glass) {
        var gimgEl = glass.querySelector('img');
        var gbb = (gimgEl || glass).getBoundingClientRect();
        bubble(gbb.left + gbb.width * (0.42 + Math.random() * 0.16), gbb.top + gbb.height * (0.4 + Math.random() * 0.2));
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

  /* ── Medium stage — photoreal product + V4 depth particles / beat SFX / scaled punch ── */
  function playMedium(opts) {
    ensureCss();
    var st = styleFor(opts.gift_key);
    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    if (opts.gift_key === 'rose' && global.FFM_GIFT_META && global.FFM_GIFT_META.protein_shake) {
      meta = global.FFM_GIFT_META.protein_shake;
      st = styleFor('protein_shake');
    }
    var combo = bumpCombo(opts.gift_key || 'gift');
    var amountCents = opts.amount_cents != null ? opts.amount_cents : (meta.amount || 0);
    var tier = opts.tier || meta.tier || 2;
    var fx = tierFx(Math.max(tier, 2));
    var big = wantsFireworks(amountCents);
    var isFlowers = !!meta.flowers || opts.gift_key === 'bouquet';
    var isPour = !!meta.pour;
    var imageUrl = opts.image || meta.image || null;
    var label = opts.label || meta.label || 'Gift';
    var emoji = opts.emoji || meta.emoji || '✨';
    var isHighFive = opts.gift_key === 'high_five' || meta.scene === 'highfive';
    var isShake = opts.gift_key === 'protein_shake' || opts.gift_key === 'rose';

    // Beat-synced SFX — fire after paint so impact aligns with motion
    if (isPour) playSfx('pop');
    else if (isHighFive) {
      setTimeout(function () {
        playSfx('slap');
        flash(hexA(st.glow, 0.28 + fx.glow * 0.4), 140);
        cameraPunch(root, fx.punch, 420);
        miniDepthBurst(st.glow, st.accent, Math.round(fx.particles * 0.7), 0.7);
      }, 560);
    }
    else if (isShake) {
      setTimeout(function () {
        playSfx('ding');
        cameraPunch(root, fx.punch, 480);
        miniDepthBurst(st.glow, st.accent, fx.particles, 0.65);
      }, 380);
    }
    else if (isFlowers) {
      setTimeout(function () { playSfx('chime'); }, fx.sfxLead);
    }
    else {
      setTimeout(function () {
        playSfx('ding');
        cameraPunch(root, fx.punch, 480);
        miniDepthBurst(st.glow, st.accent, fx.particles, 0.6);
      }, 320);
    }

    giftTrain(emoji, big ? 4 : 2, st.glow);

    var productHtml = imageUrl
      ? '<img class="gif-med-photo" src="' + esc(imageUrl) + '" alt="" draggable="false">'
      : esc(emoji);

    var root = document.createElement('div');
    root.className = 'gif-medium is-premium is-v4' + (FEVER > 0.5 ? ' is-fever' : '') + (isFlowers ? ' is-flowers' : '') + (imageUrl ? ' has-photo' : '') + ' scene-' + (meta.scene || st.scene || 'burst');
    root.innerHTML =
      '<div class="gif-medium-bg" style="background:radial-gradient(ellipse at 50% 42%,' + st.glow + (big ? '33' : '28') + ',transparent 62%),radial-gradient(ellipse at 50% 50%,#0f172acc,transparent)"></div>' +
      '<div class="gif-product-aura" style="--aura:' + st.glow + ';--aura2:' + st.accent + ';--aura-op:' + fx.glow + '"></div>' +
      '<div class="gif-medium-ring r1" style="border-color:' + st.glow + (big ? '88' : '66') + '"></div>' +
      '<div class="gif-medium-ring r2" style="border-color:' + st.accent + '55"></div>' +
      '<div class="gif-medium-emoji' + (imageUrl ? ' has-photo' : '') + '">' + productHtml + '</div>' +
      '<div class="gif-product-glow-pulse" style="--glow-c:' + st.glow + '"></div>' +
      '<div class="gif-medium-label">' +
        '<div class="gif-from">' + esc(opts.from || '') + '</div>' +
        '<div class="gif-title">' + esc(label) + '</div>' +
        (opts.amount ? '<div class="gif-sub" style="color:' + st.accent + '">$' + esc(money(opts.amount)) + '</div>' : '') +
        (combo > 1 ? '<div class="gif-combo-med" style="color:' + st.glow + '">×' + combo + '</div>' : '') +
        '<div class="gif-v4-stamp">FX V4 · T' + tier + '</div>' +
      '</div>';
    document.body.appendChild(root);

    // Entrance camera punch + product glow (scaled by tier)
    cameraPunch(root, fx.punch * 0.75, 500);
    if (isFlowers) petalRain(st.glow, st.accent, big ? 14 : 10);
    if (!isHighFive && !isShake && !isPour) {
      setTimeout(function () { miniDepthBurst(st.glow, st.accent, fx.particles, 0.55); }, 280);
    }
    flash(hexA(st.glow, big ? 0.22 : 0.08 + fx.glow * 0.5), 160);
    setTimeout(function () { root.remove(); }, isPour ? 4800 : Math.max(3200, fx.holdMs));
  }

  /* ── TIER 5+ cinematic — V4 multi-act, beat-sync, depth particles ── */
  function playCinematic(opts) {
    if (ACTIVE) {
      toast((opts.from ? opts.from + ' · ' : '') + (opts.emoji || '') + ' ' + (opts.label || 'Gift'), 2200);
      return;
    }
    ACTIVE = true;
    ensureCss();

    var tier = Math.min(10, opts.tier || 5);
    var st = styleFor(opts.gift_key);
    var isIcon = tier >= 10;          // top moment tier
    var isLegend = tier >= 9;         // second-top moment tier
    var isPower = tier >= 7;          // strong camera punch threshold
    var isSpect = tier >= 7 && !isLegend && !isIcon;
    var fx = tierFx(tier);
    var scene = st.scene || 'burst';
    var meta = (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key]) || {};
    var isMystery = !!meta.mystery || opts.gift_key === 'mystery_box';
    var imageUrl = opts.image || meta.image || null;
    if (isMystery) scene = 'mystery';

    var duration = isIcon ? 11.5 : isLegend ? 10 : isSpect ? 7.6 : 6.2;
    if (isMystery) duration = Math.max(duration, 12);
    if (scene === 'car' || scene === 'flight') duration = Math.max(duration, isIcon ? 10.5 : 8.2);

    var combo = bumpCombo(opts.gift_key || 'gift');
    var emoji = opts.emoji || '✨';
    var label = opts.label || 'GIFT';
    var productSvg = svgFor(opts.gift_key, st);
    var productHtml = imageUrl
      ? '<img class="gif-product-photo" src="' + esc(imageUrl) + '" alt="" draggable="false">'
      : productSvg;
    var amountCents = opts.amount_cents != null ? opts.amount_cents : (meta.amount || 0);
    var bigMoney = wantsFireworks(amountCents) || isPower;
    var isFlowers = !!meta.flowers || opts.gift_key === 'bouquet';

    /* Beat map (ms) — SFX + camera fire on these exact frames */
    var beats = isIcon
      ? { enter: 0, glow: 180, hero: 900, action: 2000, build: 3400, climax: 5200, hold: 6400, peak: 7600, exit: Math.max(8200, duration * 1000 - 1400) }
      : isLegend
      ? { enter: 0, glow: 160, hero: 800, action: 1700, build: 2900, climax: 4300, hold: 5400, peak: 6400, exit: Math.max(7000, duration * 1000 - 1200) }
      : isSpect
      ? { enter: 0, glow: 140, hero: 700, action: 1400, build: 2200, climax: 3200, hold: 4000, peak: 4600, exit: duration * 1000 - 900 }
      : { enter: 0, glow: 120, hero: 600, action: 1200, build: 1800, climax: 2600, hold: 3200, peak: 3600, exit: duration * 1000 - 800 };

    var tierClass = (isMystery || isIcon) ? 'icon' : isLegend ? 'legend' : isSpect ? 'spectacular' : 'major';
    var badgeText = isMystery ? 'SEALED' : isIcon ? 'ICON' : isLegend ? 'LEGENDARY' : isSpect ? 'SPECTACULAR' : 'EPIC';

    var revealLabel = label;
    if (isMystery) {
      var prizes = ['Sports Car', 'Luxury Holiday', 'Diamond Bracelet', 'Luxury Watch', 'Designer Bag', 'Home Gym'];
      revealLabel = prizes[(Math.random() * prizes.length) | 0];
      label = 'Mystery Box';
    }

    var root = document.createElement('div');
    root.id = 'gif-special-root';
    root.className = 'gif-cine is-' + tierClass + ' scene-' + scene +
      (FEVER > 0.4 ? ' is-fever' : '') + (imageUrl ? ' has-photo' : '') +
      (isPower ? ' is-power' : '') + (isIcon ? ' is-icon' : '');
    root.innerHTML =
      '<div class="gif-cine-vignette"></div>' +
      '<canvas id="gif-canvas"></canvas>' +
      '<div class="gif-cine-flash"></div>' +
      ((isLegend || isIcon) ? '<div class="gif-letterbox top"></div><div class="gif-letterbox bottom"></div><div class="gif-fx-stamp">FX V4 · ' + (isIcon ? 'ICON' : 'LEGEND') + '</div><div class="gif-beat-caption"></div>' : '') +
      '<div class="gif-cine-stage">' +
        '<div class="gif-godrays" style="--ray:' + st.glow + '"></div>' +
        '<div class="gif-orbit o1" style="border-color:' + st.glow + '55"></div>' +
        '<div class="gif-orbit o2" style="border-color:' + st.accent + '44"></div>' +
        (isLegend || isIcon ? '<div class="gif-orbit o3" style="border-color:' + st.spark + '33"></div>' : '') +
        '<div class="gif-shock" style="border-color:' + st.glow + '"></div>' +
        '<div class="gif-shock s2" style="border-color:' + st.accent + '"></div>' +
        (isIcon ? '<div class="gif-shock s3" style="border-color:' + st.spark + '"></div>' : '') +
        '<div class="gif-product-wrap scene-' + scene + (imageUrl ? ' has-photo' : '') + (isIcon ? ' icon' : isLegend ? ' legend' : '') + '" id="gif-product-wrap">' +
          '<div class="gif-product-aura" style="--aura:' + st.glow + ';--aura2:' + st.accent + '"></div>' +
          (imageUrl ? '' : '<div class="gif-product-shadow"></div>') +
          '<div class="gif-product illustrated' + (imageUrl ? ' has-img' : '') + '" style="--title-glow:' + st.glow + '">' + productHtml + '</div>' +
          (imageUrl ? '' : '<div class="gif-product-shine"></div>') +
          '<div class="gif-product-photo-glow" style="--glow-c:' + st.glow + '"></div>' +
          (isMystery ? '<div class="gif-mystery-seam"></div><div class="gif-mystery-q">?</div>' : '') +
          '<div class="gif-speed-blur"></div>' +
          '<div class="gif-ground-trail"></div>' +
        '</div>' +
        '<div class="gif-copy">' +
          (opts.from ? '<div class="gif-from">' + esc(opts.from) + '</div>' : '') +
          '<div class="gif-title" data-text="' + esc(isMystery ? 'OPENING…' : label) + '" style="--title-glow:' + st.glow + '">' + esc(isMystery ? 'OPENING…' : label) + '</div>' +
          '<div class="gif-meta">' +
            (opts.amount && !isMystery ? '<span class="gif-amount" style="color:' + st.accent + '">$' + esc(money(opts.amount)) + '</span>' : '') +
            '<span class="gif-tier-badge ' + tierClass + '" style="--badge:' + st.glow + '">' + badgeText + '</span>' +
          '</div>' +
          (combo > 1 ? '<div class="gif-combo-cine' + (FEVER > 0.5 ? ' fever' : '') + '" style="color:' + st.glow + '">×' + combo + (FEVER > 0.5 ? ' FEVER' : '') + '</div>' : '') +
        '</div>' +
      '</div>' +
      '<div class="gif-smoke-layer"></div>' +
      '<div class="gif-dust-layer"></div>';
    document.body.appendChild(root);

    var wrap = root.querySelector('#gif-product-wrap');
    var titleEl = root.querySelector('.gif-title');
    var badgeEl = root.querySelector('.gif-tier-badge');

    function setStage(name) {
      if (!wrap) return;
      wrap.classList.remove('stage-enter', 'stage-hero', 'stage-action', 'stage-build', 'stage-climax', 'stage-hold', 'stage-exit');
      wrap.classList.add('stage-' + name);
    }
    function setTitle(text) {
      if (!titleEl) return;
      titleEl.setAttribute('data-text', text);
      titleEl.textContent = text;
    }

    /* ── Choreography acts (V4: longer, distinct for Legend/Icon) ── */
    setStage('enter');
    if (isLegend || isIcon) setBeatCaption(root, 'ARRIVAL');
    atBeat(beats.glow, function () {
      // T5–6 get a lighter punch than Power/Legend/Icon — same system, scaled
      cameraPunch(root, isIcon ? 1.7 : isLegend ? 1.45 : isPower ? 1.35 : fx.punch * 1.1, 560);
      if (isLegend || isIcon) setBeatCaption(root, 'CHARGE');
    });
    atBeat(beats.hero, function () {
      setStage('hero');
      cameraPunch(root, isIcon ? 2.1 : isLegend ? 1.85 : isPower ? 1.35 : fx.punch * 1.25, 680);
      if (isLegend || isIcon) setBeatCaption(root, 'HERO');
      if (scene === 'diamond') playSfx('chime');
      else if (scene === 'watch') playSfx('tick');
      else if (scene === 'mystery') playSfx('tick');
      else if (isIcon || isLegend) playSfx('whoosh');
      else if (!isPower) playSfx('whoosh');
    });
    atBeat(beats.action, function () {
      setStage('action');
      if (isLegend || isIcon) setBeatCaption(root, isIcon ? 'ICON ACTION' : 'LEGEND ACTION');
      if (scene === 'car') playSfx('engine');
      else if (scene === 'flight') playSfx('jet');
      else if (scene === 'champagne') { playSfx('pop'); playSfx('bubbles'); }
      else if (scene === 'diamond') playSfx('chime');
      else if (isPower) playSfx('boom');
    });
    atBeat(beats.build, function () {
      setStage('build');
      if (isLegend || isIcon) {
        setTitle(isIcon ? 'INCOMING…' : 'RISING…');
        setBeatCaption(root, 'BUILD');
        playSfx('ding');
      }
    });
    atBeat(beats.climax, function () {
      setStage('climax');
      var punch = isIcon ? 2.6 : isLegend ? 2.25 : isPower ? 1.55 : Math.max(0.75, fx.punch * 1.35);
      cameraPunch(root, punch, 780);
      if (isLegend || isIcon) setBeatCaption(root, isIcon ? 'ICON IMPACT' : 'LEGEND IMPACT');
      if (isIcon) { flash('#ffffff', 380); shake(28, 800); }
      else if (isLegend) { flash(hexA(st.spark, 0.95), 340); shake(22, 720); }
      else if (isPower) { flash(hexA(st.glow, 0.6), 240); shake(14, 520); }
      else { flash(hexA(st.glow, 0.22 + fx.glow), 160); shake(Math.max(4, fx.shake), 360); }

      // impact SFX ON the climax frame
      if (scene === 'car') { playSfx('engine'); playSfx('boom'); }
      else if (scene === 'flight') { playSfx('jet'); playSfx('boom'); }
      else if (scene === 'champagne') { playSfx('pop'); playSfx('chime'); }
      else if (scene === 'diamond') { playSfx('chime'); playSfx('legend'); }
      else if (scene === 'watch') { playSfx('ding'); playSfx('legend'); }
      else if (isMystery) { playSfx('tick'); }
      else if (isIcon || isLegend) { playSfx('boom'); playSfx('legend'); }
      else playSfx('boom');

      if (isIcon || isLegend) setTitle(label);
    });
    atBeat(beats.hold, function () {
      setStage('hold');
      if (isIcon) {
        playSfx('chime');
        flash(hexA(st.glow, 0.28), 220);
        setBeatCaption(root, 'HOLD');
      } else if (isLegend) {
        setBeatCaption(root, 'HOLD');
      }
    });
    atBeat(beats.peak, function () {
      if (!(isIcon || isLegend || isPower)) return;
      cameraPunch(root, isIcon ? 2.2 : isLegend ? 1.9 : 1.4, 620);
      if (isLegend || isIcon) setBeatCaption(root, isIcon ? 'ICON PEAK' : 'LEGEND PEAK');
      if (bigMoney) {
        launchFirework(W * 0.3, st.glow);
        launchFirework(W * 0.7, st.accent);
      }
      if (isIcon || isLegend) playSfx('legend');
      if (isMystery) {
        var amountEl = root.querySelector('.gif-meta');
        var seam = root.querySelector('.gif-mystery-seam');
        var q = root.querySelector('.gif-mystery-q');
        setTitle(revealLabel);
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
        flash('#fffbeb', 320);
        shake(24, 760);
        cameraPunch(root, 2.8, 820);
        setBeatCaption(root, 'MYSTERY OPEN');
        playSfx('boom');
        playSfx('legend');
      }
    });
    atBeat(beats.exit, function () {
      setStage('exit');
      if (isLegend || isIcon) setBeatCaption(root, '');
    });

    /* Scene openers timed to action/build */
    if (scene === 'car') {
      for (var sp = 0; sp < 14; sp++) atBeat(120 + sp * 55, lightStreak);
      atBeat(beats.action + 200, function () {
        burst(W * 0.5, H * 0.42, 90, 12, { trail: true, lift: 2, depthFg: true });
      });
    }
    if (scene === 'diamond') {
      for (var pr = 0; pr < (isLegend || isIcon ? 10 : 6); pr++) {
        (function (pr) {
          atBeat(beats.action + pr * (isIcon ? 280 : 320), function () {
            burst(W * (0.15 + Math.random() * 0.7), H * (0.22 + Math.random() * 0.4), 42, 7, { trail: true });
            if (pr % 2 === 0) playSfx('chime');
          });
        })(pr);
      }
    }
    if (scene === 'watch') {
      var ticks = isIcon ? 14 : 10;
      for (var tk = 0; tk < ticks; tk++) {
        (function (tk) { atBeat(beats.action + tk * (isIcon ? 90 : 110), function () { playSfx('tick'); }); })(tk);
      }
    }
    if (scene === 'flight') {
      for (var fl = 0; fl < (isIcon ? 8 : 5); fl++) atBeat(100 + fl * 160, lightStreak);
    }
    if (scene === 'champagne' && bigMoney) {
      atBeat(beats.climax, function () { rain(50, true); });
    }
    if (isFlowers) atBeat(beats.hero, function () { petalRain(st.glow, st.accent, isIcon ? 48 : 36); });

    /* Staged particle bursts — clean under $250; fireworks carry $250+ */
    var burstPlan = !bigMoney
      ? [{ t: beats.climax, n: 16, s: 5 }]
      : isIcon
      ? [{ t: beats.hero, n: 28, s: 6 }, { t: beats.climax, n: 40, s: 8 }, { t: beats.peak, n: 36, s: 7 }]
      : isLegend
      ? [{ t: beats.hero, n: 24, s: 6 }, { t: beats.climax, n: 34, s: 8 }, { t: beats.peak, n: 28, s: 7 }]
      : [{ t: beats.hero, n: 18, s: 5 }, { t: beats.climax, n: 26, s: 7 }];

    burstPlan.forEach(function (bp, idx) {
      atBeat(bp.t + (idx === 0 ? 40 : 0), function () {
        var bx = W / 2 + (Math.random() - 0.5) * W * 0.2;
        var by = H * 0.4 + (Math.random() - 0.5) * H * 0.12;
        burst(bx, by, bp.n, bp.s, { trail: bigMoney && idx > 0, lift: 0.8, soft: !bigMoney, spark: true });
      });
    });

    if (bigMoney && (isIcon || isLegend || isSpect)) {
      atBeat(beats.build + 100, function () {
        launchFirework(W * 0.22, st.glow);
        launchFirework(W * 0.78, st.accent);
        if (isLegend || isIcon) {
          launchFirework(W * 0.5, st.spark);
          launchFirework(W * 0.15, '#fbbf24');
          launchFirework(W * 0.85, st.glow);
        }
      });
    }

    /* dust / smoke — quiet under $250; only a hint when fireworks are allowed */
    var dustLayer = root.querySelector('.gif-dust-layer');
    var dustCount = !bigMoney ? 0 : (isIcon ? 16 : isLegend ? 12 : 6) + Math.floor(FEVER * 6);
    for (var d = 0; d < dustCount; d++) {
      (function (d) {
        var depth = pickDepth(false);
        var prof = depthProfile(depth);
        var dot = document.createElement('i');
        dot.className = 'depth-' + depth;
        dot.style.left = (Math.random() * 100) + '%';
        dot.style.top = (Math.random() * 100) + '%';
        dot.style.background = d % 2 ? st.glow : st.accent;
        dot.style.opacity = String(prof.alpha * 0.4);
        if (prof.blur) dot.style.filter = 'blur(' + prof.blur + 'px)';
        dot.style.width = (2 + depth) + 'px';
        dot.style.height = dot.style.width;
        dot.style.animationDelay = (Math.random() * 2.2) + 's';
        dot.style.animationDuration = ((depth === 0 ? 4.5 : depth === 1 ? 3.4 : 2.4) + Math.random() * 2) + 's';
        dustLayer.appendChild(dot);
      })(d);
    }
    var smokeLayer = root.querySelector('.gif-smoke-layer');
    var smokeN = !bigMoney ? 0 : (isIcon ? 3 : isLegend ? 2 : 1);
    for (var sm = 0; sm < smokeN; sm++) {
      (function (sm) {
        var puff = document.createElement('span');
        puff.style.left = (22 + sm * 22 + Math.random() * 6) + '%';
        puff.style.bottom = '12%';
        puff.style.opacity = '0.28';
        puff.style.background = 'radial-gradient(circle,' + st.glow + '2a,transparent 70%)';
        puff.style.animationDelay = (sm * 0.4) + 's';
        puff.style.animationTimingFunction = EASE.outExpo;
        smokeLayer.appendChild(puff);
      })(sm);
    }

    giftTrain(emoji, !bigMoney ? 0 : isIcon ? 6 : isLegend ? 4 : 2, st.glow);

    var canvas = root.querySelector('#gif-canvas');
    var ctx = canvas.getContext('2d');
    var W = canvas.width = window.innerWidth;
    var H = canvas.height = window.innerHeight;
    var particles = [];
    var streaks = [];
    var fireworks = [];
    var colors = [st.glow, st.accent, st.spark, '#fbbf24'];
    var t0 = performance.now();
    var raf;
    var feverMul = 1 + FEVER * 0.8;
    var streakTimer;

    // Ambient — under $250 stays empty; $250+ soft spark only (no paper)
    atBeat(beats.glow, function () {
      if (bigMoney) burst(W * 0.5, H * 0.42, 20, 4.5, { soft: true, spark: true });
    });

    function burst(x, y, n, speed, bo) {
      bo = bo || {};
      // Under $250: keep bursts tiny/clean — product is the hero
      if (!bigMoney) {
        n = Math.floor(Math.min(n, 18) * feverMul * 0.45);
      } else {
        n = Math.floor(n * feverMul);
      }
      for (var i = 0; i < n; i++) {
        var depth = bo.depthFg ? (Math.random() < 0.4 ? 1 : 2) : pickDepth(false);
        var prof = depthProfile(depth);
        var a = (Math.PI * 2 * i) / n + Math.random() * 0.7;
        var s = speed * prof.speed * (0.35 + Math.random() * 1.1);
        particles.push({
          x: x, y: y,
          vx: Math.cos(a) * s,
          vy: Math.sin(a) * s - (bo.lift || 1.4) * (0.6 + prof.speed * 0.5),
          r: (bo.size || (2 + Math.random() * 6)) * prof.size,
          life: 1,
          decay: (0.004 + Math.random() * 0.012) / (depth === 0 ? 1.35 : depth === 1 ? 1 : 0.85),
          color: colors[(Math.random() * colors.length) | 0],
          glow: true,
          trail: !!bo.trail && prof.trail,
          depth: depth,
          alphaMul: bo.soft ? Math.min(prof.alpha, 0.55) : prof.alpha,
          blur: bo.soft ? Math.max(prof.blur, 3) : prof.blur,
          glowSize: prof.glow,
          px: x, py: y,
          spark: !!bo.spark
        });
      }
    }
    /* Paper confetti removed — premium look only */
    function rain() { /* intentionally empty */ }

    /* Real fireworks: rocket rises BEHIND product (canvas z below stage), then peony/willow break */
    function launchFirework(tx, color) {
      var ground = H + 20;
      var ty = H * (0.14 + Math.random() * 0.2);
      fireworks.push({
        x: tx + (Math.random() - 0.5) * 30,
        y: ground,
        ty: ty,
        vx: (Math.random() - 0.5) * 0.4,
        vy: -(8.5 + Math.random() * 3.2),
        color: color || colors[(Math.random() * 3) | 0],
        exploded: false,
        t: 0,
        trail: []
      });
      playSfx('fw_launch');
    }
    function explodeFirework(fw) {
      var n = isIcon ? 88 : isLegend ? 72 : 54;
      var willow = Math.random() > 0.42;
      var secondary = fw.color;
      for (var i = 0; i < n; i++) {
        var a = (Math.PI * 2 * i) / n + Math.random() * 0.06;
        var s = (willow ? 5 : 9) + Math.random() * (willow ? 3.5 : 5.5);
        particles.push({
          x: fw.x, y: fw.y,
          vx: Math.cos(a) * s,
          vy: Math.sin(a) * s - (willow ? 0.4 : 1.4),
          r: willow ? 1.8 + Math.random() * 2.2 : 2.4 + Math.random() * 3,
          life: 1,
          decay: willow ? 0.007 + Math.random() * 0.009 : 0.01 + Math.random() * 0.009,
          color: (i % 5 === 0) ? st.spark : (i % 3 === 0 ? secondary : fw.color),
          glow: true,
          trail: true,
          willow: willow,
          depth: 1,
          alphaMul: 1,
          blur: 0,
          glowSize: 20,
          px: fw.x, py: fw.y,
          spark: true
        });
      }
      // bright core flash
      particles.push({
        x: fw.x, y: fw.y, vx: 0, vy: 0,
        r: 28, life: 1, decay: 0.07,
        color: '#fff', glow: true, bloom: true,
        alphaMul: 0.85, depth: 0, px: fw.x, py: fw.y
      });
      particles.push({
        x: fw.x, y: fw.y, vx: 0, vy: 0,
        r: 55, life: 1, decay: 0.045,
        color: fw.color, glow: true, bloom: true,
        alphaMul: 0.4, depth: 0, px: fw.x, py: fw.y
      });
      playSfx('fw_boom');
    }
    function lightStreak() {
      if (!bigMoney) return;
      var fromLeft = Math.random() > 0.5;
      var depth = pickDepth(true);
      var prof = depthProfile(depth);
      streaks.push({
        x: fromLeft ? -80 : W + 80,
        y: H * (0.18 + Math.random() * 0.35),
        vx: (fromLeft ? 1 : -1) * (12 + Math.random() * 18) * prof.speed,
        life: 1,
        decay: depth === 0 ? 0.01 : 0.014,
        color: colors[(Math.random() * 3) | 0],
        depth: depth,
        alphaMul: 0.5,
        w: depth === 2 ? 3 : 2
      });
    }
    function firework(x, y) { launchFirework(x != null ? x : W * (0.15 + Math.random() * 0.7)); }

    streakTimer = setInterval(function () {
      if (!bigMoney) return;
      if (Math.random() > (isIcon || isLegend ? 0.45 : 0.65)) lightStreak();
    }, isIcon ? 360 : isLegend ? 420 : 560);
    atBeat(duration * 1000 - 500, function () { clearInterval(streakTimer); });

    function frame(t) {
      var el = (t - t0) / 1000;
      ctx.clearRect(0, 0, W, H);
      var pulse = 0.5 + 0.5 * Math.sin(el * (2.6 + FEVER * 1.5));
      // Quieter stage wash under $250 — product stays the hero
      var wash = bigMoney ? (0.16 + pulse * 0.12) : (0.07 + pulse * 0.04);
      var g = ctx.createRadialGradient(W / 2, H * 0.42, 20, W / 2, H * 0.42, (bigMoney ? 340 : 260) + pulse * (bigMoney ? 120 : 40));
      g.addColorStop(0, hexA(st.glow, wash * (1 + FEVER * 0.35)));
      g.addColorStop(0.45, hexA(st.accent, bigMoney ? 0.04 + pulse * 0.03 : 0.02));
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);

      for (var si = streaks.length - 1; si >= 0; si--) {
        var sk = streaks[si];
        sk.x += sk.vx; sk.life -= sk.decay;
        if (sk.life <= 0) { streaks.splice(si, 1); continue; }
        ctx.save();
        ctx.globalAlpha = Math.max(0, sk.life) * 0.55 * (sk.alphaMul || 1);
        var grad = ctx.createLinearGradient(sk.x, sk.y, sk.x - sk.vx * 4, sk.y);
        grad.addColorStop(0, sk.color); grad.addColorStop(1, 'transparent');
        ctx.strokeStyle = grad; ctx.lineWidth = sk.w || 2; ctx.lineCap = 'round';
        ctx.shadowBlur = 8; ctx.shadowColor = sk.color;
        ctx.beginPath(); ctx.moveTo(sk.x, sk.y); ctx.lineTo(sk.x - sk.vx * 3.5, sk.y); ctx.stroke();
        ctx.restore();
      }

      /* Firework rockets — rise then break behind the product */
      for (var fi = fireworks.length - 1; fi >= 0; fi--) {
        var fw = fireworks[fi];
        fw.t += 16;
        if (!fw.exploded) {
          fw.trail.push({ x: fw.x, y: fw.y });
          if (fw.trail.length > 10) fw.trail.shift();
          fw.x += fw.vx;
          fw.y += fw.vy;
          fw.vy += 0.045; // gravity slows ascent
          // draw ascent trail
          ctx.save();
          for (var ti = 0; ti < fw.trail.length; ti++) {
            var tp = fw.trail[ti];
            var ta = (ti / fw.trail.length) * 0.7;
            ctx.globalAlpha = ta;
            ctx.fillStyle = fw.color;
            ctx.beginPath();
            ctx.arc(tp.x, tp.y, 1.2 + ti * 0.15, 0, Math.PI * 2);
            ctx.fill();
          }
          ctx.globalAlpha = 1;
          ctx.shadowBlur = 12; ctx.shadowColor = fw.color;
          ctx.fillStyle = '#fff';
          ctx.beginPath(); ctx.arc(fw.x, fw.y, 2.2, 0, Math.PI * 2); ctx.fill();
          ctx.restore();
          if (fw.y <= fw.ty || fw.vy >= -0.8) {
            fw.exploded = true;
            explodeFirework(fw);
          }
        } else if (fw.t > 200 && fw.exploded) {
          fireworks.splice(fi, 1);
        }
      }

      for (var i = particles.length - 1; i >= 0; i--) {
        var p = particles[i];
        p.px = p.x; p.py = p.y;
        if (p.bloom) {
          p.r += 2.5;
          p.life -= p.decay;
          if (p.life <= 0) { particles.splice(i, 1); continue; }
          ctx.save();
          ctx.globalAlpha = Math.max(0, p.life) * (p.alphaMul || 0.3);
          var bg = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r);
          bg.addColorStop(0, hexA(p.color, 0.55));
          bg.addColorStop(1, 'rgba(0,0,0,0)');
          ctx.fillStyle = bg;
          ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2); ctx.fill();
          ctx.restore();
          continue;
        }
        p.x += p.vx; p.y += p.vy;
        // willow falls heavier; soft sparks stay light
        p.vy += p.willow ? 0.055 : (p.depth === 0 ? 0.04 : p.depth === 2 ? 0.07 : 0.055);
        p.vx *= p.willow ? 0.985 : (p.depth === 0 ? 0.988 : 0.994);
        if (p.willow) p.vx *= 0.992;
        p.life -= p.decay;
        if (p.life <= 0 || p.y > H + 80) { particles.splice(i, 1); continue; }
        ctx.save();
        ctx.globalAlpha = Math.max(0, p.life) * (p.alphaMul != null ? p.alphaMul : 1);
        if (p.blur) ctx.filter = 'blur(' + p.blur + 'px)';
        if (p.trail) {
          ctx.strokeStyle = hexA(p.color, 0.4 * p.life * (p.alphaMul || 1));
          ctx.lineWidth = Math.max(1, p.r * 0.55);
          ctx.beginPath(); ctx.moveTo(p.px, p.py); ctx.lineTo(p.x, p.y); ctx.stroke();
        }
        ctx.shadowBlur = p.glowSize || 14; ctx.shadowColor = p.color;
        ctx.beginPath();
        ctx.arc(p.x, p.y, Math.max(0.4, p.r * Math.max(0.15, p.life)), 0, Math.PI * 2);
        ctx.fillStyle = p.spark && p.life > 0.7 ? '#fff' : p.color;
        ctx.fill();
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
    if (opts.emoji == null && opts.gift_key && global.FFM_GIFT_META) {
      var m = global.FFM_GIFT_META[opts.gift_key] || global.FFM_GIFT_META.protein_shake;
      if (opts.gift_key === 'rose' && global.FFM_GIFT_META.protein_shake) m = global.FFM_GIFT_META.protein_shake;
      if (m) {
        opts.emoji = m.emoji; opts.label = m.label; opts.amount = m.amount;
        tier = m.tier || tier;
      }
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
    // Photoreal gifts (high five, protein shake, etc.) use medium stage — not emoji pop
    var hasPhoto = !!(opts.image || metaCheck.image || (global.FFM_GIFT_META && global.FFM_GIFT_META[opts.gift_key] && global.FFM_GIFT_META[opts.gift_key].image));
    if (tier >= 5) playCinematic(Object.assign({}, opts, { tier: tier }));
    else if (tier >= 3 || hasPhoto) playMedium(Object.assign({}, opts, { tier: Math.max(tier, 2) }));
    else playCute(opts);
  }

  global.GiftFX = { play: play, styles: GIFT, unlockAudio: function () { audio(); }, engine: 'v4', ease: EASE };

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
