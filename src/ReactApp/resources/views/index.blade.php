<!DOCTYPE html>
<html lang="en">
  <script>
    window.zento = JSON.parse(atob('{!! base64_encode(json_encode($data)) !!}'));
  </script>
  @include('app')
</html>