<div id="page-preloader-container">
    <div class="wrap">
        <div class="loading">
            <div class="bounceball"></div>
            <div class="text">LOADING...</div>
        </div>
    </div>

<style>
  body {
    margin:0 !important;
  }
  #page-preloader-container {
    position: absolute;
    width: 100%;
    height: 100vh;
    background-color:#0e091f;
    left:0;
    top:0;
    z-index:9999;
  }
  .wrap {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .text {
    color: #39ff39;
    display: inline-block;
    margin-left: 5px;
  }

  .bounceball {
    position: relative;
    display: inline-block;
    height: 37px;
    width: 15px;
  }
  .bounceball:before {
    position: absolute;
    content: '';
    display: block;
    top: 0;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #39ff39;
    transform-origin: 50%;
    animation: bounce 500ms alternate infinite ease;
  }

  @keyframes bounce {
    0% {
      top: 30px;
      height: 5px;
      border-radius: 60px 60px 20px 20px;
      transform: scaleX(2);
    }
    35% {
      height: 15px;
      border-radius: 50%;
      transform: scaleX(1);
    }
    100% {
      top: 0;
    }
  }
</style>
</div>

<script>
  window.hidePageLoader = function() {
    setTimeout(function() {
      const el = document.getElementById("page-preloader-container");
      el.parentNode.removeChild(el);
    }, 750);
  }
</script>
