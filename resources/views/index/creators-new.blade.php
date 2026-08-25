@extends('layouts.app')

@section('title') Become a Creator - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    {{-- Hero Section --}}
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <div class="mb-4">
          <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
            FITNESS, NUTRITION, BODYBUILDING, MARTIAL ARTS, MARTIAL ART ACTORS & COMBAT SPORTS
          </span>
        </div>
        <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 900;">Ready to grow your fitness brand?</h1>
        <p class="lead mb-4" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Join fitness, martial arts and combat sports creators building loyal fan communities and new revenue streams on {{$settings->title}}.
        </p>

        {{-- Revenue streams icons --}}
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
          <span class="badge badge-pill px-3 py-2" style="background: rgba(249, 115, 22, 0.15); color: var(--ffm-orange);">💰 Subscriptions</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(168, 85, 247, 0.15); color: var(--ffm-purple);">💬 Paid Chats</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(249, 115, 22, 0.15); color: var(--ffm-orange);">📞 Phone Calls</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(168, 85, 247, 0.15); color: var(--ffm-purple);">📹 Video Sessions</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(249, 115, 22, 0.15); color: var(--ffm-orange);">🔒 Paid Videos & Streams</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(168, 85, 247, 0.15); color: var(--ffm-purple);">🎁 Tips & Supporters</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(249, 115, 22, 0.15); color: var(--ffm-orange);">📚 Training Programs</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(168, 85, 247, 0.15); color: var(--ffm-purple);">🥗 Meal Plans</span>
          <span class="badge badge-pill px-3 py-2" style="background: rgba(249, 115, 22, 0.15); color: var(--ffm-orange);">🛒 Product Sales</span>
        </div>

        <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 rounded-pill">
          Create Your Profile Now
        </a>
      </div>
    </div>

    {{-- Why creators choose us --}}
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <h2 class="mb-4" style="font-size: 1.75rem; font-weight: 800;">Why creators choose us</h2>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-cash-stack"></i></div>
          <h5>Keep 80%+ of Earnings</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Industry-leading revenue share from subscriptions, content, calls and coaching.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-bank"></i></div>
          <h5>Get Paid Your Way</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Bank transfer or crypto payouts with low fees and fast processing.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-chat-dots"></i></div>
          <h5>Direct Fan Connection</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Paid calls, private chats and coaching so fans become long-term clients.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-shield-check"></i></div>
          <h5>Secure & Professional</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Encrypted messaging, automated billing and a professional environment for your brand.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-graph-up"></i></div>
          <h5>Track Your Success</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Simple dashboard to see earnings, active fans and content performance at a glance.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-bullseye"></i></div>
          <h5>Built for Your Niche</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Designed for fitness, bodybuilding, nutrition, martial arts and combat sports creators.</p>
        </div>
      </div>
    </div>

    {{-- Token & VIP --}}
    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <div class="p-4 rounded-4 text-center" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <div style="font-size: 2rem;">🪙</div>
          <h5 class="mt-2">Earn FFM Reward Tokens</h5>
          <p style="color: var(--ffm-text-secondary);">Earn extra reward tokens as your fans engage, which you can convert inside the platform.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="p-4 rounded-4 text-center" style="background: linear-gradient(to bottom right, rgba(168, 85, 247, 0.2), rgba(249, 115, 22, 0.2)); border: 1px solid rgba(168, 85, 247, 0.3);">
          <div style="font-size: 2rem;">💎</div>
          <h5 class="mt-2">Negotiate Higher Rates</h5>
          <p style="color: var(--ffm-text-secondary);">Large creators can discuss custom payout terms above 80%+. Contact us for VIP options.</p>
        </div>
      </div>
    </div>

    {{-- How it works --}}
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <h2 class="mb-4" style="font-size: 1.75rem; font-weight: 800;">How it works</h2>
        <p style="color: var(--ffm-text-secondary);">Get started in three simple steps and turn your fitness, nutrition, martial arts or combat sports expertise into paid content and fan relationships.</p>
      </div>
    </div>

    {{-- Stats --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4 text-center">
        <div class="p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.15), rgba(168, 85, 247, 0.15)); border: 1px solid rgba(249, 115, 22, 0.2);">
          <h2 class="text-orange fw-bold mb-1">24-48h</h2>
          <p class="mb-0 fw-semibold">Start Earning</p>
          <small style="color: var(--ffm-text-secondary);">Most creators see first earnings</small>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(168, 85, 247, 0.15), rgba(249, 115, 22, 0.15)); border: 1px solid rgba(168, 85, 247, 0.2);">
          <h2 class="text-purple fw-bold mb-1">80%+</h2>
          <p class="mb-0 fw-semibold">You Keep</p>
          <small style="color: var(--ffm-text-secondary);">Industry-leading revenue share</small>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.15), rgba(168, 85, 247, 0.15)); border: 1px solid rgba(249, 115, 22, 0.2);">
          <h2 class="text-orange fw-bold mb-1">21+</h2>
          <p class="mb-0 fw-semibold">Revenue Streams</p>
          <small style="color: var(--ffm-text-secondary);">More ways to earn than any platform</small>
        </div>
      </div>
    </div>

    {{-- Steps --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="mb-3"><span class="badge badge-pill px-3 py-2" style="background: var(--ffm-orange); color: white; font-size: 1.25rem;">1</span></div>
          <h5>Sign Up & Create Your Profile</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Create your professional creator profile in under 5 minutes with links, photos and your offer types.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="mb-3"><span class="badge badge-pill px-3 py-2" style="background: var(--ffm-purple); color: white; font-size: 1.25rem;">2</span></div>
          <h5>Launch Your Offers</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Add paid chats, video sessions, programs, meal plans or products using simple templates.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="mb-3"><span class="badge badge-pill px-3 py-2" style="background: var(--ffm-orange); color: white; font-size: 1.25rem;">3</span></div>
          <h5>Grow Your Community</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Share your link, use QR codes at events and convert followers into paying fans.</p>
        </div>
      </div>
    </div>

    {{-- CTA --}}
    <div class="text-center py-5">
      <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 rounded-pill">
        Create Your Profile Now
      </a>
    </div>
  </div>
</section>
@endsection
