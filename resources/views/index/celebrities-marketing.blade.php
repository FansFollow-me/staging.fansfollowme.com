@extends('layouts.appnew')

@section('title') Celebrities - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 900;">Celebrities on {{$settings->title}}</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Connect with your favorite celebrities, athletes, and public figures. Get exclusive content, personal messages, and direct access.
        </p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-star"></i></div>
          <h5>Exclusive Content</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Access premium content from celebrities you can't find anywhere else.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-chat-dots"></i></div>
          <h5>Direct Messages</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Send personal messages and get responses directly from celebrities.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-camera-video"></i></div>
          <h5>Video Calls</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Book one-on-one video sessions with your favorite stars.</p>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="{{url('creators')}}" class="btn btn-lg btn-main btn-primary px-5">
        Browse Celebrities
      </a>
    </div>
  </div>
</section>
@endsection
