// Welcome Page JavaScript - Moved from Blade Template
// All JavaScript functionality for the welcome page

document.addEventListener('DOMContentLoaded', function() {
    // Environment info (will be set from PHP)
    const isProduction = window.isProduction || false;
    const currentDomain = window.currentDomain || 'localhost';

    // Force apply mobile fixes immediately for all environments
    const style = document.createElement('style');
    style.id = 'environment-fix-css';
    style.textContent = `
        /* Universal Environment Fix */
        * {
            box-sizing: border-box !important;
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
                gap: 0.25rem !important;
                padding: 0 0.5rem !important;
                justify-content: flex-start !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: none !important;
            }
            
            .news-filter-container::-webkit-scrollbar,
            .gallery-filter-container::-webkit-scrollbar {
                display: none !important;
            }
            
            /* Filter buttons */
            .news-filter-btn-modern, .gallery-filter-btn-modern {
                flex-shrink: 0 !important;
                white-space: nowrap !important;
                font-size: 0.75rem !important;
                font-weight: 600 !important;
                padding: 8px 12px !important;
                border-radius: 20px !important;
                color: white !important;
                border: 1px solid rgba(255,255,255,0.4) !important;
                min-width: fit-content !important;
                margin: 0 !important;
            }
            
            .news-filter-btn-modern {
                background: linear-gradient(135deg, rgba(124,58,237,0.8), rgba(236,72,153,0.8)) !important;
            }
            
            .gallery-filter-btn-modern {
                background: linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8)) !important;
            }
            
            .news-filter-btn-modern.active {
                background: linear-gradient(135deg, #7c3aed, #ec4899) !important;
                transform: translateY(-1px) scale(1.02) !important;
            }
            
            .gallery-filter-btn-modern.active {
                background: linear-gradient(135deg, #00d4ff, #3b82f6) !important;
                transform: translateY(-1px) scale(1.02) !important;
            }
            
            /* Mobile navigation padding fix */
            nav {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }
            
            /* Section padding consistency */
            section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
        
        /* Desktop and mobile universal fixes */
        body, html {
            overflow-x: hidden !important;
            width: 100% !important;
            max-width: 100% !important;
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
        btn.innerHTML = '<i class="fas fa-bars text-xl"></i>';
        btn.style.background = 'rgba(6, 182, 212, 0.1)';
        btn.style.borderColor = 'rgba(6, 182, 212, 0.5)';
        window.mobileMenuOpen = false;
    } else {
        // Open menu
        menu.style.transform = 'translateY(0)';
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
        btn.innerHTML = '<i class="fas fa-times text-xl"></i>';
        btn.style.background = 'rgba(239, 68, 68, 0.2)';
        btn.style.borderColor = 'rgba(239, 68, 68, 0.8)';
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
            quickInfoGrid.style.gap = '0.75rem';
            quickInfoGrid.style.width = '100%';
            
            // Also force each card styling with equal dimensions
            const cards = document.querySelectorAll('.quick-info .bg-white');
            cards.forEach(function(card) {
                card.style.padding = '1rem';
                card.style.height = '150px';
                card.style.width = '100%';
                card.style.display = 'flex';
                card.style.flexDirection = 'column';
                card.style.justifyContent = 'center';
                card.style.alignItems = 'center';
                card.style.textAlign = 'center';
                card.style.boxSizing = 'border-box';
                
                // Adjust icon sizes
                const icons = card.querySelectorAll('.w-12');
                icons.forEach(function(icon) {
                    icon.style.width = '2rem';
                    icon.style.height = '2rem';
                });
                
                // Adjust text sizes and wrap long text
                const largTexts = card.querySelectorAll('.text-lg');
                largTexts.forEach(function(text) {
                    text.style.fontSize = '0.875rem';
                    text.style.lineHeight = '1.25rem';
                    text.style.wordWrap = 'break-word';
                    text.style.overflow = 'hidden';
                });
                
                const smallTexts = card.querySelectorAll('.text-sm');
                smallTexts.forEach(function(text) {
                    text.style.fontSize = '0.75rem';
                    text.style.lineHeight = '1rem';
                    text.style.wordWrap = 'break-word';
                    text.style.overflow = 'hidden';
                });
            });
        }
    }
    
    // Apply force grid immediately and on resize
    forceQuickInfoGrid();
    window.addEventListener('resize', forceQuickInfoGrid);
});

// WhatsApp chat functionality
document.addEventListener('DOMContentLoaded', function() {
    const startChatBtn = document.getElementById('start-chat');
    if (startChatBtn) {
        startChatBtn.addEventListener('click', function() {
            const whatsappNumber = window.whatsappNumber || '08123456789';
            const schoolName = window.schoolName || 'sekolah';
            const message = encodeURIComponent(`Halo saya ingin bertanya tentang ${schoolName}`);
            window.open(`https://wa.me/${whatsappNumber}?text=${message}`, '_blank');
        });
    }
    
    // Pastikan gambar hero tidak memiliki filter
    const heroImages = document.querySelectorAll('.hero-image img, .hero img');
    heroImages.forEach(function(img) {
        img.style.filter = 'none';
        img.style.webkitFilter = 'none';
        img.style.backdropFilter = 'none';
        img.style.webkitBackdropFilter = 'none';
        img.style.opacity = '1';
        img.style.transform = 'none';
        img.style.mixBlendMode = 'normal';
        img.style.boxShadow = 'none';
    });
    
    // Hapus filter dari parent containers juga
    const heroContainers = document.querySelectorAll('.hero, .hero-image, section.hero');
    heroContainers.forEach(function(container) {
        container.style.filter = 'none';
        container.style.webkitFilter = 'none';
        container.style.backdropFilter = 'none';
        container.style.webkitBackdropFilter = 'none';
        container.style.mixBlendMode = 'normal';
    });
});

// Simple gallery modal functions
function openSimpleGalleryModal(galleryId, title, description) {
    document.getElementById('simpleGalleryTitle').textContent = title;
    document.getElementById('simpleGalleryDescription').textContent = description;
    
    // Show loading
    var photosContainer = document.getElementById('simpleGalleryPhotos');
    photosContainer.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #666;"></i><br><span style="color: #666;">Memuat foto...</span></div>';
    
    // Show modal
    document.getElementById('simpleGalleryModal').classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Fetch photos
    fetch('/api/galeri/' + galleryId + '/photos')
        .then(response => response.json())
        .then(data => {
            let photosHtml = '';
            if (data && data.length > 0) {
                data.forEach(photo => {
                    photosHtml += `
                        <div style="margin-bottom: 15px;">
                            <img src="${photo.url}" alt="${photo.name || 'Foto'}" style="width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            ${photo.description ? `<p style="margin-top: 8px; font-size: 14px; color: #666;">${photo.description}</p>` : ''}
                        </div>
                    `;
                });
            } else {
                photosHtml = '<p style="text-align: center; color: #666;">Tidak ada foto untuk galeri ini.</p>';
            }
            photosContainer.innerHTML = photosHtml;
        })
        .catch(error => {
            console.error('Error:', error);
            photosContainer.innerHTML = '<p style="text-align: center; color: #ff6b6b;">Terjadi kesalahan saat memuat foto.</p>';
        });
}

function closeSimpleGalleryModal() {
    document.getElementById('simpleGalleryModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('simpleGalleryModal');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeSimpleGalleryModal();
            }
        });
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('simpleGalleryModal');
        if (modal && modal.classList.contains('show')) {
            closeSimpleGalleryModal();
        }
    }
});

// Gallery functionality
let currentGalleryPhotos = [];
let currentPhotoIndex = 0;

// Gallery Filter Function
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            galleryItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// Open gallery detail modal
function openGalleryModal(galleryId, title, description) {
    try {
        // Implementation for gallery modal
        console.log('Opening gallery modal:', galleryId, title, description);
    } catch (error) {
        console.error('Error opening gallery modal:', error);
    }
}

// Close gallery detail modal
function closeGalleryModal() {
    try {
        // Implementation for closing gallery modal
        console.log('Closing gallery modal');
    } catch (error) {
        console.error('Error closing gallery modal:', error);
    }
}

// Open image zoom modal
function openImageZoom(photoIndex) {
    try {
        // Implementation for image zoom
        console.log('Opening image zoom:', photoIndex);
    } catch (error) {
        console.error('Error opening image zoom:', error);
    }
}

// Close image zoom modal
function closeImageZoom() {
    try {
        // Implementation for closing image zoom
        console.log('Closing image zoom');
    } catch (error) {
        console.error('Error closing image zoom:', error);
    }
}

// Navigate to previous image
function prevImage() {
    currentPhotoIndex = (currentPhotoIndex - 1 + currentGalleryPhotos.length) % currentGalleryPhotos.length;
    openImageZoom(currentPhotoIndex);
}

// Navigate to next image
function nextImage() {
    currentPhotoIndex = (currentPhotoIndex + 1) % currentGalleryPhotos.length;
    openImageZoom(currentPhotoIndex);
}

// Close modals when clicking outside
function handleModalClick(event) {
    if (event.target.id === 'galleryDetailModal') {
        closeGalleryModal();
    }
}

function handleZoomModalClick(event) {
    if (event.target.id === 'imageZoomModal') {
        closeImageZoom();
    }
}

// Handle escape key and navigation
document.addEventListener('keydown', function(event) {
    const galleryDetailModal = document.getElementById('galleryDetailModal');
    const imageZoomModal = document.getElementById('imageZoomModal');
    
    const detailModalOpen = galleryDetailModal && galleryDetailModal.classList.contains('show');
    const zoomModalOpen = imageZoomModal && imageZoomModal.classList.contains('show');
    
    switch(event.key) {
        case 'Escape':
            if (zoomModalOpen) closeImageZoom();
            else if (detailModalOpen) closeGalleryModal();
            break;
        case 'ArrowLeft':
            if (zoomModalOpen) prevImage();
            break;
        case 'ArrowRight':
            if (zoomModalOpen) nextImage();
            break;
    }
});

// Modern Interactive JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
    }

    // Counter Animation
    const counters = document.querySelectorAll('[data-target]');
    const speed = 200;

    const countUp = () => {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;
            
            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(countUp, 1);
            } else {
                counter.innerText = target;
            }
        });
    };

    // Intersection Observer for Counter Animation
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                countUp();
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const heroSection = document.querySelector('#home');
    if (heroSection) {
        observer.observe(heroSection);
    }

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add parallax effect to floating elements
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelectorAll('.parallax-element');
        
        parallax.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Mouse move effect for 3D cards
    document.querySelectorAll('.card-3d').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 4;
            const rotateY = (centerX - x) / 4;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
        });
    });
});

// FORCE MOBILE HERO LAYOUT - ULTIMATE OVERRIDE
function forceMobileHeroLayout() {
    if (window.innerWidth <= 768) {
        const heroSection = document.getElementById('home');
        if (heroSection) {
            // Force mobile layout properties
            heroSection.style.height = '100vh';
            heroSection.style.maxHeight = '100vh';
            heroSection.style.overflow = 'hidden';
            heroSection.style.display = 'flex';
            heroSection.style.alignItems = 'center';
            heroSection.style.justifyContent = 'center';
            heroSection.style.paddingTop = '60px';
            heroSection.style.paddingBottom = '60px';
            
            // Force container layout
            const container = heroSection.querySelector('.mobile-consistent-padding');
            if (container) {
                container.style.height = '100%';
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                container.style.justifyContent = 'center';
            }
        }
    }
}

// Apply on load and resize
window.addEventListener('load', forceMobileHeroLayout);
window.addEventListener('resize', forceMobileHeroLayout);

// Apply immediately
forceMobileHeroLayout();

// FORCE HORIZONTAL FILTERS WITH STYLING
function forceHorizontalFilters() {
    const containers = document.querySelectorAll('#news-filters, #gallery-filters');
    containers.forEach(container => {
        container.style.display = 'flex';
        container.style.flexWrap = 'nowrap';
        container.style.overflowX = 'auto';
        container.style.gap = '0.25rem';
        container.style.padding = '0 0.5rem';
        container.style.justifyContent = 'flex-start';
        container.style.webkitOverflowScrolling = 'touch';
        container.style.scrollbarWidth = 'none';
        container.style.msOverflowStyle = 'none';
    });
}

// UPDATE ACTIVE STATES
function updateFilterActiveStates() {
    document.querySelectorAll('.news-filter-btn-modern, .gallery-filter-btn-modern').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active from siblings
            const siblings = this.parentElement.querySelectorAll('.news-filter-btn-modern, .gallery-filter-btn-modern');
            siblings.forEach(sibling => {
                sibling.classList.remove('active');
                if (sibling.classList.contains('news-filter-btn-modern')) {
                    sibling.style.background = 'linear-gradient(135deg, rgba(124,58,237,0.8), rgba(236,72,153,0.8))';
                } else {
                    sibling.style.background = 'linear-gradient(135deg, rgba(0,212,255,0.8), rgba(59,130,246,0.8))';
                }
                sibling.style.transform = 'none';
            });
            
            // Add active to clicked button
            this.classList.add('active');
            if (this.classList.contains('news-filter-btn-modern')) {
                this.style.background = 'linear-gradient(135deg, #7c3aed, #ec4899)';
            } else {
                this.style.background = 'linear-gradient(135deg, #00d4ff, #3b82f6)';
            }
            this.style.transform = 'translateY(-1px) scale(1.02)';
        });
    });
}

// Apply on all relevant events
document.addEventListener('DOMContentLoaded', function() {
    forceHorizontalFilters();
    updateFilterActiveStates();
});

window.addEventListener('load', function() {
    forceHorizontalFilters();
    updateFilterActiveStates();
});

window.addEventListener('resize', forceHorizontalFilters);

// Apply immediately and once more after 1 second
forceHorizontalFilters();
updateFilterActiveStates();
setTimeout(function() {
    forceHorizontalFilters();
    updateFilterActiveStates();
}, 1000);

// Function to set the hero section height correctly on mobile
function setHeroHeight() {
    const heroSection = document.getElementById('home');
    if (heroSection && window.innerWidth < 768) {
        // Get viewport height
        const vh = window.innerHeight;
        // Set the hero section height to exactly viewport height
        heroSection.style.height = vh + 'px';
        heroSection.style.maxHeight = vh + 'px';
        heroSection.style.overflow = 'hidden';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Set hero height on page load and resize
    setHeroHeight();
    window.addEventListener('resize', setHeroHeight);
    window.addEventListener('orientationchange', setHeroHeight);
    
    // Also run after a short delay to ensure it works after all content loads
    setTimeout(setHeroHeight, 500);
    
    // Function to ensure "Hubungi Kami" section has proper 2x2 grid on mobile
    function setupHubungiKamiGrid() {
        const hubungiKamiGrid = document.getElementById('hubungi-kami-grid');
        
        if (hubungiKamiGrid) {
            // Force 2x2 grid on mobile and tablet
            if (window.innerWidth < 1024) {
                hubungiKamiGrid.style.display = 'grid';
                hubungiKamiGrid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                hubungiKamiGrid.style.gridTemplateRows = 'repeat(2, auto)';
                hubungiKamiGrid.style.gap = '0.75rem';
                hubungiKamiGrid.style.width = '100%';
                
                // Force each card to be properly sized
                const cards = hubungiKamiGrid.querySelectorAll('.info-card-modern');
                cards.forEach(function(card) {
                    card.style.width = '100%';
                    card.style.display = 'block';
                    card.style.margin = '0';
                    card.style.padding = '0';
                    
                    // Find the glass element within each card
                    const glass = card.querySelector('.glass');
                    if (glass) {
                        glass.style.padding = '0.75rem';
                        glass.style.height = '100%';
                        glass.style.minHeight = '186px';
                        glass.style.width = '100%';
                        glass.style.display = 'flex';
                        glass.style.flexDirection = 'column';
                        glass.style.justifyContent = 'center';
                        glass.style.alignItems = 'center';
                        glass.style.textAlign = 'center';
                    }
                });
            } else {
                // Reset to desktop layout (4 columns)
                hubungiKamiGrid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                hubungiKamiGrid.style.gap = '1.5rem';
            }
        }
    }
    
    // Run immediately
    setupHubungiKamiGrid();
    
    // Also run on load and resize to ensure it works
    window.addEventListener('load', setupHubungiKamiGrid);
    window.addEventListener('resize', setupHubungiKamiGrid);
    
    // Run again after a small delay to ensure it applies after any other scripts
    setTimeout(setupHubungiKamiGrid, 500);
});