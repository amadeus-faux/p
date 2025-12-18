<!-- RESPONSIVE NAVBAR STRUCTURE (Generated dynamically by JavaScript) -->

<!-- Desktop Navbar (Visible on screens > 900px) -->
<header class="navbar-container">
    <div class="navbar-inner">
        <a href="#" class="logo">
            <img src="asset/logo/foodedu.png" alt="FoodEdu Logo" />
        </a>
        
        <!-- DESKTOP NAVIGATION -->
        <nav class="nav-menu">
            <a href="#beranda" class="nav-item active">Beranda</a>
            
            <div class="dropdown">
                <a class="nav-item dropdown-toggle">
                    Program <span class="arrow"></span>
                </a>
                <div class="dropdown-menu">
                    <a href="gizi.html#informasi-gizi">Informasi Gizi Seimbang</a>
                    <a href="gizi.html#kelayakan">Edukasi Kelayakan Makanan</a>
                </div>
            </div>
            
            <a href="pengaduan.php" class="nav-item">Pengaduan</a>
            <a href="saran.php" class="nav-item">Saran</a>
            
            <div class="nav-buttons">
                <button class="btn-login">Login</button>
                <button class="btn-signup">Sign Up</button>
            </div>
        </nav>
        
        <!-- HAMBURGER MENU (Visible on screens ≤ 900px) -->
        <button class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<!-- MOBILE NAVIGATION (Cloned and styled by JavaScript) -->
<!-- This is created dynamically by initResponsiveNavbar() function -->
<nav class="nav-menu-mobile">
    <!-- Same structure as nav-menu, cloned by JavaScript -->
    <a href="#beranda" class="nav-item active">Beranda</a>
    
    <div class="dropdown">
        <a class="nav-item dropdown-toggle">
            Program <span class="arrow"></span>
        </a>
        <div class="dropdown-menu">
            <a href="gizi.html#informasi-gizi">Informasi Gizi Seimbang</a>
            <a href="gizi.html#kelayakan">Edukasi Kelayakan Makanan</a>
        </div>
    </div>
    
    <a href="pengaduan.php" class="nav-item">Pengaduan</a>
    <a href="saran.php" class="nav-item">Saran</a>
    
    <div class="nav-buttons">
        <button class="btn-login">Login</button>
        <button class="btn-signup">Sign Up</button>
    </div>
</nav>

<!-- MOBILE OVERLAY (Click to close menu) -->
<div class="mobile-overlay"></div>

<!-- ========================================================
     ANIMATION & INTERACTION BEHAVIOR
     ======================================================== -->

HAMBURGER ANIMATION:
- Hover: scale(1.08) smooth transition
- Click: Opens mobile menu, transforms to X shape
  - Span 1: Rotates 45deg and translates (8px, 8px)
  - Span 2: Opacity 0 and translateX(-10px)
  - Span 3: Rotates -45deg and translates (7px, -8px)

MOBILE MENU ANIMATION:
- Initial state: position left: -100% (off-screen)
- Active state: position left: 0 (slides in)
- Duration: 0.5s with cubic-bezier(0.34, 1.56, 0.64, 1) for bouncy feel
- Overlay fades in simultaneously with 0.4s duration

HOVER EFFECTS:
- Nav item: Left 4px border accent appears with scaleY(0) → scaleY(1)
- Padding increases slightly (25px → 30px for left)
- Background color changes to rgba(39, 174, 96, 0.08)

DROPDOWN ANIMATION:
- Initial: opacity 0, max-height 0 (collapsed)
- Active: opacity 1, max-height 300px (expanded)
- Duration: 0.4s with cubic-bezier easing
- Arrow rotates -135deg when dropdown is open

CLOSE INTERACTIONS:
1. Click overlay (mobile-overlay)
2. Click any nav link
3. Press Escape key
4. Window resize to desktop size (> 900px)
5. Click outside menu area

BODY OVERFLOW:
- Menu open: document.body.style.overflow = 'hidden'
- Menu closed: document.body.style.overflow = 'auto'

<!-- ========================================================
     RESPONSIVE BREAKPOINTS
     ======================================================== -->

DESKTOP (>900px):
- .nav-menu: display: flex (visible)
- .hamburger: display: none (hidden)
- .nav-buttons: display: flex (visible)
- Dropdown hover effects enabled
- No mobile overlay or mobile menu

TABLET (768px - 900px):
- .hamburger: display: flex (visible)
- .nav-menu: display: none (hidden)
- .nav-menu-mobile: width 85% (shows)
- Padding reduced: 14px
- Font size: 15px
- Click-based dropdown toggle

MOBILE (480px - 768px):
- .hamburger: display: flex (visible)
- .nav-menu-mobile: width 85%
- Padding: 12px
- Font size: 14px
- Touch-friendly spacing
- Compact user profile section

SMALL MOBILE (<480px):
- .hamburger: width 28px, height 28px (smaller)
- .nav-menu-mobile: width 100% (full width)
- Padding: 12px (compact)
- Font size: 14px (readable)
- All interactive elements min 44px tall for touch targets

<!-- ========================================================
     CSS CLASSES & STATES
     ======================================================== -->

Active/Open States:
- .navbar-container: No change (always visible)
- .hamburger.active: Transforms to X shape
- .nav-menu-mobile.active: Slides in from left
- .mobile-overlay.active: Shows with dark background
- .dropdown.open: Expands to show menu items

Hover States:
- .hamburger:hover: scale(1.08)
- .nav-menu-mobile a:hover: background + color change + left padding
- .nav-menu-mobile a:hover::before: Left border appears
- .nav-menu-mobile .dropdown-toggle:hover: Same as regular link

Responsive Visibility:
- .nav-menu: display none on mobile
- .hamburger: display none on desktop
- .nav-buttons: display none on mobile
- .user-profile: display none on mobile
- .nav-menu-mobile: position fixed, visible only when active on mobile

<!-- ========================================================
     EVENT HANDLERS (JavaScript)
     ======================================================== -->

initResponsiveNavbar():
- Creates .nav-menu-mobile by cloning .nav-menu
- Creates .mobile-overlay div
- Sets up hamburger click listener
- Sets up overlay click listener
- Sets up link click listeners
- Sets up dropdown toggle listeners
- Sets up escape key listener
- Sets up window resize listener
- Sets up click-outside detection

toggleMobileMenu():
- Toggles .active class on mobile menu, hamburger, overlay
- Controls document.body.style.overflow
- Closes menu when needed

Event delegation:
- Click events properly stop propagation
- Escape key checked for 'Escape' key code
- Resize listener checks window.innerWidth
- Click-outside checks element containment

<!-- ========================================================
     CSS ANIMATION EASING
     ======================================================== -->

Cubic-bezier(0.34, 1.56, 0.64, 1):
- Creates bouncy, smooth animation feel
- Used for: hamburger transitions, menu slide, overlay fade, dropdown expand
- Provides overshoot effect that feels responsive

Transform properties (GPU accelerated):
- Hamburger: rotate + translate
- Menu: left position change
- Borders: scaleY transform
- Arrow: rotate for dropdown indicator

Transition durations:
- Hamburger: 0.3s hover, 0.4s animation
- Menu: 0.5s slide-in
- Overlay: 0.4s fade
- Dropdown: 0.4s expand
- Hover effects: 0.3s

<!-- ========================================================
     ACCESSIBILITY & UX
     ======================================================== -->

Touch-friendly:
- Min button height: 44px (from padding + line-height)
- Min button width: 44px (from padding)
- Spacing between interactive elements adequate
- Clear visual feedback on hover and active states

Keyboard navigation:
- Escape key closes mobile menu
- Tab navigation works through all links
- Visual focus indicators present

Screen reader:
- Semantic HTML structure
- Links have meaningful text
- Buttons have proper text content
- Dropdown toggle has descriptive aria attributes (optional enhancement)

Performance:
- CSS animations use transform + opacity (GPU accelerated)
- No layout-triggering properties
- Smooth 60fps animations
- Minimal JavaScript execution

<!-- ========================================================
     ISOLATION & NO INTERFERENCE
     ======================================================== -->

Selector isolation:
- .nav-menu-mobile selectors completely separate from .nav-menu
- Mobile overlay positioned fixed without affecting layout
- Z-index properly managed (998 overlay, 1000 menu)

No layout shifts:
- Mobile menu slides in from off-screen (left: -100%)
- Overlay positioned fixed
- Body overflow hidden only when menu open
- Hero section unaffected

Event handling:
- event.stopPropagation() prevents event bubbling
- Click detection includes viewport width check
- Resize listener only closes if width > 900px
- Click-outside detection verifies menu is active

Feature compatibility:
- Dashboard user profile still accessible
- Auth forms still functional
- Hero section animation unaffected
- All links still navigate properly
- Logout button still works

