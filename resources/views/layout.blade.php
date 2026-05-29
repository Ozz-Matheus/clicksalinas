<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta content="telephone=no" name="format-detection"/>
  <meta name="HandheldFriendly" content="true"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://www.googletagmanager.com">
  <link rel="dns-prefetch" href="https://www.google-analytics.com">

  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Material+Icons&display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Material+Icons&display=swap">
  </noscript>

  @stack('preload')

  <title>@yield('meta-title', config('app.name') . ' - Photographers in Cartagena de Indias')</title>
  <meta name="description" content="@yield('meta-description', 'ClickSalinas is a professional photography studio based in Cartagena, Colombia. Specializing in weddings, proposals, and photoshoot experiences.')">
  <meta name="robots" content="@yield('meta-robots', 'index, follow')">

  <link rel="canonical" href="{{ rtrim(url()->current(), '/') }}" />
  <link rel="alternate" hreflang="en" href="{{ rtrim(url()->current(), '/') }}" />
  <link rel="alternate" hreflang="x-default" href="{{ rtrim(url()->current(), '/') }}" />

  <meta property="og:title" content="@yield('meta-title', 'ClickSalinas — Photographers in Cartagena de Indias, Colombia')" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:site_name" content="{{ config('app.name') }}" />
  <meta property="og:type" content="@yield('meta-type', 'website')" />
  <meta property="og:url" content="{{ rtrim(url()->current(), '/') }}" />
  <meta property="og:image" content="@yield('meta-image', asset('images/clicksalinas-logotipo.jpg'))" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:description" content="@yield('meta-description', 'ClickSalinas is a professional photography studio based in Cartagena, Colombia. Specializing in weddings, proposals, and photoshoot experiences.')" />
  <meta property="fb:app_id" content="542652886330197" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@salinnas16" />
  <meta name="twitter:title" content="@yield('meta-title', 'ClickSalinas — Photographers in Cartagena de Indias, Colombia')" />
  <meta name="twitter:image" content="@yield('meta-image', asset('images/clicksalinas-logotipo.jpg'))" />
  <meta name="twitter:description" content="@yield('meta-description', 'ClickSalinas is a professional photography studio based in Cartagena, Colombia.')" />

  <meta name="author" content="ClickSalinas">
  <meta name="owner" content="ClickSalinas">
  <meta name="Distribution" content="global" />

  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png')}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png')}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png')}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png')}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png')}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png')}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png')}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png')}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png')}}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{ asset('favicon/manifest.json')}}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png')}}">
  <meta name="theme-color" content="#ffffff">

  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@graph": [
      {
        "@@type": "ProfessionalService",
        "@@id": "https://clicksalinas.com/#business",
        "name": "ClickSalinas",
        "description": "Professional photography studio in Cartagena de Indias, Colombia. Specializing in weddings, corporate, commercial, photoshoot, family, and proposals photography.",
        "url": "https://clicksalinas.com",
        "telephone": "+57-301-417-1660",
        "email": "hi@clicksalinas.com",
        "logo": {
          "@@type": "ImageObject",
          "@@id": "https://clicksalinas.com/#logo",
          "url": "https://clicksalinas.com/images/clicksalinas-logotipo.jpg",
          "width": 481, "height": 455,
          "caption": "ClickSalinas Logo"
        },
        "image": "https://clicksalinas.com/images/clicksalinas-logotipo.jpg",
        "address": {
          "@@type": "PostalAddress",
          "streetAddress": "Cartagena de Indias",
          "addressLocality": "Cartagena de Indias",
          "addressRegion": "Bolívar",
          "postalCode": "130001",
          "addressCountry": "CO"
        },
        "geo": { "@@type": "GeoCoordinates", "latitude": 10.3910, "longitude": -75.4794 },
        "areaServed": { "@@type": "City", "name": "Cartagena de Indias" },
        "priceRange": "$$",
        "openingHoursSpecification": [
          {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            "opens": "09:00",
            "closes": "18:00"
          },
          {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": "Saturday",
            "opens": "09:00",
            "closes": "14:00"
          }
        ],
        "sameAs": [
          "https://www.facebook.com/clicksalinas16/",
          "https://www.instagram.com/clicksalinas.photo/",
          "https://vimeo.com/carlossalinasphotography",
          "https://twitter.com/salinnas16",
          "https://www.youtube.com/user/pepey16",
          "https://www.tripadvisor.com/Attraction_Review-g297476-d24929243-Reviews-or10-Clicksalinas-Cartagena_Cartagena_District_Bolivar_Department.html"
        ],
        "contactPoint": {
          "@@type": "ContactPoint",
          "telephone": "+57-301-417-1660",
          "contactType": "customer service",
          "availableLanguage": ["English", "Spanish"]
        }
      },
      {
        "@@type": "WebSite",
        "@@id": "https://clicksalinas.com/#website",
        "url": "https://clicksalinas.com",
        "name": "ClickSalinas",
        "inLanguage": "en-US",
        "publisher": { "@@id": "https://clicksalinas.com/#business" },
        "potentialAction": {
          "@@type": "SearchAction",
          "target": "https://clicksalinas.com/blog?s={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@@type": "WebPage",
        "@@id": "https://clicksalinas.com/#homepage",
        "url": "{{ url()->current() }}",
        "name": "@yield('meta-title', 'ClickSalinas — Photographers in Cartagena de Indias')",
        "description": "@yield('meta-description', 'ClickSalinas is a professional photography studio based in Cartagena, Colombia.')",
        "inLanguage": "en-US",
        "isPartOf": { "@@id": "https://clicksalinas.com/#website" },
        "about": { "@@id": "https://clicksalinas.com/#business" },
        "dateModified": "{{ now()->toIso8601String() }}",
        "primaryImageOfPage": { "@@type": "ImageObject", "url": "@yield('meta-image', asset('images/clicksalinas-logotipo.jpg'))" }
      }
    ]
  }
  </script>

  @yield('json-ld')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css?10-04-2026')}}"/>
  @stack('style')

  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-PN6MTJGG');</script>
</head>
<body>
  <div data-barba="wrapper">
      @include('partials.header')
      <div class="page-wrapper" data-barba="container">
        <main class="page-wrapper__content">
          @yield('content')
        </main>
      </div>
      <div class="transition-curtain bg-off-white"></div>
      <canvas id="js-webgl"></canvas>
  </div>
  <div id="cookie-banner" class="cookie-banner">
      <div class="cookie-container">
          <p class="cookie-text">
              We use cookies to improve your experience and analyze website traffic. By continuing to use this site, you consent to our use of cookies as described in our
              <a href="{{ route('privacy.policy') }}" class="cookie-link" target="_blank">Privacy Policy</a>.
          </p>
          <div class="cookie-actions">
              <button id="cookie-accept" class="cookie-btn">
                  Accept
              </button>
          </div>
      </div>
  </div>
  <script src="{{ asset('js/vendor.js')}}" defer></script>
  <script src="{{ asset('js/components.min.js')}}" defer></script>

  <script>
      document.addEventListener("DOMContentLoaded", function() {
          var banner = document.getElementById('cookie-banner');
          var acceptBtn = document.getElementById('cookie-accept');

          // Comprobamos si el usuario ya aceptó las cookies previamente
          if (!localStorage.getItem('cookieConsent')) {
              banner.style.display = 'block';
          }

          // Al hacer click en aceptar, guardamos la preferencia y ocultamos el banner
          acceptBtn.addEventListener('click', function() {
              localStorage.setItem('cookieConsent', 'true');
              banner.style.display = 'none';
          });
      });
  </script>

  @stack('scripts')
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PN6MTJGG" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!--
    Description: Official theme for ClickSalinas.
    Start of project: 08-05-2018.
    Version: 0.1.
    Graphic Designer : Patricia Viaña Muñoz. / Contact: https://www.linkedin.com/in/patricia-via%C3%B1a-b35053bb/
    Full Stack Developer: Orlando Montesinos Quintana. / Contact: https://www.linkedin.com/in/orlando-montesinos-quintana-73416b107/
    Update of project: 05-10-2018.
    Second Update of project: 05-12-2022.
  -->
  </body>
</html>