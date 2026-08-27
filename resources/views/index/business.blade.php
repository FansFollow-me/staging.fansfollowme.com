@extends('layouts.appnew')

@section('title') Business - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <div class="mb-4">
          <span style="font-size: 3rem;">💼</span>
        </div>
        <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 900;">Business & Partnerships</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Explore business opportunities, brand partnerships, and our token ecosystem. Grow your fitness business with {{$settings->title}}.
        </p>
      </div>
    </div>

    {{-- Token Ecosystem --}}
    <div id="tokens" class="row g-4 mb-5">
      <div class="col-lg-10 mx-auto">
        <div class="p-5 rounded-4 text-center" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.15), rgba(168, 85, 247, 0.15)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <h2 class="mb-3" style="font-size: 1.75rem; font-weight: 800;">🪙 Token Ecosystem</h2>
          <p style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
            {{$settings->title}} is building a reward token ecosystem that lets creators earn extra tokens as their fans engage. Tokens can be converted, traded, or used within the platform for premium features.
          </p>
          <div class="row g-3 mt-4">
            <div class="col-md-4">
              <div class="p-3 rounded-3" style="background: rgba(249, 115, 22, 0.1);">
                <h5 class="text-orange fw-bold">Earn</h5>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Earn tokens through fan engagement and content creation</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 rounded-3" style="background: rgba(168, 85, 247, 0.1);">
                <h5 class="text-purple fw-bold">Convert</h5>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Convert tokens to platform credits or withdraw</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 rounded-3" style="background: rgba(249, 115, 22, 0.1);">
                <h5 class="text-orange fw-bold">Grow</h5>
                <p class="mb-0 small" style="color: var(--ffm-text-secondary);">Use tokens for premium features and visibility boosts</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Presale Info --}}
    <div id="presale" class="row g-4 mb-5">
      <div class="col-lg-10 mx-auto">
        <div class="p-5 rounded-4 text-center" style="background: linear-gradient(to bottom right, rgba(168, 85, 247, 0.15), rgba(249, 115, 22, 0.15)); border: 1px solid rgba(168, 85, 247, 0.3);">
          <h2 class="mb-3" style="font-size: 1.75rem; font-weight: 800;">💎 Presale Info</h2>
          <p style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
            Early supporters and creators can participate in our token presale. Get priority access and bonus tokens by joining the whitelist.
          </p>
          <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 mt-4 rounded-pill">
            Join Whitelist
          </a>
        </div>
      </div>
    </div>

    {{-- Business Features --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-building"></i></div>
          <h5>Brand Partnerships</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Connect with fitness brands for sponsorship and collaboration opportunities.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-graph-up-arrow"></i></div>
          <h5>Scale Your Business</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Tools and analytics to grow your fitness business and maximize revenue.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-globe2"></i></div>
          <h5>Global Reach</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Reach fans and customers worldwide with multi-currency support.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
