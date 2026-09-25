<?php

/**
 * Platform limits — defaults match live Sponzy (from Martin's admin screenshots).
 * Override via env later if needed.
 */

return [
    // Uploads — persistent disk (R2/S3). local/public are wiped on deploy.
    'upload_disk' => env('FFM_UPLOAD_DISK', 's3'),
    'upload_private_disk' => env('FFM_UPLOAD_DISK', 's3'),

    // Uploads
    'max_file_mb' => (int) env('FFM_MAX_FILE_MB', 30),

    // Text
    'post_max_chars' => (int) env('FFM_POST_MAX_CHARS', 10000),
    'story_max_chars' => (int) env('FFM_STORY_MAX_CHARS', 3000),
    'comment_max_chars' => (int) env('FFM_COMMENT_MAX_CHARS', 5000),

    // Feeds
    'posts_per_page' => (int) env('FFM_POSTS_PER_PAGE', 10),
    'comments_per_page' => (int) env('FFM_COMMENTS_PER_PAGE', 10),

    // Media counts
    'max_files_per_post' => (int) env('FFM_MAX_FILES_PER_POST', 20),
    'max_files_per_message' => (int) env('FFM_MAX_FILES_PER_MESSAGE', 20),
    'max_categories_per_user' => (int) env('FFM_MAX_CATEGORIES_PER_USER', 10),

    // Moderation
    'auto_approve_posts' => (bool) env('FFM_AUTO_APPROVE_POSTS', true),

    // Commerce (match Sponzy Stripe page)
    'platform_fee_percent' => (float) env('FFM_PLATFORM_FEE_PERCENT', 0.0),
    'platform_fee_cents' => (int) env('FFM_PLATFORM_FEE_CENTS', 0),
    'min_withdrawal_cents' => (int) env('FFM_MIN_WITHDRAWAL_CENTS', 1000),

    // Features
    'tips_enabled' => (bool) env('FFM_TIPS_ENABLED', true),
    'registration_open' => (bool) env('FFM_REGISTRATION_OPEN', true),
    'qr_enabled' => (bool) env('FFM_QR_ENABLED', true),
];
