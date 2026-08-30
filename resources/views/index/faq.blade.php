@extends('layouts.appnew')

@section('title') FAQ - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
          FANSFOLLOW.ME
        </span>
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">FAQ</h1>
        <p class="lead" style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
          Frequently asked questions about FansFollowMe, creators, fans, and account access.
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="mb-4">
          <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; text-shadow: none; color: #fff;">What is FansFollowMe?</h3>
          <p style="color: var(--ffm-text-secondary);">FansFollowMe is a creator platform for fitness, martial arts, coaching, content, and direct fan access.</p>
        </div>

        <div class="mb-4">
          <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; text-shadow: none; color: #fff;">How do fans join?</h3>
          <p style="color: var(--ffm-text-secondary);">Fans can create an account, browse creators, and subscribe or interact with available creators.</p>
        </div>

        <div class="mb-4">
          <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; text-shadow: none; color: #fff;">How do creators get started?</h3>
          <p style="color: var(--ffm-text-secondary);">Creators can sign up, complete their profile, and publish content once their account is ready.</p>
        </div>

        <div class="mb-4">
          <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; text-shadow: none; color: #fff;">Where do I get help?</h3>
          <p style="color: var(--ffm-text-secondary);">Use the contact page or the support tools available inside the live account area.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
