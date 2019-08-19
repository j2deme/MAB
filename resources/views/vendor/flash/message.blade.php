@foreach (session('flash_notification', collect())->toArray() as $message)
@if ($message['overlay'])
@include('flash::modal', [
'modalClass' => 'flash-modal',
'title' => $message['title'],
'body' => $message['message']
])
@else
<script>
  $(document).ready(function () {
    let _type = null;
    switch ("{{ $message['level'] }}") {
      case 'danger':
        _type = 'error';
        break;
      case 'success':
        _type = 'success';
        break;
      case 'warning':
        _type = 'warning';
      default:
        _type = 'info';
        break;
    }
    if(_type == 'info'){
      $('body').toast({
        message: "{{ $message['message'] }}",
        showProgress: 'bottom',
        class: 'info',
        className: {
          toast: 'ui message'
        }
      });
    } else {
      $('body').toast({
        class: _type,
        message: "{{ $message['message'] }}",
        showProgress: 'bottom',
        className: {
          toast: 'ui message'
        }
      });
    }
  });
</script>
@endif
@endforeach

{{ session()->forget('flash_notification') }}
