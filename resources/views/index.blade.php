@extends('layouts.app')
@section('title', 'FansFollow.me - Global Fitness & Martial Arts Creator Platform')

@push('head')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@section('fullbleed')
  <section class="home-hero" id="celebrities">
    <div class="container">
      <div class="hero-grid">
        <div>
          <h1>FansFollow.me — where fans become friends</h1>
          <div class="hero-eyebrow">For Fitness, Bodybuilding and Martial Arts Creators</div>
          <p>Built for fitness coaches, bodybuilders, nutrition experts, martial artists and combat sports creators to earn from fans worldwide through content, coaching and direct fan access.</p>
          <div class="home-cta">
            <a class="btn btn-light" href="{{ route('page.explore') }}">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              Explore Creators
            </a>
            <a class="btn btn-outline-light" href="{{ route('register') }}">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
              Get Started
            </a>
          </div>
        </div>
        <div class="home-hero__image">
          <img src="/public/logo-full-lockup.png" alt="FansFollow.me logo" loading="eager" decoding="async">
        </div>
      </div>
    </div>
  </section>

  <section class="section-dark">
    <div class="container">
      <div class="section-head" style="text-align:center;margin-bottom:2rem;">
        <h2>One home for fitness creators and their fans</h2>
        <p class="section-sub">FansFollow.me brings fighters, coaches, fitness influencers, sports professionals and actors with fitness-based content together on one platform, so fans can find them in one place and creators can build real relationships, add new revenue streams and unlock bigger opportunities.</p>
      </div>
      <div class="grid-4">
        <div class="feature-card"><div class="feature-icon"><i data-lucide="dollar-sign"></i></div><h3>Keep 80%+ Revenue</h3><p>Keep more of what you earn with a creator-first revenue share.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="zap"></i></div><h3>17+ Revenue Streams</h3><p>Earn through subscriptions, coaching, premium content, calls, tips and more.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="globe"></i></div><h3>Global Payments</h3><p>Accept payments from fans worldwide with flexible payment options.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="message-circle"></i></div><h3>Direct Fan Connection</h3><p>Build stronger fan relationships through private access and paid interactions.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="camera"></i></div><h3>Mobile Content Creation</h3><p>Create and upload content directly from your phone.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="phone"></i></div><h3>Instant Messaging</h3><p>Chat privately with fans in real time.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="video"></i></div><h3>Live Streaming</h3><p>Go live to your audience from any device.</p></div>
        <div class="feature-card"><div class="feature-icon"><i data-lucide="qr-code"></i></div><h3>In-Person QR Sign-Ups</h3><p>Let fans join and pay on the spot by scanning your unique QR code at events and gyms.</p></div>
      </div>
    </div>
  </section>

  <section class="fans-section" id="fans">
    <div class="fans-glow fans-glow--orange"></div>
    <div class="fans-glow fans-glow--purple"></div>
    <div class="fans-glow fans-glow--pink"></div>
    <div class="container" style="max-width:64rem;">
      <div style="text-align:center;margin-bottom:.75rem;">
        <div class="badge-qr">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fb923c" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <span>For Fans Globally | Pay with BTC/ETH/USDT/SOL</span>
        </div>
        <h2>Get closer access to your favourite athletes &amp; creators</h2>
        <p class="section-sub">FansFollow.me lets you build real connections with UFC fighters, bodybuilders, martial artists, fitness models and other creators through private chats, exclusive content, calls and video sessions.</p>
      </div>
      <div class="fans-container">
        <div class="fans-grid">
          <div class="fan-card"><i data-lucide="message-circle"></i><h4>Personal Chats</h4><p>Direct messaging with your favorite athletes</p></div>
          <div class="fan-card"><i data-lucide="lock"></i><h4>Exclusive Content</h4><p>Premium photos, videos, and training materials</p></div>
          <div class="fan-card"><i data-lucide="phone"></i><h4>Phone Calls</h4><p>Voice conversations and coaching</p></div>
          <div class="fan-card"><i data-lucide="video"></i><h4>Video Sessions</h4><p>Face-to-face time with champions and exclusive content</p></div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-photo" id="business">
    <div class="container">
      <h2>Ready to start as a creator?</h2>
      <p>Keep more of what you earn, connect with fans in one place and unlock new media and casting opportunities as you grow on FansFollow.me.</p>
      <a class="cta-btn" href="{{ route('register') }}">
        Get Started Now
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
  </section>
@endsection
