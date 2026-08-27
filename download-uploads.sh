#!/bin/bash
# Download uploads from TMD server during deployment
# Only runs if uploads are missing

UPLOADS_DIR="public/uploads"

if [ ! -d "$UPLOADS_DIR/avatar" ] || [ $(ls "$UPLOADS_DIR/avatar/" 2>/dev/null | wc -l) -lt 100 ]; then
    echo "Downloading uploads from TMD..."
    
    # Essential uploads (avatars, covers, images, shop, stories) - 221MB
    curl -sL https://fansfollow.me/essential-uploads.tar | tar x -C public/ 2>/dev/null
    echo "Essentials downloaded"
    
    # More uploads (introvideo, verification, messages) - 765MB
    curl -sL https://fansfollow.me/more-uploads.tar | tar x -C public/ 2>/dev/null
    echo "More uploads downloaded"
    
    # Videos - 5.5GB
    curl -sL https://fansfollow.me/videos.tar | tar x -C public/ 2>/dev/null
    echo "Videos downloaded"
    
    echo "Uploads download complete"
else
    echo "Uploads already exist ($(ls $UPLOADS_DIR/avatar/ | wc -l) avatars)"
fi
