<footer id="iletisim" class="main-footer-area">
    <div class="container footer-grid">
        <div class="footer-info">
            <h4>Klinik Bilgileri</h4>
            <p><strong>Adres:</strong> Novafertil Konya Tüp Bebek Merkezi Ateşbaz-I Veli Mh. Yeni Meram Cd. No:75 Meram/Konya</p>
            <p><strong>Telefon:</strong> (0332) 323 51 51</p>
            <p><strong>E-Mail:</strong> bilgi@novafertil.com</p>
        </div>
        <div class="footer-nav">
            <h4>Hızlı Menü</h4>
            <ul>
                <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
                <li><a href="<?= BASE_URL ?>hakkimizda.php">Hakkımızda</a></li>
                <li><a href="<?= BASE_URL ?>#galeri">Galeri</a></li>
                <li><a href="<?= BASE_URL ?>iletisim.php">İletişim</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 Necati Özçimen - Novafertil Konya Tüp Bebek Merkezi Tüm Hakları Saklıdır - Designed By <a href="https://www.instagram.com/ozcimenonurarda/" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: underline;">OAÖ</a></p>
    </div>
</footer>

<a href="https://api.whatsapp.com/send?phone=905063701222" class="floating-whatsapp" target="_blank" rel="noopener noreferrer">
    <svg viewBox="0 0 32 32" width="35" height="35" fill="white">
        <path d="M16.002 0c-8.837 0-16.002 7.163-16.002 16.001 0 2.915.786 5.652 2.158 8.056l-2.158 7.943 8.136-2.133c2.348 1.258 4.996 1.986 7.866 1.986 8.836 0 16-7.165 16-16.003s-7.164-16.001-16-16.001zm0 29.176c-2.484 0-4.836-.632-6.902-1.74l-.496-.264-5.11 1.341 1.36-4.98-.29-.462c-1.228-1.964-1.916-4.24-1.916-6.685 0-7.371 5.998-13.369 13.368-13.369 7.372 0 13.37 5.998 13.37 13.369 0 7.37-5.998 13.368-13.37 13.368zm7.332-9.98c-.402-.202-2.383-1.178-2.753-1.312-.37-.134-.64-.202-.91.202-.27.402-1.04 1.312-1.275 1.58-.235.27-.47.302-.872.102-3.155-1.583-4.606-3.155-6.046-6.052-.204-.41-.02-.63.18-.83.18-.18.402-.47.604-.705.202-.235.27-.402.402-.672.134-.27.067-.504-.034-.705-.102-.202-.91-2.196-1.246-3.004-.33-.787-.665-.68-.91-.692-.235-.011-.504-.011-.773-.011s-.705.101-1.075.504c-.37.402-1.411 1.378-1.411 3.36 0 1.982 1.445 3.902 1.646 4.17.202.27 2.846 4.347 6.896 6.095.962.415 1.713.662 2.298.847.964.306 1.84.262 2.532.16.776-.115 2.383-.974 2.718-1.915.335-.94.335-1.745.235-1.915-.101-.168-.37-.27-.772-.47z"/>
    </svg>
</a>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // ==========================================
    // 1. İSTATİSTİKLER (COUNTER) MANTIĞI
    // ==========================================
    const counters = document.querySelectorAll('.counter-number');
    const speed = 200; 

    const observerOptions = { root: null, rootMargin: '0px', threshold: 0.5 };
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    counters.forEach(counter => { counterObserver.observe(counter); });


    // ==========================================
    // 2. SIKÇA SORULAN SORULAR (ACCORDION)
    // ==========================================
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if(question) {
            question.addEventListener('click', () => {
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                item.classList.toggle('active');
            });
        }
    });


    // ==========================================
    // 3. İSTATİSTİKLER VEYA GÖRÜNÜM SLIDER - OTOMATİK & DÖNGÜLÜ
    // ==========================================
    const testWrapper = document.getElementById('testimonialWrapper');
    if(testWrapper) {
        let testAutoScrollTimer;
        
        function startTestAutoScroll() {
            testAutoScrollTimer = setInterval(() => { window.moveSlider(1); }, 3000);
        }
        function resetTestAutoScroll() {
            clearInterval(testAutoScrollTimer);
            startTestAutoScroll();
        }

        window.moveSlider = function(direction) {
            const card = testWrapper.querySelector('.testimonial-card');
            if(!card) return;
            const itemWidth = card.offsetWidth + 20; 
            const maxScroll = testWrapper.scrollWidth - testWrapper.clientWidth;
            
            if (direction === 1) { 
                if (testWrapper.scrollLeft >= maxScroll - 10) { 
                    testWrapper.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    testWrapper.scrollBy({ left: itemWidth, behavior: 'smooth' });
                }
            } else if (direction === -1) { 
                if (testWrapper.scrollLeft <= 10) { 
                    testWrapper.scrollTo({ left: maxScroll, behavior: 'smooth' });
                } else {
                    testWrapper.scrollBy({ left: -itemWidth, behavior: 'smooth' });
                }
            }
            resetTestAutoScroll(); 
        };

        startTestAutoScroll();
        testWrapper.addEventListener('mouseenter', () => clearInterval(testAutoScrollTimer));
        testWrapper.addEventListener('mouseleave', startTestAutoScroll);
    }


    // ==========================================
    // 4. BLOG YAZILARI (SLIDER) - OTOMATİK & DÖNGÜLÜ
    // ==========================================
    const blogWrapper = document.getElementById('blogWrapper');
    if(blogWrapper) {
        let blogAutoScrollTimer;
        
        function startBlogAutoScroll() {
            blogAutoScrollTimer = setInterval(() => { window.moveBlogSlider(1); }, 3000);
        }
        function resetBlogAutoScroll() {
            clearInterval(blogAutoScrollTimer);
            startBlogAutoScroll();
        }

        window.moveBlogSlider = function(direction) {
            const card = blogWrapper.querySelector('.blog-card-new');
            if(!card) return;
            const itemWidth = card.offsetWidth + 20; 
            const maxScroll = blogWrapper.scrollWidth - blogWrapper.clientWidth;
            
            if (direction === 1) { 
                if (blogWrapper.scrollLeft >= maxScroll - 10) { 
                    blogWrapper.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    blogWrapper.scrollBy({ left: itemWidth, behavior: 'smooth' });
                }
            } else if (direction === -1) { 
                if (blogWrapper.scrollLeft <= 10) { 
                    blogWrapper.scrollTo({ left: maxScroll, behavior: 'smooth' });
                } else {
                    blogWrapper.scrollBy({ left: -itemWidth, behavior: 'smooth' });
                }
            }
            resetBlogAutoScroll(); 
        };

        startBlogAutoScroll();
        blogWrapper.addEventListener('mouseenter', () => clearInterval(blogAutoScrollTimer));
        blogWrapper.addEventListener('mouseleave', startBlogAutoScroll);
    }
});
</script>

</body>
</html>