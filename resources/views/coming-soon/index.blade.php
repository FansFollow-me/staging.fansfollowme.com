@extends('layouts.app')
@section('title', 'Coming Soon')

@push('head')
<style>
  .soon-hero {
    background:
      radial-gradient(ellipse at 20% 0%, rgba(249,115,22,.18), transparent 50%),
      radial-gradient(ellipse at 80% 100%, rgba(168,85,247,.16), transparent 50%),
      linear-gradient(160deg, #0b0f1a 0%, #111827 50%, #1a1240 100%);
    border-radius: 20px;
    padding: 2.5rem 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255,255,255,.08);
  }
  .soon-hero h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 900;
    color: #fff;
    letter-spacing: -.02em;
    margin-bottom: .5rem;
  }
  .soon-eyebrow {
    color: #fb923c;
    font-weight: 700;
    font-size: .8rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .75rem;
  }
  .soon-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 18px;
    padding: 1.5rem;
    height: 100%;
    transition: border-color .2s, transform .2s;
    position: relative;
    overflow: hidden;
  }
  .soon-card:hover {
    border-color: rgba(249,115,22,.55);
    transform: translateY(-3px);
  }
  .soon-card::before {
    content: '';
    position: absolute;
    inset: 0 0 auto 0;
    height: 3px;
    background: linear-gradient(90deg, #f97316, #a855f7);
  }
  .soon-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background: linear-gradient(135deg, #f97316, #a855f7);
    margin-bottom: 1rem;
    box-shadow: 0 8px 20px rgba(249,115,22,.25);
  }
  .soon-card h2 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 .5rem;
  }
  .soon-card p {
    color: #cbd5e1;
    font-size: .9rem;
    line-height: 1.6;
    margin: 0 0 1rem;
  }
  .soon-tag {
    display: inline-flex;
    padding: .3rem .7rem;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    background: rgba(249,115,22,.15);
    color: #fdba74;
    border: 1px solid rgba(249,115,22,.35);
  }
  .soon-list {
    margin: 0 0 1rem;
    padding: 0;
    list-style: none;
    color: #94a3b8;
    font-size: .85rem;
  }
  .soon-list li { padding: .2rem 0; }
  .soon-list li::before { content: '✓ '; color: #fb923c; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="soon-hero text-center">
    <div class="soon-eyebrow">FansFollow roadmap</div>
    <h1>Built for creators who want more</h1>
    <p class="text-secondary mx-auto mb-0" style="max-width:34rem;">
        Launch leagues, run competitions, sell custom videos — all inside FansFollow.
        Tell us what to ship first.
    </p>
</div>

@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="soon-card">
            <div class="soon-icon">🏆</div>
            <h2>Creator Competitions</h2>
            <p>Run prize contests on FansFollow. Fans enter on your page. You set the rules and the prize — money stays on-platform.</p>
            <ul class="soon-list">
                <li>Your contest, your prize</li>
                <li>Entry fees you control</li>
                <li>Simple setup for gyms & coaches</li>
            </ul>
            <span class="soon-tag">Coming soon</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="soon-card">
            <div class="soon-icon">⚔️</div>
            <h2>Mini Leagues</h2>
            <p>Launch your own mini league. <strong style="color:#fff">Your prize. Your entry price.</strong> Fans pay to play, compete on a live scoreboard, and you crown the winner.</p>
            <ul class="soon-list">
                <li>Set entry price & prize pool</li>
                <li>Training / challenge seasons</li>
                <li>Scoreboard & streaks in FFM</li>
            </ul>
            <span class="soon-tag">Coming soon</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="soon-card">
            <div class="soon-icon">🎬</div>
            <h2>Custom Video Messages</h2>
            <p>Fans request a personal clip from your profile — wallet paid, private delivery. Separate from shop.</p>
            <ul class="soon-list">
                <li>Birthday · Congratulations · Pep talk · Shoutout</li>
                <li>3 length tiers you price</li>
                <li>Promote your brand — custom price or quote</li>
            </ul>
            <span class="soon-tag" style="background:rgba(34,197,94,.15);color:#86efac;border-color:rgba(34,197,94,.35);">Live now</span>
            @auth
                <a class="btn btn-sm btn-ffm d-block mt-3" href="{{ route('video-messages.mine') }}">My video messages</a>
            @endauth
        </div>
    </div>
</div>

<div class="card card-ffm p-4 col-lg-7 mx-auto">
    <h2 class="h5 mb-2" style="color:#fff;font-weight:800;">What should we build next?</h2>
    <p class="text-secondary small mb-3">Creators and fans — your vote shapes the roadmap.</p>
    <form method="POST" action="{{ route('coming-soon.feedback') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Feature</label>
            <select class="form-select" name="feature" required>
                <option value="competitions">Creator Competitions</option>
                <option value="mini_leagues">Mini Leagues</option>
                <option value="custom_video">Custom Video Messages</option>
                <option value="other">Something else</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Why do you want it?</label>
            <textarea class="form-control" name="message" rows="3" maxlength="1000" placeholder="e.g. I’d run a 6-week push-up league with a $500 prize…"></textarea>
        </div>
        <button class="btn btn-ffm" type="submit">Send feedback</button>
        @auth
            <span class="small text-secondary ms-2">as {{ '@'.auth()->user()->username }}</span>
        @else
            <span class="small text-secondary ms-2">Login optional</span>
        @endauth
    </form>
</div>
@endsection
