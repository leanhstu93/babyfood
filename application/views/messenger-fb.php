<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v3.2'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'http://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="126113301330195"
     theme_color="#0084ff"
     logged_in_greeting="Đừng Ngại! Hãy Inbox để nhận báo Giá & Tư vấn Mẫu sản phẩm ! "
     logged_out_greeting="Đừng Ngại! Hãy Inbox để nhận báo Giá & Tư vấn Mẫu sản phẩm ! ">
</div>

