// ===================================
// Configuration & Color Management
// ===================================
const defaultConfig = {
  background_color: "#f0f9ff",
  sidebar_color: "#006666",
  navbar_color: "#ffffff",
  primary_color: "#0284c7",
  text_color: "#0c4a6e",
  app_title: "thuexe.com",
  welcome_message: "Chào mừng đến với dịch vụ cho thuê xe",
  featured_title: "Xe nổi bật",
  footer_text: "© 2025 thuexe.com. Tất cả quyền được bảo lưu.",
  font_family: "system-ui",
  font_size: 16,
};

// ===================================
// Configuration Change Handler
// ===================================
async function onConfigChange(config) {
  const backgroundColor =
    config.background_color || defaultConfig.background_color;
  const sidebarColor = config.sidebar_color || defaultConfig.sidebar_color;
  const navbarColor = config.navbar_color || defaultConfig.navbar_color;
  const primaryColor = config.primary_color || defaultConfig.primary_color;
  const textColor = config.text_color || defaultConfig.text_color;
  const fontFamily = config.font_family || defaultConfig.font_family;
  const fontSize = config.font_size || defaultConfig.font_size;

  // Update CSS variables
  document.documentElement.style.setProperty("--bg-primary", backgroundColor);
  document.documentElement.style.setProperty("--primary-color", primaryColor);
  document.documentElement.style.setProperty("--text-primary", textColor);
  document.documentElement.style.setProperty("--navbar-bg", navbarColor);

  // Apply body styles
  document.body.style.backgroundColor = backgroundColor;
  document.body.style.fontFamily = `${fontFamily}, system-ui, -apple-system, sans-serif`;
  document.body.style.fontSize = `${fontSize}px`;

  // Update navbar
  const navbar = document.getElementById("navbar");
  if (navbar) {
    navbar.style.backgroundColor = navbarColor;
    navbar.style.color = textColor;
  }

  // Update sidebar
  const sidebar = document.getElementById("sidebar");
  if (sidebar) {
    sidebar.style.background = sidebarColor;
  }

  // Update text elements
  updateTextElement(
    "appTitle",
    config.app_title || defaultConfig.app_title,
    fontSize * 1.5
  );
  updateTextElement(
    "welcomeMessage",
    config.welcome_message || defaultConfig.welcome_message,
    fontSize * 2,
    textColor
  );
  updateTextElement(
    "featuredTitle",
    config.featured_title || defaultConfig.featured_title,
    fontSize * 1.75,
    textColor
  );
  updateTextElement(
    "footerText",
    config.footer_text || defaultConfig.footer_text,
    fontSize * 0.875,
    textColor
  );

  // Update nav items
  updateNavItems(primaryColor, textColor, fontSize);

  // Update sections
  updateHeroSection(primaryColor);
  updateButtons(primaryColor, textColor, fontSize);
  updateFooter(navbarColor);
}

// ===================================
// Helper Functions
// ===================================
function updateTextElement(id, text, fontSize, color = null) {
  const element = document.getElementById(id);
  if (element) {
    element.textContent = text;
    element.style.fontSize = `${fontSize}px`;
    if (color) element.style.color = color;
  }
}

function updateNavItems(primaryColor, textColor, fontSize) {
  const navItems = document.querySelectorAll(".nav-item");
  navItems.forEach((item, index) => {
    if (index === 0) {
      item.style.backgroundColor = `${primaryColor}33`;
      item.style.color = textColor;
    } else {
      item.style.color = textColor;
    }
    item.style.fontSize = `${fontSize * 0.875}px`;
  });
}

function updateHeroSection(primaryColor) {
  const heroSection = document.querySelector("section.rounded-2xl");
  if (heroSection) {
    heroSection.style.backgroundColor = primaryColor;
    heroSection.style.color = "#ffffff";
  }
}

function updateButtons(primaryColor, textColor, fontSize) {
  const btnPrimary = document.querySelector(".btn-primary");
  if (btnPrimary) {
    btnPrimary.style.backgroundColor = textColor;
    btnPrimary.style.fontSize = `${fontSize * 1.125}px`;
  }

  const rentButtons = document.querySelectorAll(".vehicle-card button");
  rentButtons.forEach((btn) => {
    btn.style.backgroundColor = primaryColor;
    btn.style.fontSize = `${fontSize * 0.875}px`;
  });
}

function updateFooter(navbarColor) {
  const footer = document.querySelector("footer");
  if (footer) {
    footer.style.backgroundColor = navbarColor;
  }
}

// ===================================
// Mobile Menu Functions
// ===================================
function openMobileMenu() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("mobileMenuOverlay");

  if (sidebar) sidebar.classList.add("active");
  if (overlay) overlay.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function closeMobileMenu() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("mobileMenuOverlay");

  if (sidebar) sidebar.classList.remove("active");
  if (overlay) overlay.classList.add("hidden");
  document.body.style.overflow = "";
}

// ===================================
// Desktop Sidebar Toggle
// ===================================
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const toggleIcon = document.getElementById("toggleIcon");

  if (sidebar) {
    sidebar.classList.toggle("collapsed");

    // Update toggle icon
    if (sidebar.classList.contains("collapsed")) {
      // Show expand icon (chevrons pointing right)
      toggleIcon.innerHTML =
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />';
    } else {
      // Show collapse icon (chevrons pointing left)
      toggleIcon.innerHTML =
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />';
    }
  }
}

// ===================================
// Element SDK Integration
// ===================================
function initializeElementSDK() {
  if (!window.elementSdk) return;

  window.elementSdk.init({
    defaultConfig,
    onConfigChange,
    mapToCapabilities: (config) => ({
      recolorables: [
        {
          get: () => config.background_color || defaultConfig.background_color,
          set: (value) => {
            config.background_color = value;
            window.elementSdk.setConfig({ background_color: value });
          },
        },
        {
          get: () => config.sidebar_color || defaultConfig.sidebar_color,
          set: (value) => {
            config.sidebar_color = value;
            window.elementSdk.setConfig({ sidebar_color: value });
          },
        },
        {
          get: () => config.navbar_color || defaultConfig.navbar_color,
          set: (value) => {
            config.navbar_color = value;
            window.elementSdk.setConfig({ navbar_color: value });
          },
        },
        {
          get: () => config.primary_color || defaultConfig.primary_color,
          set: (value) => {
            config.primary_color = value;
            window.elementSdk.setConfig({ primary_color: value });
          },
        },
        {
          get: () => config.text_color || defaultConfig.text_color,
          set: (value) => {
            config.text_color = value;
            window.elementSdk.setConfig({ text_color: value });
          },
        },
      ],
      borderables: [],
      fontEditable: {
        get: () => config.font_family || defaultConfig.font_family,
        set: (value) => {
          config.font_family = value;
          window.elementSdk.setConfig({ font_family: value });
        },
      },
      fontSizeable: {
        get: () => config.font_size || defaultConfig.font_size,
        set: (value) => {
          config.font_size = value;
          window.elementSdk.setConfig({ font_size: value });
        },
      },
    }),
    mapToEditPanelValues: (config) =>
      new Map([
        ["app_title", config.app_title || defaultConfig.app_title],
        [
          "welcome_message",
          config.welcome_message || defaultConfig.welcome_message,
        ],
        [
          "featured_title",
          config.featured_title || defaultConfig.featured_title,
        ],
        ["footer_text", config.footer_text || defaultConfig.footer_text],
      ]),
  });
}

// ===================================
// Event Listeners
// ===================================
function initializeEventListeners() {
  const menuToggle = document.getElementById("menuToggle");
  const closeSidebar = document.getElementById("closeSidebar");
  const mobileMenuOverlay = document.getElementById("mobileMenuOverlay");
  const toggleSidebarBtn = document.getElementById("toggleSidebar");

  if (menuToggle) menuToggle.addEventListener("click", openMobileMenu);
  if (closeSidebar) closeSidebar.addEventListener("click", closeMobileMenu);
  if (mobileMenuOverlay)
    mobileMenuOverlay.addEventListener("click", closeMobileMenu);
  if (toggleSidebarBtn)
    toggleSidebarBtn.addEventListener("click", toggleSidebar);
}

// ===================================
// Initialization
// ===================================
document.addEventListener("DOMContentLoaded", () => {
  initializeElementSDK();
  initializeEventListeners();
  onConfigChange(defaultConfig);
  initializeScrollEffects();
});

// ===================================
// Scroll Effects for Navbar
// ===================================
function initializeScrollEffects() {
  const navbar = document.getElementById("navbar");
  let lastScroll = 0;

  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }

    lastScroll = currentScroll;
  });
}

// Slider
const heroImages = [
  "../assets/img/slide1.webp",
  "../assets/img/slide2.webp",
  "../assets/img/slide3.webp",
  "../assets/img/slide4.webp",
  "../assets/img/slide5.webp",
  "../assets/img/slide6.webp",
  "../assets/img/slide7.webp",
];

let current = 0;
const slider = document.getElementById("heroSlider");

setInterval(() => {
  slider.classList.add("opacity-0");

  setTimeout(() => {
    current = (current + 1) % heroImages.length;
    slider.src = heroImages[current];
    slider.classList.remove("opacity-0");
  }, 500);
}, 4000);
