// Function to load the selected audiobook
function loadAudio(src, title) {
    const audio = document.getElementById('audio');
    const audioSource = document.getElementById('audio-source');
    const bookTitle = document.getElementById('book-title');
    
    audioSource.src = src;
    bookTitle.textContent = title;
    audio.load();  // Load the new audio file
}

// Play the audiobook
function playAudio() {
    const audio = document.getElementById('audio');
    audio.play();
}

// Pause the audiobook
function pauseAudio() {
    const audio = document.getElementById('audio');
    audio.pause();
}

// Rewind 10 seconds
function rewindAudio() {
    const audio = document.getElementById('audio');
    audio.currentTime -= 10;  // Rewind 10 seconds
}

// Forward 10 seconds
function forwardAudio() {
    const audio = document.getElementById('audio');
    audio.currentTime += 10;  // Forward 10 seconds
}

// Change playback speed
function changeSpeed() {
    const audio = document.getElementById('audio');
    const speed = document.getElementById('speed').value;
    audio.playbackRate = speed;  // Change playback speed
}
