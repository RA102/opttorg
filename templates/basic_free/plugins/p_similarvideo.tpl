{add_js file='components/video/js/owl-carousel/owl.carousel.min.js'}
{add_css file='components/video/js/owl-carousel/owl.carousel.css'}
<script type="text/javascript">
    $(function() {
      $('#owl').owlCarousel({
          autoPlay: true,
          stopOnHover : true,
          pagination: false,
          paginationNumbers: true,
          navigation: false,
          items : 3
      });
    });
</script>
<style type="text/css">
.img_cover {
    background-position: center 20%;
    background-repeat: no-repeat;
    background-size: cover;
}
.owl .item img {
    height: 0;
}
</style>
<div class="">  
    <h3>{$LANG.IMEDIA_RELATED_VIDEOS}</h3>    
</div>
<div id="owl" class="owl">
    {foreach key=tid item=video from=$videos}
        <div class="item">
            <a href="{$video.movie_link}" class="a_img3 img_cover" style="background-image: url(/upload/video/thumbs/medium/{$video.img})">
                <img src="/upload/video/thumbs/medium/{$video.img}" alt="{$video.title|escape:'html'}" />
            </a>
            <h3><a title="{$video.title|escape:'html'}" href="{$video.movie_link}">{$video.title|truncate:35}</a></h3>
            <div class="minfo">
                <span class="icn-date">{$video.fpubdate}</span>
            </div>
            {if $video.description}
                <div class="owl_descr owl_descr3">
                    {$video.description|strip_tags|truncate:300}
                </div>
            {/if}
        </div>
    {/foreach}
</div>