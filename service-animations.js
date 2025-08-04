// Service Card Animations
document.addEventListener('DOMContentLoaded', function() {
    // Service Cards animation
    const serviceCards = document.querySelectorAll('.service-card');
    
    // Staggered entrance animation
    serviceCards.forEach((card, index) => {
        // Set initial state (hidden)
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        // Animate in with delay based on index
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 100)); // Stagger the animations
    });
    
    // Initialize floating decoration elements
    initFloatingDecorations();
});

// Function to start animations when hovering over a service card
function startAnimation(card) {
    // Get the floating elements within this card
    const floatingElements = card.querySelectorAll('.floating-element');
    
    // Animate each floating element with a different animation
    floatingElements[0].style.animation = 'float-one 5s ease-in-out infinite';
    floatingElements[1].style.animation = 'float-two 7s ease-in-out infinite';
    floatingElements[2].style.animation = 'float-three 6s ease-in-out infinite';
    
    // Apply 3D effect to the card
    card.style.transform = 'translateY(-10px)';
    card.style.boxShadow = 'var(--shadow-lg)';
    
    // Add highlight to service icon
    const icon = card.querySelector('.service-icon');
    if (icon) {
        icon.style.transform = 'rotateY(180deg)';
        icon.style.boxShadow = '0 15px 30px rgba(0, 123, 255, 0.3)';
    }
    
    // Add glow effect to button
    const button = card.querySelector('.service-button');
    if (button) {
        button.style.boxShadow = '0 5px 15px rgba(0, 123, 255, 0.3)';
    }
}

// Function to stop animations when mouse leaves the card
function stopAnimation(card) {
    // Get the floating elements within this card
    const floatingElements = card.querySelectorAll('.floating-element');
    
    // Stop animations
    floatingElements.forEach(element => {
        element.style.animation = 'none';
    });
    
    // Remove 3D effect from card
    card.style.transform = 'translateY(0)';
    card.style.boxShadow = 'var(--shadow-sm)';
    
    // Reset icon
    const icon = card.querySelector('.service-icon');
    if (icon) {
        icon.style.transform = 'rotateY(0)';
        icon.style.boxShadow = 'none';
    }
    
    // Reset button
    const button = card.querySelector('.service-button');
    if (button) {
        button.style.boxShadow = 'none';
    }
}

// Initialize floating decorations
function initFloatingDecorations() {
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        // Set random positions for floating elements in each card
        const floatingElements = card.querySelectorAll('.floating-element');
        
        // Randomize position slightly for each card
        if (floatingElements.length >= 3) {
            // Customize positions for visual interest
            floatingElements[0].style.right = `-${Math.random() * 20 + 30}px`;
            floatingElements[0].style.top = `-${Math.random() * 15 + 20}px`;
            
            floatingElements[1].style.right = `${Math.random() * 30 + 20}px`;
            floatingElements[1].style.bottom = `${Math.random() * 20 + 30}px`;
            
            floatingElements[2].style.left = `${Math.random() * 20 + 30}px`;
            floatingElements[2].style.bottom = `-${Math.random() * 15 + 20}px`;
        }
    });
}
