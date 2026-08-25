@extends('layouts.app')

@section('title') Movie Casting - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <div class="mb-4">
          <span style="font-size: 3rem;">🎬</span>
        </div>
        <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 900;">Movie Casting Opportunities</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 700px; margin: 0 auto;">
          Discover casting calls and acting opportunities for fitness models, martial artists, and athletes. Connect with filmmakers looking for talent with your unique skills.
        </p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-film"></i></div>
          <h5>Action & Fitness Roles</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Find casting calls specifically looking for athletes, fighters, and fitness talent.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-people"></i></div>
          <h5>Connect with Directors</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Build relationships with filmmakers and casting directors in the action genre.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-camera-reels"></i></div>
          <h5>Build Your Portfolio</h5>
          <p class="mb-0" style="color: var(--ffm-text-secondary);">Showcase your skills and build a professional acting portfolio.</p>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="{{url('signup')}}" class="btn btn-lg btn-main btn-primary px-5">
        Join to Access Casting Calls
      </a>
    </div>
  </div>
</section>
@endsection
