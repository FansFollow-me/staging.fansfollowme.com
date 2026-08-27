@extends('layouts.appnew')

@section('title') For Fans - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <div class="mb-4">
          <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
            For Fans Globally | Pay with BTC/ETH/USDT/SOL
          </span>
        </div>
        <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 900;">Get closer access to your favourite athletes & creators</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          {{$settings->title}} lets you build real connections with UFC fighters, bodybuilders, martial artists, fitness models and other creators through private chats, exclusive content, calls and video sessions.
        </p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-3 col-6">
        <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <i class="bi bi-chat-dots text-orange mb-2" style="font-size: 1.5rem;"></i>
          <div class="fw-bold mb-1">Personal Chats</div>
          <small style="color: var(--ffm-text-secondary);">Direct messaging with your favorite athletes</small>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(168, 85, 247, 0.3);">
          <i class="bi bi-lock text-purple mb-2" style="font-size: 1.5rem;"></i>
          <div class="fw-bold mb-1">Exclusive Content</div>
          <small style="color: var(--ffm-text-secondary);">Premium photos, videos, and training materials</small>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <i class="bi bi-telephone text-orange mb-2" style="font-size: 1.5rem;"></i>
          <div class="fw-bold mb-1">Phone Calls</div>
          <small style="color: var(--ffm-text-secondary);">Voice conversations and coaching</small>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="text-center p-4 rounded-4" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(168, 85, 247, 0.3);">
          <i class="bi bi-camera-video text-purple mb-2" style="font-size: 1.5rem;"></i>
          <div class="fw-bold mb-1">Video Sessions</div>
          <small style="color: var(--ffm-text-secondary);">Face-to-face time with champions</small>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5 d-inline-flex align-items-center gap-2">
        <span>Sign Up as Fan - It's Free</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
@endsection
