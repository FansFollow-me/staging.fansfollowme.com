<footer class="public-shell-footer">
    <div class="container">
        <div class="footer-topline"></div>
        <div class="footer-grid">
            <div class="footer-links">
                <h3>For Creators</h3>
                <a href="{{ route('page.revenue-streams') }}">Revenue Streams</a>
                <a href="{{ route('register') }}?role=creator">Getting Started</a>
                <a href="{{ route('page.for-creators') }}">Personal Video Messages</a>
                @if (auth()->check() && (auth()->user()->isCreator() || auth()->user()->isAdmin()))
                <a href="{{ route('join.my-qr') }}">In-Person QR Sign-Ups</a>
                @else
                <a href="{{ route('register') }}?role=creator">In-Person QR Sign-Ups</a>
                @endif
            </div>
            <div class="footer-links">
                <h3>Revenue Streams</h3>
                <a href="{{ route('page.for-creators') }}">Content Monetization</a>
                <a href="{{ route('page.for-creators') }}">Paid Phone Calls</a>
                <a href="{{ route('page.for-creators') }}">Text Coaching</a>
                <a href="{{ route('page.for-creators') }}">Video Consultations</a>
            </div>
            <div class="footer-links">
                <h3>Support</h3>
                <a href="{{ route('page.support') }}">Help Center</a>
                <a href="{{ route('page.contact') }}">Contact Us</a>
                <a href="{{ route('page.faq') }}">FAQ</a>
            </div>
            <div class="footer-links">
                <h3>Platform</h3>
                <a href="{{ route('page.explore') }}">Explore</a>
                <a href="{{ route('page.live-streams') }}">Live Streams</a>
                <a href="{{ route('page.business') }}">Business</a>
            </div>
        </div>
        <div class="footer-bottomline"></div>
        <div class="footer-bottom">
            <div class="footer-legal">
                <span>© {{ date('Y') }} FansFollow.me. All rights reserved.</span>
                <span><span class="btc-mark">₿</span> <strong>BTC/ETH/USDT/SOL Accepted</strong></span>
            </div>
            <div class="footer-policies">
                <a href="{{ route('page.privacy') }}">Privacy Policy</a>
                <span>•</span>
                <a href="{{ route('page.terms') }}">Terms of Service</a>
                <span>•</span>
                <a href="{{ route('page.cookies') }}">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
