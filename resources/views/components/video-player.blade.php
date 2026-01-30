<!-- Video Player Component -->
<style>
    .video-player-container {
        position: relative;
        width: 100%;
        background: #000;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 16 / 9;
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    .video-player-container video,
    .video-player-container iframe {
        width: 100%;
        height: 100%;
        display: block;
    }

    .video-player-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 20px 15px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-player-container:hover .video-player-controls {
        opacity: 1;
    }

    .video-control-btn {
        background: rgba(255,255,255,0.3);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .video-control-btn:hover {
        background: rgba(255,255,255,0.6);
        transform: scale(1.1);
    }

    .video-progress-bar {
        flex: 1;
        height: 4px;
        background: rgba(255,255,255,0.3);
        border-radius: 2px;
        cursor: pointer;
        position: relative;
    }

    .video-progress-bar:hover {
        height: 6px;
    }

    .video-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #a855f7);
        border-radius: 2px;
        transition: width 0.1s linear;
    }

    .video-time {
        color: white;
        font-size: 12px;
        min-width: 50px;
        text-align: right;
    }

    .video-error {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: #000;
        color: white;
        flex-direction: column;
        gap: 12px;
        min-height: 300px;
    }

    .video-error i {
        font-size: 48px;
        opacity: 0.5;
    }

    .video-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .spinner {
        border: 4px solid rgba(255,255,255,0.1);
        border-top: 4px solid #6366f1;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .video-tooltip {
        position: absolute;
        bottom: 50px;
        background: rgba(0,0,0,0.9);
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .video-control-btn:hover .video-tooltip {
        opacity: 1;
    }
</style>

<div class="video-player-container" id="videoPlayerContainer">
    @php
        $video_path = $videoPath ?? '';
        $isYouTube = str_contains($video_path, 'youtube.com') || str_contains($video_path, 'youtu.be');
        $isVimeo = str_contains($video_path, 'vimeo.com');
    @endphp

    @if(empty($video_path))
        <div class="video-error">
            <i class="fas fa-video"></i>
            <span>Chưa có video cho bài học này</span>
            <small style="opacity: 0.6;">Hãy quay lại sau hoặc liên hệ với giảng viên</small>
        </div>
    @elseif($isYouTube)
        @php
            $video_id = '';
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_path, $match)) {
                $video_id = $match[1];
            }
        @endphp
        
        @if($video_id)
            <iframe 
                id="youtubePlayer"
                src="https://www.youtube-nocookie.com/embed/{{ $video_id }}?enablejsapi=1&modestbranding=1&rel=0&showinfo=0"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
            </iframe>
        @else
            <div class="video-error">
                <i class="fas fa-exclamation-triangle"></i>
                <span>URL YouTube không hợp lệ</span>
            </div>
        @endif
    @elseif($isVimeo)
        @php
            $vimeo_id = '';
            if (preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/', $video_path, $matches)) {
                $vimeo_id = $matches[1];
            }
        @endphp
        
        @if($vimeo_id)
            <iframe 
                id="vimeoPlayer"
                src="https://player.vimeo.com/video/{{ $vimeo_id }}?h=9c3bb7b58a&badge=0&autopause=0&player_id=0&app_id=58479"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else
            <div class="video-error">
                <i class="fas fa-exclamation-triangle"></i>
                <span>URL Vimeo không hợp lệ</span>
            </div>
        @endif
    @else
        <video 
            id="lessonVideo"
            controls
            class="w-100 h-100"
            style="outline: none;"
            controlsList="nodownload"
            crossorigin="anonymous">
            <source 
                src="{{ str_starts_with($video_path, 'http') ? $video_path : asset('storage/' . $video_path) }}" 
                type="video/mp4">
            <div class="video-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>Trình duyệt của bạn không hỗ trợ video HTML5</span>
                <small style="opacity: 0.6;">Vui lòng cập nhật trình duyệt hoặc thử lại sau</small>
            </div>
        </video>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('lessonVideo');
    
    if (!video) return;

    // Save progress every 10 seconds
    let lastSavedProgress = 0;
    
    video.addEventListener('timeupdate', function() {
        // Thực hiện lưu progress
        if (Math.abs(video.currentTime - lastSavedProgress) > 10) {
            saveVideoProgress(video.currentTime);
            lastSavedProgress = video.currentTime;
        }
    });

    // Auto-complete on video end
    video.addEventListener('ended', function() {
        completeLesson();
    });

    function saveVideoProgress(time) {
        // Gửi request AJAX để lưu progress
        console.log('Saving progress:', time);
        // Implement save progress logic
    }

    function completeLesson() {
        console.log('Video completed!');
        // Implement complete lesson logic
    }
});

// Vimeo API
if (document.getElementById('vimeoPlayer')) {
    const script = document.createElement('script');
    script.src = 'https://player.vimeo.com/api/player.js';
    document.head.appendChild(script);

    window.addEventListener('vimeo_player_loaded', function() {
        const iframe = document.getElementById('vimeoPlayer');
        const player = new Vimeo.Player(iframe);

        let lastSaved = 0;
        player.on('timeupdate', function(data) {
            if (Math.abs(data.seconds - lastSaved) > 10) {
                console.log('Saving Vimeo progress:', data.seconds);
                lastSaved = data.seconds;
            }
        });

        player.on('ended', function() {
            console.log('Vimeo video completed');
        });
    });
}
</script>
