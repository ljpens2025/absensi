
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.4.0
* @link https://tabler.io
* Copyright 2018-2025 The Tabler Authors
* Copyright 2018-2025 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <script>
      /**
       * This script is used to track user interactions and page views.
       * It is only for demo purposes. Don't use it in production.
       */
      !function (t, e) { var o, n, p, r; e.__SV || (window.posthog = e, e._i = [], e.init = function (i, s, a) { function g(t, e) { var o = e.split("."); 2 == o.length && (t = t[o[0]], e = o[1]), t[e] = function () { t.push([e].concat(Array.prototype.slice.call(arguments, 0))) } } (p = t.createElement("script")).type = "text/javascript", p.crossOrigin = "anonymous", p.async = !0, p.src = s.api_host.replace(".i.posthog.com", "-assets.i.posthog.com") + "/static/array.js", (r = t.getElementsByTagName("script")[0]).parentNode.insertBefore(p, r); var u = e; for (void 0 !== a ? u = e[a] = [] : a = "posthog", u.people = u.people || [], u.toString = function (t) { var e = "posthog"; return "posthog" !== a && (e += "." + a), t || (e += " (stub)"), e }, u.people.toString = function () { return u.toString(1) + ".people (stub)" }, o = "init capture register register_once register_for_session unregister unregister_for_session getFeatureFlag getFeatureFlagPayload isFeatureEnabled reloadFeatureFlags updateEarlyAccessFeatureEnrollment getEarlyAccessFeatures on onFeatureFlags onSessionId getSurveys getActiveMatchingSurveys renderSurvey canRenderSurvey getNextSurveyStep identify setPersonProperties group resetGroups setPersonPropertiesForFlags resetPersonPropertiesForFlags setGroupPropertiesForFlags resetGroupPropertiesForFlags reset get_distinct_id getGroups get_session_id get_session_replay_url alias set_config startSessionRecording stopSessionRecording sessionRecordingStarted captureException loadToolbar get_property getSessionProperty createPersonProfile opt_in_capturing opt_out_capturing has_opted_in_capturing has_opted_out_capturing clear_opt_in_out_capturing debug".split(" "), n = 0; n < o.length; n++)g(u, o[n]); e._i.push([i, s, a]) }, e.__SV = 1) }(document, window.posthog || []);
      const currentDomain = window.location.hostname;
      if (["docs.tabler.io", "preview.tabler.io", "dev.tabler.io"].includes(currentDomain)) {
        posthog.init("phc_Ui9ZadLvY1XWtP5iiD3LWDZoXAGYsz6yNvTAvE7wSwn", {
          api_host: `/eat`,
          person_profiles: "identified_only",
          capture_pageview: true,
          capture_pageleave: true,
          loaded: function (posthog) {
            console.log("PostHog initialized on", currentDomain);
          },
        });
      }
    </script>
    <meta name="msapplication-TileColor" content="#066fd1" />
    <meta name="theme-color" content="#066fd1" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    <meta name="description" content="Tabler is packed with beautifully crafted components and powerful features. Jump in and start building a stunning dashboard — all for free!" />
    <meta name="canonical" content="https://preview.tabler.io/layout-combo.html" />
    <meta name="twitter:image:src" content="https://preview.tabler.io/static/og.png" />
    <meta name="twitter:site" content="@tabler_ui" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI." />
    <meta name="twitter:description" content="Tabler is packed with beautifully crafted components and powerful features. Jump in and start building a stunning dashboard — all for free!" />
    <meta property="og:image" content="https://preview.tabler.io/static/og.png" />
    <meta property="og:image:width" content="1280" />
    <meta property="og:image:height" content="640" />
    <meta property="og:site_name" content="Tabler" />
    <meta property="og:type" content="object" />
    <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI." />
    <meta property="og:url" content="https://preview.tabler.io/static/og.png" />
    <meta property="og:description" content="Tabler is packed with beautifully crafted components and powerful features. Jump in and start building a stunning dashboard — all for free!" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    <!-- END CUSTOM FONT -->
  </head>
  <body>
    <!-- BEGIN GLOBAL THEME SCRIPT -->
    <!-- END GLOBAL THEME SCRIPT -->
    <div class="page">
      <!--  BEGIN SIDEBAR  -->
      @include('layout.admin.sidebar')
      <!--  END SIDEBAR  -->
      <!-- BEGIN NAVBAR  -->
     @include('layout.admin.navbar')
      <!-- END NAVBAR  -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        @yield('content')
        <!-- END PAGE BODY -->
        <!--  BEGIN FOOTER  -->
        @include('layout.admin.footer')
        <!--  END FOOTER  -->
      </div>
    </div>
    <!-- BEGIN PAGE MODALS -->
    <!-- END PAGE MODALS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('myscript')
    <!-- END PAGE SCRIPTS -->
  </body>
</html>
