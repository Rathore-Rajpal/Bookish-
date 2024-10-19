// Get URL parameters
const urlParams = new URLSearchParams(window.location.search);
const bookTitle = urlParams.get('title');
const audioSrc = urlParams.get('audio');
const bookImage = urlParams.get('image');

// Set the page content
document.getElementById('book-title').textContent = bookTitle;
document.getElementById('audio-source').src = audioSrc;
document.getElementById('book-image').src = bookImage;
document.getElementById('audio').load();

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
