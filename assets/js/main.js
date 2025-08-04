/**
* Template Name: Ejaz Programming Company
* Template URL: https://programmingejazcompany.com/
* Updated: Jul 21 2025 with Bootstrap v5.3.7
* Author: Ejaz Programming Team
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

 /********************** Light And Dark Mode */
  const themeStylesheet = document.getElementById('themeStylesheet');
  const toggleButtonDesktop = document.getElementById('themeToggle');
  const toggleButtonMobile = document.getElementById('themeToggleMobile');

  // تحميل الثيم المحفوظ
  function loadTheme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      themeStylesheet.href = 'assets/css/main-dark.css';
      updateIcons(true);
    } else {
      themeStylesheet.href = 'assets/css/main.css';
      updateIcons(false);
    }
  }

  // تحديث الأيقونات (شمس أو قمر)
  function updateIcons(isDark) {
    document.querySelectorAll('#themeToggle i, #themeToggleMobile i').forEach(icon => {
      icon.classList.toggle('bi-moon-fill', !isDark);
      icon.classList.toggle('bi-sun-fill', isDark);
    });
  }

  // تبديل الوضع
  function toggleTheme() {
    if (themeStylesheet.href.includes('main.css')) {
      themeStylesheet.href = 'assets/css/main-dark.css';
      localStorage.setItem('theme', 'dark');
      updateIcons(true);
    } else {
      themeStylesheet.href = 'assets/css/main.css';
      localStorage.setItem('theme', 'light');
      updateIcons(false);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    loadTheme();
    toggleButtonDesktop?.addEventListener('click', toggleTheme);
    toggleButtonMobile?.addEventListener('click', toggleTheme);
  });
/********************** Light And Dark Mode */

/********************** */
(() => {
  const word = "CODEYLA";
  const loader = document.getElementById('loader');
  const loaderWrapper = document.getElementById('loader-wrapper');
  const content = document.getElementById('pageContent');

  const fontSize = 100;
  const fontFamily = "'Courier New', Courier, monospace";
  const shardSize = 6;

  const mainCanvas = document.createElement('canvas');
  const ctx = mainCanvas.getContext('2d');

  ctx.font = `${fontSize}px ${fontFamily}`;
  const textWidth = ctx.measureText(word).width;

  mainCanvas.width = textWidth;
  mainCanvas.height = fontSize * 1.3;

  ctx.fillStyle = '#f4a835';
  ctx.font = `${fontSize}px ${fontFamily}`;
  ctx.textBaseline = 'top';
  ctx.fillText(word, 0, 0);

  loader.style.width = mainCanvas.width + 'px';
  loader.style.height = mainCanvas.height + 'px';

  const shardsContainer = document.createElement('div');
  shardsContainer.style.position = 'relative';
  shardsContainer.style.width = mainCanvas.width + 'px';
  shardsContainer.style.height = mainCanvas.height + 'px';
  loader.appendChild(shardsContainer);

  const imageData = ctx.getImageData(0, 0, mainCanvas.width, mainCanvas.height);
  const data = imageData.data;

  function isOpaque(x, y) {
    const index = (y * mainCanvas.width + x) * 4 + 3;
    return data[index] > 10;
  }

  const shards = [];

  for (let y = 0; y < mainCanvas.height; y += shardSize) {
    for (let x = 0; x < mainCanvas.width; x += shardSize) {
      let opaqueFound = false;
      outer: for (let py = 0; py < shardSize; py++) {
        for (let px = 0; px < shardSize; px++) {
          const sx = x + px;
          const sy = y + py;
          if (sx >= mainCanvas.width || sy >= mainCanvas.height) continue;
          if (isOpaque(sx, sy)) {
            opaqueFound = true;
            break outer;
          }
        }
      }
      if (opaqueFound) {
        const shard = document.createElement('div');
        shard.style.position = 'absolute';
        shard.style.width = shardSize + 'px';
        shard.style.height = shardSize + 'px';
        shard.style.left = x + 'px';
        shard.style.top = y + 'px';
        shard.style.backgroundColor = '#f4a835';
        shard.style.borderRadius = '2px';
        shard.style.willChange = 'transform, opacity';
        shardsContainer.appendChild(shard);
        shards.push({el: shard, x, y});
      }
    }
  }

  const displayCanvas = document.createElement('canvas');
  const displayCtx = displayCanvas.getContext('2d');
  displayCanvas.width = mainCanvas.width;
  displayCanvas.height = mainCanvas.height;
  displayCanvas.style.position = 'relative';
  displayCanvas.style.zIndex = '10';
  displayCanvas.style.opacity = '0';
  displayCanvas.style.transition = 'opacity 0.4s ease';
  loader.appendChild(displayCanvas);

  displayCtx.font = `${fontSize}px ${fontFamily}`;
  displayCtx.fillStyle = '#f4a835';
  displayCtx.textBaseline = 'top';
  displayCtx.fillText(word, 0, 0);

  function explode(duration = 1200) {
    shards.forEach(({el}, i) => {
      const angle = Math.random() * 2 * Math.PI;
      const distance = 30 + Math.random() * 80;
      const x = Math.cos(angle) * distance;
      const y = Math.sin(angle) * distance;
      const rotateX = (Math.random() - 0.5) * 720;
      const rotateY = (Math.random() - 0.5) * 720;
      const delay = i * 4;

      el.style.transition = `transform ${duration}ms ease-out ${delay}ms, opacity ${duration}ms ease-out ${delay}ms`;
      el.style.transform = `translate(${x}px, ${y}px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
      el.style.opacity = '0';
    });
  }

  function rebuild(duration = 1000) {
    shards.forEach(({el}, i) => {
      const delay = i * 2;
      el.style.transition = `transform ${duration}ms ease-in ${delay}ms, opacity ${duration}ms ease-in ${delay}ms`;
      el.style.transform = 'translate(0, 0) rotateX(0) rotateY(0)';
      el.style.opacity = '1';
    });
  }

  function glow(duration = 1200) {
    shards.forEach(({el}) => {
      el.style.boxShadow = `0 0 8px #f4a835, 0 0 20px #f4a835, 0 0 30px #f4a835`;
      el.style.transition += `, box-shadow ${duration}ms ease-in-out`;
    });

    setTimeout(() => {
      shards.forEach(({el}) => {
        el.style.boxShadow = 'none';
      });
    }, duration);
  }

  function animateOnce() {
    explode();

    setTimeout(() => {
      rebuild();
      glow();

      setTimeout(() => {
        // إخفاء اللودر وإظهار المحتوى
        loaderWrapper.style.transition = 'opacity 0.6s ease';
        loaderWrapper.style.opacity = '0';

        content.style.opacity = '1';

        setTimeout(() => {
          loaderWrapper.remove();
        }, 700);

      }, 1200);
    }, 1400);
  }

  setTimeout(() => {
    displayCanvas.style.opacity = '0';
    setTimeout(() => {
      displayCanvas.style.display = 'none';
      animateOnce();
    }, 400);
  }, 800);

})();
/********************** */

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  document.getElementById('btnConsultation').addEventListener('click', function(event) {
    event.preventDefault(); // لمنع الانتقال لأي رابط

    Swal.fire({
      icon: 'info',
      title: 'قريباً جداً',
      text: 'خدمة طلب الاستشارة قيد الإعداد، جايين في المستقبل إن شاء الله!',
      confirmButtonText: 'حسنًا',
      background: '#fff',         // خلفية البوباب بيضاء نظيفة
      color: '#333',              // لون الخط الأساسي
      confirmButtonColor: '#f4a835', // لون زر التأكيد (البرتقالي حسب ألوان موقعك)
      backdrop: `
        rgba(0,0,0,0.4)
        left top
        no-repeat
      `,
      showClass: {
        popup: 'swal2-show swal2-slide-in-top' // تأثير دخول من الأعلى
      },
      hideClass: {
        popup: 'swal2-hide swal2-slide-out-top' // تأثير خروج للأعلى
      }
    });
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();