<!DOCTYPE html>
<html lang="en">
  <script>
    window.data = JSON.parse(atob('{!! base64_encode(json_encode($configs)) !!}'));
  </script>
  @include('app')
</html>