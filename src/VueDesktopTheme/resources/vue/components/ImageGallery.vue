<template>
    <section class="jss309 jss446"> 
      <div class="jss447">
        <a class="jss448" href="/promotions/pants-all.html" style="width: 50%;">
        <div class="jss451" style="background-image: url(https://magento.r.worldssl.net/media/wysiwyg/home/home-pants.jpg);"></div>
        <div class="jss452"></div>
        <div class="jss449">
          <h3 class="jss315 jss332 jss344 jss453"> 20% OFF<div class="jss454"></div> </h3>
          </div>
          </a>
          <a class="jss448" href="/promotions/tees-all.html" style="width: 50%;">
          <div class="jss451" style="background-image: url(&quot;https://magento.r.worldssl.net/media/wysiwyg/home/home-t-shirts.png&quot;);"></div>
          <div class="jss452"></div>
          <div class="jss449">
            <h3 class="jss315 jss332 jss344 jss453"> Even more ways to mix and match<div class="jss454"></div>  </h3>
            </div></a><a class="jss448" href="/collections/erin-recommends.html" style="width: 34%;">
            <div class="jss451" style="background-image: url(&quot;https://magento.r.worldssl.net/media/wysiwyg/home/home-erin.jpg&quot;);"></div>
            <div class="jss452"></div>
            <div class="jss449"><h3 class="jss315 jss332 jss344 jss453"> Take it from Erin<div class="jss454"></div>  </h3>
            </div>
            </a>
            <a class="jss448" href="/collections/performance-fabrics.html" style="width: 32%;">
              <div class="jss451" style="background-image: url(&quot;https://magento.r.worldssl.net/media/wysiwyg/home/home-performance.jpg&quot;);"></div>
              <div class="jss452"></div>
              <div class="jss449">
              <h3 class="jss315 jss332 jss344 jss453"> Science meets performance<div class="jss454"></div>
              </h3></div></a><a class="jss448" href="/collections/eco-friendly.html" style="width: 34%;">
              <div class="jss451" style="background-image: url(&quot;https://magento.r.worldssl.net/media/wysiwyg/home/home-eco.jpg&quot;);"></div><div class="jss452"></div>
              <div class="jss449"><h3 class="jss315 jss332 jss344 jss453"> Twice around, twice as nice<div class="jss454"></div>  </h3></div></a></div> </section>
</template>

<script>
export default {
    name: 'imagegallery',
    props: {
      item: {
        type: Object
      }
    },
    methods: {
      imageUrl(img){
        return `background-image: url(${img})`;
      }
    }
  }
</script>

<style lang="scss">
.jss446 {
    margin-top: 8px;
    margin-bottom: 8px;
}

.jss309 {
    width: 100%;
}
.jss447 {
    display: flex;
    flex-wrap: wrap;
    margin-top: 8px;
}
.jss448 {
    height: 60vh;
    display: block;
    padding: 0;
    position: relative;
    min-height: 300px;
    max-height: 500px;
    border-radius: 0;
}

.jss451 {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    background-size: cover;
    background-position: center 40%;
}

.jss452 {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.5;
    position: absolute;
    background: #000;
    transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
}
.jss449 {
    top: 0;
    left: 0;
    right: 0;
    color: #fff;
    bottom: 0;
    display: flex;
    position: absolute;
    align-items: center;
    justify-content: center;
}


.jss453 {
    padding: 16px 32px 14px;
    position: relative;
}
.jss344 {
    color: inherit;
}
.jss332 {
    color: rgba(0, 0, 0, 0.87);
    font-size: 18px;
    font-family: 'Roboto Condensed', sans-serif;
    font-weight: 700;
    line-height: 1.6;
    text-transform: uppercase;
}
.jss315 {
    margin: 0;
    display: block;
}

.jss454 {
    left: calc(50% - 9px);
    width: 18px;
    height: 3px;
    bottom: -2px;
    position: absolute;
    background: #fff;
    transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
}
</style>