document.addEventListener('DOMContentLoaded', () => {
    
    // --- Mobile Navigation ---
    const mobileToggle = document.getElementById('mobile-toggle');
    const navLinks = document.getElementById('nav-links');
    
    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', () => {
            navLinks.classList.toggle('show');
            const icon = mobileToggle.querySelector('i');
            if (navLinks.classList.contains('show')) {
                icon.classList.replace('ph-list', 'ph-x');
            } else {
                icon.classList.replace('ph-x', 'ph-list');
            }
        });
    }

    // --- Audio Player Logic ---
    const audio = document.getElementById('radio-audio');
    const btnPlayPause = document.getElementById('btn-play-pause');
    const iconPlay = document.getElementById('icon-play');
    const iconPause = document.getElementById('icon-pause');
    const volumeSlider = document.getElementById('volume-slider');
    const volumeIcon = document.getElementById('volume-icon');
    
    const visualizer = document.getElementById('visualizer');
    const radioContainer = document.querySelector('.radio-container');
    const statusBadge = document.getElementById('stream-status');
    const statusText = statusBadge ? (statusBadge.querySelector('.text') || statusBadge.querySelector('span:last-child')) : null;

    if (audio && btnPlayPause) {
        
        // Initialize volume
        const volumePercent = document.getElementById('volume-percent');
        audio.volume = volumeSlider.value;
        if (volumePercent) {
            volumePercent.textContent = Math.round(volumeSlider.value * 100) + '%';
        }

        // Play / Pause Toggle
        btnPlayPause.addEventListener('click', () => {
            if (audio.paused) {
                playAudio();
            } else {
                pauseAudio();
            }
        });

        // Volume Control
        volumeSlider.addEventListener('input', (e) => {
            const vol = e.target.value;
            audio.volume = vol;
            if (volumePercent) {
                volumePercent.textContent = Math.round(vol * 100) + '%';
            }
            updateVolumeIcon(vol);
        });

        // Audio Events
        audio.addEventListener('playing', () => {
            setPlayingState(true);
            updateStatus('Live', 'live');
        });

        audio.addEventListener('pause', () => {
            setPlayingState(false);
            updateStatus('Paused', '');
        });

        audio.addEventListener('waiting', () => {
            updateStatus('Buffering...', 'loading');
        });

        audio.addEventListener('error', (e) => {
            console.error("Error loading stream", e);
            updateStatus('Stream Error', '');
            setPlayingState(false);
        });
    }

    // Helper Functions
    function playAudio() {
        // Create an empty promise to catch play errors (like browser autoplay policies)
        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.catch(error => {
                console.error("Playback failed:", error);
                updateStatus('Click to Play', '');
                setPlayingState(false);
            });
        }
        updateStatus('Connecting...', 'loading');
    }

    function pauseAudio() {
        audio.pause();
        // Since it's a live stream, sometimes setting src to empty helps fully stop buffering,
        // but for a simple toggle, just pause is fine.
    }

    function setPlayingState(isPlaying) {
        if (isPlaying) {
            iconPlay.classList.add('hidden');
            iconPause.classList.remove('hidden');
            radioContainer.classList.add('playing');
        } else {
            iconPlay.classList.remove('hidden');
            iconPause.classList.add('hidden');
            radioContainer.classList.remove('playing');
        }
    }

    function updateStatus(text, className) {
        if (!statusBadge || !statusText) return;
        
        statusText.textContent = text;
        
        // Reset classes
        statusBadge.classList.remove('live', 'loading');
        if (className) {
            statusBadge.classList.add(className);
        }
    }

    function updateVolumeIcon(vol) {
        if (!volumeIcon) return;
        
        volumeIcon.className = ''; // clear
        if (vol == 0) {
            volumeIcon.className = 'ph ph-speaker-none';
        } else if (vol < 0.5) {
            volumeIcon.className = 'ph ph-speaker-low';
        } else {
            volumeIcon.className = 'ph ph-speaker-high';
        }
    }
});
