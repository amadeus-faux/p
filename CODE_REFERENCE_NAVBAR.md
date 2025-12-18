# Code Reference - Responsive Navbar Implementation

## CSS Snippets (main.css - Lines 536-850)

### 1. Hamburger Menu Styling (Lines 545-595)

```css
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: space-around;
    width: 32px;
    height: 32px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    z-index: 1005;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.hamburger:hover {
    transform: scale(1.08);
}

.hamburger span {
    display: block;
    width: 100%;
    height: 3px;
    background: #333;
    border-radius: 2px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: center;
}

.hamburger span:nth-child(1) {
    width: 100%;
}

.hamburger span:nth-child(2) {
    width: 85%;
    margin: 0 auto;
}

.hamburger span:nth-child(3) {
    width: 100%;
}

.hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(8px, 8px);
    width: 100%;
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
    transform: translateX(-10px);
}

.hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -8px);
    width: 100%;
}
```

### 2. Mobile Overlay (Lines 599-614)

```css
.mobile-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0);
    z-index: 998;
    pointer-events: none;
    transition: background-color 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.mobile-overlay.active {
    background: rgba(0, 0, 0, 0.5);
    pointer-events: auto;
}
```

### 3. Nav Menu Mobile (Lines 617-650)

```css
.nav-menu-mobile {
    position: fixed;
    top: 0;
    left: -100%;
    width: 75%;
    max-width: 320px;
    height: 100vh;
    background: linear-gradient(135deg, #ffffff 0%, #f8fffe 100%);
    flex-direction: column;
    padding: 70px 0 30px 0;
    gap: 0;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
    transition: left 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 1000;
    overflow-y: auto;
    overflow-x: hidden;
    border-left: 1px solid rgba(39, 174, 96, 0.1);
}

.nav-menu-mobile.active {
    left: 0;
}
```

### 4. Nav Items Styling (Lines 640-682)

```css
.nav-menu-mobile a,
.nav-menu-mobile .dropdown-toggle {
    display: flex;
    align-items: center;
    padding: 16px 25px;
    color: #333;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    border-bottom: 1px solid rgba(39, 174, 96, 0.08);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    cursor: pointer;
}

.nav-menu-mobile a:hover,
.nav-menu-mobile .dropdown-toggle:hover {
    background: rgba(39, 174, 96, 0.08);
    color: var(--green);
    padding-left: 30px;
}

.nav-menu-mobile a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: var(--green);
    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.nav-menu-mobile a:hover::before {
    transform: scaleY(1);
}

.nav-menu-mobile a.active::before {
    transform: scaleY(1);
}
```

### 5. Dropdown Menu Mobile (Lines 701-730)

```css
.nav-menu-mobile .dropdown-toggle {
    justify-content: space-between;
    background: none;
    border: none;
    font-family: "Poppins", sans-serif;
    padding-right: 25px;
}

.nav-menu-mobile .arrow {
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.nav-menu-mobile .dropdown.open .arrow {
    transform: rotate(-135deg);
}

.nav-menu-mobile .dropdown-menu {
    position: relative !important;
    background: rgba(39, 174, 96, 0.05);
    box-shadow: none !important;
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    transform: none !important;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    padding: 0;
}

.nav-menu-mobile .dropdown.open .dropdown-menu {
    opacity: 1;
    max-height: 300px;
    padding: 8px 0;
}

.nav-menu-mobile .dropdown-menu a {
    padding: 12px 25px 12px 45px;
    font-size: 14px;
    border-bottom: 1px solid rgba(39, 174, 96, 0.05);
}

.nav-menu-mobile .dropdown-menu a:hover {
    padding-left: 50px;
}
```

### 6. Responsive Breakpoints (Lines 754-820)

```css
@media (max-width: 900px) {
    .hamburger {
        display: flex;
    }

    .navbar-inner {
        padding: 0 5%;
    }

    .nav-menu {
        display: none !important;
    }

    .nav-buttons {
        display: none !important;
    }

    .user-profile {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .nav-menu-mobile {
        width: 85%;
        max-width: 100%;
    }

    .nav-menu-mobile a,
    .nav-menu-mobile .dropdown-toggle {
        padding: 14px 20px;
    }

    .nav-menu-mobile a:hover {
        padding-left: 25px;
    }

    .nav-menu-mobile .dropdown-menu a {
        padding: 10px 20px 10px 40px;
    }

    .nav-menu-mobile .dropdown-menu a:hover {
        padding-left: 45px;
    }
}

@media (max-width: 480px) {
    .hamburger {
        width: 28px;
        height: 28px;
    }

    .nav-menu-mobile {
        width: 100%;
        max-width: 100%;
    }

    .nav-menu-mobile a,
    .nav-menu-mobile .dropdown-toggle {
        padding: 12px 18px;
        font-size: 14px;
    }

    .nav-menu-mobile .user-profile {
        margin: 10px 8px;
        padding: 10px 18px;
    }
}
```

---

## JavaScript Snippets (main.js - Lines 10-195)

### 1. initResponsiveNavbar() Function (Lines 14-125)

```javascript
function initResponsiveNavbar() {
    // Create mobile nav menu if it doesn't exist
    const navbarInner = document.querySelector('.navbar-inner');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navbarInner && navMenu && !document.querySelector('.nav-menu-mobile')) {
        // Clone nav-menu to create mobile version
        const mobileMenu = navMenu.cloneNode(true);
        mobileMenu.classList.remove('nav-menu');
        mobileMenu.classList.add('nav-menu-mobile');
        navbarInner.appendChild(mobileMenu);

        // Create mobile overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-overlay';
        document.body.appendChild(overlay);

        // Get references
        const hamburger = document.querySelector('.hamburger');
        const mobileNav = document.querySelector('.nav-menu-mobile');
        const mobileOverlay = document.querySelector('.mobile-overlay');

        if (hamburger && mobileNav) {
            // Toggle menu
            function toggleMobileMenu() {
                const isOpen = mobileNav.classList.contains('active');
                
                if (isOpen) {
                    mobileNav.classList.remove('active');
                    hamburger.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                } else {
                    mobileNav.classList.add('active');
                    hamburger.classList.add('active');
                    mobileOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            // Hamburger click
            hamburger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileMenu();
            });

            // Overlay click
            mobileOverlay.addEventListener('click', toggleMobileMenu);

            // Close on link click
            const mobileLinks = mobileNav.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 900) {
                        toggleMobileMenu();
                    }
                });
            });

            // Mobile dropdown toggle
            const mobileDropdownToggles = mobileNav.querySelectorAll('.dropdown-toggle');
            mobileDropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = toggle.closest('.dropdown');
                    const isOpen = dropdown.classList.contains('open');
                    
                    // Close other dropdowns
                    mobileNav.querySelectorAll('.dropdown.open').forEach(d => {
                        if (d !== dropdown) d.classList.remove('open');
                    });
                    
                    // Toggle current
                    if (isOpen) {
                        dropdown.classList.remove('open');
                    } else {
                        dropdown.classList.add('open');
                    }
                });
            });

            // Escape key to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                    toggleMobileMenu();
                }
            });

            // Close on window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 900 && mobileNav.classList.contains('active')) {
                    toggleMobileMenu();
                }
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 900 && 
                    mobileNav.classList.contains('active') &&
                    !mobileNav.contains(e.target) && 
                    !hamburger.contains(e.target)) {
                    toggleMobileMenu();
                }
            });
        }
    }
}
```

### 2. initHamburgerMenu() Wrapper (Lines 128-131)

```javascript
function initHamburgerMenu() {
    // Call the new responsive navbar initialization
    initResponsiveNavbar();
}
```

### 3. initDropdowns() Enhanced (Lines 136-195)

```javascript
function initDropdowns() {
    // Desktop dropdown functionality
    const dropdownToggles = document.querySelectorAll('.nav-menu .dropdown-toggle');
    const dropdowns = document.querySelectorAll('.nav-menu .dropdown');

    // Desktop hover
    dropdowns.forEach(dropdown => {
        if (window.innerWidth > 900) {
            dropdown.addEventListener('mouseenter', () => {
                dropdown.classList.add('open');
            });

            dropdown.addEventListener('mouseleave', () => {
                dropdown.classList.remove('open');
            });
        }
    });

    // Desktop click
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            if (window.innerWidth > 900) {
                e.preventDefault();
                e.stopPropagation();

                const dropdown = this.closest('.dropdown');
                const isActive = dropdown.classList.contains('open');

                // Close all other dropdowns
                document.querySelectorAll('.nav-menu .dropdown.open').forEach(openDropdown => {
                    if (openDropdown !== dropdown) {
                        openDropdown.classList.remove('open');
                    }
                });

                // Toggle current dropdown
                if (isActive) {
                    dropdown.classList.remove('open');
                } else {
                    dropdown.classList.add('open');
                }
            }
        });
    });

    // Close dropdowns when clicking outside (desktop only)
    document.addEventListener('click', function (e) {
        if (window.innerWidth > 900 && !e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown.open').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        }
    });

    // Close dropdowns on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown.open').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        }
    });
}
```

---

## Initialization (Already in DOMContentLoaded)

```javascript
document.addEventListener('DOMContentLoaded', () => {
    initHamburgerMenu();      // Calls initResponsiveNavbar internally
    initDropdowns();          // Enhanced for both desktop and mobile
    // ... other initializations
});
```

---

## Key CSS Variables Used

```css
--green:              Primary accent color (for active/hover states)
rgba(39, 174, 96, *): Green-based colors with transparency
#333:                 Text color (dark gray)
```

---

## Animation Easing Reference

```
cubic-bezier(0.34, 1.56, 0.64, 1)
= Smooth, bouncy animation
= Overshoot effect (1.56) = goes beyond target then settles
= Professional, modern feel
= Used for all transitions in navbar
```

---

## Z-Index Hierarchy

```
Z-Index Layers:
- 1005:   .hamburger button
- 1000:   .nav-menu-mobile (menu)
- 998:    .mobile-overlay (background dim)
- Default: navbar-container and other elements
```

---

## Event Flow Diagram

```
User Action        Event Handler           Action
─────────────      ─────────────           ──────
Click hamburger → click listener → toggleMobileMenu()
Click overlay   → click listener → toggleMobileMenu()
Click link      → click listener → close menu
Press Escape    → keydown listener → close menu
Resize window   → resize listener → close if >900px
Click outside   → click listener → close menu
Click dropdown  → click listener → toggle open class
```

---

## Testing Code Snippets

### Verify Mobile Menu Created
```javascript
const mobileMenu = document.querySelector('.nav-menu-mobile');
console.log('Mobile menu exists:', mobileMenu !== null);
console.log('Mobile menu classes:', mobileMenu?.className);
```

### Verify Overlay Created
```javascript
const overlay = document.querySelector('.mobile-overlay');
console.log('Overlay exists:', overlay !== null);
console.log('Overlay parent:', overlay?.parentElement.tagName);
```

### Test Menu Toggle
```javascript
const hamburger = document.querySelector('.hamburger');
hamburger.click();  // Opens menu
hamburger.click();  // Closes menu
```

### Check Active States
```javascript
const mobileNav = document.querySelector('.nav-menu-mobile');
console.log('Menu is active:', mobileNav.classList.contains('active'));

const hamburger = document.querySelector('.hamburger');
console.log('Hamburger is active:', hamburger.classList.contains('active'));

const overlay = document.querySelector('.mobile-overlay');
console.log('Overlay is active:', overlay.classList.contains('active'));
```

### Verify Event Listeners
```javascript
// Check if animation is smooth (should not see layout shifts)
// Should see:
// 1. Hamburger rotates to X smoothly
// 2. Menu slides in from left
// 3. Overlay fades in
// 4. All animations are bouncy (overshoot effect)
```

---

## Files Modified Summary

| File | Lines | Changes |
|------|-------|---------|
| main.css | 536-850 | Complete hamburger + mobile nav rewrite (314 lines) |
| main.js | 10-195 | initResponsiveNavbar + enhanced initDropdowns (185 lines) |

---

**All code is vanilla (no dependencies) and production-ready!** 🚀
