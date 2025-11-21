// Welcome Page JavaScript - Light Theme Version
// All JavaScript functionality for the welcome page with light theme styling

document.addEventListener('DOMContentLoaded', function() {
    // Environment info (will be set from PHP)
    const isProduction = window.isProduction || false;
    const currentDomain = window.currentDomain || 'localhost';

    // Force apply mobile fixes and light theme styles
    const style = document.createElement('style');
    style.id = 'light-theme-fix-css';
    style.textContent = `
        /* Light Theme Universal Fixes */
        * {
            box-sizing: border-box !important;
        }
        
        body {
            background-color: #f8f9fa !important;
            color: #1e293b !important;
        }
        
        @media (max-width: 768px) {
            /* Container padding consistency */
            .container, nav .container, section .container {
                padding-left: 8px !important;
                padding-right: 8px !important;
                max-width: 100% !important;
            }
            
            /* Filter button containers */
            .news-filter-container, .gallery-filter-container {
                display: flex !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                gap: 0.5rem !important;
                padding: 0 0.5rem !important;
                justify-content: flex-start !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: none !important;
            }
            
            .news-filter-container::-webkit-scrollbar,
            .gallery-filter-container::-webkit-scrollbar {
                display: none !important;
            }
            
            /* Filter buttons - Light Theme */
            .news-filter-btn-modern, .gallery-filter-btn-modern {
                flex-shrink: 0 !important;
                white-space: nowrap !important;
                font-size: 0.75rem !important;
                font-weight: 600 !important;
                padding: 8px 16px !important;
                border-radius: 20px !important;
                border: 2px solid #e2e8f0 !important;
                min-width: fit-content !important;
                margin: 0 !important;
                background: white !important;
                color: #1e293b !important;
                transition: all 0.3s ease !important;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
            }
            
            .news-filter-btn-modern:hover, .gallery-filter-btn-modern:hover {
                border-color: #06b6d4 !important;
                color: #06b6d4 !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            }
            
            .news-filter-btn-modern.active {
                background: linear-gradient(135deg, #a855f7, #ec4899) !important;
                color: white !important;
                border-color: transparent !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3) !important;
            }
            
            .gallery-filter-btn-modern.active {
                background: linear-gradient(135deg, #06b6d4, #3b82f6) !important;
                color: white !important;
                border-color: transparent !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3) !important;
            }
            
            /* Mobile navigation */
            nav {
                padding-left: 8px !important;
                padding-right: 8px !important;
                background: rgba(255, 255, 255, 0.98) !important;
                backdrop-filter: blur(12px) !important;
            }
            
            /* Mobile menu */
            #mobile-menu {
                background: rgba(255, 255, 255, 0.98) !important;
                backdrop-filter: blur(12px) !important;
            }
            
            /* Section padding consistency */
            section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
        
        /* Desktop filter buttons */
        @media (min-width: 769px) {
            .news-filter-btn-modern, .gallery-filter-btn-modern {
                padding: 0.5rem 1.5rem !important;
                border: 2px solid #e2e8f0 !important;
                background: white !important;
                color: #1e293b !important;
                transition: all 0.3s ease !important;
            }
            
            .news-filter-btn-modern:hover, .gallery-filter-btn-modern:hover {
                border-color: #06b6d4 !important;
                color: #06b6d4 !important;
                transform: translateY(-2px) !important;
            }
            
            .news-filter-btn-modern.active {
                background: linear-gradient(135deg, #a855f7, #ec4899) !important;
                color: white !important;
                border-color: transparent !important;
            }
            
            .gallery-filter-btn-modern.active {
                background: linear-gradient(135deg, #06b6d4, #3b82f6) !important;
                color: white !important;
                border-color: transparent !important;
            }
        }
        
        /* Desktop and mobile universal fixes */
        body, html {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Glass effect for light theme */
        .glass {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(59, 130, 246, 0.1) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07) !important;
        }
        
        .glass:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Card hover effects */
        .card-3d:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
        }
    `;
    document.head.appendChild(style);
});

// Mobile menu state
window.mobileMenuOpen = false;

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const btn = document.getElementById('mobile-menu-btn');
    
    if (!menu || !btn) {
        console.error('Menu elements not found');
        return;
    }
    
    if (window.mobileMenuOpen) {
        // Close menu
        menu.style.transform = 'translateY(-100%)';
        menu.style.opacity = '0';
        menu.style.visibility = 'hidden';
        btn.innerHTML = '<i class="fas fa-bars text-lg"></i>';
        btn.className = 'relative z-50 bg-cyan-50 border-2 border-cyan-300 rounded-lg p-2 cursor-pointer w-10 h-10 flex items-center justify-center text-cyan-600 transition-all duration-300 hover:bg-cyan-100';
        window.mobileMenuOpen = false;
    } else {
        // Open menu
        menu.style.transform = 'translateY(0)';
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
        btn.innerHTML = '<i class="fas fa-times text-lg"></i>';
        btn.className = 'relative z-50 bg-red-50 border-2 border-red-300 rounded-lg p-2 cursor-pointer w-10 h-10 flex items-center justify-center text-red-600 transition-all duration-300 hover:bg-red-100';
        window.mobileMenuOpen = true;
    }
}

// Initialize mobile menu when DOM loads
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    
    // Ensure button is clickable with multiple event types
    if (btn) {
        // Remove any existing listeners and add fresh ones
        btn.onclick = null;
        
        // Add multiple event listeners for better compatibility
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });
        
        btn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });
    }
    
    // Add click listeners to menu items to close menu
    const menuLinks = document.querySelectorAll('#mobile-menu a');
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.mobileMenuOpen) {
                setTimeout(function() {
                    toggleMobileMenu();
                }, 100);
            }
        });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.mobileMenuOpen && menu && btn) {
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                toggleMobileMenu();
            }
        }
    });
    
    // Force Quick Info 2x2 Grid Layout on Mobile
    function forceQuickInfoGrid() {
        const quickInfoGrid = document.querySelector('.quick-info .grid');
        if (quickInfoGrid && window.innerWidth < 768) {
            quickInfoGrid.style.display = 'grid';
            quickInfoGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
            quickInfoGrid.style.gridTemplateRows = 'repeat(2, 1fr)';
            quickInfoGrid.style.gap = '1rem';
            quickInfoGrid.style.width = '100%';
            
            // Force each card styling
            const cards = quickInfoGrid.querySelectorAll('.info-card-modern');
            cards.forEach(function(card) {
                const glassCard = card.querySelector('.glass');
                if (glassCard) {
                    glassCard.style.padding = '1rem';
                    glassCard.style.height = '100%';
                    glassCard.style.minHeight = '180px';
                    glassCard.style.display = 'flex';
                    glassCard.style.flexDirection = 'column';
                    glassCard.style.justifyContent = 'center';
                    glassCard.style.alignItems = 'center';
                    glassCard.style.textAlign = 'center';
                }
                
                // Adjust text sizes
                const titles = card.querySelectorAll('h4');
                titles.forEach(function(title) {
                    title.style.fontSize = '0.875rem';
                    title.style.marginBottom = '0.5rem';
                });
                
                const smallTexts = card.querySelectorAll('.text-xs, .text-sm');
                smallTexts.forEach(function(text) {
                    text.style.fontSize = '0.75rem';
                });
            });
        } else if (quickInfoGrid && window.innerWidth >= 1024) {
            // Desktop: 4 columns
            quickInfoGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
            quickInfoGrid.style.gap = '1.5rem';
        }
    }
    
    // Apply force grid immediately and on resize
    forceQuickInfoGrid();
    window.addEventListener('resize', forceQuickInfoGrid);
    window.addEventListener('load', forceQuickInfoGrid);
});

// WhatsApp chat functionality
document.addEventListener('DOMContentLoaded', function() {
    const startChatBtn = document.getElementById('start-chat');
    if (startChatBtn) {
        startChatBtn.addEventListener('click', function() {
            const whatsappNumber = window.whatsappNumber || '08123456789';
            const schoolName = window.schoolName || 'sekolah';
            const message = encodeURIComponent(`Halo, saya ingin bertanya tentang ${schoolName}`);
            window.open(`https://wa.me/${whatsappNumber}?text=${message}`, '_blank');
        });
    }
});

// Gallery Filter Function - Light Theme
document.addEventListener('DOMContentLoaded', function() {
    const galleryFilterButtons = document.querySelectorAll('#gallery-filters .gallery-filter-btn-modern');
    const galleryItems = document.querySelectorAll('.gallery-item-modern');

    galleryFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            galleryFilterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = 'white';
                btn.style.color = '#1e293b';
                btn.style.borderColor = '#e2e8f0';
            });
            
            this.classList.add('active');
            this.style.background = 'linear-gradient(135deg, #06b6d4, #3b82f6)';
            this.style.color = 'white';
            this.style.borderColor = 'transparent';
            
            // Filter items with animation
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    item.style.animation = 'fadeIn 0.3s ease-in';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// News Filter Function - Light Theme
document.addEventListener('DOMContentLoaded', function() {
    const newsFilterButtons = document.querySelectorAll('#news-filters .news-filter-btn-modern');
    const newsItems = document.querySelectorAll('.news-card-modern');

    newsFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            newsFilterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = 'white';
                btn.style.color = '#1e293b';
                btn.style.borderColor = '#e2e8f0';
            });
            
            this.classList.add('active');
            this.style.background = 'linear-gradient(135deg, #a855f7, #ec4899)';
            this.style.color = 'white';
            this.style.borderColor = 'transparent';
            
            // Filter items with animation
            newsItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    item.style.animation = 'fadeIn 0.3s ease-in';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// Smooth Scrolling
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Account for fixed nav
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (window.mobileMenuOpen) {
                        setTimeout(toggleMobileMenu, 300);
                    }
                }
            }
        });
    });
});

// Mouse move effect for 3D cards
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.card-3d').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
            card.style.transition = 'box-shadow 0.3s ease';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0)';
            card.style.transition = 'all 0.3s ease';
        });
    });
});

// Initialize AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
    }
});

// Hero Section Height Fix for Mobile
function setHeroHeight() {
    const heroSection = document.getElementById('home');
    if (heroSection && window.innerWidth < 768) {
        const vh = window.innerHeight;
        heroSection.style.minHeight = vh + 'px';
        heroSection.style.height = 'auto';
        heroSection.style.display = 'flex';
        heroSection.style.alignItems = 'center';
        heroSection.style.justifyContent = 'center';
    } else if (heroSection) {
        heroSection.style.minHeight = '100vh';
        heroSection.style.height = 'auto';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setHeroHeight();
    window.addEventListener('resize', setHeroHeight);
    window.addEventListener('orientationchange', setHeroHeight);
    setTimeout(setHeroHeight, 300);
});

// Hubungi Kami Grid Setup
function setupHubungiKamiGrid() {
    const hubungiKamiGrid = document.getElementById('hubungi-kami-grid');
    
    if (hubungiKamiGrid) {
        if (window.innerWidth < 1024) {
            // Mobile & Tablet: 2x2 grid
            hubungiKamiGrid.style.display = 'grid';
            hubungiKamiGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
            hubungiKamiGrid.style.gridTemplateRows = 'repeat(2, auto)';
            hubungiKamiGrid.style.gap = '1rem';
            
            const cards = hubungiKamiGrid.querySelectorAll('.info-card-modern');
            cards.forEach(function(card) {
                const glass = card.querySelector('.glass');
                if (glass) {
                    glass.style.padding = '1rem';
                    glass.style.minHeight = '180px';
                    glass.style.display = 'flex';
                    glass.style.flexDirection = 'column';
                    glass.style.justifyContent = 'center';
                }
            });
        } else {
            // Desktop: 4 columns
            hubungiKamiGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
            hubungiKamiGrid.style.gap = '1.5rem';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setupHubungiKamiGrid();
    window.addEventListener('resize', setupHubungiKamiGrid);
    window.addEventListener('load', setupHubungiKamiGrid);
    setTimeout(setupHubungiKamiGrid, 500);
});

// Add fade-in animation
const styleAnimation = document.createElement('style');
styleAnimation.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(styleAnimation);

// Navbar scroll effect
let lastScroll = 0;
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('nav');
    const currentScroll = window.pageYOffset;
    
    if (navbar) {
        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
            navbar.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    }
    
    lastScroll = currentScroll;
});

// Particle Network Animation for Hero Section
class ParticleNetwork {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
        // Adjust particle count based on screen size
        this.particleCount = window.innerWidth < 768 ? 50 : 100;
        this.maxDistance = window.innerWidth < 768 ? 120 : 150;
        this.mouse = { x: null, y: null, radius: 150 };
        
        this.init();
        this.animate();
        this.setupEventListeners();
    }
    
    init() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
        
        // Create particles
        for (let i = 0; i < this.particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.8,
                vy: (Math.random() - 0.5) * 0.8,
                radius: Math.random() * 3 + 1.5,
                color: this.getRandomColor()
            });
        }
    }
    
    getRandomColor() {
        const colors = [
            'rgba(6, 182, 212, 0.9)',    // cyan
            'rgba(236, 72, 153, 0.9)',   // pink
            'rgba(168, 85, 247, 0.9)',   // purple
            'rgba(59, 130, 246, 0.9)',   // blue
            'rgba(14, 165, 233, 0.85)',  // sky blue
            'rgba(219, 39, 119, 0.85)',  // rose
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        // Update and draw particles
        this.particles.forEach((particle, i) => {
            // Move particle
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            // Bounce off edges
            if (particle.x < 0 || particle.x > this.canvas.width) particle.vx *= -1;
            if (particle.y < 0 || particle.y > this.canvas.height) particle.vy *= -1;
            
            // Mouse interaction
            if (this.mouse.x !== null && this.mouse.y !== null) {
                const dx = this.mouse.x - particle.x;
                const dy = this.mouse.y - particle.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < this.mouse.radius) {
                    const angle = Math.atan2(dy, dx);
                    const force = (this.mouse.radius - distance) / this.mouse.radius;
                    particle.vx -= Math.cos(angle) * force * 0.2;
                    particle.vy -= Math.sin(angle) * force * 0.2;
                }
            }
            
            // Draw particle with glow effect
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color;
            this.ctx.shadowBlur = 10;
            this.ctx.shadowColor = particle.color;
            this.ctx.fill();
            this.ctx.shadowBlur = 0;
            
            // Draw connections
            for (let j = i + 1; j < this.particles.length; j++) {
                const other = this.particles[j];
                const dx = particle.x - other.x;
                const dy = particle.y - other.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < this.maxDistance) {
                    const opacity = (1 - distance / this.maxDistance) * 0.4;
                    this.ctx.beginPath();
                    
                    // Create gradient for line
                    const gradient = this.ctx.createLinearGradient(
                        particle.x, particle.y, 
                        other.x, other.y
                    );
                    gradient.addColorStop(0, `rgba(6, 182, 212, ${opacity})`);
                    gradient.addColorStop(1, `rgba(168, 85, 247, ${opacity * 0.7})`);
                    
                    this.ctx.strokeStyle = gradient;
                    this.ctx.lineWidth = 1.5;
                    this.ctx.moveTo(particle.x, particle.y);
                    this.ctx.lineTo(other.x, other.y);
                    this.ctx.stroke();
                }
            }
        });
        
        requestAnimationFrame(() => this.animate());
    }
    
    setupEventListeners() {
        // Mouse move
        this.canvas.addEventListener('mousemove', (e) => {
            const rect = this.canvas.getBoundingClientRect();
            this.mouse.x = e.clientX - rect.left;
            this.mouse.y = e.clientY - rect.top;
        });
        
        // Mouse leave
        this.canvas.addEventListener('mouseleave', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });
        
        // Touch events for mobile
        this.canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const rect = this.canvas.getBoundingClientRect();
            const touch = e.touches[0];
            this.mouse.x = touch.clientX - rect.left;
            this.mouse.y = touch.clientY - rect.top;
        });
        
        this.canvas.addEventListener('touchend', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });
        
        // Resize
        window.addEventListener('resize', () => {
            this.canvas.width = this.canvas.offsetWidth;
            this.canvas.height = this.canvas.offsetHeight;
            this.init();
        });
    }
}

// Initialize particle network when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('particle-canvas');
    if (canvas) {
        // Wait a bit to ensure canvas has proper dimensions
        setTimeout(() => {
            new ParticleNetwork(canvas);
        }, 100);
    }
});

// Console log for debugging
console.log('Welcome Light Theme JS with Particle Network loaded successfully');
