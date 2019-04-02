<!DOCTYPE html>
<html lang="en">
  <script>
    window.appconfigs = JSON.parse(atob('{!! base64_encode(json_encode($appconfigs)) !!}'));
    window.categories = JSON.parse(atob('{!! base64_encode(json_encode($categories)) !!}'));
    window.urlrw = JSON.parse(atob('{!! base64_encode(json_encode($urlrw)) !!}'));
  </script>
  @include('app')
</html>