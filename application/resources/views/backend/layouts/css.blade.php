<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
<!-- BEGIN PLUGINS STYLES -->
<link rel="stylesheet" href="{{$backendDir}}/assets/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="{{$backendDir}}/assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="{{$backendDir}}/assets/vendor/flatpickr/flatpickr.min.css"><!-- END PLUGINS STYLES -->
<!-- select2 -->
<link rel="stylesheet" href="{{$backendDir}}/assets/vendor/select2/css/select2.min.css">
<!-- BEGIN THEME STYLES -->
<link rel="stylesheet" href="{{$backendDir}}/assets/stylesheets/theme.min.css" data-skin="default">
<link rel="stylesheet" href="{{$backendDir}}/assets/stylesheets/theme-dark.min.css" data-skin="dark">
<link rel="stylesheet" href="{{$backendDir}}/assets/stylesheets/custom.css?{{rand(0,999)}}">


<script src="{{$backendDir}}/assets/vendor/jquery/jquery.min.js"></script>
<script>

    var skin = localStorage.getItem('skin') || 'default';
    var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
    // Disable unused skin immediately
    disabledSkinStylesheet.setAttribute('rel', '');
    disabledSkinStylesheet.setAttribute('disabled', true);
    // add loading class to html immediately
    document.querySelector('html').classList.add('loading');

    $(document).ready(function() {
        if (skin == 'dark') {
            jQuery('.app header.app-header').removeClass("app-header-light bg-white").addClass("app-header app-aside-light");
            jQuery('.app aside.app-aside').removeClass("bg-white")
            jQuery('footer.app-footer').removeClass("app-footer").addClass("app-aside-light text-center")
        }
    })

</script><!-- END THEME STYLES -->
