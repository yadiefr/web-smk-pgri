/*
 * Guru Layout JavaScript
 * Mobile layout stabilizer and Alpine.js data
 */

// Enhanced Mobile Layout Stabilizer
(function() {    
    function stabilizeLayout() {
        const sidebar = document.querySelector('aside');
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        const isMobile = window.innerWidth < 1024;
        
        // Stabilize header immediately
        if (header) {
            header.style.cssText = `
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                height: ${isMobile && window.innerWidth < 480 ? '3.5rem' : '4rem'} !important;
                z-index: 40 !important;
                background: white !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
                display: flex !important;
                align-items: center !important;
                padding: 0 ${isMobile ? '0.75rem' : '1rem'} !important;
            `;
        }
        
        // Stabilize sidebar positioning
        if (sidebar) {
            sidebar.style.cssText = `
                position: fixed !important;
                top: ${isMobile && window.innerWidth < 480 ? '3.5rem' : '4rem'} !important;
                left: 0 !important;
                width: ${isMobile && window.innerWidth < 480 ? '14rem' : '16rem'} !important;
                height: calc(100vh - ${isMobile && window.innerWidth < 480 ? '3.5rem' : '4rem'}) !important;
                z-index: 30 !important;
                background: white !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
                transform: translateX(${isMobile ? '-100%' : '0'}) !important;
                transition: transform 0.2s ease !important;
                overflow-y: auto !important;
            `;
        }
        
        // Stabilize main content
        if (main) {
            main.style.cssText = `
                margin-top: ${isMobile && window.innerWidth < 480 ? '3.5rem' : '4rem'} !important;
                margin-left: ${!isMobile ? '16rem' : '0'} !important;
                width: ${!isMobile ? 'calc(100% - 16rem)' : '100%'} !important;
                padding: ${isMobile && window.innerWidth < 480 ? '0.5rem' : isMobile ? '0.75rem' : '1.5rem'} !important;
                background: #f3f4f6 !important;
                min-height: calc(100vh - ${isMobile && window.innerWidth < 480 ? '3.5rem' : '4rem'}) !important;
                overflow-x: hidden !important;
            `;
        }
    }
    
    // Run immediately
    stabilizeLayout();
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', stabilizeLayout);
    }
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(stabilizeLayout, 100);
    });
})();

// CloudFlare analytics error handler
(function() {
    const originalFetch = window.fetch;
    if (originalFetch) {
        window.fetch = function() {
            return originalFetch.apply(this, arguments)
                .catch(function(err) {
                    const url = arguments[0] && arguments[0].url || arguments[0];
                    if (typeof url === 'string' && 
                        (url.includes('cloudflareinsights.com') || 
                         url.includes('beacon.min.js'))) {
                        console.warn('CloudFlare analytics request blocked - this is normal');
                        return new Response(JSON.stringify({}));
                    }
                    throw err;
                });
        };
    }
})();

// Alpine.js Data
document.addEventListener('alpine:init', () => {    
    Alpine.data('sidebarData', () => ({
        sidebarOpen: false,
        isMobile: window.innerWidth < 1024,
        isInitialized: false,
        
        init() {            
            this.isMobile = window.innerWidth < 1024;
            this.sidebarOpen = !this.isMobile;
            
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('main');
            const body = document.body;
            
            if (sidebar) {
                sidebar.style.transition = 'transform 0.2s ease';
                
                if (this.isMobile) {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    body.classList.remove('overflow-hidden');
                } else {
                    sidebar.style.transform = 'translateX(0)';
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                    if (mainContent) {
                        mainContent.style.marginLeft = '16rem';
                        mainContent.style.width = 'calc(100% - 16rem)';
                    }
                }
            }
            
            this.isInitialized = true;            
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.handleResize();
                }, 150);
            });
        },
        
        handleResize() {
            if (!this.isInitialized) return;
            
            const wasDesktop = !this.isMobile;
            this.isMobile = window.innerWidth < 1024;
                        
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('main');
            
            if (!this.isMobile && wasDesktop !== !this.isMobile) {
                this.sidebarOpen = true;
                if (sidebar) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                }
                if (mainContent) {
                    mainContent.style.marginLeft = '16rem';
                    mainContent.style.width = 'calc(100% - 16rem)';
                }
                document.body.classList.remove('overflow-hidden');
            } else if (this.isMobile && wasDesktop !== !this.isMobile) {
                this.sidebarOpen = false;
                if (sidebar) {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                }
                if (mainContent) {
                    mainContent.style.marginLeft = '0';
                    mainContent.style.width = '100%';
                }
                document.body.classList.remove('overflow-hidden');
            }
        },
        
        toggleSidebar() {
            if (!this.isInitialized) return;
            
            this.sidebarOpen = !this.sidebarOpen;
            
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('main');
            const body = document.body;
            
            if (sidebar) {
                if (this.sidebarOpen) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                    
                    if (this.isMobile) {
                        sidebar.style.boxShadow = '2px 0 25px rgba(0, 0, 0, 0.15)';
                        body.classList.add('overflow-hidden');
                    } else {
                        sidebar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                        if (mainContent) {
                            mainContent.style.marginLeft = '16rem';
                            mainContent.style.width = 'calc(100% - 16rem)';
                        }
                    }
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    sidebar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                    
                    if (this.isMobile) {
                        setTimeout(() => {
                            body.classList.remove('overflow-hidden');
                        }, 200);
                    } else {
                        if (mainContent) {
                            mainContent.style.marginLeft = '0';
                            mainContent.style.width = '100%';
                        }
                    }
                }
            }
            
            if (this.sidebarOpen) {
                body.classList.add('sidebar-expanded');
                body.classList.remove('sidebar-collapsed');
            } else {
                body.classList.add('sidebar-collapsed');
                body.classList.remove('sidebar-expanded');
            }
        }
    }));
});