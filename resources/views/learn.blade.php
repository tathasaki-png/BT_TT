@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #0b0f1a;
        }

        .learning-header {
            background: rgba(11, 15, 26, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            margin: -40px -40px 40px -40px;
        }

        .video-container {
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6);
            margin-bottom: 40px;
        }

        .content-sidebar {
            background: var(--sidebar-color);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            height: calc(100vh - 160px);
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
        }

        .lesson-list-item {
            padding: 20px 24px;
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .lesson-list-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .lesson-list-item.active {
            background: rgba(99, 102, 241, 0.1);
            border-left: 4px solid var(--primary-color);
        }

        .quiz-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 40px;
        }

        .progress-pill {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--primary-glow);
        }
    </style>

    <div class="learning-header">
        <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
            <a href="{{ route('courses.show', $course->slug) }}"
                class="text-white text-decoration-none small d-flex align-items-center gap-2">
                <div class="glass"
                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <i class="fas fa-arrow-left" style="font-size: 12px;"></i>
                </div>
                Quay lại
            </a>
            <h5 class="mb-0 fw-bold d-none d-md-block" style="font-family: 'Outfit'; color: white;">{{ $course->title }}
            </h5>
            <div class="progress-pill">
                <i class="fas fa-chart-line me-2"></i> Tiến độ: 45%
            </div>
        </div>
    </div>

    <div class="container-fluid px-lg-5">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="video-container">
                    @if($lesson)
                        @include('components.video-player', ['videoPath' => $lesson->video_path ?? ''])
                    @else
                        <div style="aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center;">
                            <div class="text-center">
                                <i class="fas fa-video-slash mb-3 opacity-30" style="font-size: 64px;"></i>
                                <h4 class="text-muted">Không tìm thấy bài học</h4>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <span class="text-primary fw-bold small text-uppercase letter-spacing-1 mb-2 d-block">Đang học bài
                            {{ $lesson ? $lesson->position : '-' }}</span>
                        <h2 class="fw-bold m-0 text-white" style="font-family: 'Outfit';">
                            {{ $lesson ? $lesson->title : 'Chọn một bài học' }}
                        </h2>
                    </div>

                    @if($lesson)
                        @if(!isset($completed[$lesson->id]) || !$completed[$lesson->id])
                            <button id="mark-current" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg"
                                data-lesson-id="{{ $lesson->id }}">
                                <i class="fas fa-check-circle me-2"></i> HOÀN THÀNH BÀI HỌC
                            </button>
                        @else
                            <button class="btn btn-outline px-5 py-3 rounded-pill fw-bold" disabled
                                style="opacity: 1; border-color: #10b981; color: #10b981;">
                                <i class="fas fa-check-double me-2"></i> ĐÃ HOÀN THÀNH
                            </button>
                        @endif
                    @endif
                </div>

                <div class="glass p-4 mb-5">
                    <h4 class="section-headline">Mô tả bài học</h4>
                    <div class="text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($lesson->content ?? 'Kênh học tập Aura mang đến cho bạn trải nghiệm học tập tốt nhất.')) !!}
                    </div>
                </div>

                @if($lesson && $lesson->questions->count() > 0)
                    <div class="quiz-card" id="quiz-section">
                        <h4 class="section-headline mb-4"><i class="fas fa-tasks text-primary me-2"></i>Kiểm tra kiến thức</h4>

                        @if($quizResult)
                            <div class="glass p-4 mb-4"
                                style="background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="glass"
                                        style="width: 48px; height: 48px; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; border-radius: 12px;">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div>
                                        <h6 class="m-0 text-white">Kết quả gần nhất:
                                            {{ $quizResult->score }}/{{ $quizResult->total_questions }} câu đúng
                                        </h6>
                                        <small class="text-muted">Chúc mừng bạn đã hoàn thành bài kiểm tra!</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('learn.quiz.submit', ['course' => $course->id, 'lesson' => $lesson->id]) }}"
                            method="POST">
                            @csrf
                            @foreach($lesson->questions as $i => $question)
                                <div class="glass p-4 mb-4">
                                    <p class="fw-bold mb-3 text-white">Câu {{ $i + 1 }}: {{ $question->question_text }}</p>
                                    @foreach($question->options as $option)
                                        <div class="form-check custom-radio mb-3 p-3 glass-hover"
                                            style="border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer;">
                                            <input class="form-check-input ms-0 me-3" type="radio" name="answers[{{ $question->id }}]"
                                                value="{{ $option->id }}" id="option{{ $option->id }}" required>
                                            <label class="form-check-label text-muted w-100 cursor-pointer"
                                                for="option{{ $option->id }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill mt-3 shadow-lg">
                                GỬI BÀI KIỂM TRA <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="content-sidebar">
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0 text-white">Nội dung khóa học</h5>
                        <span class="text-muted small">{{ $lessons->count() }} bài</span>
                    </div>
                    <div class="flex-grow-1 overflow-auto">
                        @foreach($lessons as $l)
                            <a href="{{ route('learn.show', ['course' => $course->slug, 'lesson' => $l->id]) }}"
                                class="lesson-list-item {{ isset($lesson) && $lesson->id == $l->id ? 'active' : '' }}"
                                id="lesson-item-{{ $l->id }}">
                                <div class="glass"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: {{ isset($completed[$l->id]) && $completed[$l->id] ? 'rgba(16, 185, 129, 0.1)' : 'rgba(255,255,255,0.05)' }};">
                                    @if(isset($completed[$l->id]) && $completed[$l->id])
                                        <i class="fas fa-check text-success" style="font-size: 14px;"></i>
                                    @else
                                        <i class="fas fa-play text-muted" style="font-size: 12px;"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-muted mb-1"
                                        style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                                        Bài {{ $l->position }}</div>
                                    <div class="text-white small fw-bold">{{ $l->title }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://www.youtube.com/iframe_api"></script>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const courseId = {{ $course->id }};
            const lessonId = {{ $lesson->id ?? 0 }};
            const savedTime = {{ $currentTime ?? 0 }};

            let player; // YouTube player instance
            let vimeoPlayer; // Vimeo player instance

            // YouTube API Callback
            function onYouTubeIframeAPIReady() {
                const videoId = '{{ $video_id ?? "" }}';
                if (!videoId) return;

                player = new YT.Player('player', {
                    height: '100%',
                    width: '100%',
                    videoId: videoId,
                    playerVars: {
                        'autoplay': 1,
                        'controls': 1,
                        'rel': 0,
                        'start': savedTime
                    },
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady(event) {
                // Optional: Player is ready
            }

            let progressInterval;
            function onPlayerStateChange(event) {
                if (event.data == YT.PlayerState.PLAYING) {
                    progressInterval = setInterval(saveVideoProgress, 5000); // Save every 5 seconds
                } else {
                    clearInterval(progressInterval);
                    saveVideoProgress(); // Save when paused or stopped
                }
            }

            // Vimeo Integration
            const vimeoContainer = document.getElementById('vimeo-player');
            if (vimeoContainer) {
                const vimeoId = vimeoContainer.dataset.vimeoId;
                vimeoPlayer = new Vimeo.Player(vimeoContainer, {
                    id: vimeoId,
                    width: 640,
                    autoplay: true
                });

                // Set saved time
                if (savedTime > 0) {
                    vimeoPlayer.setCurrentTime(savedTime).catch(function (error) {
                        console.error('Vimeo setCurrentTime error:', error);
                    });
                }

                vimeoPlayer.on('play', function () {
                    progressInterval = setInterval(saveVimeoProgress, 5000);
                });

                vimeoPlayer.on('pause', function () {
                    clearInterval(progressInterval);
                    saveVimeoProgress();
                });

                vimeoPlayer.on('ended', function () {
                    clearInterval(progressInterval);
                    saveVimeoProgress();
                });
            }

            async function saveVimeoProgress() {
                if (!vimeoPlayer) return;
                const time = await vimeoPlayer.getCurrentTime();
                saveToServer(Math.floor(time));
            }

            async function saveVideoProgress() {
                if (!player || typeof player.getCurrentTime !== 'function') return;
                const currentTime = Math.floor(player.getCurrentTime());
                if (currentTime <= 0) return;
                saveToServer(currentTime);
            }

            async function saveToServer(time) {
                if (time <= 0) return;
                try {
                    await fetch(`/learn/${courseId}/lessons/${lessonId}/progress`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ time: time })
                    });
                } catch (err) {
                    console.error('Error saving progress:', err);
                }
            }

            // Support for Local Video if used
            const localVideo = document.getElementById('lesson-video');
            if (localVideo) {
                localVideo.currentTime = savedTime;
                localVideo.ontimeupdate = function () {
                    // throttle saving
                    if (Math.floor(localVideo.currentTime) % 10 === 0) {
                        saveToServer(Math.floor(localVideo.currentTime));
                    }
                };
            }

            async function markCompleted(courseId, lessonId, button) {
                try {
                    const res = await fetch(`/learn/${courseId}/lessons/${lessonId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    if (!res.ok) throw new Error('Network response was not ok');
                    const json = await res.json();

                    // update UI
                    const item = document.getElementById('lesson-item-' + lessonId);
                    if (item) {
                        const iconDiv = item.querySelector('.me-3');
                        if (iconDiv) {
                            iconDiv.innerHTML = '<i class="fas fa-check-circle text-success fs-5"></i>';
                        }
                    }

                    if (button && button.tagName === 'BUTTON') {
                        button.className = 'btn btn-success px-4 rounded-pill fw-bold';
                        button.innerHTML = '<i class="fas fa-check-double me-2"></i> Đã hoàn thành';
                        button.disabled = true;
                    }

                } catch (err) {
                    console.error(err);
                    alert('Could not mark lesson completed.');
                }
            }

            document.addEventListener('click', function (e) {
                if (e.target.matches('.mark-complete')) {
                    const lessonId = e.target.dataset.lessonId;
                    const courseId = {{ $course->id }};
                    markCompleted(courseId, lessonId, e.target);
                }

                if (e.target && e.target.id === 'mark-current') {
                    const lessonId = e.target.dataset.lessonId;
                    const courseId = {{ $course->id }};
                    markCompleted(courseId, lessonId, e.target);
                }
            });
        </script>
    @endpush

@endsection