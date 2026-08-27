@extends('layouts.appnew')

@section('title') Help & Support - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    {{-- Hero --}}
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-10">
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange); font-size: 0.85rem;">
          SUPPORT CENTER
        </span>
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">We're Here to Help</h1>
        <p class="lead mb-5" style="color: var(--ffm-text-secondary); max-width: 600px; margin: 0 auto;">
          Get the support you need to succeed on {{$settings->title}}. Our team is available to help you maximize your earnings and grow your community.
        </p>
      </div>
    </div>

    {{-- Support Options --}}
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-chat-dots"></i></div>
          <h5>Live Chat Support</h5>
          <p class="mb-3" style="color: var(--ffm-text-secondary);">Connect with our support team</p>
          <a href="{{url('contact')}}" class="btn btn-sm btn-main btn-primary px-4 rounded-pill">Start Chat</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-envelope"></i></div>
          <h5>Email Support</h5>
          <p class="mb-3" style="color: var(--ffm-text-secondary);">Send us a detailed message</p>
          <a href="mailto:support@fansfollow.me" class="btn btn-sm btn-main btn-primary px-4 rounded-pill">Send Email</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center h-100 p-4">
          <div class="feature-icon mb-3"><i class="bi bi-book"></i></div>
          <h5>Help Center</h5>
          <p class="mb-3" style="color: var(--ffm-text-secondary);">Browse guides and resources</p>
          <a href="{{url('faq')}}" class="btn btn-sm btn-main btn-primary px-4 rounded-pill">View Guides</a>
        </div>
      </div>
    </div>

    {{-- Contact Form --}}
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8">
        <div class="card shadow border-0 b-radio-custom">
          <div class="card-body p-5">
            <h3 class="text-center mb-4" style="font-weight: 800;">Send Us a Message</h3>
            <p class="text-center mb-4" style="color: var(--ffm-text-secondary);">Fill out the form below and we'll get back to you as soon as possible.</p>
            
            <form method="POST" action="{{url('contact')}}">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Name *</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Email *</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Phone Number (Optional)</label>
                  <input type="tel" class="form-control" name="phone">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Subject *</label>
                  <select class="form-control" name="subject" required>
                    <option value="">Select a subject</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Creator Support">Creator Support</option>
                    <option value="Technical Issue">Technical Issue</option>
                    <option value="Payment Question">Payment Question</option>
                    <option value="Account Help">Account Help</option>
                    <option value="Partnership Opportunity">Partnership Opportunity</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold">Message *</label>
                  <textarea class="form-control" name="message" rows="5" required minlength="10" placeholder="0 characters (minimum 10)"></textarea>
                </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-lg btn-main btn-primary px-5 rounded-pill">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- Still Need Help --}}
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="p-5 rounded-4 text-center" style="background: linear-gradient(to bottom right, rgba(249, 115, 22, 0.15), rgba(168, 85, 247, 0.15)); border: 1px solid rgba(249, 115, 22, 0.3);">
          <h3 class="mb-4" style="font-weight: 800;">Still Need Help?</h3>
          <p style="color: var(--ffm-text-secondary);">Can't find what you're looking for? Our support team is standing by to help you succeed on {{$settings->title}}.</p>
          <div class="row g-3 mt-3">
            <div class="col-md-4">
              <div class="fw-bold">Email Support</div>
              <a href="mailto:support@fansfollow.me" style="color: var(--ffm-orange);">support@fansfollow.me</a>
            </div>
            <div class="col-md-4">
              <div class="fw-bold">Phone Support</div>
              <span style="color: var(--ffm-text-secondary);">Email for availability</span>
            </div>
            <div class="col-md-4">
              <div class="fw-bold">Creator Community</div>
              <a href="#" style="color: var(--ffm-orange);">Join our Discord</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
