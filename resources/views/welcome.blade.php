<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--- primary meta tags --->
    <title>DIL - PT Delta Indonesia Laboratory</title>
    <meta name="title" content="DIL - PT Delta Indonesia Laboratory">
    <meta name="description" content="This is a personal portfolio html template made by codewithsadee">

    <!--- favicon --->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <!--- google font link --->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700&display=swap" rel="stylesheet">

    <!--- custom css link --->
    <link rel="stylesheet" href="./assets/css/landing.css">

    <!--- preload images_landing --->
    <link rel="preload" as="image" href="./assets/images_landing/hero-banner.jpg">
    <link rel="preload" as="image" href="./assets/images_landing/Blog.svg">
</head>
<body>
    <!--- #HEADER --->
    <header class="header" data-header>
        <div class="container">

            <a href="#" class="logo">
                <img src="./assets/images_landing/logo-dil.png" width="64" height="24" alt="DIL home">
            </a>

            <nav class="navbar" data-navbar>

                <div class="navbar-top">
                    <a href="#" class="logo">
                        <img src="./assets/images_landing/logo-light.svg" width="64" height="24" alt="DIL home">
                    </a>

                    <button class="nav-close-btn" aria-label="close menu" data-nav-toggler>
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
                </div>

                <ul class="navbar-list">

                    <li><a href="#" class="navbar-link">Home</a></li>
                    <li><a href="#" class="navbar-link">About</a></li>
                    <li><a href="#" class="navbar-link">Projects</a></li>
                    <li><a href="#" class="navbar-link">Blog</a></li>
                    <li><a href="#" class="navbar-link">Contact</a></li>

                </ul>

                @if (Route::has('login'))
                    <div class="auth-buttons" style="position: absolute; top: 20px; right: 40px; display: flex; gap: 10px;">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-login">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-login">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-register">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="wrapper">
                    <a href="mailto:info@email.com" class="contact-link">info@email.com</a>

                    <a href="tel:001234567890" class="contact-link">00 (123) 456 78 90</a>
                </div>

                <!-- <ul class="social-list">

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-twitter"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-dribbble"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="https://www.instagram.com/deltaindonesialab/?hl=en" class="social-link">
                            <ion-icon name="logo-instagram"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="social-link">
                            <ion-icon name="logo-youtube"></ion-icon>
                        </a>
                    </li>

                </ul> -->

            </nav>

            <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
      </button>

            <div class="overlay" data-nav-toggler data-overlay></div>

        </div>
    </header>
    <main>
        <article>

            <!--- #HERO --->

            <section class="section hero" aria-label="home">
                <div class="container">

                    <figure class="hero-banner">
                        <img src="./assets/images_landing/safety.jpg" width="560" height="540" alt="DIL" class="w-100" data-reveal="top">
                    </figure>

                    <div class="hero-content">

                        <h1 class="h1 hero-title" data-reveal="top" data-reveal-delay="0.5s">
                            PT Delta Indonesia Laboratory
                        </h1>

                        <p class="section-text" data-reveal="top" data-reveal-delay="0.75s">
                            "Delta Laboratory Indonesia adalah laboratorium pengujian lingkungan
                            terakreditasi KAN-BSN (LP-1406-IDN) dan pengujian K3 (Kesehatan dan Keselamatan Kerja) lingkungan kerja. Kami juga sudah teregistrasi di Kementrian Lingkungan Hidup & Kehutanan (KLHK)."
                        </p>

                        <div class="btn-wrapper" data-reveal="top" data-reveal-delay="1s">
                            <a href="https://www.instagram.com/deltaindonesialab/?hl=en" class="btn btn-primary">See More</a>

                            <!-- <a href="#" class="btn btn-secondary">Contact Me</a> -->
                        </div>

                    </div>

                </div>
            </section>

            <!--- #ABOUT --->

            <section class="section about" aria-label="about">
                <div class="container">

                    <div class="wrapper">

                        <div data-reveal="left">
                            <h2 class="h2 section-title">Layanan Utama?</h2>

                            <p class="section-text">
                            "Kami adalah laboratorium pengujian lingkungan dan layanan pengujian K3 lingkungan kerja. Kami sudah terakreditasi KAN dan teregistrasi di KLHK."
                            </p>
                        </div>

                        <ul class="progress-list" data-reveal="right">

                            <img src="./assets/images_landing/k3.png" width="600" height="100" alt="blog icon" class="blog-icon">
                            <!-- <li class="progress-item">

                                <div class="label-wrapper">
                                    <p>Web Design</p>

                                    <span class="span">100 %</span>
                                </div>

                                <div class="progress">
                                    <div class="progress-fill" style="width: 100%; background-color: #c7b1dd"></div>
                                </div>

                            </li>

                            <li class="progress-item">

                                <div class="label-wrapper">
                                    <p>Mobile Design</p>

                                    <span class="span">80 %</span>
                                </div>

                                <div class="progress">
                                    <div class="progress-fill" style="width: 80%; background-color: #8caeec"></div>
                                </div>

                            </li>

                            <li class="progress-item">

                                <div class="label-wrapper">
                                    <p>Development</p>

                                    <span class="span">85 %</span>
                                </div>

                                <div class="progress">
                                    <div class="progress-fill" style="width: 85%; background-color: #b0d4c1"></div>
                                </div>

                            </li>

                            <li class="progress-item">

                                <div class="label-wrapper">
                                    <p>SEO</p>

                                    <span class="span">90 %</span>
                                </div>

                                <div class="progress">
                                    <div class="progress-fill" style="width: 90%; background-color: #e3a6b6"></div>
                                </div>

                            </li> -->

                        </ul>

                    </div>

                    <ul class="grid-list">

                        <li data-reveal="bottom">
                            <div class="about-card">

                                <div class="card-icon">
                                    <img src="./assets/images_landing/icon-1.svg" width="52" height="52" loading="lazy" alt="pertama icon">
                                </div>

                                <h3 class="h4 card-title">Pertama</h3>

                                <p class="card-text">
                                    Pengujian dan Pemantauan Kualitas Lingkungan seperti pemantauan udara, air, dan lain-lain.
                                </p>
                            </div>
                        </li>

                        <li data-reveal="bottom" data-reveal-delay="0.25s">
                            <div class="about-card">

                                <div class="card-icon">
                                    <img src="./assets/images_landing/icon-2.svg" width="52" height="52" loading="lazy" alt="kedua icon">
                                </div>

                                <h3 class="h4 card-title">Kedua</h3>

                                <p class="card-text">
                                    Pengujian dan Pemantauan K3 di lingkungan kerja mencakup pengukuran stressor dan faktor: Biologi, Kimia, dan lain-lain.
                                </p>

                            </div>
                        </li>

                        <li data-reveal="bottom" data-reveal-delay="0.5s">
                            <div class="about-card">

                                <div class="card-icon">
                                    <img src="./assets/images_landing/icon-3.svg" width="52" height="52" loading="lazy" alt="ketiga icon">
                                </div>

                                <h3 class="h4 card-title">Ketiga</h3>

                                <p class="card-text">
                                    Konsultan Dokumen Perizinan Lingkungan meliputi dokumen induk, dokumen pemantauan, PERTEK, RINTEK, dan lain-lain.
                                </p>

                            </div>
                        </li>

                        <!-- <li data-reveal="bottom" data-reveal-delay="0.75s">
                            <div class="about-card">

                                <div class="card-icon">
                                    <img src="./assets/images_landing/icon-4.svg" width="52" height="52" loading="lazy" alt="web seo icon">
                                </div>

                                <h3 class="h4 card-title">SEO</h3>

                                <p class="card-text">
                                    Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida at eget metus. Cras justo cum sociis natoque magnis.
                                </p>

                            </div>
                        </li> -->

                    </ul>

                </div>
            </section>





            <!--- #PROJECT --->

            <!-- <section class="section project" aria-labelledby="project-label">
                <div class="container">

                    <div class="title-wrapper" data-reveal="top">

                        <div>
                            <h2 class="h2 section-title" id="project-label">Latest Projects</h2>

                            <p class="section-text">
                                Check out some of my latest projects with creative ideas.
                            </p>
                        </div>

                        <a href="#" class="btn btn-secondary">See All Projects</a>

                    </div>

                    <ul class="grid-list">

                        <li>
                            <div class="project-card project-card-1" style="background-color: #f8f5fb">

                                <div class="card-content" data-reveal="left">

                                    <p class="card-tag" style="color: #a07cc5">Web Design</p>

                                    <h3 class="h3 card-title">Snowlake Theme</h3>

                                    <p class="card-text">
                                        Maecenas faucibus mollis interdum sed posuere consectetur est at lobortis. Scelerisque id ligula porta felis euismod semper. Fusce dapibus tellus cursus.
                                    </p>

                                    <a href="#" class="btn-text" style="color: #a07cc5">
                                        <span class="span">See Project</span>

                                        <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                    </a>

                                </div>

                                <figure class="card-banner" data-reveal="right">
                                    <img src="./assets/images_landing/project-1.png" width="650" height="370" loading="lazy" alt="Web Design" class="w-100">
                                </figure>

                            </div>
                        </li>

                        <li>
                            <div class="project-card project-card-2" style="background-color: #f1f5fd">

                                <div class="card-content" data-reveal="right">

                                    <p class=" card-tag" style="color: #3f78e0">Mobile Design</p>

                                    <h3 class="h3 card-title">Budget App</h3>

                                    <p class="card-text">
                                        Maecenas faucibus mollis interdum sed posuere consectetur est at lobortis. Scelerisque id ligula porta felis euismod semper. Fusce dapibus tellus cursus.
                                    </p>

                                    <a href="#" class="btn-text" style="color: #3f78e0">
                                        <span class="span">See Project</span>

                                        <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                    </a>

                                </div>

                                <figure class="card-banner" data-reveal="left">
                                    <img src="./assets/images_landing/project-2.png" width="600" height="367" loading="lazy" alt="Web Design" class="w-100">
                                </figure>

                            </div>
                        </li>

                        <li>
                            <div class="project-card project-card-3" style="background-color: #f5faf7">

                                <div class="card-content" data-reveal="left">

                                    <p class=" card-tag" style="color: #7cb798">Web Design</p>

                                    <h3 class="h3 card-title">Missio Theme</h3>

                                    <p class="card-text">
                                        Maecenas faucibus mollis interdum sed posuere porta consectetur cursus porta lobortis. Scelerisque id ligula felis.
                                    </p>

                                    <a href="#" class="btn-text" style="color: #7cb798">
                                        <span class="span">See Project</span>

                                        <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                    </a>

                                </div>

                                <figure class="card-banner" data-reveal="right">
                                    <img src="./assets/images_landing/project-3.png" width="600" height="367" loading="lazy" alt="Web Design" class="w-100">
                                </figure>

                            </div>
                        </li>

                        <li>
                            <div class="project-card project-card-4" style="background-color: #fcf4f6">

                                <div class="card-content" data-reveal="left">

                                    <p class=" card-tag" style="color: #d16b86">Mobile Design</p>

                                    <h3 class="h3 card-title">Storage App</h3>

                                    <p class="card-text">
                                        Maecenas faucibus mollis interdum sed posuere consectetur est at lobortis. Scelerisque id ligula porta felis euismod semper.
                                    </p>

                                    <a href="#" class="btn-text" style="color: #d16b86">
                                        <span class="span">See Project</span>

                                        <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                                    </a>

                                </div>

                                <figure class="card-banner" data-reveal="right">
                                    <img src="./assets/images_landing/project-4.png" width="620" height="370" loading="lazy" alt="Mobile Design" class="w-100">
                                </figure>

                            </div>
                        </li>

                    </ul>

                </div>
            </section> -->

            <!--- #CONTACT --->

            <section class="section contact" aria-label="location">
                <div class="container">

                    <div class="contact-card">

                        <!-- Info Lokasi -->
                        <div class="contact-content" data-reveal="left">

                            <div class="card-icon">
                                <i class="fas fa-map-marker-alt fa-2x" style="color:#B6F500;"></i>
                            </div>

                            <h2 class="h2 section-title">Lokasi Kami</h2>

                            <p class="section-text">
                                PT Delta Indonesia Laboratory (DIL) berlokasi di:
                                <br><strong>Prima Orchard Trade Mall</strong>,
                                Jl. Prima Harapan Regency No.2, RT.001/RW.012,
                                Harapan Baru, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17123.
                            </p>

                            <p class="section-text">
                                Kami siap melayani kebutuhan pengujian lingkungan dan K3 Anda!
                            </p>

                        </div>

                        <!-- Google Maps -->
                        <div class="contact-form" data-reveal="right" style="padding: 0;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.337626482865!2d107.00352011431842!3d-6.219217762675112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698be8941e24c5%3A0x328d993b4a41d93b!2sPrima%20Orchard%20Trade%20Mall!5e0!3m2!1sen!2sid!4v1718145532246!5m2!1sen!2sid"
                                width="100%" height="350"
                                style="border:0; border-radius: 10px;"
                                allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                    </div>

                </div>
            </section>

        </article>
    </main>

    <!--- #FOOTER  -->

    <footer class="footer">
        <div class="container">

            <p class="copyright">
                © 2022 codewithsadee. All rights reserved.
            </p>

            <ul class="social-list">

                <li>
                    <a href="#" class="social-link">
                        <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                        <ion-icon name="logo-dribbble"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                        <ion-icon name="logo-youtube"></ion-icon>
                    </a>
                </li>

            </ul>

        </div>
    </footer>
    <!--- custom js link -->
    <script src="./assets/js/script.js"></script>

    <!--- ionicon link -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
<!-- partial:index.partial.html -->
