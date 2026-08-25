@extends('layouts.app')

@section('title') Privacy Policy - @endsection

@section('content')
<section class="section section-sm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <a href="{{url('/')}}" class="btn btn-sm btn-outline-secondary mb-4"><i class="feather icon-arrow-left mr-1"></i> Back to Home</a>
        
        <span class="badge badge-pill px-4 py-2 mb-3" style="background: linear-gradient(to right, rgba(249, 115, 22, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(249, 115, 22, 0.3); color: var(--ffm-orange);">PRIVACY POLICY</span>
        
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900;">Your Privacy & Data Protection</h1>
        
        <p style="color: var(--ffm-text-secondary);">At {{$settings->title}}, we are committed to protecting your privacy and personal information. This Privacy Policy explains how we collect, use, and disclose your personal information when you use our Services.</p>
        
        <p class="mb-5"><small style="color: var(--ffm-text-muted);">Last updated: January 22, 2025</small></p>

        <div class="content-p">
          <h3 class="mt-5 mb-3" style="font-weight: 800;">Introduction</h3>
          <p>At {{$settings->title}}, we are committed to protecting your privacy and personal information. This Privacy Policy (the "Policy") explains how we collect, use, and disclose your personal information when you use our website and services (the "Services"). By using the Services, you consent to the collection, use, and disclosure of your personal information as described in this Policy.</p>
          
          <div class="p-3 rounded-3 my-4" style="background: rgba(249, 115, 22, 0.1); border-left: 4px solid var(--ffm-orange);">
            <strong>🛡️ By using {{$settings->title}}, you acknowledge that you have read and understand this Privacy Policy and agree to be bound by it.</strong>
          </div>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Information We Collect</h3>
          <p>We may collect the following types of personal information:</p>
          
          <h5 class="mt-4 mb-2 fw-semibold">Information You Provide to Us</h5>
          <ul>
            <li>When you create an account, we collect your name, email address, username, and other contact information</li>
            <li>Profile information you choose to provide (bio, website, categories)</li>
            <li>Content you create, messages you send, and interactions you have on our platform</li>
            <li>If you contact us for customer support, we collect information about your account and the issue you are experiencing</li>
          </ul>

          <h5 class="mt-4 mb-2 fw-semibold">Information We Collect Automatically</h5>
          <ul>
            <li>Information about your device and browser, such as IP address, browser type, and operating system</li>
            <li>Information about your usage of the Services, such as the pages you visit and the actions you take</li>
            <li>Log data including access times, pages viewed, and referring website addresses</li>
          </ul>

          <h5 class="mt-4 mb-2 fw-semibold">Information from Third-Party Services</h5>
          <p>We may collect information about you from other online services, such as social media platforms, if you choose to connect your account to those services.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">How We Use Your Information</h3>
          <p>We use the information we collect for the following purposes:</p>
          <ul>
            <li>To provide and improve our Services</li>
            <li>To process transactions and send related information</li>
            <li>To send administrative notifications and updates</li>
            <li>To respond to your comments, questions, and customer service requests</li>
            <li>To send promotional communications (with your consent)</li>
            <li>To monitor and analyze trends, usage, and activities</li>
            <li>To detect, investigate, and prevent fraudulent transactions and other illegal activities</li>
          </ul>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Information Sharing</h3>
          <p>We do not sell your personal information. We may share your information in the following circumstances:</p>
          <ul>
            <li>With other users as part of the normal operation of the platform (e.g., your public profile)</li>
            <li>With service providers who assist us in operating our platform</li>
            <li>When required by law or to protect our rights</li>
            <li>In connection with a merger, acquisition, or sale of assets</li>
          </ul>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Data Security</h3>
          <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Your Rights</h3>
          <p>You have the right to:</p>
          <ul>
            <li>Access and receive a copy of your personal information</li>
            <li>Correct inaccurate personal information</li>
            <li>Request deletion of your personal information</li>
            <li>Object to the processing of your personal information</li>
            <li>Withdraw consent at any time</li>
          </ul>

          <h3 class="mt-5 mb-3" style="font-weight: 800;">Contact Us</h3>
          <p>If you have any questions about this Privacy Policy, please contact us at <a href="mailto:support@fansfollow.me" style="color: var(--ffm-orange);">support@fansfollow.me</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
