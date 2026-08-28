@extends('layouts.appnew')

@section('title') Celebrities - @endsection

@section('content')
<section class="section section-sm" style="min-height: 85vh; display: flex; align-items: center;">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-10">
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
          CELEBRITY CONNECTIONS
        </span>
        <h1 class="mb-4" style="font-size: 3rem; font-weight: 900;">Chat Personally With<br>Your Favorite Champions</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Connect directly with UFC fighters, Olympic champions, bodybuilding legends, and fitness icons. Build real friendships through personal chats, phone calls, and video hangouts.
        </p>
        <div class="d-flex gap-3 justify-content-center">
          <a href="{{url('explore')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2">
            <span>Explore Celebrities</span>
            <i class="bi bi-arrow-right"></i>
          </a>
          <a href="{{url('signup')}}" class="btn btn-lg px-5 d-inline-flex align-items-center gap-2" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 12px;">
            <span>Become a Fan</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm" style="background: linear-gradient(to right bottom, #111827, #1f2937, #111827);">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="font-size: 2rem; font-weight: 900;">Why Celebrities Choose FansFollow</h2>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Real connections</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">Build genuine, positive relationships with fans through fitness, training and combat-sports content in a fully brand-safe environment.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Premium benefits</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">Keep 80%+ of your earnings with clear reporting, VIP rates for high-volume talent, and terms that work for you and your team.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Your schedule, your rules</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">Set your own rates, availability and interaction preferences so every engagement fits your time, boundaries and sponsors.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Brand-safe by design</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">A professional, non-adult platform built for athletes, entertainers and influencers who work with sponsors and mainstream media.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">High-quality audience</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">Reach verified, paying fans who value your work, not bots or low-intent followers.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.1rem; font-weight: 700;">Built with industry experience</h3>
          <p class="mb-0" style="color: var(--ffm-text-secondary); font-size: 0.9rem;">Created by a founder with multiple film and media credits who understands how to protect long-term reputation and endorsements.</p>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2">
        <span>Apply for Celebrity Status</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<section class="section section-sm">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
        FFM FOUNDER'S ACCOLADES
      </span>
      <h2 style="font-size: 2rem; font-weight: 900;">David Kurzhal - The Viking Samurai</h2>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">Lead Actor</div>
          <small style="color: var(--ffm-text-secondary);">8+ Feature Films</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">Martial Arts Expert</div>
          <small style="color: var(--ffm-text-secondary);">5th Dan Black Belt, Viking Samurai</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">Stunt Performer</div>
          <small style="color: var(--ffm-text-secondary);">Action Choreographer</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">YouTuber</div>
          <small style="color: var(--ffm-text-secondary);">Channel Dedicated to 80s & 90s Martial Arts Cinema</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">Celebrity Boxer</div>
          <small style="color: var(--ffm-text-secondary);">In talks with various big names</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-3">
          <div class="fw-bold" style="color: var(--ffm-orange);">Interviewed Legends</div>
          <small style="color: var(--ffm-text-secondary);">Steven Seagal, Scott Adkins, Don Wilson, Michael Jai White, Michel Qissi</small>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm" style="background: linear-gradient(to right bottom, #111827, #1f2937, #111827);">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
        NOW SHOWING: FFM FOUNDER'S FEATURED FILMS
      </span>
      <h2 style="font-size: 2rem; font-weight: 900;">From Martial Arts Champion to Hollywood Action Star</h2>
      <p style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
        David Kurzhal's complete filmography - from released blockbusters to upcoming projects. Now we're creating opportunities for FFM creators to star in martial arts films.
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="p-4 rounded-4 text-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.2rem; font-weight: 700;">The Last Kumite</h3>
          <div style="color: var(--ffm-orange); font-weight: 600;">2024</div>
          <small style="color: var(--ffm-text-secondary);">Role: Marcus Gantz</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 text-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.2rem; font-weight: 700;">Bloodstorm</h3>
          <div style="color: var(--ffm-orange); font-weight: 600;">2025</div>
          <small style="color: var(--ffm-text-secondary);">Role: Bennet (Lead Role)</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 text-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <h3 style="font-size: 1.2rem; font-weight: 700;">Elite Target</h3>
          <div style="color: var(--ffm-orange); font-weight: 600;">2025</div>
          <small style="color: var(--ffm-text-secondary);">Role: Alpha Commando</small>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
