function initMainPage() {
    initPromoRotator();
    initRevealAnimations();
    initFaqToggle();
}

function initPromoRotator() {
    const heroImage = document.getElementById("promoHeroImage");
    const promoCaption = document.getElementById("promoCaption");

    if (!heroImage || !promoCaption) {
        return;
    }

    const promoSlides = [
        {
            image: "/frontend/assets/images/promo%20images/702715826_2185751255590372_6853688975579402705_n.jpg",
            caption: "GL2 2025/2026 ayla mouch filiere"
        },
        {
            image: "/frontend/assets/images/promo%20images/Capture%20d'%C3%A9cran%202026-05-23%20092547.png",
            caption: "the beginning of an end o the end of the beginning ?"
        },
        {
            image: "/frontend/assets/images/promo-3.jpg",
            caption: "Showcase your profile and collaborate across promos."
        },
        {
            image: "/frontend/assets/images/icon-7797704_1280.png",
            caption: "Your alumni network, one place for opportunities and support."
        }
    ];

    preloadSlides(promoSlides).then(function (slides) {
        if (!slides.length) {
            return;
        }

        let index = 0;

        function applySlide(nextIndex) {
            const slide = slides[nextIndex];
            heroImage.classList.add("is-fading");

            setTimeout(function () {
                heroImage.style.backgroundImage =
                    "linear-gradient(135deg, rgba(36, 49, 69, 0.82), rgba(42, 94, 108, 0.6)), url('" + slide.image + "')";
                promoCaption.textContent = slide.caption;
                heroImage.classList.remove("is-fading");
            }, 220);
        }

        applySlide(index);

        setInterval(function () {
            index = (index + 1) % slides.length;
            applySlide(index);
        }, 5000);
    });
}

function preloadSlides(slides) {
    const checks = slides.map(function (slide) {
        return new Promise(function (resolve) {
            const testImage = new Image();
            testImage.onload = function () {
                resolve(slide);
            };
            testImage.onerror = function () {
                resolve(null);
            };
            testImage.src = slide.image;
        });
    });

    return Promise.all(checks).then(function (results) {
        return results.filter(Boolean);
    });
}

function initRevealAnimations() {
    const blocks = document.querySelectorAll(".reveal");
    if (!blocks.length) {
        return;
    }

    if (!("IntersectionObserver" in window)) {
        blocks.forEach(function (item) {
            item.classList.add("visible");
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.16
    });

    blocks.forEach(function (item) {
        observer.observe(item);
    });
}

function initFaqToggle() {
    const questions = document.querySelectorAll(".faq-question");

    questions.forEach(function (button) {
        button.addEventListener("click", function () {
            const item = button.closest(".faq-item");
            if (!item) {
                return;
            }

            item.classList.toggle("open");
        });
    });
}
