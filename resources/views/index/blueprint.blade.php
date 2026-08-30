<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FFM Platform Blueprint — Complete Technical Reference</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
  --ffm-bg: #0B0F1A;
  --ffm-card: #111827;
  --ffm-border: #1f2937;
  --ffm-orange: #f97316;
  --ffm-text: #e5e7eb;
  --ffm-muted: #9ca3af;
}
body {
  background: var(--ffm-bg);
  color: var(--ffm-text);
  font-family: 'Inter', system-ui, sans-serif;
  line-height: 1.7;
}
.card {
  background: var(--ffm-card);
  border: 1px solid var(--ffm-border);
  border-radius: 12px;
}
.card-header {
  background: rgba(249,115,22,0.08);
  border-bottom: 1px solid var(--ffm-border);
  font-weight: 700;
}
.badge-public { background: #059669; }
.badge-auth { background: #d97706; }
.badge-admin { background: #dc2626; }
.badge-feature { background: #7c3aed; }
.badge-new { background: #f97316; }
.table { color: var(--ffm-text); }
.table td, .table th { border-color: var(--ffm-border); vertical-align: middle; }
code { color: var(--ffm-orange); background: rgba(249,115,22,0.1); padding: 2px 6px; border-radius: 4px; font-size: 0.85em; }
a { color: var(--ffm-orange); }
a:hover { color: #fb923c; }
.section-title {
  font-size: 1.5rem;
  font-weight: 800;
  margin: 3rem 0 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--ffm-orange);
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.url-table td:first-child { font-family: monospace; font-size: 0.85em; }
.status-ok { color: #10b981; }
.status-warn { color: #f59e0b; }
.status-err { color: #ef4444; }
.hero-gradient {
  background: linear-gradient(135deg, #0B0F1A 0%, #1a1040 50%, #0B0F1A 100%);
  padding: 4rem 0 2rem;
  border-bottom: 1px solid var(--ffm-border);
}
.toc a { text-decoration: none; }
.toc a:hover { text-decoration: underline; }
.env-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
</style>
</head>
<body>

<!-- HERO -->
<div class="hero-gradient">
<div class="container">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <div class="mb-2"><span class="badge bg-warning text-dark">INTERNAL — DO NOT INDEX</span></div>
      <h1 class="display-5 fw-bold mb-3">FFM Platform Blueprint</h1>
      <p class="lead text-muted mb-2">Complete technical reference for FansFollow.me — every URL, every feature, every setting. Share this with your design/development team to ensure nothing is missed.</p>
      <p class="text-muted mb-0"><strong>Platform:</strong> Sponzy v7.9.2 &nbsp;|&nbsp; <strong>Framework:</strong> Laravel 12.46 / PHP 8.5 &nbsp;|&nbsp; <strong>Database:</strong> MySQL 8.4 &nbsp;|&nbsp; <strong>Hosting:</strong> Laravel Cloud &nbsp;|&nbsp; <strong>Updated:</strong> August 30, 2026</p>
    </div>
    <div class="col-lg-4 text-lg-end">
      <div class="d-flex flex-column gap-2">
        <a href="https://staging.fansfollowme.com" target="_blank" class="btn btn-warning btn-lg"><i class="bi bi-box-arrow-up-right me-2"></i>Open Staging</a>
        <a href="https://github.com/FansFollow-me/staging.fansfollowme.com" target="_blank" class="btn btn-outline-light"><i class="bi bi-github me-2"></i>GitHub Repo</a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="container py-4">

<!-- TABLE OF CONTENTS -->
<div class="card mb-4">
<div class="card-header"><i class="bi bi-list-ul me-2"></i>Table of Contents</div>
<div class="card-body toc">
<div class="row">
<div class="col-md-4">
  <ol class="mb-0">
    <li><a href="#infrastructure">Infrastructure & Access</a></li>
    <li><a href="#public">Public Pages (17 URLs)</a></li>
    <li><a href="#auth">Auth Pages (3 URLs)</a></li>
    <li><a href="#profiles">Profile Pages</a></li>
    <li><a href="#backend-fan">Fan Backend (15 URLs)</a></li>
    <li><a href="#backend-creator">Creator Backend (19 URLs)</a></li>
  </ol>
</div>
<div class="col-md-4">
  <ol start="7" class="mb-0">
    <li><a href="#admin">Admin Panel (65+ URLs)</a></li>
    <li><a href="#features">Feature Inventory</a></li>
    <li><a href="#new">New in Sponzy v7.9.2</a></li>
    <li><a href="#settings">Admin Settings Map</a></li>
    <li><a href="#payments">Payment Gateways</a></li>
    <li><a href="#design">Design Tokens</a></li>
  </ol>
</div>
<div class="col-md-4">
  <ol start="13" class="mb-0">
    <li><a href="#seo">SEO & Tracking</a></li>
    <li><a href="#database">Database Schema</a></li>
    <li><a href="#deploy">Deployment Pipeline</a></li>
    <li><a href="#test-accounts">Test Accounts</a></li>
    <li><a href="#known-issues">Known Issues</a></li>
    <li><a href="#checklist">Design Checklist</a></li>
    <li><a href="#workflow">Workflow & Team</a></li>
    <li><a href="#status">Current Status</a></li>
    <li><a href="#docs">Full Technical Docs</a></li>
  </ol>
</div>
</div>
</div>
</div>

<!-- 1. INFRASTRUCTURE -->
<h2 class="section-title" id="infrastructure"><i class="bi bi-hdd-rack"></i> 1. Infrastructure & Access</h2>

<div class="row g-3 mb-4">
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-header">Staging Environment</div>
    <div class="card-body">
      <table class="table table-sm mb-0">
        <tr><td class="text-muted">URL</td><td><a href="https://staging.fansfollowme.com" target="_blank">https://staging.fansfollowme.com</a></td></tr>
        <tr><td class="text-muted">Platform</td><td>Laravel Cloud</td></tr>
        <tr><td class="text-muted">Environment ID</td><td><code>env-a295cd63-356e-4f25-94f8-0961fd2a539e</code></td></tr>
        <tr><td class="text-muted">R2 Bucket</td><td><code>fls-a29b3308-b261-4645-bd9d-d1b983bd9cba</code></td></tr>
        <tr><td class="text-muted">R2 Public URL</td><td><code>https://fls-a29b3308-b261-4645-bd9d-d1b983bd9cba.laravel.cloud</code></td></tr>
        <tr><td class="text-muted">PHP Version</td><td>8.5</td></tr>
        <tr><td class="text-muted">Laravel Version</td><td>12.46</td></tr>
        <tr><td class="text-muted">MySQL Version</td><td>8.4</td></tr>
        <tr><td class="text-muted">Node Version</td><td>24</td></tr>
      </table>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-header">Source Code & Deployment</div>
    <div class="card-body">
      <table class="table table-sm mb-0">
        <tr><td class="text-muted">GitHub Repo</td><td><a href="https://github.com/FansFollow-me/staging.fansfollowme.com" target="_blank">FansFollow-me/staging.fansfollowme.com</a></td></tr>
        <tr><td class="text-muted">Branch</td><td><code>main</code></td></tr>
        <tr><td class="text-muted">Auto-Deploy</td><td>On push to main</td></tr>
        <tr><td class="text-muted">Build Command</td><td><code>composer install && php fix-laravel-cloud.php && php artisan view:clear</code></td></tr>
        <tr><td class="text-muted">Deploy Script</td><td><code>bash deploy.sh</code> (migrate, schema fixes, seed, cache clear)</td></tr>
        <tr><td class="text-muted">Storage</td><td>Cloudflare R2 (S3 driver)</td></tr>
        <tr><td class="text-muted">Users</td><td>17,546</td></tr>
        <tr><td class="text-muted">Posts</td><td>239</td></tr>
      </table>
    </div>
  </div>
</div>
</div>

<!-- 2. PUBLIC PAGES -->
<h2 class="section-title" id="public"><i class="bi bi-globe"></i> 2. Public Pages <span class="badge badge-public ms-2">No Login Required</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm url-table">
<thead><tr><th>URL</th><th>Page</th><th>Purpose</th><th>Status</th></tr></thead>
<tbody>
<tr><td><code>/</code></td><td>Homepage</td><td>Hero section, featured creators, CTA buttons</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/explore</code></td><td>Explore</td><td>Browse all public posts</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/creators</code></td><td>Creators</td><td>Creator directory with filters</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/fans</code></td><td>Fans Marketing</td><td>Landing page for fans</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/celebrities</code></td><td>Celebrities</td><td>Celebrity creator showcase</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/casting</code></td><td>Casting</td><td>Casting call page</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/business</code></td><td>Business</td><td>Business/brand partnerships</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/for-creators</code></td><td>For Creators</td><td>Creator recruitment landing</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/support</code></td><td>Support</td><td>Support center with contact form</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/faq</code></td><td>FAQ</td><td>Frequently asked questions</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/contact</code></td><td>Contact</td><td>Contact form (Usebasin)</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/blog</code></td><td>Blog</td><td>Blog listing</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/privacy</code></td><td>Privacy Policy</td><td>Privacy policy page</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/terms</code></td><td>Terms of Service</td><td>Terms page</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/cookies</code></td><td>Cookie Policy</td><td>Cookie policy page</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/sitemap.xml</code></td><td>Sitemap</td><td>XML sitemap for search engines</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/robots.txt</code></td><td>Robots</td><td>Search engine crawl rules</td><td class="status-ok">✅ 200</td></tr>
</tbody>
</table>
</div>

<!-- 3. AUTH PAGES -->
<h2 class="section-title" id="auth"><i class="bi bi-box-arrow-in-right"></i> 3. Auth Pages <span class="badge badge-auth ms-2">Guest Only</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm url-table">
<thead><tr><th>URL</th><th>Page</th><th>Notes</th><th>Status</th></tr></thead>
<tbody>
<tr><td><code>/login</code></td><td>Login</td><td>AJAX form, supports username or email</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/signup</code></td><td>Register</td><td>Fan or Creator registration</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/password/reset</code></td><td>Password Reset</td><td>Email-based password reset</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/oauth/google</code></td><td>Google OAuth</td><td>Social login (needs config)</td><td>—</td></tr>
<tr><td><code>/oauth/facebook</code></td><td>Facebook OAuth</td><td>Social login (needs config)</td><td>—</td></tr>
</tbody>
</table>
</div>

<!-- 4. PROFILE PAGES -->
<h2 class="section-title" id="profiles"><i class="bi bi-person"></i> 4. Profile Pages <span class="badge badge-public ms-2">Public</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm url-table">
<thead><tr><th>URL Pattern</th><th>Description</th><th>Features</th></tr></thead>
<tbody>
<tr><td><code>/{username}</code></td><td>User profile</td><td>Avatar, cover, bio, posts, subscribe button, tip button</td></tr>
<tr><td><code>/{username}/photos</code></td><td>Photo gallery</td><td>Filtered photo posts</td></tr>
<tr><td><code>/{username}/videos</code></td><td>Video gallery</td><td>Filtered video posts</td></tr>
<tr><td><code>/{username}/audio</code></td><td>Audio gallery</td><td>Filtered audio posts</td></tr>
<tr><td><code>/{username}/shop</code></td><td>Shop</td><td>Creator's products</td></tr>
<tr><td><code>/{username}/reels</code></td><td>Reels</td><td>Creator's short videos</td></tr>
<tr><td><code>/{username}/post/{id}</code></td><td>Single post</td><td>Post detail view</td></tr>
</tbody>
</table>
</div>

<!-- 5. FAN BACKEND -->
<h2 class="section-title" id="backend-fan"><i class="bi bi-heart"></i> 5. Fan Backend <span class="badge badge-auth ms-2">Login Required</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm url-table">
<thead><tr><th>URL</th><th>Page</th><th>Description</th><th>Status</th></tr></thead>
<tbody>
<tr><td><code>/dashboard</code></td><td>Dashboard</td><td>Fan home — feed, subscriptions</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/explore</code></td><td>Explore</td><td>Browse creators and posts</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/notifications</code></td><td>Notifications</td><td>Activity notifications</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/messages</code></td><td>Messages</td><td>Direct message inbox</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/messages/{id}</code></td><td>Chat</td><td>Individual conversation</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/settings/page</code></td><td>Edit Profile</td><td>Name, bio, avatar, cover, categories</td><td class="status-warn">⚠️ 500</td></tr>
<tr><td><code>/settings/password</code></td><td>Change Password</td><td>Password update form</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/settings/subscription</code></td><td>Subscription</td><td>Manage subscription settings</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/privacy/security</code></td><td>Privacy & Security</td><td>2FA, sessions, blocked users</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/bookmarks</code></td><td>Bookmarks</td><td>Saved posts</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/subscriptions</code></td><td>My Subscriptions</td><td>Creators you follow</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/purchases</code></td><td>My Purchases</td><td>Purchased content</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/wallet</code></td><td>Wallet</td><td>Balance, add funds</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/likes</code></td><td>My Likes</td><td>Liked posts</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/reels</code></td><td>Reels</td><td>Short-form video feed</td><td class="status-warn">⚠️ 302</td></tr>
<tr><td><code>/shop</code></td><td>Shop</td><td>Browse all products</td><td class="status-ok">✅ 200</td></tr>
</tbody>
</table>
</div>

<!-- 6. CREATOR BACKEND -->
<h2 class="section-title" id="backend-creator"><i class="bi bi-camera-video"></i> 6. Creator Backend <span class="badge badge-auth ms-2">Login Required</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm url-table">
<thead><tr><th>URL</th><th>Page</th><th>Description</th><th>Status</th></tr></thead>
<tbody>
<tr><td><code>/dashboard</code></td><td>Creator Dashboard</td><td>Earnings chart, stats, quick actions</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/posts</code></td><td>My Posts</td><td>All creator posts with stats</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/subscribers</code></td><td>My Subscribers</td><td>List of paying subscribers</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/products</code></td><td>My Products</td><td>Shop products management</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/sales</code></td><td>My Sales</td><td>Sales history and orders</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/stories</code></td><td>My Stories</td><td>Manage 24-hour stories</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/reels</code></td><td>My Reels</td><td>Manage short videos</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/vault</code></td><td>My Vault</td><td>Private file storage</td><td class="status-warn">⚠️ 500</td></tr>
<tr><td><code>/settings/page</code></td><td>Edit Profile</td><td>Creator profile settings</td><td class="status-warn">⚠️ 500</td></tr>
<tr><td><code>/settings/payout/method</code></td><td>Payout Method</td><td>Bank/PayPal/Stripe payout setup</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/settings/withdrawals</code></td><td>Withdrawals</td><td>Request withdrawals</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/my/referrals</code></td><td>Referrals</td><td>Referral links and earnings</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/settings/subscription</code></td><td>Subscription Settings</td><td>Set subscription price</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/privacy/security</code></td><td>Privacy & Security</td><td>2FA, sessions, blocked users</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/messages</code></td><td>Messages</td><td>Direct messages</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/notifications</code></td><td>Notifications</td><td>Activity notifications</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/create/story</code></td><td>Create Story</td><td>Upload image/text story</td><td class="status-ok">✅ 200</td></tr>
<tr><td><code>/settings/video-call</code></td><td>Video Call Settings</td><td>Set pricing for video calls</td><td class="status-warn">⚠️ 404</td></tr>
<tr><td><code>/settings/audio-call</code></td><td>Audio Call Settings</td><td>Set pricing for audio calls</td><td class="status-warn">⚠️ 404</td></tr>
<tr><td><code>/create/reel</code></td><td>Create Reel</td><td>Upload short video</td><td>—</td></tr>
<tr><td><code>/add/product</code></td><td>Add Product</td><td>Create digital product</td><td>—</td></tr>
<tr><td><code>/live/{username}</code></td><td>Live Stream</td><td>Start/view live stream</td><td>—</td></tr>
</tbody>
</table>
</div>

<!-- 7. ADMIN PANEL -->
<h2 class="section-title" id="admin"><i class="bi bi-shield-lock"></i> 7. Admin Panel <span class="badge badge-admin ms-2">Admin Only</span></h2>

<p class="text-muted mb-3">All admin pages are under <code>/panel/admin/</code>. Requires admin role.</p>

<div class="row g-3 mb-4">
<!-- Settings -->
<div class="col-md-6">
<div class="card h-100">
<div class="card-header"><i class="bi bi-gear me-2"></i>Settings & Configuration</div>
<div class="card-body p-0">
<table class="table table-sm mb-0 url-table">
<tr><td><code>/panel/admin</code></td><td>Dashboard</td></tr>
<tr><td><code>/panel/admin/settings</code></td><td>General Settings</td></tr>
<tr><td><code>/panel/admin/settings/limits</code></td><td>Limits & Restrictions</td></tr>
<tr><td><code>/panel/admin/settings/email</code></td><td>Email/SMTP Settings</td></tr>
<tr><td><code>/panel/admin/settings/cron-job</code></td><td>Cron Job Config</td></tr>
<tr><td><code>/panel/admin/theme</code></td><td>Theme & Colors</td></tr>
<tr><td><code>/panel/admin/custom-css-js</code></td><td>Custom CSS/JS</td></tr>
<tr><td><code>/panel/admin/pwa</code></td><td>PWA Settings</td></tr>
<tr><td><code>/panel/admin/websockets</code></td><td>WebSocket Config</td></tr>
<tr><td><code>/panel/admin/video/encoding</code></td><td>Video Encoding</td></tr>
<tr><td><code>/panel/admin/storage</code></td><td>Storage Settings</td></tr>
<tr><td><code>/panel/admin/billing</code></td><td>Billing Info</td></tr>
<tr><td><code>/panel/admin/maintenance/mode</code></td><td>Maintenance Mode</td></tr>
</table>
</div>
</div>
</div>

<!-- Users & Content -->
<div class="col-md-6">
<div class="card h-100">
<div class="card-header"><i class="bi bi-people me-2"></i>Users & Content</div>
<div class="card-body p-0">
<table class="table table-sm mb-0 url-table">
<tr><td><code>/panel/admin/members</code></td><td>Members List</td></tr>
<tr><td><code>/panel/admin/members/edit/{id}</code></td><td>Edit Member</td></tr>
<tr><td><code>/panel/admin/posts</code></td><td>All Posts</td></tr>
<tr><td><code>/panel/admin/comments</code></td><td>Comments</td></tr>
<tr><td><code>/panel/admin/replies</code></td><td>Replies</td></tr>
<tr><td><code>/panel/admin/reels</code></td><td>Reels Management</td></tr>
<tr><td><code>/panel/admin/stories/posts</code></td><td>Stories</td></tr>
<tr><td><code>/panel/admin/stories/settings</code></td><td>Stories Settings</td></tr>
<tr><td><code>/panel/admin/stories/backgrounds</code></td><td>Story Backgrounds</td></tr>
<tr><td><code>/panel/admin/stories/fonts</code></td><td>Story Fonts</td></tr>
<tr><td><code>/panel/admin/reports</code></td><td>Reports</td></tr>
<tr><td><code>/panel/admin/verification/members</code></td><td>Verification Requests</td></tr>
<tr><td><code>/panel/admin/moderation-image-video</code></td><td>Content Moderation</td></tr>
</table>
</div>
</div>
</div>

<!-- Monetization -->
<div class="col-md-6">
<div class="card h-100">
<div class="card-header"><i class="bi bi-currency-pound me-2"></i>Monetization</div>
<div class="card-body p-0">
<table class="table table-sm mb-0 url-table">
<tr><td><code>/panel/admin/payments</code></td><td>Payment Settings</td></tr>
<tr><td><code>/panel/admin/payments/{id}</code></td><td>Payment Gateway Config (1-12)</td></tr>
<tr><td><code>/panel/admin/subscriptions</code></td><td>Subscriptions</td></tr>
<tr><td><code>/panel/admin/transactions</code></td><td>Transactions</td></tr>
<tr><td><code>/panel/admin/deposits</code></td><td>Deposits</td></tr>
<tr><td><code>/panel/admin/withdrawals</code></td><td>Withdrawals</td></tr>
<tr><td><code>/panel/admin/sales</code></td><td>Sales</td></tr>
<tr><td><code>/panel/admin/products</code></td><td>Products</td></tr>
<tr><td><code>/panel/admin/shop</code></td><td>Shop Settings</td></tr>
<tr><td><code>/panel/admin/shop-categories</code></td><td>Shop Categories</td></tr>
<tr><td><code>/panel/admin/tax-rates</code></td><td>Tax Rates</td></tr>
<tr><td><code>/panel/admin/referrals</code></td><td>Referral Settings</td></tr>
<tr><td><code>/panel/admin/advertising</code></td><td>Advertising</td></tr>
<tr><td><code>/panel/admin/gifts</code></td><td>Gifts Management</td></tr>
</table>
</div>
</div>
</div>

<!-- Communication -->
<div class="col-md-6">
<div class="card h-100">
<div class="card-header"><i class="bi bi-chat-dots me-2"></i>Communication & Features</div>
<div class="card-body p-0">
<table class="table table-sm mb-0 url-table">
<tr><td><code>/panel/admin/video-calls</code></td><td>Video Call Settings</td></tr>
<tr><td><code>/panel/admin/audio-calls</code></td><td>Audio Call Settings</td></tr>
<tr><td><code>/panel/admin/live-streaming</code></td><td>Live Streaming Settings</td></tr>
<tr><td><code>/panel/admin/live-streaming-private-requests</code></td><td>Private Live Requests</td></tr>
<tr><td><code>/panel/admin/messages</code></td><td>Messages Settings</td></tr>
<tr><td><code>/panel/admin/push-notifications</code></td><td>Push Notifications</td></tr>
<tr><td><code>/panel/admin/announcements</code></td><td>Announcements</td></tr>
<tr><td><code>/panel/admin/age-verification</code></td><td>Age Verification</td></tr>
<tr><td><code>/panel/admin/social-login</code></td><td>Social Login Config</td></tr>
<tr><td><code>/panel/admin/google</code></td><td>Google Settings</td></tr>
<tr><td><code>/panel/admin/giphy-api</code></td><td>GIPHY Integration</td></tr>
<tr><td><code>/panel/admin/stickers</code></td><td>Stickers</td></tr>
<tr><td><code>/panel/admin/blog</code></td><td>Blog Management</td></tr>
<tr><td><code>/panel/admin/pages</code></td><td>Custom Pages</td></tr>
<tr><td><code>/panel/admin/categories</code></td><td>Categories</td></tr>
<tr><td><code>/panel/admin/languages</code></td><td>Languages</td></tr>
<tr><td><code>/panel/admin/countries</code></td><td>Countries</td></tr>
<tr><td><code>/panel/admin/names-reserved</code></td><td>Reserved Usernames</td></tr>
<tr><td><code>/panel/admin/profiles-social</code></td><td>Social Profiles</td></tr>
</table>
</div>
</div>
</div>
</div>

<!-- 8. FEATURE INVENTORY -->
<h2 class="section-title" id="features"><i class="bi bi-stars"></i> 8. Feature Inventory</h2>

<div class="row g-3 mb-4">
<div class="col-md-4">
<div class="card h-100">
<div class="card-header">Content & Creator Tools</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<tr><td>Reels</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Stories (Image + Text)</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Vault (File Storage)</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Scheduled Posts</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>EPUB Files</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>ZIP Files</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Watermark</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>QR Codes</td><td class="status-ok">✅ Enabled</td></tr>
</table>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card h-100">
<div class="card-header">Monetization</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<tr><td>Subscriptions</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Tips</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Pay-Per-View</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Gifts</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Shop (Digital + Physical)</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Earnings Simulator</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Referral System</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Wallet</td><td class="status-ok">✅ Enabled</td></tr>
</table>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card h-100">
<div class="card-header">Communication</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<tr><td>Video Calls (Agora)</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Audio Calls (Agora)</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Live Streaming</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Private Live Streaming</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Direct Messages</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Welcome Messages</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>Push Notifications</td><td class="status-ok">✅ Enabled</td></tr>
<tr><td>GIFs (GIPHY)</td><td class="status-ok">✅ Enabled</td></tr>
</table>
</div>
</div>
</div>
</div>

<!-- 9. NEW IN SPONZY v7.9.2 -->
<h2 class="section-title" id="new"><i class="bi bi-lightning"></i> 9. New in Sponzy v7.9.2 <span class="badge badge-new ms-2">Not in Old fansfollow.me</span></h2>

<div class="table-responsive mb-4">
<table class="table table-sm">
<thead><tr><th>Feature</th><th>Old Sponzy</th><th>v7.9.2</th><th>FFM Use Case</th></tr></thead>
<tbody>
<tr><td><strong>Reels</strong></td><td>❌</td><td class="status-ok">✅</td><td>Workout clips, technique demos, fight highlights</td></tr>
<tr><td><strong>Video Calls</strong></td><td>❌</td><td class="status-ok">✅</td><td>1-on-1 coaching, VIP sessions</td></tr>
<tr><td><strong>Audio Calls</strong></td><td>❌</td><td class="status-ok">✅</td><td>Coaching calls, consultations</td></tr>
<tr><td><strong>Private Live Streaming</strong></td><td>❌</td><td class="status-ok">✅</td><td>Paid private training sessions</td></tr>
<tr><td><strong>Vault</strong></td><td>❌</td><td class="status-ok">✅</td><td>Store workout plans, meal prep PDFs</td></tr>
<tr><td><strong>Gifts</strong></td><td>❌</td><td class="status-ok">✅</td><td>Fan engagement, additional revenue</td></tr>
<tr><td><strong>EPUB Support</strong></td><td>❌</td><td class="status-ok">✅</td><td>Sell training ebooks</td></tr>
<tr><td><strong>Scheduled Posts</strong></td><td>❌</td><td class="status-ok">✅</td><td>Content planning across time zones</td></tr>
<tr><td><strong>Age Verification</strong></td><td>❌</td><td class="status-ok">✅</td><td>Legal compliance (Yoti/Didit)</td></tr>
<tr><td><strong>PWA</strong></td><td>❌</td><td class="status-ok">✅</td><td>Mobile app-like experience</td></tr>
<tr><td><strong>Push Notifications</strong></td><td>❌</td><td class="status-ok">✅</td><td>Re-engagement</td></tr>
<tr><td><strong>Earnings Simulator</strong></td><td>❌</td><td class="status-ok">✅</td><td>Creator revenue education</td></tr>
<tr><td><strong>Stories (Enhanced)</strong></td><td>Basic</td><td class="status-ok">✅</td><td>Image + text stories with backgrounds/fonts</td></tr>
<tr><td><strong>Advertising System</strong></td><td>❌</td><td class="status-ok">✅</td><td>Promoted posts/creators</td></tr>
<tr><td><strong>Role & Permissions</strong></td><td>❌</td><td class="status-ok">✅</td><td>Fine-grained admin access control</td></tr>
</tbody>
</table>
</div>

<!-- 10. ADMIN SETTINGS MAP -->
<h2 class="section-title" id="settings"><i class="bi bi-sliders"></i> 10. Admin Settings Map</h2>

<div class="card mb-4">
<div class="card-header">General Settings — All Toggles</div>
<div class="card-body p-0">
<div class="table-responsive">
<table class="table table-sm mb-0">
<thead><tr><th>Setting</th><th>Current</th><th>What It Does</th></tr></thead>
<tbody>
<tr><td><code>who_can_see_content</code></td><td class="status-ok">all</td><td>Public access to profiles (vs logged-in only)</td></tr>
<tr><td><code>email_verification</code></td><td class="status-ok">✅ On</td><td>Require email verification on signup</td></tr>
<tr><td><code>account_verification</code></td><td class="status-ok">✅ On</td><td>Allow creator verification requests</td></tr>
<tr><td><code>registration_active</code></td><td class="status-ok">✅ On</td><td>Allow new registrations</td></tr>
<tr><td><code>show_counter</code></td><td class="status-ok">✅ On</td><td>Show post/like/view counts</td></tr>
<tr><td><code>widget_creators_featured</code></td><td class="status-ok">✅ On</td><td>Show featured creators widget</td></tr>
<tr><td><code>earnings_simulator</code></td><td class="status-ok">✅ On</td><td>Show earnings calculator to creators</td></tr>
<tr><td><code>requests_verify_account</code></td><td class="status-ok">✅ On</td><td>Allow verification requests</td></tr>
<tr><td><code>watermark</code></td><td class="status-ok">✅ On</td><td>Auto-watermark uploaded content</td></tr>
<tr><td><code>users_can_edit_post</code></td><td class="status-ok">✅ On</td><td>Allow post editing after publish</td></tr>
<tr><td><code>referral_system</code></td><td class="status-ok">✅ On</td><td>Enable referral program</td></tr>
<tr><td><code>search_creators_genders</code></td><td class="status-ok">✅ On</td><td>Gender filter in creator search</td></tr>
<tr><td><code>generate_qr_code</code></td><td class="status-ok">✅ On</td><td>QR code generation for profiles</td></tr>
<tr><td><code>allow_zip_files</code></td><td class="status-ok">✅ On</td><td>Allow ZIP file uploads</td></tr>
<tr><td><code>allow_scheduled_posts</code></td><td class="status-ok">✅ On</td><td>Post scheduling feature</td></tr>
<tr><td><code>allow_creators_deactivate_profile</code></td><td class="status-ok">✅ On</td><td>Temporary profile deactivation</td></tr>
<tr><td><code>allow_epub_files</code></td><td class="status-ok">✅ On</td><td>EPUB ebook uploads</td></tr>
<tr><td><code>gifts</code></td><td class="status-ok">✅ On</td><td>Virtual gift system</td></tr>
<tr><td><code>allow_reels</code></td><td class="status-ok">✅ On</td><td>Short-form video feature</td></tr>
<tr><td><code>allow_vault</code></td><td class="status-ok">✅ On</td><td>Private file storage</td></tr>
<tr><td><code>users_can_delete_messages</code></td><td class="status-ok">✅ On</td><td>Allow message deletion</td></tr>
<tr><td><code>allow_delete_account</code></td><td class="status-ok">✅ On</td><td>Allow account deletion</td></tr>
<tr><td><code>send_welcome_email_new_users</code></td><td class="status-ok">✅ On</td><td>Welcome email on registration</td></tr>
<tr><td><code>captcha_contact</code></td><td class="status-ok">✅ On</td><td>CAPTCHA on contact form</td></tr>
<tr><td><code>disable_tips</code></td><td>❌ Off</td><td>Tips are enabled (off = enabled)</td></tr>
<tr><td><code>disable_free_post</code></td><td>❌ Off</td><td>Free posts are enabled</td></tr>
<tr><td><code>disable_explore_section</code></td><td>❌ Off</td><td>Explore is enabled</td></tr>
<tr><td><code>disable_creators_section</code></td><td>❌ Off</td><td>Creators section is enabled</td></tr>
<tr><td><code>disable_contact</code></td><td>❌ Off</td><td>Contact form is enabled</td></tr>
<tr><td><code>captcha</code></td><td>❌ Off</td><td>Global CAPTCHA (off for testing)</td></tr>
<tr><td><code>alert_adult</code></td><td>❌ Off</td><td>Adult content warning (not needed)</td></tr>
<tr><td><code>hide_admin_profile</code></td><td>❌ Off</td><td>Admin profile visible</td></tr>
</tbody>
</table>
</div>
</div>
</div>

<!-- 11. PAYMENT GATEWAYS -->
<h2 class="section-title" id="payments"><i class="bi bi-credit-card"></i> 11. Payment Gateways</h2>

<div class="table-responsive mb-4">
<table class="table table-sm">
<thead><tr><th>Gateway</th><th>ID</th><th>Status</th><th>Notes</th></tr></thead>
<tbody>
<tr><td>Stripe</td><td>1</td><td>Needs API keys</td><td>Primary recommended</td></tr>
<tr><td>PayPal</td><td>2</td><td>Needs API keys</td><td>Wide reach</td></tr>
<tr><td>CCBill</td><td>3</td><td>Needs API keys</td><td>Adult-friendly</td></tr>
<tr><td>Paystack</td><td>4</td><td>Needs API keys</td><td>Africa focus</td></tr>
<tr><td>Instamojo</td><td>5</td><td>Needs API keys</td><td>India focus</td></tr>
<tr><td>Flutterwave</td><td>6</td><td>Needs API keys</td><td>Africa focus</td></tr>
<tr><td>Razorpay</td><td>7</td><td>Needs API keys</td><td>India focus</td></tr>
<tr><td>MercadoPago</td><td>8</td><td>Needs API keys</td><td>Latin America</td></tr>
<tr><td>Mollie</td><td>9</td><td>Needs API keys</td><td>Europe focus</td></tr>
<tr><td>Coinbase</td><td>10</td><td>Needs API keys</td><td>Crypto</td></tr>
<tr><td>CoinPayments</td><td>11</td><td>Needs API keys</td><td>Crypto</td></tr>
<tr><td>Cardinity</td><td>12</td><td>Needs API keys</td><td>Europe focus</td></tr>
</tbody>
</table>
</div>

<!-- 12. DESIGN TOKENS -->
<h2 class="section-title" id="design"><i class="bi bi-palette"></i> 12. Design Tokens</h2>

<div class="row g-3 mb-4">
<div class="col-md-6">
<div class="card h-100">
<div class="card-header">Colors & Typography</div>
<div class="card-body">
<table class="table table-sm mb-0">
<tr><td>Background</td><td><code>#0B0F1A</code> <span style="display:inline-block;width:20px;height:20px;background:#0B0F1A;border:1px solid #333;vertical-align:middle;border-radius:4px;"></span></td></tr>
<tr><td>Card Background</td><td><code>#111827</code> <span style="display:inline-block;width:20px;height:20px;background:#111827;border:1px solid #333;vertical-align:middle;border-radius:4px;"></span></td></tr>
<tr><td>Border</td><td><code>#1f2937</code> <span style="display:inline-block;width:20px;height:20px;background:#1f2937;border:1px solid #333;vertical-align:middle;border-radius:4px;"></span></td></tr>
<tr><td>Primary/CTA</td><td><code>#f97316</code> (Orange) <span style="display:inline-block;width:20px;height:20px;background:#f97316;vertical-align:middle;border-radius:4px;"></span></td></tr>
<tr><td>Text Primary</td><td><code>#e5e7eb</code></td></tr>
<tr><td>Text Muted</td><td><code>#9ca3af</code></td></tr>
<tr><td>Font Family</td><td>Inter, system-ui, sans-serif</td></tr>
<tr><td>Navbar Height</td><td>72px</td></tr>
<tr><td>Theme</td><td>Dark (default)</td></tr>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card h-100">
<div class="card-header">Branding Assets</div>
<div class="card-body">
<table class="table table-sm mb-0">
<tr><td>Logo</td><td><code>/fans-foloow-me-logo-final-file--png-version.png</code></td></tr>
<tr><td>Logo (480px)</td><td><code>/fans-foloow-me-logo-final-file--png-version-480.png</code></td></tr>
<tr><td>Logo (960px)</td><td><code>/fans-foloow-me-logo-final-file--png-version-960.png</code></td></tr>
<tr><td>Logo (1440px)</td><td><code>/fans-foloow-me-logo-final-file--png-version-1440.png</code></td></tr>
<tr><td>Hero Background</td><td><code>/ffmherobackground.jpg</code></td></tr>
<tr><td>Hero Background (1280)</td><td><code>/ffmherobackground-1280.jpg</code></td></tr>
<tr><td>Creators Hero BG</td><td><code>/creators-hero-bg.jpg</code></td></tr>
<tr><td>Favicon</td><td><code>/img/favicon.png</code></td></tr>
<tr><td>Custom CSS</td><td><code>/css/ffm-brand.css</code> (53KB)</td></tr>
</table>
</div>
</div>
</div>
</div>

<!-- 13. SEO & TRACKING -->
<h2 class="section-title" id="seo"><i class="bi bi-graph-up"></i> 13. SEO & Tracking</h2>

<div class="row g-3 mb-4">
<div class="col-md-6">
<div class="card h-100">
<div class="card-header">Analytics & Tracking</div>
<div class="card-body">
<table class="table table-sm mb-0">
<tr><td>GA4</td><td><code>G-SZRL69LXXS</code></td></tr>
<tr><td>Microsoft Clarity</td><td><code>xk78rrb386</code></td></tr>
<tr><td>Usebasin (Forms)</td><td><code>954d0d6e30da</code></td></tr>
<tr><td>Conversion Events</td><td><code>sign_up</code>, <code>login</code>, <code>generate_lead</code></td></tr>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card h-100">
<div class="card-header">SEO</div>
<div class="card-body">
<table class="table table-sm mb-0">
<tr><td>robots.txt</td><td class="status-ok">✅</td></tr>
<tr><td>sitemap.xml</td><td class="status-ok">✅</td></tr>
<tr><td>Open Graph Tags</td><td class="status-ok">✅</td></tr>
<tr><td>Twitter Cards</td><td class="status-ok">✅</td></tr>
<tr><td>Canonical URLs</td><td class="status-ok">✅</td></tr>
<tr><td>JSON-LD Schema</td><td class="status-ok">✅</td></tr>
<tr><td>Bing Webmaster</td><td><code>83E04AABA8CC0BC0618D1849666A133A</code></td></tr>
</table>
</div>
</div>
</div>
</div>

<!-- 14. DATABASE SCHEMA -->
<h2 class="section-title" id="database"><i class="bi bi-database"></i> 14. Database Schema</h2>

<div class="card mb-4">
<div class="card-header">Key Tables (stg_ prefix)</div>
<div class="card-body p-0">
<div class="row p-3">
<div class="col-md-4">
<p class="fw-bold mb-1">Users & Auth</p>
<ul class="list-unstyled text-muted small">
<li><code>stg_users</code> — 17,546 records</li>
<li><code>stg_login_sessions</code></li>
<li><code>stg_password_resets</code></li>
<li><code>stg_personal_access_tokens</code></li>
</ul>
<p class="fw-bold mb-1">Content</p>
<ul class="list-unstyled text-muted small">
<li><code>stg_updates</code> — 239 posts</li>
<li><code>stg_media</code> — Post media files</li>
<li><code>stg_comments</code></li>
<li><code>stg_comment_replies</code></li>
<li><code>stg_reels</code> — Short videos</li>
<li><code>stg_media_reels</code></li>
<li><code>stg_stories</code></li>
<li><code>stg_media_stories</code></li>
</ul>
</div>
<div class="col-md-4">
<p class="fw-bold mb-1">Monetization</p>
<ul class="list-unstyled text-muted small">
<li><code>stg_subscriptions</code></li>
<li><code>stg_transactions</code></li>
<li><code>stg_deposits</code></li>
<li><code>stg_withdrawals</code></li>
<li><code>stg_products</code></li>
<li><code>stg_sales</code></li>
<li><code>stg_tips</code></li>
<li><code>stg_gifts</code></li>
<li><code>stg_advertising</code></li>
</ul>
<p class="fw-bold mb-1">Communication</p>
<ul class="list-unstyled text-muted small">
<li><code>stg_messages</code></li>
<li><code>stg_conversations</code></li>
<li><code>stg_notifications</code></li>
<li><code>video_calls</code></li>
<li><code>audio_calls</code></li>
</ul>
</div>
<div class="col-md-4">
<p class="fw-bold mb-1">Categories & Taxonomy</p>
<ul class="list-unstyled text-muted small">
<li><code>stg_categories</code></li>
<li><code>stg_shop_categories</code></li>
<li><code>stg_countries</code></li>
<li><code>stg_states</code></li>
<li><code>stg_languages</code></li>
</ul>
<p class="fw-bold mb-1">Settings & Config</p>
<ul class="list-unstyled text-muted small">
<li><code>admin_settings</code> — Global settings</li>
<li><code>stg_pages</code> — Custom pages</li>
<li><code>stg_blog</code></li>
<li><code>stg_stickers</code></li>
<li><code>stg_gifts</code></li>
<li><code>vaults</code> — Creator file storage</li>
</ul>
</div>
</div>
</div>
</div>

<!-- 15. DEPLOYMENT -->
<h2 class="section-title" id="deploy"><i class="bi bi-rocket"></i> 15. Deployment Pipeline</h2>

<div class="card mb-4">
<div class="card-body">
<pre class="mb-0" style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 8px; font-size: 0.85em;">
Git Push (main)
    ↓
Laravel Cloud Auto-Deploy
    ↓
Build: composer install --no-dev && php fix-laravel-cloud.php && php artisan view:clear
    ↓
Deploy: bash deploy.sh
    ├── Create storage directories
    ├── Create public/public symlink
    ├── Run pending migrations (php artisan migrate --force)
    ├── Fix missing database columns (idempotent)
    ├── Create missing tables (video_calls, audio_calls, vaults)
    ├── Seed test accounts (testfan, testcreator)
    ├── Clear caches (config, view, route)
    └── Done
    ↓
Live at https://staging.fansfollowme.com
</pre>
</div>
</div>

<!-- 16. TEST ACCOUNTS -->
<h2 class="section-title" id="test-accounts"><i class="bi bi-person-check"></i> 16. Test Accounts</h2>

<div class="table-responsive mb-4">
<table class="table table-sm">
<thead><tr><th>Account</th><th>Username</th><th>Role</th><th>Features</th></tr></thead>
<tbody>
<tr><td>Admin</td><td><code>Admin</code></td><td>Admin</td><td>Full admin panel access</td></tr>
<tr><td>Test Fan</td><td><code>testfan</code></td><td>Fan (Normal)</td><td>Subscribe, tip, message, purchase</td></tr>
<tr><td>Test Creator</td><td><code>testcreator</code></td><td>Creator</td><td>Post, sell, receive tips, go live</td></tr>
</tbody>
</table>
<p class="text-muted small mb-0">Password for all: <code>TestPass123!</code></p>
</div>

<!-- 17. KNOWN ISSUES -->
<h2 class="section-title" id="known-issues"><i class="bi bi-bug"></i> 17. Known Issues</h2>

<div class="table-responsive mb-4">
<table class="table table-sm">
<thead><tr><th>Issue</th><th>Page</th><th>Status</th><th>Root Cause</th></tr></thead>
<tbody>
<tr><td>Settings Page 500</td><td><code>/settings/page</code></td><td class="status-warn">⚠️ Investigating</td><td>Categories model table prefix fix deployed, may need cache clear</td></tr>
<tr><td>Vault 500</td><td><code>/my/vault</code></td><td class="status-warn">⚠️ Investigating</td><td>vaults table created in deploy, may need cache clear</td></tr>
<tr><td>Video/Audio Call 404</td><td><code>/settings/video-call</code></td><td class="status-warn">⚠️ Config Needed</td><td>Enabled in admin but needs valid Agora credentials</td></tr>
<tr><td>Reels 302</td><td><code>/reels</code></td><td class="status-ok">✅ Expected</td><td>No reels exist yet, redirects to home</td></tr>
<tr><td>Age Verification</td><td>All auth pages</td><td class="status-ok">✅ Disabled</td><td>Disabled for testing, enable for production</td></tr>
</tbody>
</table>
</div>

<!-- 18. DESIGN CHECKLIST -->
<h2 class="section-title" id="checklist"><i class="bi bi-check2-square"></i> 18. Design Checklist for Martin</h2>

<div class="card mb-4">
<div class="card-body">
<p class="fw-bold mb-3">Every page below needs a FFM-branded design. Check off as designed:</p>

<div class="row">
<div class="col-md-6">
<p class="fw-bold text-warning">Public Pages (17)</p>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c1"><label class="form-check-label" for="c1">Homepage — Hero, featured creators, CTA</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c2"><label class="form-check-label" for="c2">Explore — Post feed with filters</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c3"><label class="form-check-label" for="c3">Creators — Creator directory</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c4"><label class="form-check-label" for="c4">Fans — Fan landing page</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c5"><label class="form-check-label" for="c5">Celebrities — Celebrity showcase</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c6"><label class="form-check-label" for="c6">Casting — Casting calls</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c7"><label class="form-check-label" for="c7">Business — Brand partnerships</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c8"><label class="form-check-label" for="c8">For Creators — Creator recruitment</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c9"><label class="form-check-label" for="c9">Support — Help center</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c10"><label class="form-check-label" for="c10">FAQ — Questions & answers</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c11"><label class="form-check-label" for="c11">Contact — Contact form</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c12"><label class="form-check-label" for="c12">Blog — Blog listing</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c13"><label class="form-check-label" for="c13">Privacy / Terms / Cookies</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c14"><label class="form-check-label" for="c14">Login / Signup / Password Reset</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c15"><label class="form-check-label" for="c15">Profile Page — Avatar, cover, posts, tabs</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c16"><label class="form-check-label" for="c16">Reels — Vertical video feed</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c17"><label class="form-check-label" for="c17">Shop — Product listing</label></div>
</div>
<div class="col-md-6">
<p class="fw-bold text-warning">Backend Pages (Fan + Creator)</p>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c18"><label class="form-check-label" for="c18">Dashboard — Feed, stats, quick actions</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c19"><label class="form-check-label" for="c19">Notifications</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c20"><label class="form-check-label" for="c20">Messages — Inbox + Chat</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c21"><label class="form-check-label" for="c21">Settings — Edit profile, password, privacy</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c22"><label class="form-check-label" for="c22">My Posts / My Products / My Sales</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c23"><label class="form-check-label" for="c23">My Subscribers / My Subscriptions</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c24"><label class="form-check-label" for="c24">Wallet / Withdrawals / Payout</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c25"><label class="form-check-label" for="c25">Bookmarks / Likes / Purchases</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c26"><label class="form-check-label" for="c26">Stories — Create + View</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c27"><label class="form-check-label" for="c27">Reels — Create + View</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c28"><label class="form-check-label" for="c28">Vault — File storage</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c29"><label class="form-check-label" for="c29">Video/Audio Call — Settings + UI</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c30"><label class="form-check-label" for="c30">Live Streaming — Go live + Watch</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c31"><label class="form-check-label" for="c31">Referrals</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c32"><label class="form-check-label" for="c32">Age Verification</label></div>

<p class="fw-bold text-warning mt-3">Admin Panel (20 key pages)</p>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c33"><label class="form-check-label" for="c33">Admin Dashboard</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c34"><label class="form-check-label" for="c34">Settings / Members / Posts / Categories</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c35"><label class="form-check-label" for="c35">Payments / Subscriptions / Transactions</label></div>
<div class="form-check"><input class="form-check-input" type="checkbox" id="c36"><label class="form-check-label" for="c36">Theme / Billing / Storage / Reports</label></div>
</div>
</div>
</div>
</div>

<!-- 19. WORKFLOW & TEAM -->
<h2 class="section-title" id="workflow"><i class="bi bi-diagram-3"></i> 19. Workflow & Team Collaboration</h2>

<div class="card mb-4">
<div class="card-header"><i class="bi bi-people-fill me-2"></i>Who Does What</div>
<div class="card-body">
<div class="row">
<div class="col-md-4">
<div class="card bg-dark border-warning h-100">
<div class="card-body text-center">
<h5 class="text-warning"><i class="bi bi-person-fill me-2"></i>Martin</h5>
<p class="small text-muted mb-2"><strong>Role:</strong> Product Owner / Designer</p>
<ul class="list-unstyled small text-start">
<li>✅ Creates tasks in <strong>Highrise</strong></li>
<li>✅ Provides design feedback</li>
<li>✅ Approves/rejects changes</li>
<li>✅ Writes notes and emails (BCC'd to Highrise)</li>
<li>✅ Signs off on features before build</li>
<li>❌ Does NOT write code</li>
<li>❌ Does NOT deploy</li>
</ul>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card bg-dark border-primary h-100">
<div class="card-body text-center">
<h5 class="text-primary"><i class="bi bi-robot me-2"></i>Claude (AI)</h5>
<p class="small text-muted mb-2"><strong>Role:</strong> Developer / QA</p>
<ul class="list-unstyled small text-start">
<li>✅ Monitors Highrise every 5-30 min</li>
<li>✅ Reads Martin's tasks and feedback</li>
<li>✅ Writes code and fixes bugs</li>
<li>✅ Runs QA tests (automated)</li>
<li>✅ Commits, pushes, deploys</li>
<li>✅ Verifies in browser</li>
<li>✅ Replies to Martin in Highrise</li>
</ul>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card bg-dark border-success h-100">
<div class="card-body text-center">
<h5 class="text-success"><i class="bi bi-github me-2"></i>System</h5>
<p class="small text-muted mb-2"><strong>Role:</strong> Infrastructure</p>
<ul class="list-unstyled small text-start">
<li>✅ <strong>GitHub:</strong> Source code, version control</li>
<li>✅ <strong>Laravel Cloud:</strong> Hosting, auto-deploy</li>
<li>✅ <strong>Cloudflare R2:</strong> File storage</li>
<li>✅ <strong>Highrise:</strong> Task management</li>
<li>✅ <strong>GA4/Clarity:</strong> Analytics</li>
<li>✅ <strong>Usebasin:</strong> Form handling</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-header"><i class="bi bi-arrow-repeat me-2"></i>Development Workflow</div>
<div class="card-body">
<pre class="mb-0" style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.85em; line-height: 1.8;">
<span class="text-warning">Martin</span> creates task in <span class="text-info">Highrise</span>
    ↓
<span class="text-primary">Claude</span> monitors Highrise (every 5-30 minutes)
    ↓
<span class="text-primary">Claude</span> reads task, explores codebase, plans approach
    ↓
<span class="text-primary">Claude</span> implements changes (code, templates, settings)
    ↓
<span class="text-primary">Claude</span> runs <span class="text-success">QA tests</span> (automated browser tests)
    ├── Public pages (17 URLs) — HTTP status + screenshots
    ├── Auth pages (3 URLs) — Login flow verification
    ├── Fan backend (15 URLs) — Logged-in user flow
    ├── Creator backend (19 URLs) — Creator-specific pages
    └── Admin panel (20 URLs) — Admin-only pages
    ↓
<span class="text-primary">Claude</span> commits to <span class="text-info">GitHub</span> (main branch)
    ↓
<span class="text-info">Laravel Cloud</span> auto-deploys to <span class="text-success">staging.fansfollowme.com</span>
    ↓
<span class="text-primary">Claude</span> verifies in browser (screenshots, behavior check)
    ↓
<span class="text-primary">Claude</span> replies to <span class="text-warning">Martin</span> in <span class="text-info">Highrise</span> with results
    ↓
<span class="text-warning">Martin</span> reviews, approves, or requests changes
    ↓
<span class="text-warning">Martin</span> signs off → Feature complete ✅
</pre>
</div>
</div>

<div class="card mb-4">
<div class="card-header"><i class="bi bi-clipboard-check me-2"></i>QA Testing Scripts</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<thead><tr><th>Script</th><th>Purpose</th><th>What It Tests</th><th>Output</th></tr></thead>
<tbody>
<tr>
<td><code>tests/qa-browser-test.sh</code></td>
<td>Public page smoke test</td>
<td>All 17 public pages, auth pages, profiles, backend redirects, admin redirects, static assets</td>
<td><code>tests/qa-results.md</code> + screenshots</td>
</tr>
<tr>
<td><code>tests/qa-auth-test.sh</code></td>
<td>Authenticated user flow test</td>
<td>Login as testfan/testcreator/Admin, test every backend page with real sessions</td>
<td><code>tests/qa-auth-results.md</code> + screenshots</td>
</tr>
<tr>
<td><code>tests/FFM-FEATURE-AUDIT.md</code></td>
<td>Feature inventory</td>
<td>Every Sponzy feature, what's enabled, what it does for FFM</td>
<td>Markdown document</td>
</tr>
</tbody>
</table>
</div>
</div>

<div class="card mb-4">
<div class="card-header"><i class="bi bi-envelope me-2"></i>Highrise Integration</div>
<div class="card-body">
<div class="row">
<div class="col-md-6">
<p class="fw-bold">How Martin Communicates</p>
<ul class="small">
<li><strong>Highrise Tasks:</strong> Creates tasks with descriptions, priorities, and deadlines</li>
<li><strong>Highrise Notes:</strong> Adds feedback and context to existing tasks</li>
<li><strong>Emails:</strong> BCC'd to Highrise so all communication is tracked</li>
<li><strong>Design Sign-off:</strong> Martin must approve designs before code changes</li>
</ul>
</div>
<div class="col-md-6">
<p class="fw-bold">How Claude Responds</p>
<ul class="small">
<li><strong>Monitors:</strong> Checks Highrise every 5-30 minutes for new tasks/feedback</li>
<li><strong>Implements:</strong> Reads task, writes code, runs tests</li>
<li><strong>Deploys:</strong> Pushes to GitHub → auto-deploys to staging</li>
<li><strong>Verifies:</strong> Tests in browser, takes screenshots</li>
<li><strong>Reports:</strong> Replies in Highrise with results and screenshots</li>
</ul>
</div>
</div>
<div class="alert alert-warning mt-3 mb-0">
<strong><i class="bi bi-exclamation-triangle me-2"></i>Important Rule:</strong> Claude does NOT touch the site or build anything until Martin provides design sign-off. Martin controls the "what" — Claude handles the "how".
</div>
</div>
</div>

<!-- 20. CURRENT STATUS -->
<h2 class="section-title" id="status"><i class="bi bi-activity"></i> 20. Current Status & Next Steps</h2>

<div class="row g-3 mb-4">
<div class="col-md-6">
<div class="card h-100">
<div class="card-header bg-success text-white"><i class="bi bi-check-circle me-2"></i>Completed</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<tr><td>✅</td><td>Staging environment live and operational</td></tr>
<tr><td>✅</td><td>All 17 public pages returning 200</td></tr>
<tr><td>✅</td><td>Login/signup/password reset working</td></tr>
<tr><td>✅</td><td>Fan backend (13/15 pages) working</td></tr>
<tr><td>✅</td><td>Creator backend (16/19 pages) working</td></tr>
<tr><td>✅</td><td>Admin panel (20/20 pages) working</td></tr>
<tr><td>✅</td><td>All Sponzy v7.9.2 features enabled</td></tr>
<tr><td>✅</td><td>GA4, Clarity, Usebasin tracking active</td></tr>
<tr><td>✅</td><td>SEO (sitemap, robots, OG tags, JSON-LD)</td></tr>
<tr><td>✅</td><td>Automated QA test scripts created</td></tr>
<tr><td>✅</td><td>Platform Blueprint page created</td></tr>
<tr><td>✅</td><td>Test accounts seeded (testfan, testcreator)</td></tr>
</table>
</div>
</div>
</div>
<div class="col-md-6">
<div class="card h-100">
<div class="card-header bg-warning text-dark"><i class="bi bi-clock me-2"></i>Waiting On</div>
<div class="card-body p-0">
<table class="table table-sm mb-0">
<tr><td>⏳</td><td><strong>Martin's design sign-off</strong> — before any UI/template work</td></tr>
<tr><td>⏳</td><td>Settings page 500 fix (cache issue)</td></tr>
<tr><td>⏳</td><td>Vault page 500 fix (table created, needs verification)</td></tr>
<tr><td>⏳</td><td>Agora API credentials for video/audio calls</td></tr>
<tr><td>⏳</td><td>Payment gateway API keys (Stripe, PayPal, etc.)</td></tr>
<tr><td>⏳</td><td>SMTP/email configuration</td></tr>
<tr><td>⏳</td><td>Age verification decision (enable for production?)</td></tr>
<tr><td>⏳</td><td>Content seeding (sample posts, reels, products)</td></tr>
</table>
</div>
</div>
</div>
</div>

<!-- 21. FULL TECHNICAL DOCUMENTATION -->
<h2 class="section-title" id="docs"><i class="bi bi-file-earmark-code"></i> 21. Full Technical Documentation <span class="badge bg-info ms-2">For Claude / Developers</span></h2>

<p class="text-muted mb-3">Complete source documentation. Click each section to expand. These are the actual files from the repository — Claude can review, enhance, and follow these conventions.</p>

<!-- AGENTS.md -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#agents-md" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2" id="agents-icon"></i>
<strong>AGENTS.md</strong> — Project Architecture, Conventions & Rules
<span class="badge bg-danger ms-2">MUST READ</span>
</div>
<div class="collapse" id="agents-md">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 600px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;"># AGENTS.md — FFM Sponzy Project Instructions

## Project Overview
FansFollow.me (FFM) is a creator platform for fitness, bodybuilding, and martial arts creators. Built on **Sponzy v7.9.2** (a commercial PHP/Laravel script), hosted on **Laravel Cloud**, with **Cloudflare R2** for file storage.

**This is NOT a greenfield project.** Sponzy is a purchased script with its own conventions. Respect them.

## Architecture

### Stack
- **Framework:** Laravel 12.46 / PHP 8.5
- **Database:** MySQL 8.4 (tables use `stg_` prefix)
- **Frontend:** Blade templates + Bootstrap 5 + vanilla JS (no React/Vue)
- **Storage:** Cloudflare R2 (S3-compatible)
- **Hosting:** Laravel Cloud (auto-deploy on push to main)
- **Video/Audio:** Agora SDK
- **Analytics:** GA4, Microsoft Clarity, Usebasin

### Directory Structure
app/
├── Http/Controllers/    # All controllers (80+ files)
├── Models/              # Eloquent models (66 files)
├── Services/            # External service integrations
├── Jobs/                # Queue jobs (video encoding, moderation)
├── Events/              # Laravel events
├── Listeners/           # Event listeners
├── Notifications/       # Email/push notifications
└── Helper.php           # Global helper class

resources/views/
├── index/               # Public pages (home, explore, creators, etc.)
├── users/               # Authenticated user pages (dashboard, settings, etc.)
├── admin/               # Admin panel pages (100+ files)
├── includes/            # Shared partials (navbar, footer, modals)
├── layouts/             # Master layouts (app.blade.php, appnew.blade.php)
├── reels/               # Reels views
├── shop/                # Shop views
└── emails/              # Email templates

routes/
├── web.php              # ALL routes (public, auth, admin)
├── api.php              # API routes (minimal)
└── console.php          # Artisan commands

### Key Patterns

#### Table Prefix: `stg_`
ALL database tables use the `stg_` prefix. When creating Eloquent models, ALWAYS set:
  protected $table = 'stg_tablename';

**Exception:** Some tables like `admin_settings`, `video_calls`, `audio_calls`, `vaults` do NOT have the prefix. Check the schema before assuming.

#### Model Convention
class ExampleModel extends Model
{
    protected $table = 'stg_examples';  // ALWAYS set this
    protected $guarded = [];            // Sponzy uses guarded=[], not fillable
    public $timestamps = false;         // Most Sponzy tables don't use timestamps
}

#### Controller Convention
class ExampleController extends Controller
{
    protected $settings;  // Admin settings singleton
    public function __construct()
    {
        $this->settings = config('settings');  // Always available
    }
}

#### View Convention
@extends('layouts.app')
@section('title')Page Title @endsection
@section('content')
    {{-- Page content here --}}
@endsection

#### Route Convention
// Public routes (no auth)
Route::get('page', [Controller::class, 'method']);

// Authenticated routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [UserController::class, 'dashboard']);
});

// Admin routes (role middleware)
Route::group(['middleware' => ['role', 'nocache']], function () {
    Route::prefix('panel/admin')->group(function () {
        Route::get('/', [AdminController::class, 'admin']);
    });
});

## Critical Rules

### DO NOT
1. DO NOT create new tables without the `stg_` prefix (unless it's a system table like `admin_settings`)
2. DO NOT use React, Vue, or any SPA framework — this is Blade + vanilla JS
3. DO NOT modify the Sponzy core files without documenting why
4. DO NOT add Composer packages without checking if Sponzy already has the functionality
5. DO NOT use `$fillable` — Sponzy uses `$guarded = []`
6. DO NOT assume table names — always check `database/schema.sql` or the model
7. DO NOT create new CSS files — use `public/css/ffm-brand.css` for FFM customizations
8. DO NOT modify `public/css/core.min.css` or `public/css/bootstrap.min.css` — these are Sponzy vendor files
9. DO NOT hardcode URLs — use `url()`, `route()`, or `asset()` helpers
10. DO NOT skip the `stg_` prefix on joins — this caused the Reels 500 bug

### ALWAYS
1. ALWAYS check if a feature already exists in Sponzy before building it
2. ALWAYS use `ffm-brand.css` for FFM-specific styling (53KB of overrides already exist)
3. ALWAYS test with all 3 user roles: fan (testfan), creator (testcreator), admin (Admin)
4. ALWAYS run `tests/qa-auth-test.sh` after changes
5. ALWAYS commit to `main` branch (auto-deploys to staging)
6. ALWAYS check `database/schema.sql` for table structure before writing queries
7. ALWAYS use the dark theme (`data-bs-theme="dark"`) — FFM is dark by default
8. ALWAYS use Inter font family — FFM brand font
9. ALWAYS check `config('settings.*')` for feature flags before showing UI elements
10. ALWAYS preserve existing Sponzy functionality when adding FFM branding

## Design Tokens
--ffm-bg: #0B0F1A;           /* Main background */
--ffm-card: #111827;         /* Card/panel background */
--ffm-border: #1f2937;       /* Borders */
--ffm-orange: #f97316;       /* Primary CTA / brand color */
--ffm-text: #e5e7eb;         /* Primary text */
--ffm-muted: #9ca3af;        /* Secondary text */
font-family: 'Inter', system-ui, sans-serif;
navbar-height: 72px;

## File Editing Rules
- CSS: ONLY edit `public/css/ffm-brand.css`
- Blade: index/ (public), users/ (auth), admin/ (admin), includes/ (partials)
- PHP: Controllers in app/Http/Controllers/, Models in app/Models/
- Routes: ALL in routes/web.php
- Database: Schema in database/schema.sql, fixes in deploy.sh

## Test Accounts
| Admin | Admin | TestPass123! | Admin (full access) |
| Fan | testfan | TestPass123! | Normal user |
| Creator | testcreator | TestPass123! | Creator (verified) |

## QA Scripts
bash tests/qa-browser-test.sh    # Public page smoke test
bash tests/qa-auth-test.sh       # Authenticated user flow test

## Deployment
git push origin main → Laravel Cloud auto-deploys → Live at staging.fansfollowme.com

## Feature Flags
@if(config('settings.allow_reels'))    {{-- Reels --}}
@if(config('settings.allow_vault'))    {{-- Vault --}}
@if(config('settings.gifts'))          {{-- Gifts --}}
@if(config('settings.video_call_status'))  {{-- Video calls --}}
@if(config('settings.audio_call_status'))  {{-- Audio calls --}}

## Common Pitfalls
1. Table prefix: The #1 bug source. Always use `stg_` prefix.
2. CSRF tokens: Login uses AJAX with `X-Requested-With: XMLHttpRequest`
3. Age verification: Redirects to `/age/verification` if `user->age_verification !== 1`
4. Admin routes: Under `/panel/admin/`, NOT `/admin/`
5. User routes: Under `/settings/`, `/my/`, etc. — NOT `/user/`
6. View cache: Run `php artisan view:clear` after Blade changes
7. Config cache: Run `php artisan config:clear` after settings changes

## What Martin Needs
Martin is the product owner. He creates tasks in Highrise, provides design feedback, signs off on designs BEFORE code changes. He does NOT write code.

**Rule:** Do NOT touch the site or build anything until Martin provides design sign-off.</pre>
</div>
</div>
</div>

<!-- QA Browser Test Script -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#qa-browser" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2"></i>
<strong>tests/qa-browser-test.sh</strong> — Public Page Smoke Test (No Auth)
<span class="badge bg-success ms-2">56 tests</span>
</div>
<div class="collapse" id="qa-browser">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">#!/bin/bash
# FFM Staging Comprehensive Browser Test
# Tests public, backend, admin, fan, and creator pages

BASE_URL="https://staging.fansfollowme.com"

# PUBLIC PAGES (17 tests)
# Homepage, Explore, Creators, Fans, Celebrities, Casting, Business,
# Support, FAQ, Privacy, Terms, Cookies, Contact, Blog, For Creators,
# Sitemap, Robots

# AUTH PAGES (3 tests)
# Login, Signup, Password Reset

# PROFILE PAGES (3 tests)
# VikingSamurai, Ronsmoorenburg, TongPo

# BACKEND PAGES (10 tests - should redirect to login)
# /dashboard, /messages, /notifications, /settings/page, /my/posts,
# /my/subscribers, /my/subscriptions, /my/wallet, /settings/withdrawals,
# /my/referrals

# ADMIN PAGES (15 tests - should redirect to login)
# /panel/admin, /panel/admin/settings, /panel/admin/members,
# /panel/admin/posts, /panel/admin/categories, /panel/admin/pages,
# /panel/admin/blog, /panel/admin/subscriptions, /panel/admin/transactions,
# /panel/admin/withdrawals, /panel/admin/reports,
# /panel/admin/verification/members, /panel/admin/theme,
# /panel/admin/billing, /panel/admin/storage

# STATIC ASSETS (5 tests)
# /css/ffm-brand.css, /css/bootstrap.min.css, /js/app.js,
# /img/favicon.png, /fans-foloow-me-logo-final-file--png-version.png

# Run: bash tests/qa-browser-test.sh
# Output: tests/qa-results.md + tests/screenshots/</pre>
</div>
</div>
</div>

<!-- QA Auth Test Script -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#qa-auth" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2"></i>
<strong>tests/qa-auth-test.sh</strong> — Authenticated User Flow Test
<span class="badge bg-warning text-dark ms-2">54 tests</span>
</div>
<div class="collapse" id="qa-auth">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">#!/bin/bash
# FFM Staging Authenticated User Flow Test
# Tests actual login + navigation for fan, creator, and admin

BASE_URL="https://staging.fansfollowme.com"

# FAN FLOW (15 tests - logs in as testfan)
# Dashboard, Explore, Notifications, Messages, Settings, Password,
# Bookmarks, Subscriptions, Purchases, Wallet, Likes,
# Creator Profile, Creators, Reels, Shop

# CREATOR FLOW (19 tests - logs in as testcreator)
# Dashboard, Posts, Subscribers, Products, Sales, Stories, Reels,
# Vault, Settings, Payout, Withdrawals, Referrals, Subscription,
# Privacy, Messages, Notifications, Create Story,
# Video Call Settings, Audio Call Settings

# ADMIN FLOW (20 tests - logs in as Admin)
# Dashboard, Settings, Members, Posts, Categories, Pages, Blog,
# Subscriptions, Transactions, Withdrawals, Reports, Verification,
# Theme, Billing, Storage, Payments, Social Login, Google,
# Languages, Maintenance Mode

# Login method: AJAX with X-Requested-With: XMLHttpRequest
# Field name: username_email (NOT username)
# Session: Cookie-based (fansfollowme_session)

# Run: bash tests/qa-auth-test.sh
# Output: tests/qa-auth-results.md + tests/screenshots/auth/</pre>
</div>
</div>
</div>

<!-- Feature Audit -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#feature-audit" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2"></i>
<strong>tests/FFM-FEATURE-AUDIT.md</strong> — Complete Feature Inventory
<span class="badge bg-info ms-2">All Features</span>
</div>
<div class="collapse" id="feature-audit">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;"># FFM Staging — Sponzy v7.9.2 Feature Audit

## ENABLED FEATURES

### Content & Creator Tools
- Reels (short-form video)
- Stories (24-hour disappearing content)
- Vault (private file storage)
- Scheduled Posts
- EPUB Files
- ZIP Files
- Watermark
- QR Codes

### Monetization
- Tips
- Subscriptions
- Pay-Per-View
- Gifts
- Earnings Simulator
- Referral System
- Wallet
- Shop (physical + digital)

### Communication
- Video Calls (Agora)
- Audio Calls (Agora)
- Live Streaming
- Private Live Streaming
- Messages
- Welcome Messages

### User Experience
- Dark Mode (default)
- Featured Creators
- Search by Gender
- Creator Badges
- Post Counters
- Edit Posts
- Delete Messages
- Delete Account
- Deactivate Profile

### Security & Verification
- Email Verification
- Account Verification
- Age Verification (disabled for testing)
- 2FA
- QR Code Login

### Marketing & Growth
- Blog
- Custom Pages
- Social Login
- Push Notifications
- PWA
- Welcome Email

## NEW IN SPONZY v7.9.2 (Not in old fansfollow.me)
- Reels (TikTok-style)
- Video/Audio Calls
- Private Live Streaming
- Vault (file storage)
- Gifts
- EPUB Support
- Scheduled Posts
- Age Verification
- PWA
- Push Notifications
- Earnings Simulator
- Stories (Enhanced)
- Advertising System
- Role & Permissions

## NEEDS CONFIGURATION
- Video/Audio Calls: Needs valid Agora credentials
- Payment Gateways: Stripe, PayPal, etc. need API keys
- Email/SMTP: For sending verification emails
- Age Verification: Enable for production with Yoti/Didit</pre>
</div>
</div>
</div>

<!-- Deploy Script -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#deploy-script" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2"></i>
<strong>deploy.sh</strong> — Deployment Script
<span class="badge bg-secondary ms-2">Runs on every push</span>
</div>
<div class="collapse" id="deploy-script">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;">#!/bin/bash
# FFM Staging Deploy Script
# Runs on the persistent app container after each deploy

set -e
echo "=== FFM Deploy ==="

# 1. Create storage directories
mkdir -p storage/logs storage/framework/views storage/framework/cache storage/framework/sessions
chmod -R 777 storage bootstrap/cache

# 2. Create public/public symlink (for /public/uploads/ URLs)
cd public && ln -sf . public && cd ..

# 3. Uploads are on R2 (S3 driver)
echo "Uploads: using R2 storage (FILESYSTEM_DRIVER=s3)"

# 3b. Run pending migrations
php artisan migrate --force 2>&1 | tail -3

# 4. Fix missing database columns (idempotent)
# Adds: post_views, scheduled_date, likes_extras, crowdfund_goal, etc.
# Adds: captcha=off, disable_contact=0 to admin_settings

# 4b. Create missing tables and columns
# Creates: video_calls, audio_calls, vaults tables
# Adds: allow_vault, allow_crowdfund, video_call_status, audio_call_status, etc.

# 4c. Seed test accounts (idempotent)
# Creates: testfan, testcreator (if not exist)
# Sets: age_verification=1 for both

# 5. Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "=== Deploy complete ==="</pre>
</div>
</div>
</div>

<!-- STATUS.md -->
<div class="card mb-3">
<div class="card-header" data-bs-toggle="collapse" data-bs-target="#status-md" style="cursor: pointer;">
<i class="bi bi-chevron-right me-2"></i>
<strong>STATUS.md</strong> — Live System Status
<span class="badge bg-success ms-2">All Systems Operational</span>
</div>
<div class="collapse" id="status-md">
<div class="card-body">
<pre style="color: var(--ffm-text); background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 8px; font-size: 0.8em; line-height: 1.6; max-height: 500px; overflow-y: auto; white-space: pre-wrap; word-wrap: break-word;"># FFM Staging Status Report

## ALL SYSTEMS OPERATIONAL

### Infrastructure
- URL: https://staging.fansfollowme.com
- Platform: Laravel Cloud (Sponzy v7.9.2)
- PHP 8.5, Laravel 12.46, MySQL 8.4
- R2 Object Storage: 2131+ files, 6.08GB uploaded
- Deploy: Auto on push to main
- Zero 500 errors

### All Pages (19/19 = 200)
- /, /explore, /fans, /celebrities, /casting, /business
- /support, /faq, /privacy, /terms, /cookies, /contact
- /blog, /for-creators, /login, /signup, /password/reset
- /sitemap.xml, /robots.txt

### Profile Pages
- All profile pages working
- Avatar: 128px (CSS override)
- Cover: 80px height
- Tabs: Posts/About (tab switching working)

### Logged-In Experience
- Login: Admin / TestPass123!
- Dashboard, Messages, Notifications, Settings, Explore: All working

### Analytics & Tracking
- GA4: G-SZRL69LXXS
- Microsoft Clarity: xk78rrb386
- Usebasin: 954d0d6e30da
- Conversion Events: sign_up, login, generate_lead

### Design Matching
- Background: #0B0F1A
- Font: Inter, system-ui
- Branding: FansFollow.me
- Navbar: 72px

### Database
- 17,546 users, 239 posts
- All Sponzy v7.9.2 tables created
- 53+ missing admin_settings columns added</pre>
</div>
</div>
</div>

<script>
// Toggle chevron icons on collapse
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(el => {
    el.addEventListener('click', function() {
        const icon = this.querySelector('.bi-chevron-right, .bi-chevron-down');
        if (icon) {
            icon.classList.toggle('bi-chevron-right');
            icon.classList.toggle('bi-chevron-down');
        }
    });
});
</script>

<!-- FOOTER -->
<div class="text-center py-4 mt-4" style="border-top: 1px solid var(--ffm-border);">
<p class="text-muted mb-1"><strong>FansFollow.me</strong> — Creator Platform for Fitness & Sports</p>
<p class="text-muted small mb-0">This document is auto-generated from the staging environment. Last updated: August 30, 2026.</p>
<p class="text-muted small mb-0">Share this URL with your design/development team. Do not index this page.</p>
</div>

</div><!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
