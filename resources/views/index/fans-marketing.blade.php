@extends('layouts.appnew')

@section('title') For Fans - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <h1 class="mb-4" style="font-size: 3.5rem; font-weight: 900;">Discover and connect<br>with your favourite<br>fitness creators</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Find fighters, coaches, bodybuilders and fitness influencers in one place and get closer access through chats, exclusive content, calls and video sessions.
        </p>
        <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2">
          <span>Sign Up as Fan – It's Free</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm" style="background: linear-gradient(to right bottom, #0B0F1A, #1f2937, #0B0F1A);">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
        FOR FANS
      </span>
      <h2 style="font-size: 2rem; font-weight: 900;">Ways to connect with creators</h2>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-chat-dots text-orange mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Private Chats</h3>
          <small style="color: var(--ffm-text-secondary);">Message creators directly and get personal replies.</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-play-circle text-purple mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Exclusive Videos & Streams</h3>
          <small style="color: var(--ffm-text-secondary);">Unlock members-only videos and live events.</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-heart text-orange mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Tips & Support</h3>
          <small style="color: var(--ffm-text-secondary);">Tip your favourite athletes and show extra support.</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-clipboard-data text-purple mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Training Programs</h3>
          <small style="color: var(--ffm-text-secondary);">Access structured plans from trusted coaches.</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-apple text-orange mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Meal Plans</h3>
          <small style="color: var(--ffm-text-secondary);">Get nutrition plans tailored by fitness experts.</small>
        </div>
      </div>
      <div class="col-md-4 col-6">
        <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
          <i class="bi bi-bag text-purple mb-2" style="font-size: 1.5rem;"></i>
          <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">Merch & Products</h3>
          <small style="color: var(--ffm-text-secondary);">Buy branded gear, supplements and digital downloads.</small>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="text-center mb-4" style="font-size: 1.5rem; font-weight: 700;">Why fans love FansFollowMe</h2>
        <div class="row g-3">
          <div class="col-6">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span style="color: var(--ffm-orange);">•</span>
              <div>
                <strong>Closer access</strong>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Go beyond social media with real conversations and interactions.</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span style="color: var(--ffm-orange);">•</span>
              <div>
                <strong>All your favourites in one place</strong>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Follow multiple fitness and combat sports creators on a single platform.</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span style="color: var(--ffm-orange);">•</span>
              <div>
                <strong>Safe & secure</strong>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Protected payments and private communication with creators.</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span style="color: var(--ffm-orange);">•</span>
              <div>
                <strong>Global access</strong>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Support creators from any country with card or crypto payments.</p>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span style="color: var(--ffm-orange);">•</span>
              <div>
                <strong>Easy to use</strong>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Simple mobile-friendly experience for chats, content and calls.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm" style="background: linear-gradient(to right bottom, #0B0F1A, #000000, #0B0F1A);">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="font-size: 3.5rem; font-weight: 900;">How it works for fans</h2>
      <p style="color: var(--ffm-text-secondary);">Join in minutes and start following your favourite fitness and combat sports creators.</p>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="text-center p-4">
          <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(to right, #F97316, #9333EA); font-size: 1.5rem; font-weight: 900;">1</div>
          <h3 style="font-size: 1.5rem; font-weight: 700;">Create your fan account</h3>
          <p style="color: var(--ffm-text-secondary);">Sign up for free and choose your interests so we can recommend creators.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="text-center p-4">
          <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(to right, #F97316, #9333EA); font-size: 1.5rem; font-weight: 900;">2</div>
          <h3 style="font-size: 1.5rem; font-weight: 700;">Follow and unlock content</h3>
          <p style="color: var(--ffm-text-secondary);">Subscribe, tip and unlock content from your favourite creators.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="text-center p-4">
          <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(to right, #F97316, #9333EA); font-size: 1.5rem; font-weight: 900;">3</div>
          <h3 style="font-size: 1.5rem; font-weight: 700;">Get closer access</h3>
          <p style="color: var(--ffm-text-secondary);">Chat, call and connect with creators on a deeper level.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-sm">
  <div class="container">
    <div class="text-center p-5 rounded-4" style="background: linear-gradient(135deg, rgba(249,115,22,0.3), rgba(147,51,234,0.3)); border: 1px solid rgba(249,115,22,0.3);">
      <h2 class="mb-4" style="font-size: 2rem; font-weight: 900;">Ready to support your favourite creators?</h2>
      <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2 rounded-pill">
        <span>Sign Up as Fan – It's Free</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
@endsection
